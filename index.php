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

    <a href="./controller/LogIn.php">Login</a>
    <a href="./controller/creationAccout.php">SignIn</a>


    <article>

        <h1>Ressource</h1>

        <section onclick="onAmeliorationClick('Scierie')">
            <p>Scierie</p>
            <p>
                lvl <span id="lvlScierie"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Carriere')">
            <p>Carrière</p>
            <p>
                lvl <span id="lvlCarriere"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Ferme')">
            <p>Ferme</p>
            <p>
                lvl <span id="lvlFerme"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDeBois')">
            <p>Entrepot de bois</p>
            <p>
                lvl <span id="lvlEntrepotDeBois"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDePierre')">
            <p>Entrepot de pierre</p>
            <p>
                lvl <span id="lvlEntrepotDePierre"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Silo')">
            <p>Silo</p>
            <p>
                lvl <span id="lvlSilo"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Maison')">
            <p>maison</p>
            <p>
                lvl <span id="lvlMaison"></span>
            </p>
        </section>

    </article>


    <script src="./ressource/amelioration.js" async defer></script>
</body>

</html>