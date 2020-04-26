<?php

include('home.php');

if (!isset($_SESSION['computing']))
    header("location:home.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

function updateDB() {
    
}

?>

<body>
    <div class="col-md-offset-1">
        <form ng-app="" ng-init='edit=false;' method="post">
            <h1>
                Profile
                <a ng-click="edit = true"><button type="button" class=btn btn-light><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
            </h1>
            <div class="form-group">
                <label for="first">First Name</label>
                <input type="text" ng-disabled='!edit' class="form-control" id="first" aria-describedby="subtext" value="<?php echo ($_SESSION['user_first_name']) ?>" style="width: 25%;">
            </div>
            <div class="form-group">
                <label for="middle">Middle Name</label>
                <input type="text" ng-disabled='!edit' class="form-control" id="middle" aria-describedby="subtext" value="<?php echo ($_SESSION['user_middle_name']) ?>" style="width: 25%;">
            </div>
            <div class="form-group">
                <label for="last">Last Name</label>
                <input type="text" ng-disabled='!edit' class="form-control" id="last" aria-describedby="subtext" value="<?php echo ($_SESSION['user_last_name']) ?>" style="width: 25%;">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" ng-disabled='true' class="form-control" id="email" aria-describedby="subtext" value="<?php echo ($_SESSION['user_email_address']) ?>" style="width: 25%;">
            </div>


            <button type="submit" href='#modal' data-toggle='modal' ng-hide='!edit' class="btn btn-primary" ng-click="edit = false" onclick="udpateDB()">Save</button>

            <div id="modal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Success!</h4>
                            <p>Your account has been successfully updated.</p>
                            <button class="btn btn-success" data-dismiss="modal"><span>Continue</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>