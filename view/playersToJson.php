<?php

function playersToJson($players)
{
    if (!isset($players)) return "{}";
    $index = 1;
    foreach ($players as $player) {

        $levels[$player->getId()] = array(
            "username" => $player->getUsername(),
            "position" => $player->getPosition(),
        );

        $index = $index + 1;
    }
    if (isset($levels)) {
        return json_encode($levels);
    }
}
