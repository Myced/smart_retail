<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

//do page transactions here
//query initialisation
$results_per_page = 30; //number of results to show on a sigle page

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
$query = "SELECT * from `stock_count_ref`";
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
$query = "SELECT * FROM `stock_count_ref` ORDER BY `id` DESC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");



/**
 * set up page active links
 */
$sidebar = "inventory";
$sublink = "more";


/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<br>
<div class="row">
    
    <br>
    <div class="row">
        <div class="text-center">
            <h3> Stock Count History</h3>
        </div>
    </div>
    <br>
    <div class="row">
          <!--search bar-->
          
          <div class="col-md-1">
              
          </div>
          
          <div class="col-md-6">
              
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
                                <th> Ref</th>
                                <th> Sales Agent</th>
                                <th> Items Updated</th>
                                <th> Time Updated</th>
                                <th> Action </th>

                              </tr>

                          <?php



                          if(mysqli_num_rows($result) == 0)
                          {
                              ?>
                              <tr>
                                <td colspan="7" class="text-center">
                                  <strong class="text-primary">
                                      No Sotck History Yet!
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
                                    <?php echo $row['agent_name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['item_number']; ?>
                                </td>

                                <td>
                                    <?php echo time_from_timestamp($row['time_added']); ?>
                                </td>

                                <td>
                                    <button class="btn btn-success" 
                                            onclick="window.open('print_stock_count.php?ref=<?php echo $row['ref']; ?>', '', 'width=800,height=400')">
                                        <i class="fa fa-print"></i>
                                        Print
                                    </button>
                                </td>

                            </tr>
                                <?php
                            }
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
                                <a href="stock_count_history.php?page=<?php echo $page_number - 1; ?>">Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php 
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="stock_count_history.php?page=<?php echo $i; ?>" >
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
                                <a href="stock_count_history.php?page=<?php echo $page_number + 1; ?>"> Next</a>
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
          
      </div>
  </div>
</div>

<?php
require_once './includes/bottom.php';
?>
