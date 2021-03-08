<?php

namespace App\Controller;

use \App\config\View;
use \App\model\UserManager;


class SecurityController
{
  public function __construct()
  {
    if (empty($_GET['submit'])) {
      unset($_SESSION['flash']);
      unset($_SESSION['error']);
    }
  }

  public function login()
  {
    return View::twig()->render('security/login.html.twig');
  }

  public function loginSubmit(string $user_email, string $user_password)
  {
    if (empty($user_password)  || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['error'] = 'Informations submitted are not valid';
      header('Location: ../public/index.php?action=login&submit=error');
    } else {
      $email = strip_tags(htmlspecialchars($user_email));
      $password = strip_tags(htmlspecialchars($user_password));

      $userManager = new UserManager();
      $userLogin = $userManager->login($email);

      if (password_verify($password, $userLogin->getPassword())) {
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
  }

  public function logout()
  {
    session_destroy();
    header('Location: ../public/index.php');
  }
}
