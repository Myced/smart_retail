<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

/////////////////

//collection and saving of data
if(isset($_POST['submit']))
{
    //start grabint things
    $pcode  = filter($_POST['pcode']);
    
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
    
    //if an error is not set. then insert everthing into the database
    if(!isset($error))
    {
        //insert your data
        $query = "UPDATE `products` SET "
                . " `date` = '$date', `barcode` = '$barcode', `product_code` = '$product_code', "
                . " `product_name` = '$product_name', `quantity` = '$quantity', "
                . " `measure_unit` = '$unit', `category` = '$category', `cost` = '$cost', "
                . " `unit_price` = '$unit_price', `reorder_level` = '$reorder_level', "
                . " `suplier` = '$suplier', `location` = '$sup_location', "
                . " `contact` = '$sup_contact', `product_status` = '$product_status', "
                . " `show_stock_available` = '$show_stock', "
                . " `expiry_date` = '$expiry_date', `valuation_method` = '$valuation' "
                . "  "
                . " WHERE `product_code` =  '$pcode'";
                
        
        $result = mysqli_query($dbc, $query)
                or die("Error1");
        
        $success = "Item has been updated successfully";
    }
            
}

//grab the code of the product and show it 
if(isset($_GET['item']))
{
    //ge the product code
    $pcode = filter($_GET['item']);
    
    //now get all the items using this id.
    $query = "SELECT * FROM `products` WHERE `product_code` = '$pcode'";
    $result = mysqli_query($dbc, $query)
            or die("Could not query the db" . mysqli_error($dbc));
}

else
{
    header("Location: product_list.php");
}


//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';

while($row = mysqli_fetch_array($result))
{
?>


<form class="form-horizontal" action="" method="POST">

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
                               required="true" readonly="true" value="<?php echo $row['ref']; ?>">
                    </div>
                </div>
                
                <div class="col-md-4 col-md-offset-1">
                    <div class="form-group">
                        <label for="name" >Date</label>
                        <input type="text" class="form-control datepicker" name="date" readonly="true"
                               value="<?php echo $row['date']; ?>">
                    </div>
                </div>  
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-9 col-md-offset-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Product Code</label>
                        <input type="text" class="form-control" name="product_code" required="true" readonly="true"
                               readonly="true" value="<?php echo $row['product_code']; ?>">
                        <input type="hidden" name="pcode" value="<?php echo $row['product_code']; ?>">
                    </div>

                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class="form-group">
                        <label for="name" >Barcode</label>
                        <input type="text" class="form-control"  name="barcode"
                               value="<?php echo $row['barcode']; ?>" >
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
                           required="true" value="<?php echo $row['product_name']; ?>">
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
                        <td>
                            <input type="text"  class="form-control" name="quantity"
                                   value="<?php echo $row['quantity']; ?>" >
                        </td>
                        <td>
                            <!--<input type="text" value="" class="form-control" name="unit">-->
                            <select name="unit" class="form-control">
                                <option value="--"> -- SELECT --</option>
                                <?php
                                    $db = new dbc();
                                    $dbc = $db->connect();

                                    $q = "SELECT * FROM `units` WHERE `status` != '0'";
                                    $result = mysqli_query($dbc, $q);

                                    while($ro = mysqli_fetch_array($result))
                                    {
                                        ?>
                                <option value="<?php echo $ro['unit']; ?>"
                                        <?php ($row['measure_unit'] == $ro['unit']) ? print("selected") : ""; ?>
                                        >
                                    <?php echo $ro['unit']; ?>
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

                                    while($ro = mysqli_fetch_array($result))
                                    {
                                        ?>
                                <option value="<?php echo $ro['category']; ?>"
                                        <?php ($row['category'] == $ro['category']) ? print("selected") : ""; ?>
                                        >
                                    <?php echo $ro['category']; ?>
                                </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text"  class="form-control" name="reorder"
                                   value="<?php echo $row['reorder_level']; ?>" >
                        </td>
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
                        <td>
                            <input type="text"  class="form-control" name="cost"
                                   value="<?php echo $row['cost']; ?>" >
                        </td>
                        <td>
                            <input type="text" class="form-control" name="unit_price"
                                   value="<?php echo $row['unit_price']; ?>" >
                        </td>
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
                    <input type="text" class="form-control"  name="suplier" placeholder="Please enter a supplier"
                           value="<?php echo $row['suplier']; ?>" >
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
                    <input type="text" class="form-control" name="location"
                           value="<?php echo $row['location']; ?>" >
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-inline">
                <div class="form-group">
                    <label for="name">Contact</label>
                    <input type="text" class="form-control" name="contact"
                           value="<?php echo $row['contact']; ?>" >
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
                    <input type="text" class="form-control datepicker" name="expiry_date"
                           value="<?php echo $row['expiry_date']; ?>" >
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

            <a class="btn btn-success" style="margin-right: 10px;" href="">Cancel</a>

            <a class="btn btn-success" style="margin-right: 10px; margin-bottom: 20px;" href="home.php">
                Close
            </a>
        </div>
    </div>
</div>

</form>


<?php
}
require_once './includes/bottom.php';
?>