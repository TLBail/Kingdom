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
        $sql = "INSERT INTO `BATIMENT` (`playerId`, `type`, `standardProduction`, `level`) VALUES (? , ?, '10', '1')";
        $query = $bdd->prepare($sql);
        $query->execute(array($user->getId(), $batimentsName));

        return new Batiment(
            $batimentsName,
            10,
            1,
        );
    }
}
