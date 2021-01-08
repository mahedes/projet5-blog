<?php
namespace App\model\Manager;

class CommentManager extends Database
{
    public function getCommentsFromPost($postId)
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->prepare('SELECT c.id id, c.id_user, c.id_post, DATE_FORMAT(c.date_created, "%d/%m/%Y") AS dayMonthYear, DATE_FORMAT(c.date_created, "%Hh%imin%ss") AS hour, c.content content, c.validation_status validation_status, u.pseudo author FROM comments c INNER JOIN users u ON u.id = c.id_user WHERE c.id_post = ? ORDER BY date_created DESC');
        $result->execute(array(
          $postId
          )
        );
        return $result;
    }
}