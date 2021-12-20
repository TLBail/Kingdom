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
            <h3>Scierie</h3>
            <p>
                lvl <span id="lvlScierie"></span> <br>
                ressource par heure<span id="ressourceRateScierie"></span> <br>
                consomation en villageois <span id="villageoisCostScierie"></span> <br>
                coût en bois pour le level suivant <span id="woodCostScierie"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostScierie"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Carriere')">
            <h3>Carrière</h3>
            <p>
                lvl <span id="lvlCarriere"></span> <br>
                ressource par heure<span id="ressourceRateCarriere"></span> <br>
                consomation en villageois <span id="villageoisCostCarriere"></span> <br>
                coût en bois pour le level suivant <span id="woodCostCarriere"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostCarriere"></span>

            </p>
        </section>

        <section onclick="onAmeliorationClick('Ferme')">
            <h3>Ferme</h3>
            <p>
                lvl <span id="lvlFerme"></span> <br>
                ressource par heure<span id="ressourceRateFerme"></span> <br>
                consomation en villageois <span id="villageoisCostFerme"></span> <br>
                coût en bois pour le level suivant <span id="woodCostFerme"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostFerme"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDeBois')">
            <h3>Entrepot de bois</h3>
            <p>
                lvl <span id="lvlEntrepotDeBois"></span> <br>
                capacité en Bois <span id="storageCapacityEntrepotDeBois"></span> <br>
                coût en bois pour le level suivant <span id="woodCostEntrepotDeBois"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostEntrepotDeBois"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('EntrepotDePierre')">
            <h3>Entrepot de pierre</h3>
            <p>
                lvl <span id="lvlEntrepotDePierre"></span> <br>
                capacité en pierre <span id="storageCapacityEntrepotDePierre"></span> <br>
                coût en bois pour le level suivant <span id="woodCostEntrepotDePierre"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostEntrepotDePierre"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Silo')">
            <h3>Silo</h3>
            <p>
                lvl <span id="lvlSilo"></span> <br>
                capacité en nourriture <span id="storageCapacitySilo"></span> <br>
                coût en bois pour le level suivant <span id="woodCostSilo"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostSilo"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Maison')">
            <h3>maison</h3>
            <p>
                lvl <span id="lvlMaison"></span> <br>
                nombre de villageois<span id="ressourceRateMaison"></span> <br>
                coût en bois pour le level suivant <span id="woodCostMaison"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostMaison"></span>
            </p>
        </section>

        <section onclick="onAmeliorationClick('Immeuble')">
            <h3>Immeuble</h3>
            <p>
                lvl <span id="lvlImmeuble"></span> <br>
                nombre de villageois<span id="ressourceRateImmeuble"></span> <br>
                coût en bois pour le level suivant <span id="woodCostImmeuble"></span> <br>
                coût en pierre pour le level suivant <span id="pierreCostImmeuble"></span> <br>
                coût en Nourriture pour le level suivant <span id="nourritureCostImmeuble"></span>
            </p>
        </section>

    </article>


    <script src="./ressource/amelioration.js" async defer></script>
</body>

</html>