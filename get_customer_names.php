<?php
//require database connection and session varibales
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

//create an instance of the database connection
$db = new dbc();
$dbc = $db->connect();

//Grab the member_id
$customer_name = filter($_POST['key']);


$query = "SELECT `customer_name` FROM `customers` WHERE `customer_name` LIKE '%$customer_name%'";
$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) == 1)
{
    while($row = mysqli_fetch_array($result))
    {
        $out = $row['customer_name'];
    }

    echo $out;
}

?>