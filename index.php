<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (isset($_POST['logOut'])) {
    session_start();
    session_reset();
    session_destroy();
    header('Location: ./');
} else {
    session_start();
}

include("./model/userManager.php");



?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Salut</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./ressource/indexStyle.css">
</head>

<body>
    <h1>Salut</h1>


    <?php
    if (isset($_SESSION['connected']) && $_SESSION['connected'] == 'true') {
        echo '<form action="./index.php" method="POST">';
        echo "<h2>LogOut</h2>";
        echo '<input id="logOut" name="logOut" type="hidden" value="logOut">';
        echo '<input type="submit" id="logOut" value="Log out">';
    } else {
        echo '<form style="display:inline;" action="./controller/LogIn.php" method="POST">';
        echo "<h2>Non connecter</h2>";
        echo '<input type="submit" id="logIn" value="se connecter">';
        echo '</form>';
        echo '<form  style="display:inline;" action="./controller/creationAccout.php" method="POST">';
        echo '<input type="submit" id="logIn" value="créer un compte">';
        echo '</form>';
    }
    ?>

    <article>

        <h1>
            Ressource 🪓✊🍞
        </h1>

        <section id="ressourceContainer"></section>

    </article>


    <article>

        <h1>Batiment 🏢</h1>

        <section onclick="onAmeliorationClick('Scierie')">
            <h3>Scierie</h3>
            <p id="Scierie"></p>
        </section>

        <section onclick="onAmeliorationClick('Carriere')">
            <h3>Carrière</h3>
            <p id="Carriere"></p>
        </section>

        <section onclick="onAmeliorationClick('Ferme')">
            <h3>Ferme</h3>
            <p id="Ferme"></p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDeBois')">
            <h3>Entrepot de bois</h3>
            <p id="EntrepotDeBois"></p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDePierre')">
            <h3>Entrepot de pierre</h3>
            <p id="EntrepotDePierre"></p>
        </section>

        <section onclick="onAmeliorationClick('Silo')">
            <h3>Silo</h3>
            <p id="Silo"></p>
        </section>

        <section onclick="onAmeliorationClick('Maison')">
            <h3>maison</h3>
            <p id="Maison"></p>
        </section>

        <section onclick="onAmeliorationClick('Immeuble')">
            <h3>Immeuble</h3>
            <p id="Immeuble"></p>
        </section>

    </article>


    <script src="./ressource/amelioration.js" async defer></script>
</body>

</html>