<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

?>

<html>
    <head>
        <title>
            Inventory List
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
                                    Fax: 466
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
                    INVENTORY LIST
                </div>
            </div>
            
            <!--end of document title-->
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    
                    <?php
                    //do the query here
                    $query = "SELECT * FROM `products` ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");
                    
                    $count = 1;
                    ?>
                    
                    <table class="table table-striped table-bordered text-center">
                            <tr style="background-color: inherit;">
                            <th> N<sup>o</sup> </th>
                            <th> Product Code</th>
                            <th> Product Name </th>
                            <th> Category</th>
                            <th> Unit</th>
                            <th> Quantity </th>
                            <th> Unit Price</th>

                          </tr>

                          <?php



                          if(mysqli_num_rows($result) == 0)
                          {
                              ?>
                              <tr>
                                <td colspan="7" class="text-center">
                                  <strong class="text-primary">
                                      No Products Found!
                                  </strong>
                                </td>
                              </tr>
                              <?php
                          }
                          else
                          {

                            while ($row = mysqli_fetch_array($result))
                            {
                                ?>
                              <tr style="background-color:  white;">
                                <td>
                                  <?php echo $count++; ?>
                                </td>

                                
                                
                                <td>
                                    <?php echo $row['product_code']; ?>
                                </td>

                                <td>
                                  <?php echo $row['product_name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['category']; ?>
                                </td>
                                
                                <td>
                                    <?php echo $row['measure_unit']; ?>
                                </td>

                                <td>
                                    <?php echo $row['quantity']; ?>
                                </td>

                                <td>
                                    <?php echo number_format($row['unit_price']); ?>
                                </td>

                            </tr>
                                <?php
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