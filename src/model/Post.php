<?php

namespace App\model;

class Post
{
    private $_idPost;
    private $_title;
    private $_author;
    private $_createdAt;
    private $_updatedAt;
    private $_chapo;
    private $_content;
    /**
     * @var array < Comment >
     */
    private $_comments;

    public function getId()
    {
        return $this->_idPost;
    }
    public function setId(int $_idPost)
    {
        $this->_idPost = $_idPost;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($_title)
    {
        $this->_title = $_title;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
    }

    public function setCreatedAt($_createdAt)
    {
        $this->_createdAt = $_createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->_updatedAt;
    }

    public function setUpdatedAt($_updatedAt)
    {
        $this->_updatedAt = $_updatedAt;
    }

    public function getChapo()
    {
        return $this->_chapo;
    }

    public function setChapo($_chapo)
    {
        $this->_chapo = $_chapo;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setContent($_content)
    {
        $this->_content = $_content;
    }

    public function getAuthor()
    {
        return $this->_author;
    }
    public function setAuthor($_author)
    {
        $this->_author = $_author;
    }

    // OneToMany
    public function getComments()
    {
        return $this->_comments;
    }
    public function setComments(Comment $_comments)
    {
        $this->_comments[] = $_comments;
    }
}
