<?php

function chatsToHTML($chats)
{
    echo "<ul>";
    echo "message : ";
    foreach ($chats as &$chat) {
        echo "<li>";
        $user = $chat->getUser();
        echo "<div class=\"userBox\">";
        echo "<img style=\"width: 40px; height:40px\" src=\"" . $user->getppurl() . "\" alt=\"\"> ";
        echo "utilisateur : " . $user->getNom() . "<br>";
        echo "</div>";
        echo "<p>";
        echo $chat->getMessageText();
        echo "</p>";
        echo "</li>";
    }
    echo "</ul>";
}
