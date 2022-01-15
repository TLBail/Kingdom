<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


session_start();





if (isset($_GET['all'])) {

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expeditionsManager.php";
    include_once($path);


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/view/expeditionsView.php";
    include_once($path);


    $expeditions = getExpedition();

    echo viewExpedition($expeditions);
}


if (isset($_GET['new'])) {

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expeditionsManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/unit.class.php";
    include_once($path);

    $coo = $_GET['coo'];

    $units = array();
    $index = 0;
    if (isset($_GET['chasseur']) && $_GET['chasseur'] > 0) {
        $units[$index] =  new Unit("chasseur", $_GET['chasseur'], 0, 0, 0);
        $index++;
    }

    if (isset($_GET['chevalier']) && isset($_GET['chevalier']) > 0) {
        $units[$index] =  new Unit("chevalier", $_GET['chevalier'], 0, 0, 0);
        $index++;
    }

    if (isset($_GET['templier']) && isset($_GET['templier']) > 0) {
        $units[$index] =  new Unit("templier", $_GET['templier'], 0, 0, 0);
        $index++;
    }
    if (count($units) == 0) {
        echo "pas d'unit" . $index;
        return;
    }
    addnewExpedition($units, $coo);
}


if (isset($_GET['players'])) {

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expeditionsManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/view/playersToJson.php";
    include_once($path);

    $players = getPlayersForExpeditions();

    echo playersToJson($players);
}
