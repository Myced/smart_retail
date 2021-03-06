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
            Returned Inventory
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
                    Ref: 
                    <span class="ref">
                        <?php echo $ref; ?>
                    </span>
                </div>
            </div>
            
            <!--now document title-->
            <div class="row">
                <div class="document_title">
                    Stock Count
                </div>
            </div>
            
            <!--end of document title-->
            <?php 
                $query = "SELECT * FROM `stock_count_ref` WHERE `ref` = '$ref'";
                $result = mysqli_query($dbc, $query);
                
                while($row = mysqli_fetch_array($result))

                {
                    $date = $row['date'];
                    $sales_agent = $row['agent_name'];
                }
?>
            
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="information">
                        <div class="set1">
                            Sales Agent:
                            
                            <span class="sales_agent">
                                <?php echo $sales_agent; ?>
                            </span>
                        </div>
                        
                        <div class="set2">
                            Date Counted:
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
                    $query = "SELECT * FROM `stock_count` WHERE `ref` = '$ref'";
                    $result = mysqli_query($dbc, $query);
                    ?>
                    <table class="table table-striped table-bordered text-center">
                        <tr style="background-color: inherit;">
                            <th> N<sup>o</sup> </th>
                            <th> Product Code</th>
                            <th> Product Name </th>
                            <th> S. Quantity </th>
                            <th> M. Unit Price</th>
                            <th> Difference</th>

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
                                <?php echo $row['s_quantity']; ?>
                                    </td>

                                    <td>
                                <?php echo $row['m_quantity']; ?>
                                    </td>
                                    
                                    <td>
                                <?php echo $row['difference']; ?>
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