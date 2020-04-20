<?php

require_once 'vendor/autoload.php';

$google_client = new Google_Client();
$google_client->setClientId('890292507460-udqq1fpb6kmpolrk2a4s1rmiho0kg9n6.apps.googleusercontent.com');
$google_client->setClientSecret('R6dOZe_F97PhDcpHMtMrASjd');
$google_client->setRedirectUri('http://localhost/cs4750/newcbox/home.php');

$google_client->addScope('email');
$google_client->addScope('profile');

session_start();

?>