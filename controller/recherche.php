<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();


if (isset($_GET['upgrade'])) {


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/view/rechercheToJson.php";
    include_once($path);


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/rechercheManager.php";
    include_once($path);

    $recherche = upgradeRecherche($_GET['upgrade']);
    if (isset($recherche)) {
        echo getRechercheToJson(array($recherche));
    } else {
        echo "erreur";
    }
}


if (isset($_GET['all'])) {

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/rechercheManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/view/rechercheToJson.php";
    include_once($path);


    $recherche = getRechercheOfUser();
    echo getRechercheToJson($recherche);
}
