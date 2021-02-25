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
    View::twig()->load('blog.html.twig');
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
    $comments = $newComment->addComment($id, $coms);
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
    return $this->view->render('registration.html.twig');
  }

  public function login()
  {
    return View::twig()->render('login.html.twig');
  }
  public function loginSubmit($pseudo, $password)
  {
    var_dump($pseudo, $password);
    // $userManager = new UserManager();
    // $newUser = $userManager->register($pseudo, $password);
    // header('Location: ../public/index.php');
    // return $this->view->render('registration.html.twig');
  }
}
