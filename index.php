<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (isset($_POST['disconnect'])) {
    session_start();
    session_reset();
    session_destroy();
    header('Location: ./index.php');
} else {
    session_start();
}

include("./model/userManager.php");


function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

//list every .php file in the folder
$phpFiles = glob('./view/*.{html}', GLOB_BRACE);

//remove this file from the list
$phpFiles = array_filter($phpFiles, function ($file) {
    return !endsWith($file, 'index.php');
});

$connectionStatus;
$formAction;
$firstInput;
$secondInput;
$connected;

if (isset($_SESSION['connected']) && $_SESSION['connected'] == 'true') {
    $connected = true;
    $connectionStatus = "Connecté";
    $firstInput = '<form method="POST"><input type="submit" name="disconnect" value="Déconnexion"></form>';
    $secondInput = "";
} else {
    $connected = false;
    $connectionStatus = " Déconnecté";
    $firstInput = '<button name="login" id="logIn" onclick="goto(\'' . "./controller/LogIn.php" . '\')"> se Connecter</button>';
    $secondInput = '<button name="register" id="register" onclick="goto(\'' . "./controller/creationAccout.php" . '\')"> Créer un compte</button>';
}

?>
<!DOCTYPE html>

<head>
    <title>Projet</title>
    <link rel='stylesheet' href='style.css'>
    <link rel='stylesheet' href='ressource/indexStyle.css'>
</head>

<body>
    <div class='parent'>
        <div class='div1' id="PageContainer"><?php echo file_get_contents("mainPage.html") ?></div>
        <div class='div2'>
            <article class="dropdownWrapper">
                <li>
                    <section id="ressourceBar">

                        <span class="boisNumber">

                        </span>

                        <span class="foodNumber">

                        </span>


                        <span class="pierreNumber">

                        </span>

                        <span class="villageoisNumber">
                        </span>

                    </section>
                    <section class="dropdown">
                        <h1>
                            Ressource 🪓
                        </h1>
                        <p>
                            Bois <span class="boisNumber"></span>
                            Capacité max de bois <span class="boisMaxCapacity"></span>
                        </p>

                        <p>
                            Nourriture <span class="foodNumber"></span>
                            Capacité max de nourriture <span class="nourritureMaxCapacity"></span>
                        </p>
                        <p>
                            Pierre <span class="pierreNumber"></span>
                            Capacité max de pierre <span class="pierreMaxCapacity"></span>

                        </p>
                        <p>
                            Villageois Disponible <span class="villageoisNumber"></span> <br>
                            un nombre de villageois négatif diminura la production de 50%
                        </p>

                    </section>
                </li>
            </article>
        </div>
        <div class='div3'>
            <div class="sessionInfo">
                <span>Vous êtes <?php echo $connectionStatus ?></span>
                <div>
                    <?php echo $firstInput ?>
                    <?php echo $secondInput ?>
                </div>
            </div>
            <div class="pageButtonsHolder">
                <button class='pageButton' onclick="changePage('mainPage.html')">🏠</button>
                <?php
                foreach ($phpFiles as $file) {
                    $fileName = basename($file);
                    $fileName = str_replace('.html', '', $fileName);
                    $string = "<button class='pageButton' onclick=\"changePage('" . $file . "')\" ";
                    if (!$connected) {
                        $string .= "disabled";
                    }
                    $string .= ">" . $fileName . "</button>";
                    echo $string;
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <?php
    if ($connected) {
        echo ("<script type='text/javascript' src='./ressource/javascript/client.js' async defer></script>
            <script type='text/javascript' src='./ressource/javascript/unit.js' async defer></script>
            <script type='text/javascript' src='./ressource/javascript/batimentPanel.js' async defer></script>
	    	<script type='text/javascript' src='./ressource/javascript/canvas.js'></script>");
    }
    ?>
    <script defer>
        function goto(page) {
            window.location.href = page;
        }

        //change displayed page
        function changePage(page) {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    // console.log(xhr.responseText);
                    document.getElementById("PageContainer").innerHTML = xhr.responseText;
                }

                if (page.endsWith("Batiments.html")) {
                    updateCanvas();
                }

            }
            xhr.open('GET', page, true);
            xhr.send();
        }
    </script>
</body>