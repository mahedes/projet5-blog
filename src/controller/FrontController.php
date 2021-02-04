<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;

class FrontController
{
  public function home()
  {
    return View::twig()->render('home.html.twig');
  }
  public function blog()
  {

    //return View::twig()->render('blog.html.twig');
    View::twig()->load('blog.html.twig');
    $post = new PostManager();
    $posts = $post->getPosts();
    return View::twig()->render('blog.html.twig', [
      'posts' => $posts
    ]);
  }
  public function post($id)
  {
    $post = new PostManager();
    $postId = $post->getPost($id);
    return View::twig()->render('post.html.twig', [
      'postId' => $postId
    ]);
  }
}
