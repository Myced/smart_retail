<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

$ref = filter($_GET['ref']);
?>

<html>
    <head>
        <title>
            Receipt
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
            
            <div class="row">
                <div class="reference">
                    N<sup>o</sup>: 
                    <span class="ref">
                        <?php echo $ref; ?>
                    </span>
                </div>
            </div>
            
            <!--now document title-->
            <div class="row">
                <div class="document_title">
                    <div class="reciept" style="width: 50%; margin:  auto; border-bottom: 1px solid #999; margin-bottom: 30px;">
                        Receipt
                    </div>
                </div>
            </div>
            
            <!--end of document title-->
            <?php 
                $query = "SELECT * FROM `sales_ref` WHERE `ref` = '$ref'";
                $result = mysqli_query($dbc, $query);
                
                while($row = mysqli_fetch_array($result))

                {
                    $date = $row['date'];
                    $sales_agent = $row['sales_agent'];
                    $total = $row['total_price'];
                }
?>
            
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="information">
                        <div class="set1">
                            Client Name:
                            
                            <span class="sales_agent">
                                <?php echo $sales_agent; ?>
                            </span>
                        </div>
                        
                        <div class="set2">
                            Sales Date:
                            <span class="date">
                                <?php echo $date; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    <?php
                    $query = "SELECT * FROM `sales` WHERE `ref` = '$ref'";
                    $result = mysqli_query($dbc, $query);
                    ?>
                    <table class="table table-striped table-bordered text-center">
                        <tr style="background-color: inherit;">
                            <th> N<sup>o</sup> </th>
                            <th> Product Code</th>
                            <th> Product Name </th>
                            <th> Quantity </th>
                            <th> Unit Price</th>
                            <th> Total</th>

                        </tr>

                        <?php
                        if (mysqli_num_rows($result) == 0) {
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <strong class="text-primary">
                                        No Funds Found!
                                    </strong>
                                </td>
                            </tr>
                            <?php
                        } else {
                            $count = 1;
                            while ($row = mysqli_fetch_array($result)) {
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
                                <?php echo $row['quantity']; ?>
                                    </td>

                                    <td>
                                <?php echo number_format($row['unit_price']); ?>
                                    </td>
                                    
                                    <td>
                                <?php echo number_format($row['total']); ?>
                                    </td>

                                </tr>
                                    <?php
                                }
                            }
                            ?>
                                <tr>
                                    <td colspan="4">
                                        <strong> Total </strong>
                                    </td>
                                    <td colspan="2">
                                        <strong>
                                            <?php echo number_format($total); ?> FCFA
                                        </strong>
                                    </td>
                                </tr>
                    </table>
                    
                    <div class="row">
                        <div class="signature">
                            Sales Agent:
                            <span class="signature_line">
                                
                            </span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            <div class="divFooter">
                Printed On <span class="text-italics"><?php echo date("d/m/Y"); ?></span>
            </div>
        </div>
    </body>
</html>
