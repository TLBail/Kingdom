<?php


class Chat
{

    private $id;
    private $userId;
    private $messageText;
    private $channelId;

    private $user;

    public function __construct($Id, $userId, $messageText, $channelId)
    {
        $this->id = $Id;
        $this->userId = $userId;
        $this->messageText = $messageText;
        $this->channelId = $channelId;
    }

    public function getChannelId()
    {
        return $this->channelId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMessageText()
    {
        return $this->messageText;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUser($user)
    {
        return $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
