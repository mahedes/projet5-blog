<?php
// error_reporting(E_ALL);
//On inclut le fichier dont on a besoin (ici à la racine de notre site)
// require 'model/Database.php';
// require 'model/PostManager.php';
require '../vendor/autoload.php';
require '../config/router.php';
require '../config/view.php';


//echo $twig->render('blog.html.twig');

$router = new App\Config\Router();
$router->run();
