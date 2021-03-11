<?php

namespace App\Config;

class View
{
    private static $_twig;

    /**
     * Configuration of Twig template : https://twig.symfony.com/
     */
    public static function twig()
    {
        if (self::$_twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader('../template');
            self::$_twig = new \Twig\Environment(
                $loader,
                [
                    'cache' => false,
                    'debug' => true
                ]
            );
            self::$_twig->addGlobal('session', $_SESSION);
            self::$_twig->addExtension(new \Twig\Extension\DebugExtension); // active dump() function
        }
        return self::$_twig;
    }
}
