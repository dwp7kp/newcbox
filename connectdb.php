<?php

$username = 'php_api';
$password = 'dataBASE999';
$dbname = 'newcbox';
$host = '35.245.228.165';
$dsn = "mysql:host=$host;dbname=$dbname";

$db = new PDO($dsn, $username, $password);


?>

<?php 
// To close a connection, uncomment the following line
//$db = null;
?>