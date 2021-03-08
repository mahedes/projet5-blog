<?php

namespace App\model;

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
    $users->setId((int) $row['idUser']);
    $users->setPseudo($row['pseudo']);
    $users->setName($row['name']);
    $users->setFirstname($row['firstname']);
    $users->setEmail($row['email']);
    $users->setPassword($row['password']);
    $users->setAdminStatus((bool) $row['admin_status']);
    $createAt = $row['created_at'];
    $users->setCreatedAt($createAt);
    return $users;
  }

  public function getUsersAdmin()
  {
    $result = $this->connection->query(
      'SELECT id idUser, pseudo FROM users WHERE admin_status = 1'
    );

    $usersAdmin = $result->fetchAll(\PDO::FETCH_ASSOC);

    return $usersAdmin;
  }

  public function register(string $pseudo, string $name, string $firstname, string $email, string $password)
  {
    $req = $this->connection->prepare('INSERT INTO users(pseudo, name, firstname, email, password, admin_status, created_at) VALUES(:pseudo, :name, :firstname, :email, :password, :adminStatus, :createdAt)');
    $req->execute(array(
      'pseudo' => $pseudo,
      'name' => $name,
      'firstname' => $firstname,
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'adminStatus' => 0,
      'createdAt' => date("Y-m-d H:i:s")
    ));
  }

  public function login(string $email)
  {
    $result = $this->connection->query(
      'SELECT id idUser, pseudo, name, firstname, email, password, admin_status, created_at FROM users WHERE email = \'' . $email . '\''
    );

    $data = $result->fetchAll(\PDO::FETCH_ASSOC);
    $modelUser = $this->build($data[0]);

    return $modelUser;
  }
}
