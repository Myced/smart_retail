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
    $product  = filter($_POST['product']);
    
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
        <div class="col-md-4">
            Product Code: <strong> <?php echo $product; ?> </strong>
        </div>
        
        <div class="col-md-4">
            Product name: <strong> 
                <?php 
                $query = "SELECT `product_name` FROM `products` WHERE `product_code` = '$product'";
                $rs = mysqli_query($dbc, $query);
                
                list($pname) = mysqli_fetch_array($rs);
                
                echo $pname;
                ?> 
            </strong>
        </div>
        
        <div class="col-md-4">
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
          <form action="inventory_movement.php" method="POST">
            <div class="col-md-4">
                <div class="text-center">
                    <select name="product" class="select2 " required="true" style="width: 100%;">
                        <option value="--">
                             -- SELECT PRODUCT --
                        </option>
                        
                        <?php
                        $query = "SELECT * FROM `products`";
                        $result = mysqli_query($dbc, $query)
                                or die("Error. Could not get products");
                        while($row = mysqli_fetch_array($result))
                        {
                            //echo them out.
                            ?>
                        <option value="<?php echo $row['product_code']; ?>">
                            <?php echo $row['product_name']; ?>
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
                                    Month
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
                                        Please select a product and a year
                                    </strong>
                                </td>
                            </tr>
                                <?php
                            }
                            else
                            {
                                if(isset($show_results))
                                {
                                    //then do your query here
                                    for($i = 1; $i <= 12; $i++)
                                    {
                                        //append a zero at the front if the digit is one
                                        if(strlen($i) == 1)
                                        {
                                            $num = '0' . $i;
                                        }
                                        else
                                        {
                                            $num = $i;
                                        }
                                        ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                
                                <td>
                                    <?php echo get_month($i); ?>
                                </td>
                                
                                <td>
                                    <?php
                                        //call the function that will return the starting quantity
                                    echo get_start_qty($num, $year, $product); 
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    //call the function that will return the ending quantity
                                    echo get_end_qty($num, $year, $product);
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
          <div class="col-md-8">
              
              
          </div>
          <div class="col-md-4">
              <?php
              if(isset($show_search))
              {
                  $url = "print_purchase_period.php?start_date=" . $s_date . "&end_date=" . $e_date;
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
              <a href="#" class="btn btn-success" id="all">
                    <i class="fa fa-print"></i>
                    Print
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
