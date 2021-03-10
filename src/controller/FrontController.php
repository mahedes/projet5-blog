<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;
use \App\model\CommentManager;


class FrontController
{
    public function __construct()
    {
        if (empty($_GET['submit'])) {
            unset($_SESSION['flash']);
            unset($_SESSION['error']);
        }
    }

    public function home()
    {
        return View::twig()->render('front/home.html.twig');
    }

    public function blog()
    {
        $post = new PostManager();
        $posts = $post->getPosts();
        return View::twig()->render('front/blog.html.twig', [
            'posts' => $posts
        ]);
    }

    public function post(int $id)
    {
        $postManager = new PostManager();
        $postId = $postManager->getPostWithComments($id);
        return View::twig()->render('front/post.html.twig', [
            'postId' => $postId,
        ]);
    }

    public function newComment(int $post_id, string $post_coms)
    {
        $postManager = new PostManager();
        $posts_id = $postManager->getArrayPostId();
        if (in_array($post_id, $posts_id)) {
            if (empty($post_coms) || empty($post_id)) {
                $_SESSION['error'] = 'Informations submitted are not valid';
                header('Location: index.php?action=article&id=' . $post_id . '&submit=error');
            } else {
                $coms = strip_tags(htmlspecialchars($post_coms));
                $newComment = new CommentManager();
                $comments = $newComment->addComment($post_id, $coms, (int) $_SESSION['id']);
                $_SESSION['flash'] = 'Your comment has been added and submitted for validation';
                header('Location: index.php?action=article&id=' . $post_id . '&submit=success');
            }
        }
    }

    public function sendMail(string $post_name, string $post_email, string $post_message)
    {
        // Check for empty fields
        if (empty($post_name) || empty($post_email) || empty($post_message)  || !filter_var($post_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Informations submitted are not valid';
            header('Location: ../public/index.php?submit=error');
        } else {
            $name = strip_tags(htmlspecialchars($post_name));
            $email = strip_tags(htmlspecialchars($post_email));
            $message = strip_tags(htmlspecialchars($post_message));

            $to = 'mahevadessart@gmail.com';
            $email_subject = "Website Contact Form:  $name";
            $email_body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email\n\nMessage:\n$message";
            $headers = "From: noreply@yourdomain.com\n";
            $headers .= "Reply-To: $email";
            mail($to, $email_subject, $email_body, $headers);

            $_SESSION['flash'] = 'Message has been sent successfully';
            header('Location: index.php?submit=success');
        }
    }
}
