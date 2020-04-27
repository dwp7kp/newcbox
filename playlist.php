<?php
require('connectdb.php');
require('playlist-db.php');
include('home.php')
?>

<?php
    $msgLocation = '';
    $location = '';
    if(isset($_POST['submit'])) {
        $location = $_POST['location'];
        echo "the location is " + $location;
        if(!empty(getLocationPlaylist($location))) {
            $msgLocation = "Playlist: " + getLocationPlaylist($location) + "Current Song Playing: " + getCurrentSong($location);
        } 
        else {
            $msgLocation = "The selected location currently does not have a playlist."; 
        }
    }
?>

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
<!-- <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">NewcBox</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li class="active"><a href="#">Playlist</a></li>
                <li><a href="song.php">Song</a></li>
            </ul>
            <form class="navbar-form navbar-left" action="/action_page.php">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</body> -->
<body>
    <div style="padding-left:15px;">
    <h1>Playlist</h1>
    <h4>Select location below to view corresponding playlist and current song being played:</h4>
    <form method="POST" action="#">
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
        <input type="submit" name="submit" value="Submit" />
    </form>
    <h5> <?php echo $msgLocation ?> </h5>
    </div>
</body>
</html>
