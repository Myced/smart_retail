<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

//do page transactions here
//query initialisation
$results_per_page = 50; //number of results to show on a sigle page

//data manipulation
if(isset($_GET['page']))
{
    //get the page number
    $page_number = filter($_GET['page']);
    
    //Variable to maintain countring
    $inter  = $page_number - 1; //reduces the page numer in order to count
    $count = (int) ($inter * $results_per_page) + 1;
}
else
{
    $page_number = 1;
    
    //Variable to do countring
    $count = 1;
}

//START OF search results 
if($page_number < 2)
{
    $start = 0;
}
 else {
     $start = (($page_number - 1) * ($results_per_page));
}

//total data in the database;
$query = "SELECT * from `sales`";
$result  = mysqli_query($dbc, $query);

$total = mysqli_num_rows($result);

if($results_per_page >= 1)
{
    
   $number_of_pages = ceil($total/$results_per_page);
   
   if($number_of_pages < 1)
   {
       $page_count = 1;
   }
   else
   {
       $page_count = $number_of_pages;
   }
    
} 
else
{
    $error = "Results Per page Cannot be zero or Less";
    $page_count = 1;
}
//end 
$end = $results_per_page;

//now if page number is greater that 
if($page_number > $page_count)
{
    $error = "That Page does not Exist";
}


///check the filter has been check
if(isset($_POST['client']))
{
    //now collect everythign here
    
    $client = filter($_POST['client']);
    $start_date = get_date(filter($_POST['start_date']));
    $end_date = get_date(filter($_POST['end_date']));
    
    $s_date = filter($_POST['start_date']);
    $e_date  = filter(filter($_POST['end_date']));
    
    (int)$ed = (int) strtotime($end_date);
    (int) $sd = (int)strtotime($start_date);
    
    if($sd > $ed)
    {
        $error = "Sorry. Starting date is ahead of ending Date. <strong> Please Correct that </strong>";
    }
    
    if($client == '--')
    {
        $error = "You did not select a product";
    }
    
    if(!isset($error))
    {
        //then start looking for products
        //do your calculation
        $incremnt = 24*60*60;
        
    }
    
    
}





/**
 * set up page active links
 */
$sidebar = "sell";
$sublink = "reports";


