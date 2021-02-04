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
          echo $controller->post($_GET['id']);
        } else {
          echo 'page inconnue2';
          echo $_GET['id'];
        }
      } else {
        echo $controller->home();
      }
    } catch (Exception $e) {
      echo 'Erreur';
    }
  }
}
