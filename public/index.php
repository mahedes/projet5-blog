<?php
// error_reporting(E_ALL);
require '../vendor/autoload.php';
require '../config/router.php';
require '../config/view.php';

session_start();



foreach ($_SESSION as $row) {
  echo $row;
}

$router = new App\Config\Router();
$router->run();