/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<br>
<div class="row">
    <?php
    require_once './includes/notifications.php';
    ?>
    
    <?php
    require_once './letter_head.php';
    ?>

    <div class="row">
          <!--search bar-->
          <div class="col-md-12">
              <div class="text-center">
                  <h2>Customer Sales Report </h2>
                  
                  <?php
                  if(!isset($error))
                  {
                      if(isset($start_date))
                      {
                          ?>
                  From <?php echo $s_date; ?> To <?php echo $e_date; ?>
                          <?php
                      }
                      else
                        {?>

                        From 01/01/<?php echo date("Y"); ?> To 01/01/<?php echo date("Y"); ?>
                        <?php
                        }
                  }
                  else
                    {
                      ?>

                    From 01/01/<?php echo date("Y"); ?> To 01/01/<?php echo date("Y"); ?>
                    <?php
                    }
                    ?>
              </div>
          </div>
      </div>
      
      <br>
      
      <div class="row">
          <!--search bar-->
          <form action="customer_sales_report.php" method="POST">
            <div class="col-md-4">
                <div class="text-center">
                    <select name="client" class="form-control">
                        <option value="--">--Customer--</option>
                        <?php
                        $query = "SELECT * FROM `sales_ref` GROUP BY `sales_agent`";
                        $res = mysqli_query($dbc, $query);

                        while($row  = mysqli_fetch_array($res))

                        {
                            ?>
                        <option value="<?php echo $row['sales_agent']; ?>">
                            <?php echo $row['sales_agent']; ?>
                        </option>
                            <?php
                        }
                          ?>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <input type="text" name="start_date" class="form-control datepicker" placeholder="Start Date">
            </div>

            <div class="col-md-3">
                <input type="text" name="end_date" class="form-control datepicker" placeholder="End Date">
            </div>

            <div class="col-md-2">
                <input type="submit" class="btn btn-block btn-success" value="Filter">
            </div>
          </form>
      </div>
      
      <br>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <div id="table_area">
                        <table class="table table-striped table-bordered text-center">
                            <tr style="background-color: inherit;">
                                <th> N<sup>o</sup> </th>
                                <th> Date</th>
                                <th> Ref </th>
                                <th> Client</th>
                                <th> Product Name </th>
                                <th> Quantity </th>
                                <th> Amount</th>

                              </tr>

                          <?php
                          $sales = 0;
                            if (!isset($error) && isset($client) && $client != '--') {
                              while ($sd <= $ed) {
                                  //get the data first
                                  
                                  $current_date = date("d/m/Y", $sd);;

                                  $daay = substr($current_date, 0, 2);
                                  $moonth = substr($current_date, 3, 2);
                                  $yeear = substr($current_date, 6, 4);

                                  //now do a query
                                  $query = "SELECT * FROM `sales_ref` WHERE "
                                          . " `day` = '$daay' AND `month` = '$moonth'"
                                          . " AND `year` = '$yeear' AND `sales_agent` = '$client'";
                                  $ress = mysqli_query($dbc, $query);

                                  $sd += $incremnt;
                                  
                                  while($row = mysqli_fetch_array($ress))
                                  {
                                      $client_name = $row['sales_agent'];
                                      $sales_ref = $row['ref'];
                                      
                                      //now get all items with this ref
                                      $query = "SELECT * FROM `sales` WHERE "
                                          . " `day` = '$daay' AND `month` = '$moonth'"
                                          . " AND `year` = '$yeear' AND `ref` = '$sales_ref'";
                                        $res = mysqli_query($dbc, $query);
                                  
                                  
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
                                              <?php echo $client_name; ?>
                                          </td>
                                          
                                          <td>
                                            <?php echo $row['product_name']; ?>
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
                                  } //end the while loop
                              }
                              
                              if($sales == 0)
                                    {
                                        ?>
                                      <tr class="white-background">
                                          <td colspan="6" class="text-center">
                                            <strong class="text-primary">
                                                No Sales History Found for this Product!
                                            </strong>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                          }
                          else
                          {
                             
                          }



                          
                           ?>
                      </table>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="pull-right">
                      Page <?php echo $page_number; ?>/<?php echo $page_count; ?>
                  </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <?php 
                        if($page_count > 1)
                        {
                            ?>
                        <ul class="pagination">
                            <?php 
                            if($page_number != 1)
                            {
                                ?>
                            <li class="previous">
                                <a href="customer_sales_report.php?page=<?php echo $page_number - 1; ?>">Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php 
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="customer_sales_report.php?page=<?php echo $i; ?>" >
                                    <?php echo $i; ?>
                                </a>
                            </li>
                                <?php
                            }
                            ?>
                            
                            <?php
                            //If the pages and page number are not the same then show the next button
                            if($page_number != $page_count)
                            {
                                ?>
                            <li class="next">
                                <a href="customer_sales_report.php?page=<?php echo $page_number + 1; ?>"> Next</a>
                            </li>
                                <?php
                            }
                            ?>
                            
                        </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </section>
  
  <br><br>
  
  <div class="row">
      <div class="col-md-12">
          <div class="col-md-8">
              
              
          </div>
          <div class="col-md-4">
              <!--opens popup window to show details-->
              <?php
              if(isset($show_print))
              {
                  ?>
              <?php
              $url = "print_customer_report.php?code=" . $client . "&start_date=" . $s_date . "&end_date=" . $e_date;
              ?>
              
              <a href="#" class="btn btn-success " onclick="window.open('<?php echo $url; ?>', '', 'width=800,height=400')">
                  <i class="fa fa-print"></i>
                  Print
              </a>
              
              
              <a href="#" class="btn btn-success">
                  <i class="fa fa-close"></i>
                  Close
              </a>
                  <?php
              }
              ?>
          </div>
      </div>
  </div>
</div>

<?php
require_once './includes/bottom.php';
?>
