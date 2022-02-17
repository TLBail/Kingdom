<?php


if (isset($_GET['newChatMessage'])) {
    addMessage($_GET['newChatMessage']);
}

function addMessage($msg)
{

    $path = explode("/projet", __DIR__)[0] . "/projet";
    $path .= "/model/userManager.php";
    include_once($path);

    $msg = preg_replace("/[^a-zA-Z0-9 ]+/", "", $msg);

    $user = getUser();

    $bdd = getBDDChat();
    $query = $bdd->prepare("INSERT INTO `Chat` (`id`, `messageText`, `userId`, `ChannelId`) VALUES (NULL, :nom , :id , '1')");
    $id = $user->getId();
    $query->execute(array(
        ':nom' => $msg,
        ':id' => $id
    ));

    echo "message ajouter !";
}


function getBDDChat()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/session/model/dc.inc.php";

    include($path);
    return new PDO("$server:host=$host;dbname=$base", $user, $pass);
}


function getMessages()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/session/model/chat.class.php";
    include_once($path);
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/session/model/user.class.php";
    include_once($path);

    $sql = "SELECT *   FROM `Chat` INNER JOIN USER WHERE userId=USER.id ORDER BY Chat.id DESC";
    $db = getBDDChat();

    $index = 1;
    foreach ($db->query($sql) as $ligne) {
        $chats[$index] = new Chat(
            $ligne['id'],
            $ligne['userId'],
            $ligne['messageText'],
            $ligne['ChannelId'],
        );
        $chats[$index]->setUser(new User(
            $ligne['id'],
            $ligne['nom'],
            $ligne['ppurl'],
        ));
        $index = $index + 1;
    }
    return $chats;
}
