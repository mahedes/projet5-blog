<?php

namespace App\Controller;

use \App\config\View;

class BlogController
{
  public function blog()
  {
    return View::twig()->render('blog.html.twig');
  }
}
