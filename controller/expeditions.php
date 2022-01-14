<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);





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
