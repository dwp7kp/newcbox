<?php

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

include('config.php');
require('connectdb.php');
$data = [];
$login_button = '';

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

function create_table()
{
    global $db;
	$query = "create table if not exists song (
        sName VARCHAR(40) NOT NULL,
		mArtist VARCHAR(60) NOT NULL,
		fArtist VARCHAR(60),
genre VARCHAR(15) NOT NULL,
year  YEAR NOT NULL,
rating INT(2) DEFAULT NULL,
clean BOOL NOT NULL,
PRIMARY KEY (sName, mArtist)	 )";

	$statement = $db->prepare($query);
	$statement->execute();
	$statement->closeCursor();
}

function getAllSongs()
{
    global $db;
   $query = "select * from song";
   $statement = $db->prepare($query);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}

$songs = getAllSongs();


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
                <li><a href="/cs4750/newcbox/playlist.php">Playlists</a></li>
                <li class="active"><a href="#">Songs</a></li>
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

    <div style="height:500px;overflow:auto;">
    <h4>All Songs</h4>
      <table class="table table-striped table-bordered">
        <tr>
          <th>Name</th>
          <th>Main Artist</th>
          <th>Featured Artist </th>
          <th>Genre</th>
          <th>Year</th>
          <th>Rating</th>
          <th>Clean</th>
        </tr>      
        <?php foreach ($songs as $song): ?>
        <tr>
          <td>
            <?php echo $song['sName']; ?> 
          </td>
          <td>
            <?php echo $song['mArtist']; ?> 
          </td>        
          <td>
            <?php echo $song['fArtist']; ?> 
          </td>
          <td>
            <?php echo $song['genre']; ?> 
          </td>
          <td>
            <?php echo $song['year']; ?> 
          </td>
          <td>
            <?php echo $song['rating']; ?> 
          </td>
          <td>
            <?php echo $song['clean']; ?> 
          </td>                                                      
        </tr>
        <?php endforeach; ?>
      </table>
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