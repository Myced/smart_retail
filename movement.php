<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/movement_functions.php';

$db = new dbc();
$dbc = $db->connect();

//do page transactions here
//query initialisation

if(isset($_GET['product']))
{
    //grab the product code and the year.
    // the display the table.
    
    $year = filter($_GET['year']);
    $product  = filter($_GET['product']);
    $mont = filter($_GET['month']);
    
    if(strlen($mont) == 1)
    {
        $month = '0' . $mont;
    }
    else
    {
        $month = $mont;
    }
    
    if(empty($product) || $product == '--')
    {
        //show anm error message
        $error = "Sorry. You must select a product";
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
                  <h2> <strong> INVENTORY MOVEMENT DETAIL</strong> </h2>
                    
              </div>
          </div>
    </div>
    
    <br>
    <div class="row text-center">
        <div class="col-md-3">
            Product Code: <strong> <?php echo $product; ?> </strong>
        </div>
        
        <div class="col-md-3">
            Product name: <strong> 
                <?php 
                $query = "SELECT `product_name` FROM `products` WHERE `product_code` = '$product'";
                $rs = mysqli_query($dbc, $query);
                
                list($pname) = mysqli_fetch_array($rs);
                
                echo $pname;
                ?> 
            </strong>
        </div>
        
        <div class="col-md-3">
            Month: <strong> <?php echo get_month($month); ?> </strong>
        </div>
        
        <div class="col-md-3">
            Year: <strong> <?php echo $year; ?> </strong>
        </div>
    </div>
    <br>
    
    <br>
      <br>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <div id="table_area">
                        <table class="table table-striped table-bordered text-center white-background table-hover">
                            <tr>
                                <th>
                                    N<sup>o</sup>
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Time
                                </th>
                                
                                <th class="">
                                    Opening Qty
                                </th>
                                
                                <th>
                                    Closing Qty
                                </th>
                                
                                <th>
                                    Comment
                                </th>
                            </tr>
                            
                            <?php
                            $count = 1; // variable to track counting
                            
                            if(isset($show_results) && $show_results == TRUE)
                            {
                                //WE SHOW THE INVENTORY MOVEMENT FOR THAT PRODUCT
                                $query = "SELECT * FROM `movement`"
                                        . " WHERE "
                                        . "     `product_code` = '$product' AND"
                                        . "     `year` = '$year' AND "
                                        . "     `month` = '$month'";
                                $result = mysqli_query($dbc, $query)
                                        or die("Could not get the details");
                                
                                if(mysqli_num_rows($result) == 0)
                                {
                                    //there fore therer is not inventory moveemnt for this item in theis specified time
                                    ?>
                            <tr>
                                <td colspan="6">
                                    <strong class="text-primary">
                                        No Movement found for this item For this month Specified.
                                    </strong>
                                </td>
                            </tr>
                                    <?php
                                }
                                else
                                {
                                    //now we print out the inventory movement.
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $type = $row['type'];
                                        
                                        ?>
                            <tr>
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                
                                <td>
                                    <?php echo date_from_timestamp($row['time_added']); ?>
                                </td>
                                
                                <td>
                                    <?php echo time_from_timestamp($row['time_added']); ?>
                                </td>
                                
                                <td>
                                    <?php echo $row['initial']; ?>
                                </td>
                                
                                <td class="
                                    <?php
                                    if($type == '0')
                                    {
                                        echo 'text-danger';
                                    }
                                    else
                                    {
                                        echo 'text-success';
                                    }
                                    ?>
                                    ">
                                    <strong>
                                        <?php
                                        if($type == '0')
                                        {
                                            ?>
                                        <i class="fa fa-angle-down"></i>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                        <i class="fa fa-angle-up"></i>
                                            <?php
                                        }
                                        ?>
                                        <?php echo $row['final']; ?> 
                                    </strong>
                                </td>
                                
                                <td>
                                    <?php echo $row['comment']; ?>
                                </td>
                            </tr>
                                        <?php
                                    }
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
          <div class="col-md-5">
              
              
          </div>
          <div class="col-md-7">
              <a href="group_movement.php" class="btn btn-success">
                  <i class="fa fa-backward"></i>
                  Back
              </a>
				<?php 
                  $url = "print_detail_movement.php?month=" . $month . "&year=" . $year . "&product=" . $product;
                    ?>
              <a href="#" class="btn btn-success " onclick="window.open('<?php echo $url; ?>', '', 'width=800,height=400')">
                  <i class="fa fa-print"></i>
                  Print
              </a>
              
              <a href="home.php" class="btn btn-success">
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
