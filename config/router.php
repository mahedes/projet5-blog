<?php

namespace App\Config;

use App\Controller\FrontController;
use App\Controller\AdminController;
use App\Controller\RegistrationController;
use App\Controller\SecurityController;

use Exception;

class Router
{
  public static function run()
  {
    $frontController = new FrontController;
    $adminController = new AdminController;
    $registrationController = new RegistrationController;
    $securityController = new SecurityController;

    try {
      if (isset($_GET['action'])) {

        // FrontController
        if ($_GET['action'] === 'blog') {
          echo $frontController->blog();
        } else if ($_GET['action'] === 'article') {
          echo $frontController->post($_GET['id']);
        } else if ($_GET['action'] === 'add-comment') {
          echo $frontController->newComment($_GET['postId'], $_POST['coms']);
        }

        // RegistrationController
        else if ($_GET['action'] === 'register') {
          echo $registrationController->register();
        } else if ($_GET['action'] === 'registrationSubmitted') {
          echo $registrationController->registerSubmit($_POST['pseudo'], $_POST['name'], $_POST['firstname'], $_POST['email'], $_POST['password']);
        } else if ($_GET['action'] === 'contactFormSubmitted') {
          echo $frontController->sendMail($_POST['name'], $_POST['email'], $_POST['message']);
        }

        // SecurityControllers
        else if ($_GET['action'] === 'login') {
          echo $securityController->login();
        } else if ($_GET['action'] === 'loginSubmitted') {
          echo $securityController->loginSubmit($_POST['email'], $_POST['password']);
        } else if ($_GET['action'] === 'logout') {
          echo $securityController->logout();
        }

        // AdminController
        else if ($_GET['action'] === 'admin') {
          echo $adminController->admin();
        } else if ($_GET['action'] === 'admin/allow-comment') {
          echo $adminController->allowComment((int) $_GET['idComment']);
        } else if ($_GET['action'] === 'admin/delete-comment') {
          echo $adminController->deleteComment((int) $_GET['idComment']);
        } else if ($_GET['action'] === 'admin/add-post') {
          echo $adminController->newPost();
        } else if ($_GET['action'] === 'admin/add-post/newPostSubmitted') {
          echo $adminController->newPostSubmitted($_POST['title'], $_POST['chapo'], $_POST['content']);
        } else if ($_GET['action'] === 'admin/edit-post') {
          echo $adminController->editPost((int) $_GET['id']);
        } else if ($_GET['action'] === 'admin/edit-post/editPostSubmitted') {
          echo $adminController->editPostSubmitted((int) $_GET['id'], $_POST['title'], $_POST['chapo'], $_POST['author'], $_POST['content']);
        } else if ($_GET['action'] === 'admin/delete-post') {
          echo $adminController->deletePostSubmitted((int) $_GET['id']);
        } else {
          echo $frontController->home();
        }
      } else {
        echo $frontController->home();
      }
    } catch (Exception $e) {
      echo 'Erreur';
    }
  }
}
