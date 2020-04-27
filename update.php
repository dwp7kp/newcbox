<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

    include('config.php');
    include('connectdb.php');

    

    if (!isset($_SESSION['computing']))
        exit();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        global $db;
        $stm = $db->prepare("UPDATE user SET first_name = :first, middle_name = :middle, last_name = :last WHERE computingID = :computing");
        $dom = new DOMDocument('1.0', 'iso-8859-1'); 
        $stm->bindParam(":first", $_GET['first'], PDO::PARAM_STR);
        $stm->bindParam(":middle", $_GET['middle'], PDO::PARAM_STR);
        $stm->bindParam(":last", $_GET['last'], PDO::PARAM_STR);
        $stm->bindParam(":computing", $_SESSION['computing'], PDO::PARAM_STR);
        $stm->execute();

        $_SESSION['user_first_name'] = $_GET['first'];
        $_SESSION['user_middle_name'] = $_GET['middle'];
        $_SESSION['user_last_name'] = $_GET['last'];
        
    }

?>