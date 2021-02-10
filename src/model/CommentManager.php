<?php

namespace App\model;

class CommentManager extends Database
{
  public function build($row): Comment
  {
    $comments = new Comment;
    $comments->setId($row['id']);
    $comments->setAuthor($row['author']);
    $comments->setDayMonthYear($row['dayMonthYear']);
    $comments->setHour($row['hour']);
    $comments->setContent($row['content']);
    $comments->setValidationStatus($row['validationStatus']);
    return $comments;
  }
  public function getCommentsFromPost(int $commentId)
  {
    $db = new Database();
    $connection = $db->getConnection();
    $result = $connection->prepare('SELECT c.id id, c.id_user, c.id_post, DATE_FORMAT(c.created_at, "%d/%m/%Y") AS dayMonthYear, DATE_FORMAT(c.created_at, "%Hh%imin%ss") AS hour, c.content content, c.validation_status validationStatus, u.pseudo author FROM comments c INNER JOIN users u ON u.id = c.id_user WHERE c.id_post = ? ORDER BY created_at DESC');
    $result->execute(
      array(
        $commentId
      )
    );
    foreach ($result as $row) {
      $commentId = $row['id'];
      $comments[$commentId] = $this->build($row);
    }
    $result->closeCursor();
    return $comments;
  }

  public function addComment(int $postId, $commentsContent)
  {
    $db = new Database();
    $connection = $db->getConnection();
    $req = $connection->prepare('INSERT INTO comments (id_user, id_post, created_at, content, validation_status) VALUES(:id_user, :id_post, :createdAt, :content, :validationStatus)');
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
