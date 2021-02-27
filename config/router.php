<?php

namespace App\Config;

use App\Controller\FrontController;
use \App\model\Manager\PostManager;

use Exception;

class Router
{
  public function run()
  {
    $controller = new FrontController;
    try {
      if (isset($_GET['action'])) {
        if ($_GET['action'] === 'blog') {
          echo $controller->blog();
        } else if ($_GET['action'] === 'article') {
          echo $controller->post((int) $_GET['id']);
        } else if ($_GET['action'] === 'add-comment') {
          echo $controller->newComment((int) $_GET['postId'], $_POST['coms']);
        } else if ($_GET['action'] === 'register') {
          echo $controller->register();
        } else if ($_GET['action'] === 'registrationSubmitted') {
          echo $controller->registerSubmit($_POST['pseudo'], $_POST['name'], $_POST['firstname'], $_POST['email'], $_POST['password']);
        } else if ($_GET['action'] === 'login') {
          echo $controller->login();
        } else if ($_GET['action'] === 'loginSubmitted') {
          echo $controller->loginSubmit($_POST['email'], $_POST['password']);
        } else if ($_GET['action'] === 'logout') {
          echo $controller->logout();
        } else if ($_GET['action'] === 'admin') {
          echo $controller->admin();
        } else if ($_GET['action'] === 'admin/allow-comment') {
          echo $controller->allowComment((int) $_GET['idComment']);
        } else if ($_GET['action'] === 'admin/delete-comment') {
          echo $controller->deleteComment((int) $_GET['idComment']);
        } else if ($_GET['action'] === 'admin/add-post') {
          echo $controller->newPost();
        } else if ($_GET['action'] === 'admin/add-post/newPostSubmitted') {
          echo $controller->newPostSubmitted($_POST['title'], $_POST['chapo'], $_POST['content']);
        } else if ($_GET['action'] === 'admin/edit-post') {
          echo $controller->editPost((int) $_GET['id']);
        } else if ($_GET['action'] === 'admin/edit-post/editPostSubmitted') {
          echo $controller->editPostSubmitted((int) $_GET['id'], $_POST['title'], $_POST['chapo'], $_POST['content']);
        } else if ($_GET['action'] === 'admin/delete-post') {
          echo $controller->deletePostSubmitted((int) $_GET['id']);
        } else {
          echo 'page inconnue';
        }
      } else {
        echo $controller->home();
      }
    } catch (Exception $e) {
      echo 'Erreur';
    }
  }
}
