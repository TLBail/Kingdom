<?php

function getRessourceByName($ressourceName)
{
    if ($ressourceName == "villageois") {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
        $path .= "/model/batimentManager.php";
        include_once($path);
        $buildings = getBatimentsofUser();

        $total = 0;
        foreach ($buildings as $building) {
            if (strcmp($building->getType(), "Immeuble") == 0 || strcmp($building->getType(), "Maison") == 0) {
                $total += $building->getRessourceRatePerHour();
            } else {
                $total -= $building->getTotalVillageoisCost();
            }
        }
        return floor($total);
    }

    $ressources = getRessourcesAtConnection();
    foreach ($ressources as $ressource) {
        if (strcmp($ressource->getType(), $ressourceName)) {
            return $ressource->getAmount();
        }
    }
}

function getRessourcesAtConnection()
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);
    $bdd = getBDD();


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/batimentManager.php";
    include_once($path);
    $buildings = getBatimentsofUser();

    $time = time();
    $elapsedTime = (time() - strtotime($user->getLastTimeOnline())) / 3600;
    $ressources = getRessources($bdd);


    foreach ($ressources as $ressource) {
        foreach ($buildings as $building) {
            if (isBuildingAndRessourceBound($building->getType(), $ressource->getType())) {
                $rate = $building->getRessourceRatePerHour();
                $ressource->addAmount($rate * $elapsedTime);
                updateRessourceOfUser($ressource);
            }
        }
    }

    updateLastTimeOnlineOfUser();

    return $ressources;
}

function updateLastTimeOnlineOfUser()
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);
    $bdd = getBDD();

    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');

    $sql = "UPDATE `USER` SET `lastTimeOnline` = ? WHERE `USER`.`id` = ? ";
    $query = $bdd->prepare($sql);
    $query->execute(array($dateTime, $user->getId()));
}


function getRessources()
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    $user = getUser();


    $array = array();
    $sql = "select * from RESSOURCES where playerId=" . $user->getId();
    $response = getBDD()->query($sql);
    if (is_object($response)) {
        $line = $response->fetch();
        array_push($array, new Ressource('bois', $line['bois']));
        array_push($array, new Ressource('pierre', $line['pierre']));
        array_push($array, new Ressource('nourriture', $line['nourriture']));
    }
    return $array;
}

function isBuildingAndRessourceBound($buildingType, $ressourceType)
{
    if ($buildingType == 'Scierie' && $ressourceType == 'bois') return true;
    if ($buildingType == 'Carriere' && $ressourceType == 'pierre') return true;
    if ($buildingType == 'Ferme' && $ressourceType == 'nourriture') return true;
    if ($buildingType == 'Maison' && $ressourceType == 'villageois') return true;
    if ($buildingType == 'Immeuble' && $ressourceType == 'villageois') return true;
    return false;
}


function updateRessourceOfUser($ressource)
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);
    $bdd = getBDD();

    $sql = "UPDATE `RESSOURCES` SET `" . $ressource->getType() . "`= ? WHERE `RESSOURCES`.`playerId` = ? ";
    $query = $bdd->prepare($sql);
    $query->execute(array($ressource->getAmount(), $user->getId()));
}


/*function updateBDD($bdd, $ressources, $time, $playerId)
{
    updateTime($bdd, $time, $playerId);
    updateRessources($bdd, $ressources, $playerId);
}

function updateTime($bdd, $time, $playerId)
{
    $updateRequest = '';
    $bdd->exec($updateRequest);
}

function updateRessources($bdd, $ressources, $playerId)
{
    $updateRequest = 'update RESSOURCES set ';
    $endRequest = ' where playerId='.$playerId;
    
    foreach ($ressources as $ressource) {
        if($ressource == $ressources->end())
            $updateRessources .= $ressource->getType() .'='.$ressource->getAmount();
        else
            $updateRessources .= $ressource->getType() .'='.$ressource->getAmount().', ';
    }
    $updateRequest .= $endRequest;
    $bdd->exec($updateRequest);
}*/