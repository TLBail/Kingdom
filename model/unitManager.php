<?php

function getUnitsOfUser()
{
    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/unit.class.php";
    include_once($path);

    $user = getUser();


    $sql = "SELECT * FROM `UNIT` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));

    $units;
    foreach ($query as $line) {
        $remainingTime = 0;
        if($line['dateTimeAtlastUpdate']) && isset($line['remaningTimeUpgrade'])){
            $elapsedTime = time() - strtotime($line['dateTimeAtlastUpdate']);
            $remainingTime = $line['remaningTimeUpgrade'] - $elapsedTime;
            if ($remainingTime < 0) {
                $line['nbUnit'] += $line['nbUnitToAdd'];
                $line['nbUnitToAdd'] = 0;
                $line['remaningTimeUpgrade'] = 0;
            }
            $line['remaningTimeUpgrade'] = $remainingTime;
        }
        array_push($units, new Unit($line['unitName'], $line['nbUnit'], $line['remaningTimeUpgrade'],$line['nbUnitToAdd'], $line['dateTimeLastUpdate']));
    }
    updateBdd($units);
    return $units;
}


function getUnitByName($name)
{
    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/unit.class.php";
    include_once($path);

    $user = getUser();


    $sql = "SELECT * FROM `UNIT` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));

    $unit;
    foreach ($query as $line) {
        if($line['unitName'] == $name)
            return new Unit($line['unitName'], $line['nbUnit'], $line['remaningTimeUpgrade'],$line['nbUnitToAdd'], $line['dateTimeLastUpdate']);
    }
}

function updateBdd($unit_array){
    $bdd = getBDD();
    $user = getUser();

    $sql = "UPDATE BATIMENT SET dateTimeAtlastUpdate= ? WHERE playerId= ? AND type= ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array((new \DateTime())->format('Y-m-d H:i:s'), $user->getId(), $batiment->getType()));
    }

    $sql = "UPDATE `UNIT` set `remaningTimeUpgrade` = ? WHERE `playerId` = ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array($unit->getRemainingTime(), $user->getId()));
    }
}

function addUnit($name, $nb){
    $unit = getUnitByName($name);
    if(!isset($unit)){
        echo "test"
        $bdd = getBDD();
        $sql = "INSERT INTO `UNIT` (`playerId`, `unitName`, `nbUnit`, `dateTimeLastUpdate`, `nbUnitToAdd`, `remaningTimeUpgrade`)  VALUES (? , ?, ?, NULL,NULL,NULL)";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $name, $nb));
        $unit = getUnitByName($name);
    }
    $unit->setNumberToAdd($nb);
    $unit->timeRemainingGenerate();
}