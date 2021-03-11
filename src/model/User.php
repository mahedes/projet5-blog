<?php

namespace App\model;

class User
{
    private $_idUser;
    private $_pseudo;
    private $_name;
    private $_firstname;
    private $_email;
    private $_password;
    private $_adminStatus;
    private $_createdAt;

    public function getId()
    {
        return $this->_idUser;
    }
    public function setId(int $_idUser)
    {
        $this->_idUser = $_idUser;
    }

    public function getPseudo()
    {
        return $this->_pseudo;
    }
    public function setPseudo($_pseudo)
    {
        $this->_pseudo = $_pseudo;
    }

    public function getName()
    {
        return $this->_name;
    }
    public function setName($_name)
    {
        $this->_name = $_name;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }
    public function setFirstname($_firstname)
    {
        $this->_firstname = $_firstname;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    public function setEmail($_email)
    {
        $this->_email = $_email;
    }

    public function getPassword()
    {
        return $this->_password;
    }
    public function setPassword($_password)
    {
        $this->_password = $_password;
    }

    public function getAdminStatus()
    {
        return $this->_adminStatus;
    }
    public function setAdminStatus($_adminStatus)
    {
        $this->_adminStatus = $_adminStatus;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
    }
    public function setCreatedAt($_createdAt)
    {
        $this->_createdAt = $_createdAt;
    }
}
