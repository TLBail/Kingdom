<?php
if (isset($_POST['username'])) {
    echo "connexion en cours ...";
    connexion();
}

if (isset($_POST['newusername'])) {
    echo "creation du compte en cour ...";
    creationCompte();
}






function creationCompte()
{


    $username = preg_replace("/[^a-zA-Z0-9 ]+/", "", $_POST['newusername']);
    $password = md5($_POST['newpassword']);

    $user = connect($username, $password);

    if (isset($user)) {
        echo "<h1> ERROR L'utilisateur existe déjà !! </h1>";
    } else {
        $sql = "INSERT INTO `USER` (`id`, `username`, `password`, `lastTimeOnline`, `position`) VALUES (NULL, ?, ?, current_timestamp(), NULL) ";
        $preparedSql = getBDD()->prepare($sql);
        $preparedSql->execute(array($username, $password));

        echo "compte créer !";
    }
}

function connexion()
{


    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);


    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $user = connect($username, $password);
    if (isset($user)) {
        echo "user trouvé !";
        $_SESSION['connected'] = 'true';
        $_SESSION['id'] = $user->getId();
    } else {
        echo "user non trouvé :(";
        session_destroy();
    }
}


function connect($username, $password)
{
    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);



    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);

    $sql = "SELECT * FROM `USER` WHERE username=? AND password=?;";
    $bdd = getBDD();

    $query = $bdd->prepare($sql);
    $query->execute(array($username, $password));

    $index = 1;
    foreach ($query as $ligne) {
        $useros[$index] = new User(
            $ligne['id'],
            $ligne['username'],
            $ligne['lastTimeOnline'],
            $ligne['position']

        );
        $index = $index + 1;
    }
    if (isset($useros[1])) {
        return $useros[1];
    }
}

function getUser()
{

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/user.class.php";
    include_once($path);

    $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
    $path .= "/model/bddManager.php";
    include_once($path);


    if (isset($_SESSION['id'])) {

        $id = $_SESSION['id'];

        $sql = "SELECT * FROM `USER` WHERE id=? ";
        $bdd = getBDD();


        $query = $bdd->prepare($sql);
        $query->execute(array($id));


        $index = 1;
        foreach ($query as $ligne) {
            $useros[$index] = new User(
                $ligne['id'],
                $ligne['username'],
                $ligne['lastTimeOnline'],
                $ligne['position']
            );
            $index = $index + 1;
        }
        if (isset($useros[1])) {
            return $useros[1];
        }
    } else {
    }
}
