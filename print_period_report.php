<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

///check the filter has been check
if(isset($_GET['start_date']))
{
    //now collect everythign here

    $start_date = get_date(filter($_GET['start_date']));
    $end_date = get_date(filter($_GET['end_date']));
    
    $s_date = filter($_GET['start_date']);
    $e_date  = filter(filter($_GET['end_date']));
    
    (int)$ed = (int) strtotime($end_date);
    (int) $sd = (int)strtotime($start_date);
    
    if($sd > $ed)
    {
        $error = "Sorry. Starting date is ahead of ending Date. <strong> Please Correct that </strong>";
    }
   
    
    if(!isset($error))
    {
        //then start looking for products
        //do your calculation
        $incremnt = 24*60*60;
        
    }
    
    
}

?>

<html>
    <head>
        <title>
            General Sales Report
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
                    General Sales Report
                </div>
            </div> 
            <!--end of document title-->
            
            <div class="row" style="text-align: center; margin-bottom: 10px;">
                From <?php echo $s_date; ?>    To <?php echo $e_date; ?>
            </div>
            
            <!--nwo docuemtn databank-->
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="document_data">
                    
                    <?php
                    //do the query here
                    
                    $count = 1;
                    ?>
                    
                    <table class="table table-striped table-bordered text-center">
                            <tr style="background-color: inherit;">
                                <th> N<sup>o</sup> </th>
                                <th> Date</th>
                                <th> Ref </th>
                                <th> Product Name </th>
                                <th> Unit Price</th>
                                <th> Quantity </th>
                                <th> Amount</th>

                              </tr>

                          <?php
                          $sales = 0;
                            if (!isset($error) ) {
                              while ($sd <= $ed) {
                                  //get the data first
                                  
                                  $current_date = date("d/m/Y", $sd);;

                                  $daay = substr($current_date, 0, 2);
                                  $moonth = substr($current_date, 3, 2);
                                  $yeear = substr($current_date, 6, 4);

                                  //now do a query
                                  $query = "SELECT * FROM `sales` WHERE "
                                          . " `day` = '$daay' AND `month` = '$moonth'"
                                          . " AND `year` = '$yeear' ";
                                  $res = mysqli_query($dbc, $query);

                                  $sd += $incremnt;
                                  
                                  if(mysqli_num_rows($res) == 0)
                                    {
                                        ?>
                                        
                                        <?php
                                    }
                                    else
                                    {
                                        $show_print = TRUE;
                                      while ($row = mysqli_fetch_array($res))
                                      {
                                       $sales++;   
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
                                              <?php echo number_format($row['unit_price']); ?>
                                          </td>

                                          <td>
                                              <?php echo $row['quantity']; ?>
                                          </td>

                                          <td>
                                              <?php echo number_format($row['total']) . ' FCFA'; ?>
                                          </td>

                                      </tr>
                                          <?php
                                      }
                                    }
                                  
                              }
                              
                            if($sales == 0)
                                {
                                    ?>
                                  <tr class="white-background">
                                      <td colspan="6" class="text-center">
                                        <strong class="text-primary">
                                            No Sales History Found for this Period.
                                        </strong>
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