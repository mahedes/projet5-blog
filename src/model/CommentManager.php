<?php

namespace App\model;

use PDOException;

class CommentManager extends Database
{
  private $db;
  private $connection;

  public function __construct()
  {
    $this->db = new Database();
    $this->connection = $this->db->getConnection();
  }

  public function build($row): Comment
  {
    $comments = new Comment;
    $comments->setId($row['id']);
    $comments->setAuthor($row['author']);
    $comments->setPost($row['post']);
    $createAt = $row['createdAt'];
    $comments->setCreatedAt($createAt);
    $comments->setContent($row['commentContent']);
    $comments->setValidationStatus($row['validationStatus']);

    return $comments;
  }

  public function getUnvalidatedComments()
  {
    try {
      $result = $this->connection->query(
        'SELECT c.id, c.id_user, c.id_post post, c.created_at createdAt, c.content commentContent, c.validation_status validationStatus, u.pseudo author 
        FROM comments c 
        LEFT JOIN users u 
        ON u.id = c.id_user 
        LEFT JOIN posts p 
        ON p.id = c.id_post 
        WHERE c.validation_status = 0
        
        ORDER BY id ASC'
      );

      foreach ($result as $row) {
        $commentId = $row['id'];
        $commentsList[$commentId] = $this->build($row);
      }
      $result->closeCursor();

      return $commentsList;
    } catch (PDOException $e) {
      die($e->getmessage());
    }
  }

  public function addComment(int $postId, $commentsContent, int $author)
  {
    $req = $this->connection->prepare('INSERT INTO comments (id_user, id_post, created_at, content, validation_status) VALUES(:id_user, :id_post, :createdAt, :content, :validationStatus)');
    $req->execute(array(
      'id_user' => $author,
      'id_post' => $postId,
      'createdAt' => date("Y-m-d H:i:s"),
      'content' => $commentsContent,
      'validationStatus' => 0
    ));
  }

  public function validationComment($commentId)
  {
    $req = $this->connection->prepare('UPDATE comments SET validation_status = :validationStatus WHERE id = :idComment');
    $req->execute(array(
      'idComment' => $commentId,
      'validationStatus' => 1
    ));
  }

  public function deleteComment($idComment)
  {
    $req = $this->connection->prepare('DELETE FROM comments WHERE id = :idComment');
    $req->execute(array(
      'idComment' => $idComment
    ));
  }
}
