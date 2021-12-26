<?php


function getBDD()
{
    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/dc.inc.php";
    include($path);
    return new PDO("$server:host=$host;dbname=$base", $user, $pass);
}
