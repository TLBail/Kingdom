<?php


function getBatimentsToJson($batiments)
{
    if (!isset($batiments)) return "{}";

    $index = 1;
    foreach ($batiments as $batiment) {

        $levels[$batiment->getType()] = array(
            "lvl" => $batiment->getLevel(),
            "woodCost" => floor($batiment->getWoodCostForNextLevel()),
            "pierreCost" => floor($batiment->getPierreCostForNextLevel())
        );
        if ($batiment->getNourritureCostForNextLevel() !== 0)
            $levels[$batiment->getType()]["nourritureCost"] = floor($batiment->getNourritureCostForNextLevel());
        if ($batiment->getRessourceRatePerHour() !== 0)
            $levels[$batiment->getType()]["ressourceRate"] = floor($batiment->getRessourceRatePerHour());
        if ($batiment->getTotalVillageoisCost() !== 0)
            $levels[$batiment->getType()]["villageoisCost"] = floor($batiment->getTotalVillageoisCost());
        if ($batiment->getStorageCapacity() !== 0)
            $levels[$batiment->getType()]["storageCapacity"] = floor($batiment->getStorageCapacity());
        if ($batiment->getTimeRemainingAmelioration() !== 0)
            $levels[$batiment->getType()]["temps restant"] = floor($batiment->getTimeRemainingAmelioration());
        $index = $index + 1;
    }
    if (isset($levels)) {
        return json_encode($levels);
    }
}