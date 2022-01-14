<?php


function getUnitToJson($units)
{
    if (!isset($units) || $units === null) return "{}";

    $index = 1;
    foreach ($units as $unit) {

        $unitsArr[$unit->getName()] = array(
            "woodCost" => floor($unit->getWoodCost()),
            "pierreCost" => floor($unit->getStoneCost()),
            "timeRemaining" => floor($unit->getTimeRemainingAmelioration()),
            "number" => floor($unit->getNumber())
        );
        $unit->timeRemainingGenerate();
        $unitsArr[$unit->getName()]['timefrom'] = floor($unit->getTimeRemainingAmelioration());
        if ($unit->getNbToAdd() != 0) {
            $unitsArr[$unit->getName()]['nbUnitToAdd'] = floor($unit->getNbToAdd());
        }

        $index = $index + 1;
    }
    if (isset($unitsArr)) {
        return json_encode($unitsArr);
    }
}
