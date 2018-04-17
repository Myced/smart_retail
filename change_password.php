<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

if(isset($_POST['change']))
{
    //grab the various password fields.
    $old_password = filter($_POST['current_password']);
    $new_password = filter($_POST['new_password']);
    $repeat_password = filter($_POST['repeat_password']);
    
    $old_hash = sha1($old_password);
    $new_hash = sha1($new_password);
    
    $user_id = get_user_id();
    
    if(empty($old_password) || empty($new_password) || empty($repeat_password))
    {
        $error = "You must fill all form fields";
    }
    
    if(!isset($error))
    {
        //now check if the new password is corrent.
        $query = "SELECT `password` FROM `users` WHERE `user_id` = '$user_id'";
        $result  = mysqli_query($dbc, $query)
                 or die("Could not check the password");

        list($password) = mysqli_fetch_array($result);

        if($password == $old_hash)
        {
            //then the password are the same
            if($new_password != $repeat_password)
            {
                //error again
                $error = "The new password and the repeated password do not match";
            }
            else
            {
                //update the password.
                $query = "UPDATE `users` SET `password` = '$new_hash'";
                $result = mysqli_query($dbc, $query)
                         or die("Could not change your password");
                
                $success = "Password Successfully changed";
            }
        }
        else
        {
            $error = "Current Password is not correct";
        }
    }
}

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<div class="row">
    <div class="row">
        <div class="col-md-12 text-center">
            <br>
            <h1 class="page-header" >Change Password</h1>
        </div>
    </div>

    <?php
    require_once './includes/notifications.php';
    ?>

    <div class="row">
        <div class="col-md-12">
            <form action="" method="POST">
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="password" placeholder="Enter Current Password" 
                                name="current_password" class="form-control">
                    </div>
                </div>
                
                <br>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <input type="password" placeholder="Enter New Password" 
                                name="new_password" class="form-control">
                    </div>
                </div>
                
                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <input type="password" placeholder="Repeat the new Password" 
                                name="repeat_password" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button class="btn btn-info btn-block btn-flat" name="change">
                            <strong> Change Password </strong>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<?php
require_once './includes/bottom.php';
?>