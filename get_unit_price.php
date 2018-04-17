<?php
//require database connection and session varibales
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

//create an instance of the database connection
$db = new dbc();
$dbc = $db->connect();

//Grab the member_id
$product_name = filter($_POST['key']);


$query = "SELECT `unit_price` FROM `products` WHERE `product_name` = '$product_name'";
$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) == 1)
{
    while($row = mysqli_fetch_array($result))
    {
        $out = $row['unit_price'];
    }

    echo $out;
}

?>