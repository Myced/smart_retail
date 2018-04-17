<?php
//check if the user is logged in

if(!isset($_SESSION['user_id']))
{
    //sned the person bacl to login
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=0.1">	
        <meta name="author" content="Smart Retail"> 
        <title>Smart Retail</title> 
        <link rel="shortcut icon" href="images/smart_ico.ico">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css"> 
        <link href="css/style.css" rel="stylesheet" type="text/css"> 
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
        <link rel="stylesheet" href="css/select2.css" type="text/css">
        <link rel="stylesheet" href="css/animate.css" type="text/css">
        <link rel="stylesheet" href="css/church.css" type="text/css">
        <link rel="stylesheet" href="css/svg.css" type="text/css">
        
        
        <!--scripts-->
        <script src="js/jquery.js"></script>
        <script src="js/select2.full.js"></script>
        <script src="js/bootstrap3-typeahead.js"></script>
        <script src="js/jquery.preimage.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/wow.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/app.js"></script>

    </head>

    <body>

        <nav class="navbar navbar-inverse top-nav navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <ul>
                        <li><a href="#" class="menu-icon" id="btn-menu"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="brand-logo">
                                Smart Retail
                            </a>
                        </li>      
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-left">      
                        <li><a href="home.php" class="home"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                        <form class="navbar-form navbar-left">
                            <div class="input-group">        
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </form> 
                    </ul>

                    <ul class="navbar-right">
                        <li><a href="#" class="th-icon"><i class="" aria-hidden="true"></i>Welcome</a></li>     
                        

<!--                              <li class="">
                                  
                                  <a href="#" class=" dropdown-toggle user">
                                      <img src="images/no.jpg" class="img-responsive img-circle profil">
                                      
                                  </a>
                                 
                              </li>-->

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle profil" data-toggle="dropdown">
                                <img src="<?php echo $_SESSION['user_photo']; ?>" class="img-responsive img-circle">
                            </a>
                            <ul class="dropdown-menu">
                                <div class="row welcome text-center">
                                    <strong>
                                        Welcome!
                                    </strong>
                                </div>
                                
                                <div class="row username">
                                    <strong class="text-primary">
                                        <?php echo $_SESSION['username']; ?>
                                    </strong>
                                </div>
                                
                                <li><a href="#"></a></li>
                                <li class="divider"></li>
                                <li class="divider"></li>
                                
                                <li class="divider"></li>
                                <li style="width: 100%; text-align: center;"><a href="change_password.php"> Change Password</a></li>
                                <li style="width: 100%; text-align: center;"><a href="logout.php">Sign Out </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> 