<?php


function getExpedition()
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/expedition.class.php";
    include_once($path);

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);

    $user = getUser();
    if (!isset($user)) return null;

    $sql = "SELECT * FROM `EXPEDITIONS` ";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute();


    $index = 1;
    foreach ($query as $ligne) {

        // id, $dateDepart, $tempsPourArriver, $playerId)
        echo $ligne['id'];
        $remainingTime = 0;
        $expeditions[$index] = new Expedition(
            $ligne['id'],
            $ligne['dateTimeDepart'],
            $ligne['tempsPourArriver'],
            $ligne['playerId']
        );

        $index = $index + 1;
    }
    if (isset($expeditions)) {
        return $expeditions;
    }
}
