<?php

namespace App\Controller;

use \App\config\View;
use \App\model\UserManager;


class RegistrationController
{
    public function __construct()
    {
        if (empty($_GET['submit'])) {
            unset($_SESSION['flash']);
            unset($_SESSION['error']);
        }
    }

    public function register()
    {
        return View::twig()->render('registration/registration.html.twig');
    }

    public function registerSubmit(string $new_user_pseudo, string $new_user_name, string $new_user_firstname, string $new_user_email, string $new_user_password)
    {
        if (empty($new_user_pseudo) || empty($new_user_name) || empty($new_user_firstname) || empty($new_user_password)  || !filter_var($new_user_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Informations submitted are not valid';
            header('Location: ../public/index.php?action=register&submit=error');
        } else {
            $pseudo = strip_tags(htmlspecialchars($new_user_pseudo));
            $name = strip_tags(htmlspecialchars($new_user_name));
            $firstname = strip_tags(htmlspecialchars($new_user_firstname));
            $email = strip_tags(htmlspecialchars($new_user_email));
            $password = strip_tags(htmlspecialchars($new_user_password));

            $userManager = new UserManager();
            $newUser = $userManager->register($pseudo, $name, $firstname, $email, $password);
            $_SESSION['flash'] = 'Your account has been created successfully';
            header('Location: ../public/index.php?action=login&submit=success');
        }
    }
}
