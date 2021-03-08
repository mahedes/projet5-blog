<?php

namespace App\Controller;

use \App\config\View;
use \App\model\PostManager;
use \App\model\UserManager;
use \App\model\CommentManager;

class AdminController
{
  public function __construct()
  {
    if (empty($_GET['submit'])) {
      unset($_SESSION['flash']);
      unset($_SESSION['error']);
    }
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

  public function allowComment(int $idComment)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      $comment = new CommentManager();
      $comments = $comment->validationComment($idComment);
      $_SESSION['flash'] = 'Comment ' . $idComment . ' has been validated';
      header('Location: index.php?action=admin&submit=success');
    }
  }

  public function deleteComment(int $idComment)
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

  public function newPostSubmitted(string $title, string $chapo, string $content)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      if (empty($title) || empty($chapo) || empty($content)) {
        $_SESSION['error'] = 'Informations submitted are not valid';
        header('Location: ../public/index.php?action=admin&submit=error');
      } else {
        $new_title = strip_tags(htmlspecialchars($title));
        $new_chapo = strip_tags(htmlspecialchars($chapo));
        $new_content = strip_tags(htmlspecialchars($content));
        $newPost = new PostManager();
        $postAdded = $newPost->addPost($_SESSION['id'], $new_title, $new_chapo, $new_content);
        $_SESSION['flash'] = 'New post has been added successfully';
        header('Location: index.php?action=admin&submit=success');
      }
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

  public function editPostSubmitted(int $idPost, string $title, string $chapo, int $author, string $content)
  {
    if ($_SESSION && $_SESSION['auth'] === 'ROLE_ADMIN') {
      if (empty($idPost) || empty($title) || empty($chapo) || empty($author) || empty($content)) {
        $_SESSION['error'] = 'Informations submitted are not valid';
        header('Location: ../public/index.php?action=admin/edit-post&submit=error');
      } else {
        $idPost = strip_tags(htmlspecialchars($idPost));
        $postManager = new PostManager();
        $posts_id = $postManager->getArrayPostId();
        if (in_array($idPost, $posts_id)) {
          $new_title = strip_tags(htmlspecialchars($title));
          $new_chapo = strip_tags(htmlspecialchars($chapo));
          $new_author = strip_tags(htmlspecialchars($author));
          $new_content = strip_tags(htmlspecialchars($content));
          $newPost = new PostManager();
          $postAdded = $newPost->editPost($idPost, $new_title, $new_chapo, $new_author, $new_content);
          $_SESSION['flash'] = 'Post ' . $idPost . ' has been edited successfully';
          header('Location: index.php?action=admin&submit=success');
        }
      }
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
}
