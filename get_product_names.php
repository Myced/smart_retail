<?php 
require_once './includes/class.dbc.php';

require_once './includes/functions.php';

$db  = new dbc();
$dbc = $db->connect();

$key = filter($_POST['key']);


//array to contain the results
$return = [];

$query = "SELECT `product_name` from `products`"
        . " WHERE `product_name` LIKE '%$key%' LIMIT 20;";

$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) > 0)
{
    //enter the results into an array
    while($row = mysqli_fetch_array($result))
    {
        array_push($return, $row['product_name']);
    }
    
    //now json encode the data first
    $final = json_encode($return);
    
    echo $final;
}
?>