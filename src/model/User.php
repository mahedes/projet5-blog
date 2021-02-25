<?php

/**
 * @todo: typage + security password
 */

namespace App\model;

class User
{
  private $id;
  private $pseudo;
  private $name;
  private $firstname;
  private $email;
  private $password;
  private $admin_status;
  private $createdAd;

  public function getId()
  {
    return $this->id;
  }
  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getPseudo()
  {
    return $this->pseudo;
  }
  public function setPseudo($pseudo)
  {
    $this->pseudo = $pseudo;
  }

  public function getName()
  {
    return $this->name;
  }
  public function setName($name)
  {
    $this->name = $name;
  }

  public function getFirstname()
  {
    return $this->firstname;
  }
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }

  public function getEmail()
  {
    return $this->email;
  }
  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getPassword()
  {
    return $this->password;
  }
  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getAdminStatus()
  {
    return $this->admin_status;
  }
  public function setAdminStatus($admin_status)
  {
    $this->admin_status = $admin_status;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }
}
