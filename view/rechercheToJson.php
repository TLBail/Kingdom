<?php


function getRechercheToJson($recherches)
{
    if (!isset($recherches)) return "{}";

    $index = 1;
    foreach ($recherches as $recherche) {
        $levels[$recherche->getType()] = array(
            "lvl" => $recherche->getLevel(),
            "woodCost" => floor($recherche->getWoodCostForNextLevel()),
            "pierreCost" => floor($recherche->getPierreCostForNextLevel())
        );
        if ($recherche->getTimeRemainingAmelioration() !== 0) {
            $levels[$recherche->getType()]["timeRemaining"] = floor($recherche->getTimeRemainingAmelioration());
            $levels[$recherche->getType()]["timefrom"] = floor($recherche->getUpgradeTimeForNextLevelInSeconde());
        }

        $index = $index + 1;
    }
    if (isset($levels)) {
        return json_encode($levels);
    }
}
