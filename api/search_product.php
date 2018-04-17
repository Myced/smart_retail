<?php
require_once '../includes/class.dbc.php';
require_once '../includes/functions.php';


$search = filter($_POST['search']);


//setup database connection
$db = new dbc();
$dbc = $db->connect();

//now search the db and send results back

$query  = "SELECT * FROM `products` WHERE "
        . " `product_code` LIKE '%$search%' OR "
        . " `product_name` LIKE '%$search%' "
        . "  LIMIT 15";
$result = mysqli_query($dbc, $query);

//send out the result
$output = '';
$count = 1;

$output .= "<table class='table table-striped table-bordered text-center white-background'>"
        . "     <tr>"
        . "         <th>N<sup>o</sup> </th> "
        . "         <th> Product Code</th> "
        . "         <th> Product Name </th> "
        . "         <th> Category </th> "
        . "         <th> Unit </th> "
        . "         <th> Qauntity </th> "
        . "         <th> Unit Price </th> "
        . "         <th> Action </th> "
        . "     </tr>";

if(mysqli_num_rows($result) == 0)
{
    $output .= "<tr>"
            . " <td colspan='9' class='text-center'>
                        <strong class='text-primary'>
                            No Items Match this search
                        </strong>
                      </td>"
            . "</tr>";
}

else
{
    while($row = mysqli_fetch_array($result))
    {   
        $output .= "<tr class='white_background'>"
                . "     <td>" . $count++ . "</td>"
                . "     <td>" . $row['product_code'] . "</td>"
                . "     <td>" . $row['product_name'] . "</td>"
                . "     <td>" . $row['category']  . "</td>"
                . "     <td>" . $row['measure_unit'] . "</td>"
                . "     <td>" . $row['quantity'] . "</td>"
                . "     <td>" . number_format($row['unit_price']) . "</td>"
                . "     <td>
                            <a href='edit_product.php?item=" . $row['product_code'] . "'
                                class='btn btn-primary btn-xs' title='Edit this product'>
                                <i class='fa fa-pencil'></i>
                            </a>
                    </td>"
                . "</tr>";
    }
}

$output .= "</table>";

echo $output;
