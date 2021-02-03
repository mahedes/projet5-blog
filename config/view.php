<?php

namespace App\Config;

class View
{
  public static function twig()
  {
    $loader = new \Twig\Loader\FilesystemLoader('../template');
    $twig = new \Twig\Environment($loader, [
      'cache' => false
    ]);
    return $twig;
  }
}
