<?php


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();

include("../model/chatManager.php");

include("../view/chatView.php");

$chats = getMessages();
chatsToHTML($chats);
