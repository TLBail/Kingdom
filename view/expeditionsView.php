<?php

function viewExpedition($expeditions)
{

    $text = "expeditions : ";

    if (!isset($expeditions)) {
        return "aucune expéditions de lancer ..";
    }

    $index = 1;
    foreach ($expeditions as $expedition) {

        $text += "départ " + $expedition->getDateDepart();
        $text += " arriver dans " + $expedition->getTempsPourArriver() + " s";
        $index = $index + 1;
    }
    return $text;
}
