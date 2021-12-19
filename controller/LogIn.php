<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include("../model/userManager.php");


?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../ressource/style.css">
    <script src="../ressource/script.js" async defer></script>

</head>

<body>

    <main>
        <div class="wrapper">
            <form action="../index.php" method="POST" class="login">
                <p class="title">Log in</p>
                <input type="text" name="username" id="username" placeholder="Username" autofocus />
                <i class="fa fa-user"></i>
                <input type="password" name="password" id="password" placeholder="Password" />
                <i class="fa fa-key"></i>
                <a href="#">Forgot your password?</a>
                <input class="spinner, button" type="submit" name="login" id="login" value="Log in">
            </form>
            <footer><a target="blank" href="https://tlbail.fr/">tlbail.fr</a></footer>
            </p>

            <article>
                <a target="blank" href="./creationAccout.php">crée un compte</a>
            </article>

        </div>


    </main>



</body>

</html>