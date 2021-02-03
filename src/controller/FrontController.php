<?php

namespace App\Controller;

use \App\config\View;

class FrontController
{
  public function home()
  {
    return View::twig()->render('home.html.twig');
  }
  public function blog()
  {
    return View::twig()->render('blog.html.twig');
  }
  public function post()
  {
    return View::twig()->render('post.html.twig');
  }
}
