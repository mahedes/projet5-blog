<?php

namespace App\Config;

class Session
{
  private $session;

  public function __construct($session)
  {
    $this->session = $session;
  }

  public function start()
  {
    session_start();
  }
}
