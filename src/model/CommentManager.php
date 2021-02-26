<?php

namespace App\model;

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
    $comments->setId($row['idComment']);
    $comments->setAuthor($row['author']);
    $createAt = $row['createdAt'];
    $comments->setCreatedAt($createAt);
    $comments->setContent($row['commentContent']);
    $comments->setValidationStatus($row['validationStatus']);
    return $comments;
  }

  /**  
   * @todo : Make a link with admin
   */
  public function addComment(int $postId, $commentsContent)
  {
    $req = $this->connection->prepare('INSERT INTO comments (id_user, id_post, created_at, content, validation_status) VALUES(:id_user, :id_post, :createdAt, :content, :validationStatus)');
    $req->execute(array(
      'id_user' => 1,
      'id_post' => $postId,
      'createdAt' => date("Y-m-d H:i:s"),
      'content' => $commentsContent,
      'validationStatus' => 0
    ));
    header('Location: index.php?action=article&id=' . $postId);
  }
}
