<?php
require '../vendor/autoload.php';
require '../config/router.php';
require '../config/view.php';

use App\Config\Router;

session_start();

$router = new Router();
$router->run();
