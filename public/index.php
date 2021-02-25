<?php
// error_reporting(E_ALL);
require '../vendor/autoload.php';
require '../config/router.php';
require '../config/view.php';

$router = new App\Config\Router();
$router->run();
