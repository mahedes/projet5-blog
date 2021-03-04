<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;
use \App\model\UserManager;
use \App\model\CommentManager;
use \App\model\Post;


class FrontController
{
  public function __construct()
  {
    if (empty($_GET['submit'])) {
      unset($_SESSION['flash']);
    }
  }

  public function home()
  {
    return View::twig()->render('home.html.twig');
  }

  public function blog()
  {
    $post = new PostManager();
    $posts = $post->getPosts();
    return View::twig()->render('blog.html.twig', [
      'posts' => $posts
    ]);
  }

  public function post(int $id)
  {
    $postManager = new PostManager();
    $postId = $postManager->getPostWithComments($id);
    return View::twig()->render('post.html.twig', [
      'postId' => $postId,
    ]);
  }

  public function newComment(int $id, $coms)
  {
    $newComment = new CommentManager();
    $comments = $newComment->addComment((int) $id, $coms, (int) $_SESSION['id']);
    $_SESSION['flash'] = 'Your comment has been added and submitted for validation';
    header('Location: index.php?action=article&id=' . $id . '&submit=success');
  }

  public function register()
  {
    return View::twig()->render('registration.html.twig');
  }

  public function registerSubmit($pseudo, $name, $firstname, $email, $password)
  {
    $userManager = new UserManager();
    $newUser = $userManager->register($pseudo, $name, $firstname, $email, $password);
    $_SESSION['flash'] = 'Your account has been created successfully';
    header('Location: ../public/index.php?submit=success');
  }

  public function login()
  {
    return View::twig()->render('login.html.twig');
  }

  public function loginSubmit($email, $password)
  {
    $userManager = new UserManager();
    $userLogin = $userManager->login($email);

    if (password_verify($_POST['password'], $userLogin->getPassword())) {
      $_SESSION['id'] = $userLogin->getId();
      $_SESSION['pseudo'] = $userLogin->getPseudo();
      $_SESSION['name'] = $userLogin->getName();
      $_SESSION['firstname'] = $userLogin->getFirstname();
      $_SESSION['email'] = $userLogin->getEmail();

      if ((int) $userLogin->getAdminStatus() === 1) {
        $_SESSION['auth'] = 'ROLE_ADMIN';
      } else {
        $_SESSION['auth'] = 'ROLE_USER';
      }
    }
    header('Location: ../public/index.php');
  }

  public function logout()
  {
    session_destroy();
    $_SESSION['flash'] = 'You have been disconnected';
    header('Location: ../public/index.php?submit=success');
  }

  public function admin()
  {

    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $post = new PostManager();
      $posts = $post->getPosts();
      $comment = new CommentManager();
      $comments = $comment->getUnvalidatedComments();
      return View::twig()->render('admin/dashboard.html.twig', [
        'posts' => $posts,
        'comments' => $comments
      ]);
    } else {
      return View::twig()->render('home.html.twig');
    }
  }

  public function allowComment($idComment)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $comment = new CommentManager();
      $comments = $comment->validationComment($idComment);
      $_SESSION['flash'] = 'Comment ' . $idComment . ' has been validated';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function deleteComment($idComment)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $comment = new CommentManager();
      $comments = $comment->deleteComment($idComment);
      $_SESSION['flash'] = 'Comment ' . $idComment . ' has been deleted';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function newPost()
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      return View::twig()->render('admin/add.html.twig');
    }
  }

  public function newPostSubmitted($title, $chapo, $content)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $newPost = new PostManager();
      $postAdded = $newPost->addPost($_SESSION['id'], $title, $chapo, $content);
      $_SESSION['flash'] = 'New post has been added successfully';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function editPost(int $id)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $postManager = new PostManager();
      $postId = $postManager->getPostWithComments($id);
      $userManager = new UserManager();
      $usersAdmin = $userManager->getUsersAdmin();

      return View::twig()->render('admin/edit.html.twig', [
        'post' => $postId,
        'usersAdmin' => $usersAdmin
      ]);
    }
  }

  public function editPostSubmitted(int $idPost, $title, $chapo, int $author, $content)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $newPost = new PostManager();
      $postAdded = $newPost->editPost($idPost, $title, $chapo, $author, $content);
      $_SESSION['flash'] = 'Post ' . $idPost . ' has been edited successfully';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function deletePostSubmitted(int $idPost)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $postManager = new postManager();
      $postToDelete = $postManager->deletePost($idPost);
      $_SESSION['flash'] = 'Post ' . $idPost . ' has been deleted successfully';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function sendMail($post_name, $post_email, $post_message)
  {

    // Check for empty fields
    if (
      empty($post_name)      ||
      empty($post_email)     ||
      empty($post_message)  ||
      !filter_var($post_email, FILTER_VALIDATE_EMAIL)
    ) {
      echo "No arguments Provided!";
      return false;
    }

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
