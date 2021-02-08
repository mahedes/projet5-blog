<?php

namespace App\model;

class PostManager extends Database
{
    public function build($row): Post
    {
        $post = new Post;
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $post->setCreatedAt($row['createdAt']);
        $post->setUpdatedAt($row['updatedAt']);
        $post->setChapo($row['chapo']);
        $post->setContent($row['content']);
        $post->setAuthor($row['author']);
        return $post;
    }

    public function getPosts()
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->query(
            'SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY id DESC'
        );
        return $result;
    }

    public function getPost(int $postId)
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->prepare('SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user WHERE p.id = ?');
        $result->execute([
            $postId
        ]);
        $data = $result->fetch(\PDO::FETCH_ASSOC);

        return $this->build($data);
    }
}
