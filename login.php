<?php
require_once './includes/class.dbc.php';
require_once './includes/functions_home.php';


//connect to the database
$db = new dbc();
$dbc = $db->connect();

if(isset($_POST['signin']))
{
    //the grab the credentials
    $username = filter($_POST['username']);
    $password = filter($_POST['password']);
    
    $hash = sha1($password);
    
    //check if the username exist
    $query = "SELECT * FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($dbc, $query);
    
    //now for the number of rows
    if(mysqli_num_rows($result) == 0)
    {
        //the username was not found
        $error = "Invalid Username or Password";
    }
    elseif(mysqli_num_rows($result) > 1)
    {
        $error = "No Valid User Found. Contact Admin";
    }
    else
    {
        //ther username is found. So check for password
        
        //get the password stored in the database
        while($row = mysqli_fetch_array($result))
        {
            $user_id = $row['user_id'];
            $pass = $row['password'];
            $photo = $row['photo'];
            
        }
        
        //now check if the passwords match
        if($hash == $pass)
        {
            //log the user in
            //create sessions and session ids.
            
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_photo'] = $photo;
            
            //now set the cookies if remember me is set
            if(isset($_POST['remember']))
            {
                //set the cookies.
                setcookie("user_id", $user_id);
                setcookie("username", $username);
                setcookie("user_photo", $photo);
            }
            
            //now redirect to home.
            header("Location: home.php");
        }
        else
        {
            //invalid password supplied
            $error = "Invalid Username or Password";
        }
    }
}
?>

<html>
    <head>
        <title>Smart Retail Login</title>
        
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/graphic.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        
    </head>
    
    <body>
        <div class="container">
            <div class="card card-container">
                <div class="row">
                    <div class="logo">
                        <img src="images/Smartretailx300.png" title="Smart Retail" alt="SMART RETAIL LOGO">
                    </div>
                </div>
                
                
                <?php
                    //space for error display
                    if(isset($error))
                    {
                        ?>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center error">
                            <?php echo $error; ?>
                        </div>
                    </div>
                </div>
                <br>
                        <?php
                    }
                ?>
                
                <form class="form-signin" method="POST">
                    <span id="reauth-email" class="reauth-email"></span>
                    <input type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus name="username">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me" name="remember"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="signin">Sign in</button>
                </form><!-- /form -->
                <a href="#" class="forgot-password">
                    Forgot the password?
                </a>
            </div><!-- /card-container -->
        </div><!-- /container -->
        
        <script src="js/login.js"></script>
    </body>
</html>
