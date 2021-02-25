<?php

namespace App\model;

class Comment
{
  private $id;
  private $author;
  private $createdAt;
  private $content;
  private $validationStatus;
  /**
   * @var Post
   */
  private $post;

  public function getId()
  {
    return $this->id;
  }
  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getAuthor()
  {
    return $this->author;
  }
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }

  public function getContent()
  {
    return $this->content;
  }
  public function setContent($content)
  {
    $this->content = $content;
  }

  public function getValidationStatus()
  {
    return $this->validationStatus;
  }
  public function setValidationStatus($validationStatus)
  {
    $this->validationStatus = $validationStatus;
  }

  public function getPost()
  {
    return $this->post;
  }
  public function setPost(Post $post)
  {
    $this->post = $post;
  }
}
