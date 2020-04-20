<?php

include('config.php');

// Reset OAuth access token
$google_client->revokeToken();

// Destroy entire session data.
session_destroy();

// Jump to home page
header('location:home.php');

?>