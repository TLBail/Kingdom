<?php

function ressourcesToJson($ressources)
{
    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    $index = 1;
    foreach ($ressources as $ressource) {
        $arrayToEncode[$ressource->getType()] = floor($ressource->getAmount());
        $index = $index + 1;
    }
    if (isset($arrayToEncode)) {
        return json_encode($arrayToEncode);
    }
}
