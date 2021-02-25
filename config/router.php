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
          echo $controller->loginSubmit($_POST['pseudo'], $_POST['password']);
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
