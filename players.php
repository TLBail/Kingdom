<html>

<head>
    <title>CHAT</title>
    <meta charset="utf-8">
</head>

<body>

    


    <?php
    include_once("/model/userManager.php");


    //get results from database
    $db = new PDO("$server:dbname=$base;host=$host", $user, $pass);

    $sql = "SELECT username FROM USER";
    foreach ($db->query($sql) as $ligne){
        echo $ligne['username'];
    }

    $db = null;
    ?>
</body>

</html>