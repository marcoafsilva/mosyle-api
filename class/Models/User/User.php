<?php

namespace Api\Models\User;

use Api\Controllers\ControllerInterface;

class User extends ControllerInterface
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;

    public function __construct($userId = null)
    {
        if ($userId) {
            $this->id = $userId;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;
        return $this;
    }
}