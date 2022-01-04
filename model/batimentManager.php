<?php




function getBatimentsOfUser()
{

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/batiment.class.php";
    include_once($path);

    $user = getUser();
    if (!isset($user)) return null;

    $sql = "SELECT * FROM `BATIMENT` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));


    $index = 1;
    foreach ($query as $ligne) {

        $remainingTime = 0;


        if (isset($ligne['dateTimeAtlastUpdate']) && isset($ligne['remaningTimeUpgrade'])) {
            $tempEcouler = time() - strtotime($ligne['dateTimeAtlastUpdate']);
            $remainingTime = $ligne['remaningTimeUpgrade'] - $tempEcouler;
            if ($remainingTime < 0) {
                $remainingTime = 0;
                //Todo upgrade le bat
                updateLvlOfBatiment($ligne['type']);
                $ligne['level']++;
            }
        }

        $batiments[$index] = new Batiment(
            $ligne['type'],
            $ligne['standardProduction'],
            $ligne['level'],
            $remainingTime
        );
        $index = $index + 1;
    }
    if (isset($batiments)) {
        return $batiments;
    }
}


function upgradeBatiment($batimentsName)
{

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/batiment.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $user = getUser();

    //check if batiment already exist

    $sql = "SELECT * FROM `BATIMENT` WHERE type= ? AND playerId= ? ;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($batimentsName, $user->getId()));

    $index = 1;
    foreach ($query as $ligne) {
        $batiments[$index] = new Batiment(
            $ligne['type'],
            $ligne['standardProduction'],
            $ligne['level'],
            $ligne['remaningTimeUpgrade']
        );
        $index = $index + 1;
    }

    if (isset($batiments)) {
        $batiment = $batiments[1];
        if ($batiment->getTimeRemainingAmelioration()) {
            return null;
        }
    }

    if (isset($batiment)) {
        //le batiment existe déjà on lui rajoute un level

        if (buyBatiment($batiment) === null) return; //si l'achat est un échec on annule la transaction

        $upgradetime = $batiment->getUpgradeTimeForNextLevelInSeconde();

        $sql = "UPDATE BATIMENT SET dateTimeAtlastUpdate= ? WHERE playerId= ? AND type= ?";
        $query = $bdd->prepare($sql);
        $query->execute(array((new \DateTime())->format('Y-m-d H:i:s'), $user->getId(), $batiment->getType()));

        $sql = "UPDATE BATIMENT SET remaningTimeUpgrade= ? WHERE playerId= ? AND type= ?";
        $query = $bdd->prepare($sql);
        $query->execute(array($upgradetime, $user->getId(), $batiment->getType()));

        return new Batiment(
            $batiment->getType(),
            $batiment->getStandardProduction(),
            $batiment->getLevel(),
            $upgradetime
        );
    } else {
        // le batiment n'existe pas on le créer
        $batiment = new Batiment($batimentsName, 10, 1, 0);

        if (buyBatiment($batiment) === null) return; //si l'achat est un échec on annule la transaction

        $sql = "INSERT INTO `BATIMENT` (`playerId`, `type`, `standardProduction`, `level`) VALUES (? , ?, '10', '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $batimentsName));

        return $batiment;
    }
}


function buyBatiment($batiment)
{

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    //on recupère le coût en bois, pierre, nourriture
    $coutPiere = $batiment->getPierreCostForNextLevel();
    $coutBois = $batiment->getWoodCostForNextLevel();
    $coutNourriture = $batiment->getNourritureCostForNextLevel();
    //on vérifie que le joueur a assez de nourriture
    //pas implementer pour l'instant
    $actualPierre = getRessourceByName("bois");
    $actualBois = getRessourceByName("pierre");
    $actualNourriture = getRessourceByName("nourriture");

    if ($actualBois >= $coutBois && $actualPierre >= $coutPiere && $actualNourriture > $coutNourriture) {
        $actualBois += -$coutBois;
        updateRessourceOfUser(new Ressource("bois", $actualBois));
        if ($coutNourriture !== 0) {
            $actualNourriture += -$coutNourriture;
            updateRessourceOfUser(new Ressource("nourriture", $actualNourriture));
        }
        $actualPierre += -$coutPiere;
        updateRessourceOfUser(new Ressource("pierre", $actualPierre));
        return 1;
    } else {
        return null;
    }
}


function updateLvlOfBatiment($batimentsName)
{

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/batiment.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__ )[0]."/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $user = getUser();




    //check if batiment already exist

    $sql = "SELECT * FROM `BATIMENT` WHERE type= ? AND playerId= ? ;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($batimentsName, $user->getId()));

    $index = 1;
    foreach ($query as $ligne) {
        $batiments[$index] = new Batiment(
            $ligne['type'],
            $ligne['standardProduction'],
            $ligne['level'],
            0
        );
        $index = $index + 1;
    }
    if (isset($batiments)) {
        $batiment = $batiments[1];
    }




    if (isset($batiment)) {
        //le batiment existe déjà on lui rajoute un level
        $sql = "UPDATE `BATIMENT` SET `level` = ? WHERE `BATIMENT`.`playerId` = ? AND  type= ?;";
        $query = $bdd->prepare($sql);
        $query->execute(array($batiment->getLevel() + 1, $user->getId(), $batiment->getType()));
    } else {
        // le batiment n'existe pas on le créer
        $batiment = new Batiment($batimentsName, 10, 1, 0);

        $sql = "INSERT INTO `BATIMENT` (`playerId`, `type`, `standardProduction`, `level`) VALUES (? , ?, '10', '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $batimentsName));
    }

    $sql = "UPDATE BATIMENT SET dateTimeAtlastUpdate= ? WHERE playerId= ? AND type= ?";
    $query = $bdd->prepare($sql);
    $query->execute(array(null, $user->getId(), $batiment->getType()));

    $sql = "UPDATE BATIMENT SET remaningTimeUpgrade= ? WHERE playerId= ? AND type= ?";
    $query = $bdd->prepare($sql);
    $query->execute(array(null, $user->getId(), $batiment->getType()));
}
