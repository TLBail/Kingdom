<?php


class User
{

    private $id;
    private $username;
    private $lastTimeOnline;
    private $position;

    public function __construct($id, $username, $lastTimeOnline, $position)
    {
        $this->id = $id;
        $this->username = $username;
        $this->lastTimeOnline = $lastTimeOnline;
        $this->position = $position;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getLastTimeOnline()
    {
        return $this->lastTimeOnline;
    }

    public function getPosition()
    {
        return $this->position;
    }
}
