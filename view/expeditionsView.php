<?php

function viewExpedition($expeditions)
{

    if (!isset($expeditions)) {
        return "aucune expéditions de lancer ..";
    }

    $arrayToReturn = array();
    $index = 1;
    foreach ($expeditions as $expedition) {

        $arrayToReturn[$index]['depart'] = $expedition->getDateDepart();
        $arrayToReturn[$index]['arriver'] = $expedition->getTempsPourArriver();
        foreach ($expedition->getUnits() as $unit) {
            $arrayToReturn[$index][$unit->getName()] = $unit->getNumber();
        }
        $index = $index + 1;
    }
    return json_encode($arrayToReturn);
}
