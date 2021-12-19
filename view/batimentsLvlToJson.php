<?php


function getLvlInJsonFromBatiments($batiments)
{


    $index = 1;
    foreach ($batiments as $batiment) {
        $levels[$batiment->getType()] = $batiment->getLevel();
        $index = $index + 1;
    }
    if (isset($levels)) {
        return $levels;
    }
}
