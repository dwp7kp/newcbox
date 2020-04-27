<?php
//export.php
if(isset($_POST["export"]))
{
    require('connectdb.php');
    global $db;
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Main Artist', 'Featured Artist', 'Genre', 'Year', 'Rating', 'Clean'));
    
    //NEED TO REPLACE QUERY WITH QUERY FOR ACTUAL PLAYLIST
    $query = "SELECT * from song WHERE mArtist='Ariana Grande'";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor(); 
    foreach($results as $result)
    {
        fputcsv($output, $result);
    }
    fclose($output);
}
?>