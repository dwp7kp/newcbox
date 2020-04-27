<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

    include('config.php');
    include('connectdb.php');

    if (!isset($_SESSION['computing']))
        exit();

    // get playlist corresponding to the location selected
    function getLocationPlaylist($location)
    {
        global $db;
        $query = "select playlistName from playlist where location = :location";
        $statement = $db->prepare($query);
        $statement->bindValue(':location', $location);
        $statement->execute();

        $results = $statement->fetchAll();
        $statement->closecursor();

        return $results;
    }

    // get song currently being played at location selected 
    function getCurrentSong($location)
    {
        global $db;
        $query = "select currentSong from playlist where location = :location";
        $statement = $db->prepare($query);
        $statement->bindValue(':location', $location);
        $statement->execute();

        $results = $statement->fetchAll();
        $statement->closecursor();

        return $results;
    }
?>