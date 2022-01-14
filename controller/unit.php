<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();
if (isset($_GET['addUnite'])) {
    echo 'ajout de ' . $_GET['addUnite'] .  $_GET['addUniteName'];
    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/unitManager.php";
    include_once($path);
    addUnit($_GET['addUniteName'], $_GET['addUnite']);
}


if (isset($_GET['all'])) {

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/unitManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/view/unitsToJson.php";
    include_once($path);

    $units = getUnitsOfUser();
    echo getUnitToJson($units);
}
