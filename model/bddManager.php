<?php




function getBDD()
{
    // static $bddBackup;
    // if($bddBackup != null) return $bddBackup;

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/dc.inc.php";
    include($path);

    $GLOBALS['bdd'] = new PDO("$server:host=$host;dbname=$base", $user, $pass);

    // $bddBackup = new PDO("$server:host=$host;dbname=$base", $user, $pass);
    // return $bddBackup;
    return $GLOBALS['bdd'];
}
