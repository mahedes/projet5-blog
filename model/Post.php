<?php

class Post
{
    public function getPosts()
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->query('SELECT p.id id, p.title title, p.date_created date_created, p.last_edit last_edit, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY id DESC'
        );
        return $result;
    }

    public function getPost($postId)
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->prepare('SELECT id, title, date_created, last_edit, short_description, content FROM posts WHERE id = ?');
        $result->execute([
            $postId
        ]);
        return $result;
    }
}