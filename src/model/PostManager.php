<?php

namespace App\model;

class PostManager extends Database
{
    private $db;
    private $connection;

    public function __construct()
    {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function build(array $row): Post
    {
        $post = new Post;
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $createAt = $row['createdAt'];
        $post->setCreatedAt($createAt);
        $post->setUpdatedAt($row['updatedAt']);
        $post->setChapo($row['chapo']);
        $post->setContent($row['content']);
        $post->setAuthor($row['author']);
        return $post;
    }

    public function getPosts()
    {
        $result = $this->connection->query(
            'SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY id DESC'
        );
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->build($row);
        }
        $result->closeCursor();
        return $posts;
    }

    public function getPostWithComments($id)
    {
        $result = $this->connection->prepare('SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author, c.id idComment, c.id_post, c.id_user commentUser, c.created_at createdAt, c.content commentContent, c.validation_status validationStatus
                                        FROM posts p 
                                        INNER JOIN users u 
                                        ON u.id = p.id_user 
                                        LEFT JOIN comments c 
                                        ON c.id_post = p.id 
                                        WHERE p.id = ?');

        $result->execute([
            $id
        ]);

        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        $modelPost = $this->build($data[0]);

        foreach ($data as $row) {
            if ($row['idComment'] !== null) {
                $commentManager = new CommentManager;
                $comment = $commentManager->build($row);
                $modelPost->addComments($comment);
            }
        }

        return $modelPost;
    }
}
