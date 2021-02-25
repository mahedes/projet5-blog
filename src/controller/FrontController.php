<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;
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
    // SQL avec jointures
    $postManager = new PostManager();
    $postId = $postManager->getPostWithComments($id);

    // $commentManager = new CommentManager();
    // $comments = $commentManager->getCommentsFromPost($id);

    return View::twig()->render('post.html.twig', [
      'postId' => $postId,
      // 'comments' => $comments
    ]);
  }

  public function newComment($id, $coms)
  {
    $newComment = new CommentManager();
    $comments = $newComment->addComment($id, $coms);
  }
}
