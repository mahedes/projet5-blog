<?php

namespace App\model;

class User
{
  private $idUser;
  private $pseudo;
  private $name;
  private $firstname;
  private $email;
  private $password;
  private $adminStatus;
  private $createdAt;

  public function getId()
  {
    return $this->idUser;
  }
  public function setId(int $idUser)
  {
    $this->idUser = $idUser;
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
    return $this->adminStatus;
  }
  public function setAdminStatus($adminStatus)
  {
    $this->adminStatus = $adminStatus;
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
