<?php


function get_quantity($code)
{
    global $dbc;
    
    $q = "SELECT `quantity` FROM `products` WHERE `product_code` = '$code'";
    $result = mysqli_query($dbc, $q);
    
    if(mysqli_num_rows($result) == 1)
    {
        while ($row = mysqli_fetch_array($result))
        {
            $quan = $row['quantity'];
        }
        
        return $quan;
    }
    else
        return '-111';
}
?>


