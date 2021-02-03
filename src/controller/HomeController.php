<?php

namespace App\Controller;

use \App\config\View;

class HomeController
{
  public function home()
  {
    return View::twig()->render('home.html.twig');
  }
}
