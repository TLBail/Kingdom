<?php


function getBDD()
{
    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/dc.inc.php";
    include($path);
    return new PDO("$server:host=$host;dbname=$base", $user, $pass);
}
