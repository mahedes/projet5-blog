<?php

namespace App\Config;

class View
{
  private static $twig;

  public static function twig()
  {
    if (self::$twig == null) {
      $loader = new \Twig\Loader\FilesystemLoader('../template');
      self::$twig = new \Twig\Environment($loader, [
        'cache' => false,
        'debug' => true
      ]);
      self::$twig->addGlobal('session', $_SESSION);
      self::$twig->addExtension(new \Twig\Extension\DebugExtension); // active dump() function
    }
    return self::$twig;
  }
}
