<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/movement_functions.php';

$month = filter($_GET['month']);
$year = filter($_GET['year']);
$product = filter($_GET['product']);

$db = new dbc();
$dbc = $db->connect();

?>

<html>
    <head>
        <title>
            Inventory Movement Details
        </title>
        
        <link rel="stylesheet" href="css/AdminLTE.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/print.css">
		<link rel="stylesheet" href="css/font-awesome.css">
        
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
                    Inventory Movement Details
                </div>
            </div>
            
            <div class="row">
                <div style="text-align: center">
                    <div class="col-md-2 col-md-offset-1">
						Product Code: <strong> <?php echo $product; ?> </strong>
					</div>
					
					<div class="col-md-2">
						Product name: <strong> 
							<?php 
							$query = "SELECT `product_name` FROM `products` WHERE `product_code` = '$product'";
							$rs = mysqli_query($dbc, $query);
							
							list($pname) = mysqli_fetch_array($rs);
							
							echo $pname;
							?> 
						</strong>
					</div>
					
					<div class="col-md-2">
						Month: <strong> <?php echo get_month($month); ?> </strong>
					</div>
					
					<div class="col-md-3">
						Year: <strong> <?php echo $year; ?> </strong>
					</div>
                </div>
            </div>
			<br>
            
            <!--end of document title-->
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    
                    
                    <table class="table table-striped table-bordered text-center white-background">
                        <tr>
                            <th> N<sup>o</sup> </th>
                            <th> Date</th>
                            <th> Time </th>
                            <th> Opening Quantity </th>
                            <th> Closing Quantity </th>
							<th> Comment </th>

                          </tr>

							<?php
                            $count = 1; // variable to track counting
                            
                            if(isset($product))
                            {
                                //WE SHOW THE INVENTORY MOVEMENT FOR THAT PRODUCT
                                $query = "SELECT * FROM `movement`"
                                        . " WHERE "
                                        . "     `product_code` = '$product' AND"
                                        . "     `year` = '$year' AND "
                                        . "     `month` = '$month'";
                                $result = mysqli_query($dbc, $query)
                                        or die("Could not get the details");
                                
                                if(mysqli_num_rows($result) == 0)
                                {
                                    //there fore therer is not inventory moveemnt for this item in theis specified time
                                    ?>
                            <tr>
                                <td colspan="6">
                                    <strong class="text-primary">
                                        No Movement found for this item For this month Specified.
                                    </strong>
                                </td>
                            </tr>
                                    <?php
                                }
                                else
                                {
                                    //now we print out the inventory movement.
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $type = $row['type'];
                                        
                                        ?>
                            <tr>
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                
                                <td>
                                    <?php echo date_from_timestamp($row['time_added']); ?>
                                </td>
                                
                                <td>
                                    <?php echo time_from_timestamp($row['time_added']); ?>
                                </td>
                                
                                <td>
                                    <?php echo $row['initial']; ?>
                                </td>
                                
                                <td class="
                                    <?php
                                    if($type == '0')
                                    {
                                        echo 'text-danger';
                                    }
                                    else
                                    {
                                        echo 'text-success';
                                    }
                                    ?>
                                    ">
                                    <strong>
                                        <?php
                                        if($type == '0')
                                        {
                                            ?>
                                        <i class="fa fa-angle-down"></i>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                        <i class="fa fa-angle-up"></i>
                                            <?php
                                        }
                                        ?>
                                        <?php echo $row['final']; ?> 
                                    </strong>
                                </td>
                                
                                <td>
                                    <?php echo $row['comment']; ?>
                                </td>
                            </tr>
                                        <?php
                                    }
                                }
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