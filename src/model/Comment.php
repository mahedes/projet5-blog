<?php

namespace App\model;

class Comment
{
    private $_id;
    private $_XauthorComment;
    private $_createdAt;
    private $_content;
    private $_validationStatus;
    /** 
     * @var Post
     */
    private $_post;

    public function getId()
    {
        return $this->_id;
    }
    public function setId(int $_id)
    {
        $this->_id = $_id;
    }

    public function getAuthor()
    {
        return $this->_authorComment;
    }
    public function setAuthor($_authorComment)
    {
        $this->_authorComment = $_authorComment;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
    }
    public function setCreatedAt($_createdAt)
    {
        $this->_createdAt = $_createdAt;
    }

    public function getContent()
    {
        return $this->_content;
    }
    public function setContent($_content)
    {
        $this->_content = $_content;
    }

    public function getValidationStatus()
    {
        return $this->_validationStatus;
    }
    public function setValidationStatus($_validationStatus)
    {
        $this->_validationStatus = $_validationStatus;
    }

    public function getPost()
    {
        return $this->_post;
    }
    // public function setPost(Post $post)
    public function setPost($_post)
    {
        $this->_post = $_post;
    }
}
