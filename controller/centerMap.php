<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


session_start();

$path = explode("/projet", __DIR__)[0] . "/projet";
$path .= "/model/userManager.php";
include_once($path);

$path = explode("/projet", __DIR__)[0] . "/projet";
$path .= "/model/user.class.php";
include_once($path);

echo getUser()->getPosition();