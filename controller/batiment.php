<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();


if (isset($_GET['upgrade'])) {



    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/view/batimentsToJson.php";
    include_once($path);


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/batimentManager.php";
    include_once($path);

    $batiment = upgradeBatiment($_GET['upgrade']);
    if (isset($batiment)) {
        echo getBatimentsToJson(array($batiment));
    } else {
        echo "erreur";
    }
}


if (isset($_GET['all'])) {

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/batimentManager.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/view/batimentsToJson.php";
    include_once($path);


    $batiments = getBatimentsOfUser();

    echo getBatimentsToJson($batiments);
}
