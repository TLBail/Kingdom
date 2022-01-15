<?php


function getExpedition()
{


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/unit.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expedition.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);


    $user = getUser();
    if (!isset($user)) return null;


    $sql = "SELECT * FROM `EXPEDITIONS` INNER JOIN UNITEXPEDITIONS ON EXPEDITIONS.id = UNITEXPEDITIONS.expeditionsId  WHERE playerId = ? ORDER BY dateTimeDepart DESC";
    $bdd = getBDD();


    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));


    $index = 0;
    $lastId = -1;
    $expeditions = array();
    foreach ($query as $ligne) {


        if ($lastId == $ligne['id']) {
            $units = $expeditions[$index]->getUnits();
            array_push($units, new Unit($ligne['unitName'], $ligne['nbUnit'], 0, 0, 0));
            $expeditions[$index]->setUnits($units);
        } else {
            $units = array();

            $index = $index + 1;
            $expeditions[$index] = new Expedition(
                $ligne['id'],
                $ligne['dateTimeDepart'],
                $ligne['tempsPourArriver'],
                $ligne['position'],
                $ligne['playerId']
            );
            array_push($units, new Unit($ligne['unitName'], $ligne['nbUnit'], 0, 0, 0));
            $expeditions[$index]->setUnits($units);

            $lastId = $ligne['id'];
        }
    }
    if (isset($expeditions)) {
        return $expeditions;
    }
}


function addnewExpedition($units, $coo)
{

    if (!isset($units)) {
        echo "no unit";
        return;
    }
    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);

    $user = getUser();
    if (!isset($user)) return null;

    $distance = abs($coo - $user->getPosition());


    $sql  = 'INSERT INTO `EXPEDITIONS` (`id`, `dateTimeDepart`, `tempsPourArriver`, `position`, `playerId`) VALUES (NULL, ?, ?, ?, ?)';
    $bdd = getBDD();

    $dateTime = (new DateTime())->format('Y-m-d H:i:s');


    $query = $bdd->prepare($sql);
    $query->execute(array($dateTime, $distance, $coo, $user->getId()));

    $id = $bdd->lastInsertId();
    $sql  = 'INSERT INTO `UNITEXPEDITIONS` (`expeditionsId`, `unitName`, `nbUnit`) VALUES (? , ?, ?)';

    echo $units[0]->getName();
    //insert unit
    foreach ($units as $unit) {
        echo $unit->getName();
        $query = $bdd->prepare($sql);
        $query->execute(array($id, $unit->getName(), $unit->getNumber()));
    }
}


function getPlayersForExpeditions()
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);


    $sql = "SELECT * FROM USER";
    $bdd = getBDD();


    $query = $bdd->prepare($sql);
    $query->execute();


    $index = 0;
    foreach ($query as $ligne) {


        $index = $index + 1;
        $players[$index] = new User(
            $ligne['id'],
            $ligne['username'],
            $ligne['lastTimeOnline'],
            $ligne['position']
        );
    }
    if (isset($players)) {
        return $players;
    }
}


function updateExpedition()
{


    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);

    $user = getUser();
    $time = time();
    $elapsedTime = (time() - strtotime($user->getLastTimeOnline())) / 3600;
}
