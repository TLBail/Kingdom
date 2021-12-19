<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();


if (isset($_GET['upgrade'])) {


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $lvl = upgradeBatiment($_GET['upgrade']);
    if (isset($lvl)) {
        $lvlBat[$_GET['upgrade']] = $lvl;
        echo json_encode($lvlBat);
    } else {
        echo "erreur";
    }
}

if (isset($_GET['lvl'])) {



    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/view/batimentsLvlToJson.php";
    include_once($path);


    $batiments = getBatimentsOfUser();

    echo json_encode(getLvlInJsonFromBatiments($batiments));
}
