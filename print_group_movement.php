<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/movement_functions.php';

$month = filter($_GET['month']);
$year = filter($_GET['year']);

$db = new dbc();
$dbc = $db->connect();

?>

<html>
    <head>
        <title>
            Inventory Movement
        </title>
        
        <link rel="stylesheet" href="css/AdminLTE.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/print.css">
        
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                
                
                <?php
                $que = "SELECT * FROM `company` WHERE `id` = '1'";
                
                $res = mysqli_query($dbc, $que);
                
                while($r = mysqli_fetch_array($res))
                {
                    
                ?>
                
                <div class="head">
                    <div class="logo">
                        <img src="
                             <?php 
                             $photo = $r['photo'];
                             
                             if(file_exists($photo))
                             {
                                 echo $photo;
                             }
                             else
                             {
                                 echo 'images/no.jpg';
                             }
                             ?>
                             " class="image">
                    </div>
                    
                    <div class="other">
                        <div class="row">
                            <div class="company">
                                <?php echo $r['company_name']; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="more_company">
                                <div class="info contact">
                                    Contact: <?php echo $r['contact']; ?>
                                </div>
                                
                                <div class="info fax">
                                    Fax: 
                                </div>
                                
                                <div class="info email">
                                     Email: <?php echo $r['email']; ?>
                                </div>
                                
                                <div class="info pobox">
                                     <?php echo $r['pobox']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                } //endigng the while loop for the page header.
                ?>
                
            </div>
            <!--end of heading row-->
            
            
            <!--now document title-->
            <div class="row">
                <div class="document_title">
                    Inventory Movement
                </div>
            </div>
            
            <div class="row">
                <div style="text-align: center">
                    Month: <strong><?php echo get_month($month); ?></strong> -  Year: <strong><?php echo $year; ?></strong>
                </div>
            </div>
            
            <!--end of document title-->
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    
                    
                    <table class="table table-striped table-bordered text-center white-background">
                        <tr>
                            <th> N<sup>o</sup> </th>
                            <th> Product Code</th>
                            <th> Product Name </th>
                            <th> Opening Quantity </th>
                            <th> Closing Quantity </th>

                          </tr>

                          <?php
							//append a zero at the front if the digit is one
                                    $i = $month;
                                    if(strlen($i) == 1)
                                    {
                                        $num = '0' . $i;
                                    }
                                    else
                                    {
                                        $num = $i;
                                    }
                                    
                                    //counting variable
                                    $count = 1;
                                    
                                    //get all the products here and see their opening and coling 
                                    // balances
                                    $query = "SELECT * FROM `products`";
                                    $result = mysqli_query($dbc, $query)
                                            or die("Cannot continue");
                                    while($row = mysqli_fetch_array($result))
                                    {
                                           $quantity = $row['quantity']; 
                                        ?>
                            <tr>
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                
                                <td>
                                    <?php echo $product = $row['product_code']; ?>
                                </td>
                                
                                <td>
                                    <?php echo $row['product_name']; ?>
                                </td>
                                
                                <td>
                                    <?php
                                        //call the function that will return the starting quantity
                                    $start = get_start_qty($num, $year, $product); 
                                    if($start == 0)
                                    {
                                        echo $quantity;
                                    }
                                    else
                                    {
                                        echo $start;
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    //call the function that will return the ending quantity
                                    $end = get_end_qty($num, $year, $product);
                                    if($end == 0)
                                    {
                                        echo $quantity;
                                    }
                                    else
                                    {
                                        echo $end;
                                    }
                                    ?>
                                </td>
                                
                            </tr>
							<?php
									}
									?>
                           
                      </table>
                </div>
                </div>
            </div>
            
            <div class="divFooter">
                Printed On <span class="text-italics"><?php echo date("d/m/Y"); ?></span>
            </div>
        </div>
    </body>
</html>