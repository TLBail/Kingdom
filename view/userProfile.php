<?php
function showUser($user)
{

    if (isset($user)) {
        echo "<div class=\"userBox\">";
        echo "<img style=\"width: 40px; height:40px\" src=\"" . $user->getppurl() . "\" alt=\"\"> ";
        echo "utilisateur : " . $user->getNom() . "<br>";
        echo "</div>";
    }
}
