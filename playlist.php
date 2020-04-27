<?php

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

include('config.php');
$data = [];
$login_button = '';

// $submit = $_POST['submit'];

// function getLocationPlaylist($submit)
// {
//     $query= '';
//     global $db;
//     $query = "select playlistName from playlist where location = :submit";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':submit', $submit);
//     $statement->execute();
//     $results = $statement->fetchAll();
//     $statement->closecursor();
//     return $results;
// }

// $locationPlaylist = getLocationPlaylist($submit);

// function getCurrentSong($submit)
// {
//     global $db;
//     $query = "select currentSong from playlist where location = :submit";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':submit', $submit);
//     $statement->execute();
//     $results = $statement->fetchAll();
//     $statement->closecursor();
//     return $results;
// }

// $locationCurrentSong = getCurrentSong($submit);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

// If being redirected from google auth
if (isset($_GET["code"])) {
    // Get the token
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    // Check if the token failed
    if (!isset($token['error'])) {
        // Use the token to get the data from google
        $google_client->setAccessToken($token['access_token']);
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        // Use the data from google and set session variables to track basic data
        $_SESSION['access_token'] = $token['access_token'];
        $_SESSION['user_first_name'] = $data['given_name'];
        $_SESSION['user_last_name'] = $data['family_name'];
        $_SESSION['user_email_address'] = $data['email'];
        $_SESSION['user_image'] = $data['picture'];
    }
}

?>
<!-- Navbar template from https://www.w3schools.com/bootstrap/bootstrap_navbar.asp -->
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>NewcBox</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">NewcBox</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="/cs4750/newcbox/home.php">Home</a></li>
                <li class="active"><a href="#">Playlists</a></li>
                <li><a href="/cs4750/newcbox/song.php">Songs</a></li>
            </ul>
            <form class="navbar-form navbar-left" action="/cs4750/newcbox/search.php" method="post" id="searchform">
                <select class="browser-default custom-select" name="field" form="searchform">
                    <option value="sName" selected>Song</option>
                    <option value="mArtist">Artist</option>
                    <option value="genre">Genre</option>
                    <option value="year">Year</option>
                </select>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="searchq">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="navbar-right" style="margin-right: 0px;">
                <div class="mr-3">
                    <?php
                    //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
                    if (!isset($_SESSION['access_token'])) {
                        //Create a URL to obtain user authorization
                        $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" /></a>';
                        echo ($login_button);
                    } else {
                        $profile_button = '<img src="' . $_SESSION["user_image"] . '" class="img-responsive img-circle img-thumbnail" style="width: 50px; height: 50px" /> </h2>';
                        echo ('<a class="dropdown-toggle" data-toggle="dropdown">' . $profile_button . '</a>
                               <ul class="dropdown-menu">
                                  <li><a href="logout.php">Logout</li>
                               </ul>');
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    
    <br /><br />
    <div class="container" style="width:900px;">
        <h2 align="center">Playlists</h2>
        <br /><br />
        <form method="post" action="export.php">
            <input type="submit" name="export" value="Download Playlist as CSV" />
        </form>
        <br /><br />
        <div>
        <h4>Select location below to view corresponding playlist and current song being played:</h4>
        <form method="POST" >
            <select id="location" name="location">
                <option value="1515">1515</option>
                <option value="afc">AFC</option>
                <option value="memGym">Mem Gym</option>
                <option value="msc">Multicultural Students Center</option>
                <option value="newcomb">Newcomb</option>
                <option value="newcombStarbucks">Newcomb Starbucks</option>
                <option value="ohill">Ohill</option>
                <option value="pav">Pav</option>
                <option value="runk">Runk</option>
                <option value="slaughter">Slaughter</option>
                <option value="westRange">West Range</option>
            </select>
        <input type="submit" name="submit" value="Submit">
        </form>
        <!-- <h5> <?php echo $location + "Playlist Name: " + $locationPlaylist + "Current Song" + $locationCurrentSong ?> </h5> -->
    </div>
        
    <!--
    <div class="container">
        <h3>Navbar Forms</h3>
        <p>Use the .navbar-form class to vertically align form elements (same padding as links) inside the navbar.</p>
        <p>The .input-group class is a container to enhance an input by adding an icon, text or a button in front or behind it as a "help text".</p>
        <p>The .input-group-btn class attaches a button next to an input field. This is often used as a search bar:</p>
    </div>
                -->
</body>

</html>