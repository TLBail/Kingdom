<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$path = explode("/projet", __DIR__ )[0]."/projet";
$path .= "/model/bddManager.php";
include_once($path);
//get results from database
$db = getBDD();

$sql = "SELECT username, SUM(level) AS level_total FROM USER INNER JOIN BATIMENT ON USER.id = BATIMENT.playerId GROUP BY username";

?>
<html>

<head>
    <title>CLASSEMENT JOUEUR</title>
    <link rel=stylesheet href="ressource/classement.css"/>
    <meta charset="utf-8">
</head>

<body>
    <div class="parent">
        <div class="div1"> </div>
        <div class="div2"> </div>
        <div class="div3"> </div>
        <div class="div4">
            <center>
            <table>
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($db->query($sql) as $ligne): ?>
                <tr>
                    <td><?= $ligne['username']?></td>
                    <td><?= $ligne['level_total']?></td>
                </tr>
                <?php $db = null;
                endforeach; ?>
                </tbody>
            </table>
            </center>
        </div>
        <div class="div5"> </div>
    </div>

</body>

</html>