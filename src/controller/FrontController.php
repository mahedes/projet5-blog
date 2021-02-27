<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;
use \App\model\UserManager;
use \App\model\CommentManager;
use \App\model\Post;

class FrontController
{
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
    $comments = $newComment->addComment($id, $coms, $_SESSION['id']);
    header('Location: index.php?action=article&id=' . $id);
  }

  public function register()
  {
    return View::twig()->render('registration.html.twig');
  }

  public function registerSubmit($pseudo, $name, $firstname, $email, $password)
  {
    $userManager = new UserManager();
    $newUser = $userManager->register($pseudo, $name, $firstname, $email, $password);
    header('Location: ../public/index.php');
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
    header('Location: ../public/index.php');
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
      header('Location: index.php?action=admin');
    }
  }

  public function deleteComment($idComment)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $comment = new CommentManager();
      $comments = $comment->deleteComment($idComment);
      header('Location: index.php?action=admin');
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
      header('Location: index.php?action=admin');
    }
  }

  public function editPost(int $id)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $postManager = new PostManager();
      $postId = $postManager->getPostWithComments($id);
      return View::twig()->render('admin/edit.html.twig', [
        'post' => $postId,
      ]);
    }
  }

  public function editPostSubmitted(int $idPost, $title, $chapo, $content)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $newPost = new PostManager();
      $postAdded = $newPost->editPost($idPost, $title, $chapo, $content);
      header('Location: index.php?action=admin');
    }
  }

  public function deletePostSubmitted(int $idPost)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $postManager = new postManager();
      $postToDelete = $postManager->deletePost($idPost);
      header('Location: index.php?action=admin');
    }
  }

  public function sendMail()
  {
    die('hi');
    // Check for empty fields
    // if (
    //   empty($_POST['name'])      ||
    //   empty($_POST['email'])     ||
    //   empty($_POST['message'])  ||
    //   !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    // ) {
    //   echo "No arguments Provided!";
    //   return false;
    // }

    // $name = strip_tags(htmlspecialchars($_POST['name']));
    // $email_address = strip_tags(htmlspecialchars($_POST['email']));
    // $phone = strip_tags(htmlspecialchars($_POST['phone']));
    // $message = strip_tags(htmlspecialchars($_POST['message']));

    // // Create the email and send the message
    // $to = 'mahevadessart@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
    // $email_subject = "Website Contact Form:  $name";
    // $email_body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message";
    // $headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
    // $headers .= "Reply-To: $email_address";
    // mail($to, $email_subject, $email_body, $headers);
    // return true;
  }
}
