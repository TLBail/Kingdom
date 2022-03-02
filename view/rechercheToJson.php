<?php


function getRechercheToJson($batiments)
{
    if (!isset($batiments)) return "{}";

    $index = 1;
    foreach ($batiments as $batiment) {

        $levels[$batiment->getType()] = array(
            "lvl" => $batiment->getLevel(),
            "woodCost" => floor($batiment->getWoodCostForNextLevel()),
            "pierreCost" => floor($batiment->getPierreCostForNextLevel())
        );
        if ($batiment->getTimeRemainingAmelioration() !== 0) {
            $levels[$batiment->getType()]["timeRemaining"] = floor($batiment->getTimeRemainingAmelioration());
            $levels[$batiment->getType()]["timefrom"] = floor($batiment->getUpgradeTimeForNextLevelInSeconde());
        }

        $index = $index + 1;
    }
    if (isset($levels)) {
        return json_encode($levels);
    }
}
