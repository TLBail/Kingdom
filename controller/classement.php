<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$path = explode("/projet", __DIR__)[0] . "/projet";
$path .= "/model/bddManager.php";
include_once($path);
//get results from database
$db = getBDD();

$sql = "SELECT username, (SUM(level)*100) AS score FROM USER INNER JOIN BATIMENT ON USER.id = BATIMENT.playerId GROUP BY username ORDER BY score DESC";


$array = array();

foreach ($db->query($sql) as $ligne) {
    $array[$ligne['username']] = $ligne['score'];
}

echo json_encode($array);
