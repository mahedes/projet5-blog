<?php

namespace App\model;

class Post
{
  private $idPost;
  private $title;
  private $author;
  private $createdAt;
  private $updatedAt;
  private $chapo;
  private $content;
  /**
   * @var array < Comment >
   */
  private $comments;

  public function getId()
  {
    return $this->idPost;
  }
  public function setId(int $idPost)
  {
    $this->idPost = $idPost;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
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

  // OneToMany
  public function getComments()
  {
    return $this->comments;
  }
  public function setComments(Comment $comments)
  {
    $this->comments[] = $comments;
  }
}
