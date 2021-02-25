<?php

namespace App\model;

use PDOException;

class UserManager extends Database
{
  private $db;
  private $connection;

  public function __construct()
  {
    $this->db = new Database();
    $this->connection = $this->db->getConnection();
  }

  public function build($row): User
  {
    $users = new User;
    $users->setId($row['idUser']);
    $users->setPseudo($row['pseudo']);
    $users->setName($row['name']);
    $users->setFirstname($row['firstname']);
    $users->setEmail($row['email']);
    $users->setPassword($row['password']);
    $users->setAdminStatus($row['adminStatus']);
    $createAt = $row['createdAt'];
    $users->setCreatedAt($createAt);
    return $users;
  }

  public function register($pseudo, $name, $firstname, $email, $password)
  {
    $req = $this->connection->prepare('INSERT INTO users(pseudo, name, firstname, email, password, admin_status, created_at) VALUES(:pseudo, :name, :firstname, :email, :password, :adminStatus, :createdAt)');
    $req->execute(array(
      'pseudo' => $pseudo,
      'name' => $name,
      'firstname' => $firstname,
      'email' => $email,
      'password' => $password,
      'adminStatus' => 0,
      'createdAt' => date("Y-m-d H:i:s")
    ));
    header('Location: index.php');
  }
}
