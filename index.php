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
                lvl <span id="lvlScierie"></span> <br>
                ressource par heure<span id="ressourceRateScierie"></span> <br>
                consomation en villageois <span id="villageoisCostScierie"></span> <br>
                coût en bois pour le level suivant <span id="woodCostScierie"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostScierie"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Carriere')">
            <p>Carrière</p>
            <p>
                lvl <span id="lvlCarriere"></span> <br>
                ressource par heure<span id="ressourceRateCarriere"></span> <br>
                consomation en villageois <span id="villageoisCostCarriere"></span> <br>
                coût en bois pour le level suivant <span id="woodCostCarriere"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostCarriere"></span>

            </p>
        </section>

        <section onclick="onAmeliorationClick('Ferme')">
            <p>Ferme</p>
            <p>
                lvl <span id="lvlFerme"></span> <br>
                ressource par heure<span id="ressourceRateFerme"></span> <br>
                consomation en villageois <span id="villageoisCostFerme"></span> <br>
                coût en bois pour le level suivant <span id="woodCostFerme"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostFerme"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDeBois')">
            <p>Entrepot de bois</p>
            <p>
                lvl <span id="lvlEntrepotDeBois"></span> <br>
                capacité en Bois <span id="storageCapacityEntrepotDeBois"></span> <br>
                coût en bois pour le level suivant <span id="woodCostEntrepotDeBois"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostEntrepotDeBois"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDePierre')">
            <p>Entrepot de pierre</p>
            <p>
                lvl <span id="lvlEntrepotDePierre"></span> <br>
                capacité en pierre <span id="storageCapacityEntrepotDePierre"></span> <br>
                coût en bois pour le level suivant <span id="woodCostEntrepotDePierre"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostEntrepotDePierre"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Silo')">
            <p>Silo</p>
            <p>
                lvl <span id="lvlSilo"></span> <br>
                capacité en nourriture <span id="storageCapacitySilo"></span> <br>
                coût en bois pour le level suivant <span id="woodCostSilo"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostSilo"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Maison')">
            <p>maison</p>
            <p>
                lvl <span id="lvlMaison"></span> <br>
                nombre de villageois<span id="ressourceRateMaison"></span> <br>
                coût en bois pour le level suivant <span id="woodCostMaison"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostMaison"></span>
            </p>
        </section>

    </article>


    <script src="./ressource/amelioration.js" async defer></script>
</body>

</html>