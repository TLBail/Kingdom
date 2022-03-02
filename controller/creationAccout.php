<?php

include("../model/userManager.php");


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/dist/loginPage.css">
</head>

<body>

    <iframe id="bateau" src="https://tlbail.fr/bateau" frameborder="0">
    </iframe>


    <main>

        <div class="wrapper">
            <form action="./LogIn.php" method="POST" class="login">
                <p class="title">Create Account</p>
                <input type="text" name="newusername" id="newusername" placeholder="Username" autofocus />
                <i class="fa fa-user"></i>
                <input type="password" name="newpassword" id="newpassword" placeholder="Password" />
                <i class="fa fa-key"></i>
                <input class="spinner, button" type="submit" name="createAccount" id="createAccount" value="createAccount">
            </form>
            <footer><a target="blank" href="https://tlbail.fr/">tlbail.fr</a></footer>


            <article>
                <a target="blank" href="./LogIn.php">Login</a>
            </article>

        </div>

    </main>

    <script src="" async defer></script>
</body>

</html>