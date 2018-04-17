<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/movement_functions.php';

$db = new dbc();
$dbc = $db->connect();

//do page transactions here
//query initialisation

if(isset($_POST['filter']))
{
    //grab the product code and the year.
    // the display the table.
    
    $year = filter($_POST['year']);
    $month  = filter($_POST['month']);
    
    if(empty($month) || $month == '--')
    {
        //show anm error message
        $error = "Sorry. You must select a Month";
    }
    
    if(empty($year) || $year == '--')
    {
        $error = "Sorry You must select the year";
    }
    
    if(!isset($error))
    {
        //htne show the result.
        $show_results = TRUE;
    }
}




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
                  <h2> <strong> INVENTORY MOVEMENT </strong> </h2>
                  
                  From <strong>January <?php echo date("- Y"); ?> </strong> 
                  
                  To  
                  
                  <strong> December <?php echo date("- Y"); ?> </strong>
                    
              </div>
          </div>
    </div>
    
    <?php
    if(isset($_POST['filter']) && !isset($error))
    {
        ?>
    <br>
    <div class="row text-center">
        
        <div class="col-md-6">
            Month: <strong> <?php echo get_month($month); ?> </strong>
        </div>
        
        <div class="col-md-6">
            Year: <strong> <?php echo $year; ?> </strong>
        </div>
    </div>
    <br>
        <?php
    }
    ?>
    
    <br>
    <div class="row">
          <!--search bar-->
          <form action="group_movement.php" method="POST">
            <div class="col-md-4">
                <div class="text-center">
                    <select name="month" class="form-control" required="true">
                        <option value="--">
                             -- SELECT MONTH --
                        </option>
                        
                        <?php
                        for($i = 1; $i <= 12; $i++)
                        {
                            //echo them out.
                            ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo get_month($i); ?>
                        </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <select name="year" class="form-control" required="true" >
                    <option value="--">
                         -- SELECT YEAR --
                    </option>

                    <?php
                    $query = "SELECT * FROM `sales` GROUP BY `year`";
                    $result = mysqli_query($dbc, $query)
                            or die("Error. Could not get products");
                    while($row = mysqli_fetch_array($result))
                    {
                        //echo them out.
                        ?>
                    <option value="<?php echo $row['year']; ?>">
                        <?php echo $row['year']; ?>
                    </option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <input type="submit" class="btn btn-block btn-success" value="Filter" name="filter">
            </div>

            <div class="col-md-2">
                
            </div>
          </form>
      </div>
      
      <br>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <div id="table_area">
                        <table class="table table-striped table-bordered text-center white-background">
                            <tr>
                                <th>
                                    N<sup>o</sup>
                                </th>
                                <th>
                                    Product Code
                                </th>
                                <th>
                                    Product Name
                                </th>
                                <th>
                                    Opening Qty
                                </th>
                                
                                <th>
                                    Closing Qty
                                </th>
                                
                                <th>
                                    Action
                                </th>
                            </tr>
                            
                            <?php
                            if(!isset($_POST['filter']))
                            {
                                ?>
                            <tr>
                                <td colspan="7">
                                    <strong class="text-primary">
                                        Please select a month and year
                                    </strong>
                                </td>
                            </tr>
                                <?php
                            }
                            else
                            {
                                if(isset($show_results))
                                {
                                    
                                    //append a zero at the front if the digit is one
                                    $i = $month;
                                    if(strlen($i) == 1)
                                    {
                                        $num = '0' . $i;
                                    }
                                    else
                                    {
                                        $num = $i;
                                    }
                                    
                                    //counting variable
                                    $count = 1;
                                    
                                    //get all the products here and see their opening and coling 
                                    // balances
                                    $query = "SELECT * FROM `products`";
                                    $result = mysqli_query($dbc, $query)
                                            or die("Cannot continue");
                                    while($row = mysqli_fetch_array($result))
                                    {
                                           $quantity = $row['quantity']; 
                                        ?>
                            <tr>
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                
                                <td>
                                    <?php echo $product = $row['product_code']; ?>
                                </td>
                                
                                <td>
                                    <?php echo $row['product_name']; ?>
                                </td>
                                
                                <td>
                                    <?php
                                        //call the function that will return the starting quantity
                                    $start = get_start_qty($num, $year, $product); 
                                    if($start == 0)
                                    {
                                        echo $quantity;
                                    }
                                    else
                                    {
                                        echo $start;
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    //call the function that will return the ending quantity
                                    $end = get_end_qty($num, $year, $product);
                                    if($end == 0)
                                    {
                                        echo $quantity;
                                    }
                                    else
                                    {
                                        echo $end;
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <a href="movement.php?product=<?php echo $product; ?>&year=<?php 
                                                echo $year; ?>&month=<?php echo $i; ?>"
                                                class="btn btn-success">
                                        
                                        More Details
                                    </a>
                                </td>
                            </tr>
                                        <?php
                                    } //end the loop for looping through products
                                }
                            }
                            ?>
                        </table>
                  </div>
              </div>
              
              
              
          </div>
      </div>
  
  <br><br>
  
  <div class="row">
      <div class="col-md-12">
          <div class="col-md-8">
              
              
          </div>
          <div class="col-md-4">
              <?php
              if(isset($month))
              {
                  $url = "print_group_movement.php?month=" . $month . "&year=" . $year;
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
              <a href="#" class="btn btn-success" >
                    <i class="fa fa-print"></i>
                    Select Period
                </a>
                  <?php
              }
              ?>
              
              
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

