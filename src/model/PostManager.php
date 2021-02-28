<?php

namespace App\model;

use PDOException;

class PostManager extends Database
{
    private $db;
    private $connection;

    public function __construct()
    {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    /**
     * @todo: convertir heure avec createFormFormat()
     */
    public function build(array $row): Post
    {
        $post = new Post;
        $post->setId($row['idPost']);
        $post->setTitle($row['title']);
        $post->setAuthor($row['author']);
        $createAt = $row['createdAt'];
        $post->setCreatedAt($createAt);
        $post->setUpdatedAt($row['updatedAt']);
        $post->setChapo($row['chapo']);
        $post->setContent($row['content']);
        return $post;
    }

    public function getPosts()
    {
        $result = $this->connection->query(
            'SELECT p.id idPost, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.pseudo author FROM posts p INNER JOIN users u ON u.id = p.id_user ORDER BY idPost DESC'
        );
        foreach ($result as $row) {
            $postId = $row['idPost'];
            $posts[$postId] = $this->build($row);
        }
        $result->closeCursor();
        return $posts;
    }

    public function getPostWithComments($id)
    {
        try {
            // $result = $this->connection->prepare('SELECT p.id id, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user, u.id author, u.pseudo, c.id idComment, c.id_post post, c.id_user commentUser, c.created_at createdAt, c.content commentContent, c.validation_status validationStatus
            $result = $this->connection->prepare('SELECT p.id idPost, p.title title, p.created_at createdAt, p.updated_at updatedAt, p.short_description chapo, p.content content, p.id_user author, u.id idUser, us.id, us.pseudo authorComment, u.pseudo, u.name, u.firstname, u.email, u.password, u.admin_status, u.created_at, c.id idComment, c.id_post post, c.id_user, c.created_at createdAt, c.content commentContent, c.validation_status validationStatus
                                        FROM posts p 
                                        LEFT JOIN users u 
                                        ON u.id = p.id_user
                                        LEFT JOIN comments c 
                                        ON c.id_post = p.id
                                        LEFT JOIN users us 
                                        ON us.id = c.id_user
                                        WHERE p.id = ?');

            $result->execute([
                $id
            ]);

            $data = $result->fetchAll(\PDO::FETCH_ASSOC);
            $modelPost = $this->build($data[0]);

            // $userManager = new UserManager;
            // $userPost = $userManager->build($data[0]);
            // $modelPost->setAuthor($userPost);

            foreach ($data as $row) {
                if ($row['author']) {

                    $userManager = new UserManager;
                    $userPost = $userManager->build($row);
                    // var_dump($userPost);
                    // die();
                    $modelPost->setAuthor($userPost);
                }
                if ($row['idComment'] !== null) {
                    $commentManager = new CommentManager;
                    $comment = $commentManager->build($row);
                    // if ($row['author'] !== null) {
                    //     $userComment = $userManager->build($row);
                    //     $comment->setAuthorComment($userComment);
                    // } 
                    $modelPost->setComments($comment);
                }
            }

            return $modelPost;
        } catch (PDOException $e) {
            die($e->getmessage());
        }
    }

    /**
     * @todo : updated_at -> Invalid parameter number: number of bound variables does not match number of tokens
     */
    public function addPost(int $author, $title, $chapo, $content)
    {
        try {
            $req = $this->connection->prepare('INSERT INTO posts (id_user, title, created_at, short_description, content) VALUES(:id_user, :title, :created_at, :short_description, :content)');
            $req->execute(array(
                'id_user' => $author,
                'title' => $title,
                'created_at' => date("Y-m-d H:i:s"),
                'short_description' => $chapo,
                'content' => $content
            ));
        } catch (PDOException $e) {
            die($e->getmessage());
        }
    }

    public function editPost(int $idPost, $title, $chapo, $author, $content)
    {
        try {
            $req = $this->connection->prepare('UPDATE posts SET title = :title, short_description = :chapo, id_user = :author, content = :content , updated_at = :updatedAt WHERE id = :idPost');
            $req->execute(array(
                'idPost' => $idPost,
                'title' => $title,
                'chapo' => $chapo,
                'author' => $author,
                'content' => $content,
                'updatedAt' => date("Y-m-d H:i:s")
            ));
        } catch (PDOException $e) {
            die($e->getmessage());
        }
    }

    public function deletePost(int $idPost)
    {
        try {
            $reqComments = $this->connection->prepare('DELETE FROM comments WHERE id_post = :idPost');
            $reqComments->execute(array(
                'idPost' => $idPost
            ));

            $reqPost = $this->connection->prepare('DELETE FROM posts WHERE id= :idPost');
            $reqPost->execute(array(
                'idPost' => $idPost,
            ));
        } catch (PDOException $e) {
            die($e->getmessage());
        }
    }
}
