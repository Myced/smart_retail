<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

/////////////////

// FUNCTION TO GETNERATE A UNIQUE ID
function gen_return_ref()
{
    global $dbc;
    
    $query = "SELECT `id` FROM `products` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    $constant = 'ITM';
    
    if(mysqli_num_rows($result)== 0)
    {
        $value = '00001';
    }
    else
    {
        //grab the value of the id
        list($last_idd) = mysqli_fetch_array($result);
        
        $last_id = (int) $last_idd;
        
        $last_id++;
        
        if($last_id < 10)
        {
            $value = '0000' . $last_id;
        }
        elseif($last_id < 100)
        {
            $value = '000' . $last_id;
        }
        elseif($last_id < 1000)
        {
            $value = '00' . $last_id;
        }
        elseif($last_id < 10000)
        {
            $value = '0' . $last_id;
        }
        else
        {
            $value = $last_id;
        }
    }
    
    return $constant . $value;
}

function gen_product_ref()
{
    global $dbc;
    
    $query = "SELECT `id` FROM `products` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    $constant = 'REF';
    
    if(mysqli_num_rows($result)== 0)
    {
        $value = '00001';
    }
    else
    {
        //grab the value of the id
        list($last_idd) = mysqli_fetch_array($result);
        
        $last_id = (int) $last_idd;
        
        $last_id++;
        
        if($last_id < 10)
        {
            $value = '0000' . $last_id;
        }
        elseif($last_id < 100)
        {
            $value = '000' . $last_id;
        }
        elseif($last_id < 1000)
        {
            $value = '00' . $last_id;
        }
        elseif($last_id < 10000)
        {
            $value = '0' . $last_id;
        }
        else
        {
            $value = $last_id;
        }
    }
    
    return $constant . $value;
}

//collection and saving of data
if(isset($_POST['submit']))
{
    //start grabint things
    $ref = filter($_POST['ref']);
    $product_code = filter($_POST['product_code']);
    $date = filter($_POST['date']);
    
    $barcode = filter($_POST['barcode']);
    
    $product_name = filter($_POST['product_name']);
    
    $quantity = filter($_POST['quantity']);
    $unit =  filter($_POST['unit']);
    $category = filter($_POST['category']);
    
    $cost = filter(get_money($_POST['cost']));
    $unit_price = filter(get_money($_POST['unit_price']));
    
    //suplier information
    $suplier = filter($_POST['suplier']);
    $sup_location = filter($_POST['location']);
    $sup_contact = filter($_POST['contact']);
    
    $product_status = filter($_POST['product_status']);
    $reorder_level = filter($_POST['reorder']);
    
    if(isset($_POST['show_stock']))
    {
        $show_stock = filter($_POST['show_stock']);
    }
    else
    {
        $show_stock = FALSE;
    }
    
    $expiry_date = filter($_POST['expiry_date']);
    
    $valuation = filter($_POST['valuation']);
    
    if(empty($product_name))
    {
        $error = "Sorry. You must Provide a product name";
    }
    
    if(empty($product_code))
    {
        $error = "Please a product code is needed";
    }
    
    if(!isset($quantity))
    {
        $error = "Sorry. We need an initial Quantity";
    }
    
    //chceck that the product code is not already used
    $query = "SELECT * FROM `products` WHERE `ref` = '$ref'";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "Sorry. This Ref is already used. Please take another one.";
    }
    
    $query = "SELECT * FROM `products` WHERE `product_code` = '$product_code'";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "Sorry. This Product Code is already used. Please use  another one.";
    }
    
    $query = "SELECT * FROM `products` WHERE `product_name` = '$product_name'";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "Sorry. This Product name is already used. Please use  another one in other "
                . " to avoid confusion.";
    }
    
    
    //if an error is not set. then insert everthing into the database
    if(!isset($error))
    {
        //insert your data
        $query = "INSERT INTO `products` "
                . " (`id`, `ref`, `date`, `barcode`, `product_code`, `product_name`, "
                . " `quantity`, `measure_unit`, `category`, `cost`, `unit_price`, `reorder_level`, "
                . " `suplier`, `location`, `contact`, `product_status`, `show_stock_available`, "
                . " `expiry_date`, `valuation_method`, `day`, `month`, `year`, `time_added`, "
                . " `time_updated`, `user_id`)"
                . ""
                . " VALUES( "
                . " 0, '$ref', '$date', '$barcode', '$product_code', '$product_name', "
                . " '$quantity', '$unit', '$category', '$cost', '$unit_price', '$reorder_level', "
                . " '$suplier', '$sup_location', '$sup_contact', '$product_status', "
                . " '$show_stock', '$expiry_date', '$valuation', '$day', '$month',"
                . " '$year', NOW(), NOW(), '$user_id')";
        
        $result = mysqli_query($dbc, $query)
                or die("Error");
        
        $success = "Item Added to Inventory";
    }
            
}

/**
 * set up page active links
 */
$sidebar = "inventory";
$sublink = "new_product";

$item_id = gen_return_ref();

