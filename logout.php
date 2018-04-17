<?php


session_start();

//destroy sessions and cookies
if(isset($_COOKIE['user_id']))
{
    setcookie('username', '', time() - 333*24*60*60);
    setcookie('user_id', '', time() - 333*24*60*60);
    setcookie('user_photo', '', time() - 333*24*60*60);
}

if(isset($_SESSION['user_id']))
{
    $_SESSION = array();
    
    session_destroy();
}

// redirect to login
header("Location: login.php");

?>

