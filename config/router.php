<?php

namespace App\Config;

use App\Controller\HomeController;
use App\Controller\BlogController;
use Exception;

class Router
{
  public function run()
  {
    try {
      if (isset($_GET['action'])) {
        if ($_GET['action'] === 'blog') {
          $controller = new BlogController;
          echo $controller->blog();
        } else {
          echo 'page inconnue';
        }
      } else if (isset($_GET['action'])) {
        if ($_GET['action'] === 'article') {
          echo 'page article';
        } else {
          echo 'page inconnue';
        }
      } else {
        $controller = new HomeController;
        echo $controller->home();
      }
    } catch (Exception $e) {
      echo 'Erreur';
    }
  }
}