$new_ref = gen_product_ref();
/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<form class="form-horizontal" action="new_product.php" method="POST">

    <div class="row">
        <h3 class="page-header">Enter New Product</h3>
    </div>

    <?php
    require_once './includes/notifications.php';
    ?>
        <div class="row">
            <div class="col-md-9 col-md-offset-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Ref</label>
                        <input type="text" class="form-control" name="ref"
                               required="true" readonly="true" value="<?php echo $new_ref; ?>">
                    </div>
                </div>
                
                <div class="col-md-4 col-md-offset-1">
                    <div class="form-group">
                        <label for="name" >Date</label>
                        <input type="text" class="form-control datepicker" name="date"
                               value="<?php echo date("d/m/Y"); ?>">
                    </div>
                </div>  
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-9 col-md-offset-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Product Code</label>
                        <input type="text" class="form-control" name="product_code" required="true"
                               readonly="true" value="<?php echo $item_id; ?>">
                    </div>

                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class="form-group">
                        <label for="name" >Barcode</label>
                        <input type="text" class="form-control"  name="barcode">
                    </div>
                </div>  
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" >
                    <label for="name" class="col-md-2">Product Name: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="product_name"
                           required="true">
                    </div>
                </div>
            </div> 
        </div>


    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                
            </div>
            
            <div class="col-md-8">
                <table style="width: 102%; ">
                    <tr>
                        <th style="text-align: center; ">Qty</th>
                        <th style="text-align: center; ">Unit</th>
                        <th style="text-align: center; ">Category</th>
                        <th style="text-align: center; ">Reorder Level</th>
                    </tr>

                    <tr>
                        <td><input type="text" value="" class="form-control" name="quantity"></td>
                        <td>
                            <!--<input type="text" value="" class="form-control" name="unit">-->
                            <select name="unit" class="form-control">
                                <option value="--"> -- SELECT --</option>
                                <?php
                                    $db = new dbc();
                                    $dbc = $db->connect();

                                    $q = "SELECT * FROM `units` WHERE `status` != '0'";
                                    $result = mysqli_query($dbc, $q);

                                    while($row = mysqli_fetch_array($result))
                                    {
                                        ?>
                                <option value="<?php echo $row['unit']; ?>">
                                    <?php echo $row['unit']; ?>
                                </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <!--<input type="text" value="" class="form-control" name="category">-->
                            <select name="category" class="form-control">
                                <option value="--"> -- SELECT --</option>
                                <?php
                                    $db = new dbc();
                                    $dbc = $db->connect();

                                    $q = "SELECT * FROM `categories` WHERE `status` != '0'";
                                    $result = mysqli_query($dbc, $q);

                                    while($row = mysqli_fetch_array($result))
                                    {
                                        ?>
                                <option value="<?php echo $row['category']; ?>">
                                    <?php echo $row['category']; ?>
                                </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" value="" class="form-control" name="reorder"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <table style="width: 100%; margin: auto; margin-top: 20px;">
                    <tr>
                        <th style="text-align: center; width: 50%;">Cost</th>
                        <th style="text-align: center; width: 50%;">Unit Price</th>
                    </tr>

                    <tr>
                        <td><input type="text" value="" class="form-control" name="cost"></td>
                        <td><input type="text" value="" class="form-control" name="unit_price"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="col-md-2">Supplier</label>
                <div class="col-md-8">
                    <input type="text" class="form-control"  name="suplier" placeholder="Please enter a supplier">
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-2">
            
        </div>
        <div class="col-md-3">
            <div class="form-inline">
                <div class="form-group">
                    <label for="name">Location</label>
                    <input type="text" class="form-control" name="location">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-inline">
                <div class="form-group">
                    <label for="name">Contact</label>
                    <input type="text" class="form-control" name="contact">
                </div>
            </div>
        </div>
    </div>
    
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <h3 class="col-md-8 col-md-offset-2">
                    <strong>
                        Product Status
                    </strong>
                </h3>
            </div>
            
            <div class="col-md-2">
                
            </div>
            
                <div class="col-md-4">
                    
                    <div class="">
                        <div class="col-md-4">
                            <div class="radio">
                                
                                <label>
                                    <input type="radio" name="product_status" value="1" checked="true">
                                    Active
                                </label>
                                
                            </div>
                            <div class="radio">
                                
                                <label>
                                    <input type="radio" name="product_status" value="0">
                                    Not Active
                                </label>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-inline">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="checkbox">
                                        
                                        <label>
                                            <input type="checkbox" name="show_stock" value="1" checked="true">
                                            Show Stock Available
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
    </div>

    <br><br>
    <div class="row">
        <div class="col-md-2">
            
        </div>
        
        <div class="col-md-4" >
            <div class="form-inline">
                <div class="form-group">
                    <label for="name">Expiry date</label>
                    <input type="text" class="form-control datepicker" name="expiry_date">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-horizontal">
                <div class="col-md-6">
                    <h3><strong> Valuation Method </strong></h3>
                    <div class="checkbox">

                        <label class="control-label">
                            <input type="radio" name="valuation" value="FIFO" checked>
                            FIFO
                        </label>
                    </div>

                    <div class="checkbox">

                        <label class="control-label">
                            <input type="radio" name="valuation" value="LIFO">
                            LIFO
                        </label>
                    </div>

                    <div class="checkbox">

                        <label class="control-label">
                            <input type="radio" name="valuation" value="WAP">
                            WAP
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>
<div class="container">
    <div class="btn-group col-md-4 col-md-offset-5" style="">
        <div class="btn-group">
            <input type="submit" class="btn btn-success" style="margin-right: 10px;" name="submit" value="Save">

            <a class="btn btn-success" style="margin-right: 10px;" href="new_product.php">Cancel</a>

            <button class="btn btn-success" style="margin-right: 10px; margin-bottom: 20px;">Close</button>
        </div>
    </div>
</div>

</form>


<?php
require_once './includes/bottom.php';
?>