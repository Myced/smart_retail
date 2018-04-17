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

//do the query here
$query = "SELECT * FROM `sales` ORDER BY `id` DESC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");


///check the filter has been check
if(isset($_POST['start_date']))
{
    
    //now collect everythign here
    
    $agent = filter($_POST['agent']);
    
    $start_date = get_date(filter($_POST['start_date']));
    $end_date = get_date(filter($_POST['end_date']));
    
    $s_date = filter($_POST['start_date']);
    $e_date  = filter(filter($_POST['end_date']));
    
    (int)$ed = (int) strtotime($end_date);
    (int) $sd = (int)strtotime($start_date);
    
    if(empty($start_date) || $start_date == '')
    {
        $error = "Start Date cannot be empty";
    }
    
    if(empty($end_date) || $end_date == '')
    {
        $error = "Sorry. Ending date cannot be empty";
    }
    
    if($sd > $ed)
    {
        $error = "Sorry. Starting date is ahead of ending Date. <strong> Please Correct that </strong>";
    }
    
    
    if(!isset($error))
    {
        //then start looking for products
        //do your calculation
        $incremnt = 24*60*60;
        
        $show_search = TRUE;
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
                  <h2>Sales Agent Sales Report </h2>
                  
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
          <form action="sales_agent_report.php" method="POST">
            <div class="col-md-4">
                <div class="text-center">
                    <select name="agent" class="form-control">
                        <option value="--">--SELECT AGENT--</option>
                        <?php
                        $query = "SELECT * FROM `agents`";
                        $res = mysqli_query($dbc, $query);

                        while($row  = mysqli_fetch_array($res))

                        {
                            ?>
                        <option value="<?php echo $row['agent_name']; ?>">
                            <?php echo $row['agent_name']; ?>
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
                        <table class="table table-striped table-bordered text-center white-background table-condensed">
                            <tr>
                                <th> N<sup>o</sup> </th>
                                <th> Date</th>
                                <th> Ref </th>
                                <th> Sales Agent </th>
                                <th> N<sup>o</sup> Items </th>
                                <th> Amount</th>
                                <th> More</th>
                              </tr>

                          <?php

                          //if the filter has been set then show filtered results only.
                          if(isset($show_search))
                          {
                              if(!isset($error) && $agent != '--' )
                              {
                                  $sales = 0;
                                    while ($sd <= $ed) {
                                    //get the data first

                                    $current_date = date("d/m/Y", $sd);

                                    $daay = substr($current_date, 0, 2);
                                    $moonth = substr($current_date, 3, 2);
                                    $yeear = substr($current_date, 6, 4);

                                    //now do a query
                                    $query = "SELECT * FROM `issue_ref` WHERE "
                                            . " `day` = '$daay' AND `month` = '$moonth'"
                                            . " AND `year` = '$yeear' AND `sales_agent` = '$agent'";
                                    $res = mysqli_query($dbc, $query);

                                    $sd += $incremnt;

                                    if(mysqli_num_rows($res) == 0)
                                      {
                                          ?>

                                          <?php
                                      }
                                      else
                                      {
                                          
                                        while ($row = mysqli_fetch_array($res))
                                        {
                                         $sales++;   
                                            ?>
                                          <tr>
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
                                            <?php echo $row['sales_agent']; ?>
                                          </td>
                                          

                                          <td>
                                              <?php echo $row['items_sold']; ?>
                                          </td>

                                          <td>
                                              <?php echo number_format($row['total_price']) . ' FCFA'; ?>
                                          </td>
                                          
                                          <td>
                                              <?php
                                                $url = "print_sales_agent_report.php?agent= " . $agent . "start_date=" . $s_date . "&end_date=" . $e_date;
                                              ?>
                    
                                                <button class="btn btn-success" 
                                                        onclick="window.open('print_issued_stock.php?ref=<?php echo $row['ref']; ?>', '', 'width=800,height=400')">
                                                    <i class="fa fa-print"></i>
                                                    More
                                                </button>
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
                                      <td colspan="8" class="text-center">
                                        <strong class="text-primary">
                                            No Sales History For this agent in the specified period
                                        </strong>
                                      </td>
                                    </tr>
                                    <?php
                                }
                              }
                          }
                          else
                          {
                                ?>
                                <tr>
                                  <td colspan="8" class="text-center">
                                    <strong class="text-primary">
                                        Please Select Sales Agent and Period to see Sales
                                    </strong>
                                  </td>
                                </tr>
                                <?php

                            }//end if the result is zero
                          
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
                                <a href="sales_agent_report.php?page=<?php echo $page_number - 1; ?>">Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php 
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="sales_agent_report.php?page=<?php echo $i; ?>" >
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
                                <a href="sales_agent_report.php?page=<?php echo $page_number + 1; ?>"> Next</a>
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
              <?php
              if(isset($show_search))
              {
                  $url = "print_sales_agent_report.php?agent=" . $agent . "&start_date=" . $s_date . "&end_date=" . $e_date;
                    ?>
              <a href="#" class="btn btn-success " onclick="window.open('<?php echo $url; ?>', '', 'width=800,height=400')">
                  <i class="fa fa-print"></i>
                  Print
              </a>
                <?php
              }
              else
              {
                    ?>
              
                <?php
              }
              ?>
              
              
              <a href="home.php" class="btn btn-success">
                  <i class="fa fa-close"></i>
                  Close
              </a>
          </div>
      </div>
  </div>
</div>
<script>
    $(document).on('click', '#all', function(){
        alert("Please select the sales agent, starting and ending dates");
    });
</script>

<?php
require_once './includes/bottom.php';
?>

