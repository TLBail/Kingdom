<?php

function getUnitByName($name)
{


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/unit.class.php";
    include_once($path);

    $user = getUser();


    $sql = "SELECT * FROM `BATIMENT` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));
}
