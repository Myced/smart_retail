<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

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

//do the query here
$query = "SELECT * FROM `sales` "
        . " WHERE `day` = '$day' AND `month` = '$month' AND `year` = '$year'"
        . "ORDER BY `id` ASC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");

/**
 * set up page active links
 */
$sidebar = "sell";
$sublink = "sales_today";


/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<br>
<div class="row">
    
    <?php
    require_once './letter_head.php';
    ?>

    <div class="row">
          <!--search bar-->
          <div class="col-md-12">
              <div class="text-center">
                  <h2>Sales Report for Today </h2>
                  
                  <?php echo date("l - d/m/Y"); ?> 
              </div>
          </div>
      </div>
      
      <br>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <div id="table_area">
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
                                <a href="general_sales_report.php?page=<?php echo $page_number - 1; ?>">Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php 
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="general_sales_report.php?page=<?php echo $i; ?>" >
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
                                <a href="general_sales_report.php?page=<?php echo $page_number + 1; ?>"> Next</a>
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
              <a href="#" class="btn btn-success"
                 onclick="window.open('print_today_sales.php?', '', 'width=800,height=400')"
                 >
                  <i class="fa fa-print"></i>
                  Print
              </a>
              
              
              <a href="#" class="btn btn-success">
                  <i class="fa fa-close"></i>
                  Close
              </a>
          </div>
      </div>
  </div>
</div>

<?php
require_once './includes/bottom.php';
?>
