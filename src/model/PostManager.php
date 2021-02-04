<?php

namespace App\model;

class PostManager extends Database
{
    public function getPosts()
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->query(
            'SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY id DESC'
        );
        return $result;
    }

    public function getPost($postId)
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->prepare('SELECT id, title, created_at, updated_at, short_description, content FROM posts WHERE id = ?');
        $result->execute([
            $postId
        ]);
        return $result;
    }
}
