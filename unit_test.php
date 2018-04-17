<?php

//Testing if a function is working

//first include the datbase connectin and other things
include_once './includes/class.dbc.php';
include_once './includes/functions.php';

// now lets move the inventory and see.,

// now lets call the funciton and see.
//now lets move the inventory
$code = 'ITM00006';
$init = 140;
$end = 200;
$comment = "Updating the stock i have with stocks";

move_inventory($code, $init, $end, $comment)
?>