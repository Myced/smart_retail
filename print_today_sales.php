<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
include_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

?>

<html>
    <head>
        <title>
            Sales Today <?php echo date("d/M/Y"); ?>
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
                    Sales Today <?php echo date("l - d/M/Y"); ?>
                </div>
            </div>
            
            <!--end of document title-->
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    
                    <?php
                    //do the query here
                    $query = "SELECT * FROM `sales` "
                            . " WHERE `day` = '$day' AND `month` = '$month' AND `year` = '$year'"
                            . "ORDER BY `id` ASC";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");
                    
                    $count = 1;
                    ?>
                    
                    <table class="table table-striped table-bordered text-center white-background">
                        <tr style="background-color: inherit;">
                            <th> N<sup>o</sup> </th>
                            <th> Date</th>
                            <th> Ref </th>
                            <th> Product Name </th>
                            <th> Quantity </th>
                            <th> Amount</th>

                          </tr>

                      <?php

                      $total = 0;

                      if(mysqli_num_rows($result) == 0)
                      {
                          ?>
                          <tr>
                            <td colspan="6" class="text-center">
                              <strong class="text-primary">
                                  No Sales History Found!
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
                                <?php echo $row['date']; ?>
                            </td>

                            <td>
                                <?php echo $row['ref']; ?>
                            </td>

                            <td>
                              <?php echo $row['product_name']; ?>
                            </td>


                            <td>
                                <?php echo $row['quantity']; ?>
                            </td>

                            <td>
                                <?php 
                                $total += (int)$row['total'];
                                echo number_format($row['total']) . ' FCFA'; ?>
                            </td>

                        </tr>
                            <?php
                        }
                      }
                       ?>
                        <tr>
                            <th class="text-center" colspan="5">
                                Total
                            </th>
                            <th>
                                <strong class="">
                                    <?php echo number_format($total); ?> FCFA
                                </strong>
                            </th>
                        </tr>
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