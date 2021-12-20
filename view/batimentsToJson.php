<?php


function getBatimentsToJson($batiments)
{
    $index = 1;
    foreach ($batiments as $batiment) {
        if ($batiment->getRessourceRatePerHour() !== null) {
            $levels[$batiment->getType()] = array(
                "lvl" => $batiment->getLevel(),
                "woodCost" => floor($batiment->getWoodCostForNextLevel()),
                "pierreCost" => floor($batiment->getPierreCostForNextLevel()),
                "ressourceRate" => floor($batiment->getRessourceRatePerHour()->getAmount()),
                "villageoisCost" => floor($batiment->getTotalVillageoisCost())
            );
        } else {
            $levels[$batiment->getType()] = array(
                "lvl" => $batiment->getLevel(),
                "woodCost" => floor($batiment->getWoodCostForNextLevel()),
                "pierreCost" => floor($batiment->getPierreCostForNextLevel()),
                "villageoisCost" => floor($batiment->getTotalVillageoisCost()),
                "storageCapacity" => floor($batiment->getStorageCapacity())
            );
        }
        $index = $index + 1;
    }
    if (isset($levels)) {
        return json_encode($levels);
    }
}
