<?php
// mettre tous les attributs et getter/setter pour la table post ( à faire pr chaque table )
namespace App\model;

class Comment
{
  private $id;
  private $author;
  private $dayMonthYear;
  private $hour;
  private $content;
  private $validationStatus;

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

  public function getDayMonthYear()
  {
    return $this->dayMonthYear;
  }
  public function setDayMonthYear($dayMonthYear)
  {
    $this->dayMonthYear = $dayMonthYear;
  }

  public function getHour()
  {
    return $this->hour;
  }
  public function setHour($hour)
  {
    $this->hour = $hour;
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
}
