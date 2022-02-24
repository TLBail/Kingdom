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

    if ($distance == 0) {
        echo "erreur tu t'est envoyé l'expeditions à toi même";
        return null;
    }

    $sql  = 'INSERT INTO `EXPEDITIONS` (`id`, `dateTimeDepart`, `tempsPourArriver`, `position`, `playerId`) VALUES (NULL, ?, ?, ?, ?)';
    $bdd = getBDD();

    $dateTime = (new DateTime())->format('Y-m-d H:i:s');


    $query = $bdd->prepare($sql);
    $query->execute(array($dateTime, $distance, $coo, $user->getId()));

    $id = $bdd->lastInsertId();
    $sql  = 'INSERT INTO `UNITEXPEDITIONS` (`expeditionsId`, `unitName`, `nbUnit`) VALUES (? , ?, ?)';

    //ajout des unité dans unitexpeditions et supression des unité dans unite
    foreach ($units as $unit) {

        //ajout
        $query = $bdd->prepare($sql);
        $query->execute(array($id, $unit->getName(), $unit->getNumber()));

        try {
            $sqlUnit  = 'UPDATE UNIT SET nbUnit = nbUnit - ' . $unit->getNumber() . ' WHERE playerId=? AND unitName=?';
            $query = $bdd->prepare($sqlUnit);
            $query->execute(array($user->getId(), $unit->getName()));
        } catch (PDOException $exception) {
            return $exception;
        }
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

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expedition.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    $user = getUser();
    $time = time();
    $elapsedTime = (time() - strtotime($user->getLastTimeOnline()));

    $expeditions = getExpedition();



    // $myfile = fopen("../logs.txt", "a") or die("Unable to open file!");


    foreach ($expeditions as $expedition) {

        if ($expedition->getTempsPourArriver() < 0) return;

        $path = explode("/projet", __DIR__)[0] . "/projet";
        $path .= "/model/bddManager.php";
        include_once($path);


        $bdd = getBDD();

        $time = $expedition->getTempsPourArriver() - $elapsedTime;

        if ($time < 0) {

            // $txt = "expeditions " . $expedition->getId() . " terminer \n";
            // fwrite($myfile, $txt);

            $unitofuser = $expedition->getUnits();

            $poweruser = 0;
            foreach ($unitofuser as $unit) {
                $poweruser += $unit->getLife() *  $unit->getNumber();
            }

            $sql2  = 'SELECT DISTINCT unitName, nbUnit FROM UNIT INNER JOIN USER ON UNIT.playerId=USER.id WHERE USER.position=?';


            $query = $bdd->prepare($sql2);
            $query->execute(array($expedition->getPosition()));


            $unitsoftarget = array();

            $index = 0;
            foreach ($query as $ligne) {
                $index = $index + 1;
                $unitsoftarget[$index] = new Unit(
                    $ligne['unitName'],
                    $ligne['nbUnit'],
                    0,
                    0,
                    0
                );
            }

            // on calcul la puissance des deux armer


            $powertarget = 0;
            foreach ($unitsoftarget as $unit) {
                $powertarget += $unit->getLife() * $unit->getNumber();
            }



            if ($poweruser > $powertarget) {

                $sql  = 'SELECT RESSOURCES.bois, RESSOURCES.pierre, RESSOURCES.nourriture FROM RESSOURCES INNER JOIN USER ON USER.id=RESSOURCES.playerId WHERE USER.position= ?';

                $query = $bdd->prepare($sql);
                $query->execute(array($expedition->getPosition()));

                $ressources = getRessources();


                foreach ($ressources as $ressource) {
                    if (strcmp($ressource->getType(), "bois")) {
                        $bois =  $ressource->getAmount();
                    }

                    if (strcmp($ressource->getType(), "pierre")) {
                        $pierre =  $ressource->getAmount();
                    }

                    if (strcmp($ressource->getType(), "nourriture")) {
                        $nourriture =  $ressource->getAmount();
                    }
                }

                foreach ($query as $ligne) {
                    $bois += $ligne['bois'];
                    $pierre += $ligne['pierre'];
                    $nourriture += $ligne['nourriture'];
                }

                //on ajoute au joueur les ressources gagné
                $sql  = 'UPDATE `RESSOURCES` SET `bois` = ?, `pierre` = ?, `nourriture` = ? WHERE RESSOURCES.playerId = ?';

                try {
                    $query = $bdd->prepare($sql);
                    $query->execute(array($bois, $pierre, $nourriture, $user->getId()));

                    //on retire au joueur attaqué les ressource perdu (tout)
                    $sql  = 'UPDATE `RESSOURCES` SET `bois` = ?, `pierre` = ?, `nourriture` = ? WHERE RESSOURCES.playerId = (SELECT id FROM USER WHERE position= ?)';

                    $query = $bdd->prepare($sql);
                    $query->execute(array(0, 0, 0, $expedition->getPosition()));
                } catch (PDOException $exception) {
                    // $txt = "expeditions " . $expedition->getId() . " erreur  " . $exception->getMessage() . "\n";
                    // fwrite($myfile, $txt);

                    return $exception->getMessage();
                }

                // $txt = "expeditions " . $expedition->getId() . " ressource enlever \n";
                // fwrite($myfile, $txt);
            }
        }

        $sql  = 'UPDATE `EXPEDITIONS` SET `tempsPourArriver` = ? WHERE `EXPEDITIONS`.`id` = ?';
        $query = $bdd->prepare($sql);
        $query->execute(array($time, $expedition->getId()));
    }

    // fclose($myfile);
}
