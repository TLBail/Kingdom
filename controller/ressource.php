<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



session_start();


if (isset($_GET['upgrade'])) {



    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/view/batimentToJson.php";
    include_once($path);


    $path = explode("/projet", __DIR__ )[0]."/projet";
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

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/view/ressourceToJson.php";
    include_once($path);


    $batiments = getRessourcesAtConnection();

    echo ressourcesToJson($batiments);
}

if (isset($_GET['start'])) {
    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    $ressources = ressourcesAtConnection();

    $values;
    foreach ($ressources as $ressource) {
        if (!isset($values)) $values .= $ressource->getAmount();
        else $values .= "/" . $ressource->getAmount();
    }

    echo $values;
}

if (isset($_GET['villageois'])) {
    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    echo getRessourceByName("villageois");
}
