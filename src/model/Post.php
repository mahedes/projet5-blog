<?php
// mettre tous les attributs et getter/setter pour la table post ( à faire pr chaque table )
namespace App\model;

class Post
{
  private $id;
  private $title;
  private $createdAt;
  private $updatedAt;
  private $chapo;
  private $content;
  private $author;

  public function getId()
  {
    return $this->id;
  }
  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle(string $title)
  {
    $this->title = $title;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;
  }

  public function getChapo()
  {
    return $this->chapo;
  }

  public function setChapo($chapo)
  {
    $this->chapo = $chapo;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }

  public function getAuthor()
  {
    return $this->author;
  }

  public function setAuthor($author)
  {
    $this->author = $author;
  }
}
