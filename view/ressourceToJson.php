<?php

function ressourcesToJson($ressources, $buildings)
{
    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    // on récupère les stockage maximal (10 000 = stockage de base sans entrepot)
    $boisMax = 10000;
    $pierreMax = 10000;
    $nourritureMax = 10000;

    foreach ($buildings as $building) {
        if (strcmp($building->getType(), "EntrepotDeBois") == 0) {
            $boisMax = $building->getStorageCapacity();
        }
        if (strcmp($building->getType(), "EntrepotDePierre") == 0) {
            $pierreMax = $building->getStorageCapacity();
        }
        if (strcmp($building->getType(), "Silo") == 0) {
            $nourritureMax = $building->getStorageCapacity();
        }
    }




    $index = 1;
    foreach ($ressources as $ressource) {
        $arrayToEncode[$ressource->getType()] = array(
            "amout" => floor($ressource->getAmount())
        );
        if (strcmp($ressource->getType(), "bois") == 0) {
            $arrayToEncode[$ressource->getType()]["capacity"] = $boisMax;
        }
        if (strcmp($ressource->getType(), "pierre") == 0) {
            $arrayToEncode[$ressource->getType()]["capacity"] = $pierreMax;
        }
        if (strcmp($ressource->getType(), "nourriture") == 0) {
            $arrayToEncode[$ressource->getType()]["capacity"] = $nourritureMax;
        }

        $index = $index + 1;
    }
    if (isset($arrayToEncode)) {
        return json_encode($arrayToEncode);
    }
}
