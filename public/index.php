<?php
require '../vendor/autoload.php';
require '../config/router.php';
require '../config/view.php';

session_start();

$router = new \App\Config\Router();
$router->run();
