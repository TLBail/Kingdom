<?php




function getBatimentsOfUser()
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/batiment.class.php";
    include_once($path);

    $user = getUser();

    $sql = "SELECT * FROM `BATIMENT` WHERE playerId=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($user->getId()));


    $index = 1;
    foreach ($query as $ligne) {
        $batiments[$index] = new Batiment(
            $ligne['type'],
            $ligne['standardProduction'],
            $ligne['level']
        );
        $index = $index + 1;
    }
    if (isset($batiments)) {
        return $batiments;
    }
}


function upgradeBatiment($batimentsName)
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/batiment.class.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
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
            $ligne['level']
        );
        $index = $index + 1;
    }
    if (isset($batiments)) {
        $batiment = $batiments[1];
    }




    if (isset($batiment)) {
        //le batiment existe déjà on lui rajoute un level

        if (buyBatiment($batiment) === null) return; //si l'achat est un échec on annule la transaction

        $sql = "UPDATE `BATIMENT` SET `level` = ? WHERE `BATIMENT`.`playerId` = ? AND  type= ?;";
        $query = $bdd->prepare($sql);
        $query->execute(array($batiment->getLevel() + 1, $user->getId(), $batiment->getType()));

        return new Batiment(
            $batiment->getType(),
            $batiment->getStandardProduction(),
            $batiment->getLevel() + 1,
        );
    } else {
        // le batiment n'existe pas on le créer
        $batiment = new Batiment($batimentsName, 10, 1,);

        if (buyBatiment($batiment) === null) return; //si l'achat est un échec on annule la transaction
        $sql = "INSERT INTO `BATIMENT` (`playerId`, `type`, `standardProduction`, `level`) VALUES (? , ?, '10', '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $batimentsName));

        return $batiment;
    }
}


function buyBatiment($batiment)
{
    //on recupère le coût en bois, pierre, nourriture
    $coutPiere = $batiment->getPierreCostForNextLevel();
    $coutBois = $batiment->getWoodCostForNextLevel();
    $coutNourriture = $batiment->getNourritureCostForNextLevel();
    //on vérifie que le joueur a assez de nourriture
    //pas implementer pour l'instant
    $actualPierre = 2147483647;
    $actualBois = 2147483647;
    $actualNourriture = 2147483647;

    if ($actualBois >= $coutBois && $actualPierre >= $coutPiere && $actualNourriture > $coutNourriture) {
        $actualBois += -$coutBois;
        $actualNourriture += -$coutNourriture;
        $actualPierre += -$coutPiere;
        return 1;
        //update les valeur dans la bdd
    } else {
        return null;
    }
}
