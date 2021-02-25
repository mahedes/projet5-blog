<?php

namespace App\model;

class PostManager extends Database
{
    private $db;
    private $connection;
    /**
     * @todo : mettre dans un construct
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }
    // $db = new Database();
    // $connection = $db->getConnection();

    public function build($row): Post
    {
        // $createAt = ;// $row['createdAt'];  à convertir en DateTime avec createFormFormat()


        $post = new Post;
        var_dump($row);
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        // $post->setCreatedAt($createAt);
        // $post->setCreatedAt($row['createdAt']);
        // $post->setUpdatedAt($row['updatedAt']);
        // $post->setChapo($row['chapo']);
        // $post->setContent($row['content']);
        // $post->setAuthor($row['author']);
        return $post;
    }

    public function getPosts()
    {
        $db = new Database();
        $connection = $db->getConnection();
        $result = $connection->query(
            'SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY id DESC'
        );
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->build($row);
        }
        $result->closeCursor();
        return $posts;
    }

    public function getPost($postId)
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

    public function getPostWithComments($id)
    {
        $db = new Database();
        $connection = $db->getConnection();

        /**
         * @todo : ajouter les champs comments
         * attention avec inner join à trouver ligne 70
         */
        $result = $connection->prepare('SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author, c.id idComment, c.id_post, c.id_user commentUser, c.content commentContent
                                        FROM posts p 
                                        INNER JOIN users u 
                                        ON u.id = p.id_user 
                                        INNER JOIN comments c 
                                        ON c.id_post = p.id 
                                        WHERE p.id = ?');
        $result->execute([
            $id
        ]);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        $modelPost = $this->build($data[0]);
        foreach ($data as $row) {
            $commentManager = new CommentManager;
            $comment = $commentManager->build($row);
            $modelPost->addComments($comment);
        }

        // var_dump($modelPost);
        // die('abc');
        return $this->build($modelPost);
        // return $this->build($modelPost);
    }
}
