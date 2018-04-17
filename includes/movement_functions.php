<?php

/**
 * 
 * @param int $month the month to get the initial quantity
 * @param int $year the year to get the initial quantity
 * @param mixed $product The product code of the product to get its inital quantity
 * @return string The initial quantity for that product in that month and year
 * @author T N CED tncedric@yahoo.com
 * @
 */
function get_start_qty($month, $year, $product)
{
    $db = new dbc();
    $dbc = $db->connect();
    
    //initialise the initial quantity
    $initial_quantity = '';
    
    //the initial quantity is the quantity of the first row for this product
    // for that month and for the year.
    $query = "SELECT * FROM `movement` "
            . " WHERE `month` = '$month' AND"
            . "       `year` = '$year' AND "
            . "       `product_code` = '$product'"
            . ""
            . " ORDER BY `id` ASC LIMIT 1";
    
    $result = mysqli_query($dbc, $query)
            or die("Cannot get start quantity");
    if(mysqli_num_rows($result) == 0)
    {
        $initial_quantity = 0;
        
    }
    else
    {
        //grab the initial quantity
        while($row = mysqli_fetch_array($result))
        {
            $qun = $row['initial'];
            $initial_quantity = $qun;
        }
    }
    
    return $initial_quantity;
}

/**
 * 
 * @param int $month the month to get the initial quantity
 * @param int $year the year to get the initial quantity
 * @param mixed $product The product code of the product to get its inital quantity
 * @return string The Final quantity for that product in that month and year
 * @author T N CED tncedric@yahoo.com
 * @
 */
function get_end_qty($month, $year, $product)
{
    $db = new dbc();
    $dbc = $db->connect();
    
    //initialise the initial quantity
    $final_quantity = '';
    
    //the initial quantity is the quantity of the first row for this product
    // for that month and for the year.
    $query = "SELECT * FROM `movement` "
            . " WHERE `month` = '$month' AND "
            . "       `year` = '$year' AND "
            . "       `product_code` = '$product'"
            . ""
            . " ORDER BY `id` DESC LIMIT 1";
    
    $result = mysqli_query($dbc, $query)
            or die("Cannot get start quantity");
    if(mysqli_num_rows($result) == 0)
    {
        $final_quantity = 0;
        
    }
    else
    {
        //grab the initial quantity
        while($row = mysqli_fetch_array($result))
        {
            $qun = $row['final'];
            $final_quantity = $qun;
        }
    }
    
    return $final_quantity;
}

?>

