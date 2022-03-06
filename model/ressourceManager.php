<?php

function getRessourceByName($ressourceName)
{

    if ($ressourceName == "villageois") {
        $path = explode("/projet", __DIR__)[0] . "/projet";
        $path .= "/model/batimentManager.php";
        include_once($path);
        $buildings = getBatimentsofUser();

        $path = explode("/projet", __DIR__)[0] . "/projet";
        $path .= "/model/rechercheManager.php";
        include_once($path);
        $recherches = getRechercheMapOfUser();

        if ($buildings == null) return null;
        $total = 0;
        foreach ($buildings as $building) {
            if (strcmp($building->getType(), "Immeuble") == 0 || strcmp($building->getType(), "Maison") == 0) {
                $total += $building->getRessourceRatePerHour($recherches);
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

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);
    $bdd = getBDD();


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/batimentManager.php";
    include_once($path);
    $buildings = getBatimentsofUser();

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/rechercheManager.php";
    include_once($path);
    $recherches = getRechercheMapOfUser();

    $time = time();
    $elapsedTime = (time() - strtotime($user->getLastTimeOnline())) / 3600;
    $ressources = getRessources($bdd);

    //si le nombre de villageois dispo est négatif on divise la prod par 2
    $villageois = getRessourceByName("villageois");
    if ($villageois < 0) $elapsedTime =  $elapsedTime / 2;

    foreach ($ressources as $ressource) {
        foreach ($buildings as $building) {
            if (isBuildingAndRessourceBound($building->getType(), $ressource->getType())) {
                $rate = $building->getRessourceRatePerHour($recherches);
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

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expeditionsManager.php";
    include_once($path);
    $user = getUser();


    updateExpedition();


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = explode("/projet", __DIR__)[0] . "/projet";
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

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);


    $path = explode("/projet", __DIR__)[0] . "/projet";
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

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);
    $user = getUser();

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/ressource.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);
    $bdd = getBDD();

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/batimentManager.php";
    include_once($path);
    $buildings = getBatimentsofUser();

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

    // on bloque les ressource au seuil si supérieurr a la capacité
    if (strcmp($ressource->getType(), "bois") == 0 && $ressource->getAmount() > $boisMax) $ressource->setAmount($boisMax);
    if (strcmp($ressource->getType(), "pierre") == 0 && $ressource->getAmount() > $pierreMax) $ressource->setAmount($pierreMax);
    if (strcmp($ressource->getType(), "nourriture") == 0 && $ressource->getAmount() > $nourritureMax) $ressource->setAmount($nourritureMax);

    // on update les valeurs dans la bdd
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