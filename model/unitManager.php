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

    $units = array();
    foreach ($query as $line) {
        $remainingTime = 0;
        if (isset($line['dateTimeLastUpdate']) && isset($line['remaningTimeUpgrade'])) {
            $elapsedTime = time() - strtotime($line['dateTimeLastUpdate']);
            $remainingTime = $line['remaningTimeUpgrade'] - $elapsedTime;
            if ($remainingTime < 0) {
                $line['nbUnit'] += $line['nbUnitToAdd'];
                $line['nbUnitToAdd'] = 0;
                $line['remaningTimeUpgrade'] = 0;
            }
            $line['remaningTimeUpgrade'] = $remainingTime;
        }
        array_push($units, new Unit($line['unitName'], $line['nbUnit'], $line['remaningTimeUpgrade'], $line['nbUnitToAdd'], $line['dateTimeLastUpdate']));
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
        if ($line['unitName'] == $name)
            return new Unit($line['unitName'], $line['nbUnit'], $line['remaningTimeUpgrade'], $line['nbUnitToAdd'], $line['dateTimeLastUpdate']);
    }
}

function updateBdd($unit_array)
{
    $bdd = getBDD();
    $user = getUser();

    $sql = "UPDATE UNIT SET dateTimelastUpdate= ? WHERE playerId= ? AND unitName= ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array((new \DateTime())->format('Y-m-d H:i:s'), $user->getId(), $unit->getName()));
    }

    $sql = "UPDATE `UNIT` set `remaningTimeUpgrade` = ? WHERE `playerId` = ? AND unitName= ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array($unit->getTimeRemainingAmelioration(), $user->getId(), $unit->getName()));
    }

    $sql = "UPDATE `UNIT` set `nbUnitToAdd` = ? where `playerId` = ? AND unitName= ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array($unit->getNbToAdd(), $user->getId(), $unit->getName()));
    }

    $sql = "UPDATE `UNIT` set `nbUnit` = ? where `playerId` = ? AND unitName= ?";
    $query = $bdd->prepare($sql);
    foreach ($unit_array as $unit) {
        $query->execute(array($unit->getNumber(), $user->getId(), $unit->getName()));
    }
}

function setUnit($name, $nb)
{
    $bdd = getBDD();
    $user = getUser();
    $unit = new Unit($name, 0, 0, $nb, 0);
    $unit->timeRemainingGenerate();
    $sql = "INSERT INTO `UNIT` (`playerId`, `unitName`, `nbUnit`, `dateTimeLastUpdate`, `nbUnitToAdd`, `remaningTimeUpgrade`)  VALUES (? , ?, 0, NULL,?,?)";
    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId(), $name, $nb, $unit->getTimeRemainingAmelioration()));
}

function addUnit($name, $nb)
{
    $units = getUnitsOfUser();
    foreach ($units as $unit) {
        if ($unit->getName() == $name) {
            $unit->setNumberToAdd($nb);
            $unit->timeRemainingGenerate();
            updateBdd($units);
            return;
        }
    }
    setUnit($name, $nb);
}
