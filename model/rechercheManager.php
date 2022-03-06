<?php



function getRechercheMapOfUser()
{
    $recherches = getRechercheOfUser();
    if (!isset($recherches)) return null;
    $toreturn = array();
    foreach ($recherches as $recherche) {
        $toreturn[$recherche->getType()] = $recherche;
    }
    return $toreturn;
}


function getRechercheOfUser()
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/recherche.class.php";
    include_once($path);

    $user = getUser();
    if (!isset($user)) return null;

    $sql = "SELECT * FROM `RECHERCHE` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));


    $index = 1;
    foreach ($query as $ligne) {

        $remainingTime = 0;


        if (isset($ligne['dateTimeLastUpdate']) && isset($ligne['remainingTimeUpgrade'])) {
            $tempEcouler = time() - strtotime($ligne['dateTimeLastUpdate']);
            $remainingTime = $ligne['remainingTimeUpgrade'] - $tempEcouler;
            if ($remainingTime < 0) {
                echo "rem" . $remainingTime;
                $remainingTime = 0;
                updateLvlOfRecherche($ligne['type']);
                $ligne['level']++;
            }
        }
        $recherches[$index] = new Recherche(
            $ligne['type'],
            $ligne['level'],
            $remainingTime
        );
        $index = $index + 1;
    }
    if (isset($recherches)) {
        return $recherches;
    }
}


function upgradeRecherche($recherchesName)
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/recherche.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $user = getUser();

    //check if recherche already exist

    $sql = "SELECT * FROM `RECHERCHE` WHERE type= ? AND playerId= ? ;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($recherchesName, $user->getId()));

    $index = 1;
    foreach ($query as $ligne) {
        $recherches[$index] = new Recherche(
            $ligne['type'],
            $ligne['level'],
            $ligne['remainingTimeUpgrade']
        );
        $index = $index + 1;
    }

    if (isset($recherches)) {
        $recherche = $recherches[1];
        if ($recherche->getTimeRemainingAmelioration()) {
            return null;
        }
    }

    if (isset($recherche)) {

        //le recherche existe déjà on lui rajoute un level

        if (buyRecherche($recherche) === null) return; //si l'achat est un échec on annule la transaction

        $upgradetime = $recherche->getUpgradeTimeForNextLevelInSeconde();

        $sql = "UPDATE RECHERCHE SET dateTimeLastUpdate= ? WHERE playerId= ? AND type=?";
        $query = $bdd->prepare($sql);
        $query->execute(array((new \DateTime())->format('Y-m-d H:i:s'), $user->getId(), $recherche->getType()));

        $sql = "UPDATE RECHERCHE SET remainingTimeUpgrade= ? WHERE playerId= ? AND type=?";
        $query = $bdd->prepare($sql);
        $query->execute(array($upgradetime, $user->getId(), $recherche->getType()));

        return new Recherche(
            $recherche->getType(),
            $recherche->getLevel(),
            $upgradetime
        );
    } else {
        // le recherche n'existe pas on le créer
        $recherche = new Recherche($recherchesName, 10, 1, 0);

        if (buyRecherche($recherche) === null) return; //si l'achat est un échec on annule la transaction

        $sql = "INSERT INTO `RECHERCHE` (`playerId`, `type`,  `level`) VALUES (? , ?, '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $recherchesName));

        return $recherche;
    }
}


function buyRecherche($recherche)
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/ressourceManager.php";
    include_once($path);

    //on recupère le coût en bois, pierre, nourriture
    $coutPiere = $recherche->getPierreCostForNextLevel();
    $coutBois = $recherche->getWoodCostForNextLevel();
    $coutNourriture = $recherche->getNourritureCostForNextLevel();
    //on vérifie que le joueur a assez de nourriture
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


function updateLvlOfRecherche($recherchesName)
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/recherche.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $user = getUser();


    //check if recherche already exist

    $sql = "SELECT * FROM `RECHERCHE` WHERE type=? AND playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($recherchesName, $user->getId()));

    $index = 1;
    foreach ($query as $ligne) {

        $recherches[$index] = new Recherche(
            $ligne['type'],
            $ligne['level'],
            0
        );
        $index = $index + 1;
    }
    if (isset($recherches)) {
        $recherche = $recherches[1];
    }

    if (isset($recherche)) {
        //le recherche existe déjà on lui rajoute un level
        $sql = "UPDATE `RECHERCHE` SET `level`=? WHERE `RECHERCHE`.`playerId`=? AND  type=?;";
        $query = $bdd->prepare($sql);
        $query->execute(array($recherche->getLevel() + 1, $user->getId(), $recherche->getType()));
    } else {
        // le recherche n'existe pas on le créer
        $recherche = new Recherche($recherchesName, 10, 1, 0);

        $sql = "INSERT INTO `RECHERCHE` (`playerId`, `type`, `level`) VALUES (? , ?, '10', '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $recherchesName));
    }

    $sql = "UPDATE RECHERCHE SET dateTimeLastUpdate= ? WHERE playerId= ? AND type= ?";
    $query = $bdd->prepare($sql);
    $query->execute(array(null, $user->getId(), $recherche->getType()));

    $sql = "UPDATE RECHERCHE SET remainingTimeUpgrade= ? WHERE playerId= ? AND type= ?";
    $query = $bdd->prepare($sql);
    $query->execute(array(null, $user->getId(), $recherche->getType()));
}
