<?php

require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

//database connection
$db = new dbc();
$dbc = $db->connect();

$sale;

//function to get product quantity
require_once './get_product_quantity.php';

// FUNCTIO TO GETNERATE A UNIQUE ID
function gen_sales_ref()
{
    global $dbc;

    $query = "SELECT `id` FROM `sales_ref` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Error");

    $constant = '';

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


//now data manipulation
if(isset($_POST['submit']))
{
    //grab all the data
    $ref = filter($_POST['ref']);
    $date = filter($_POST['date']);

    $agent = filter($_POST['agent']);
    $stock = filter($_POST['stock']);


    $tax = filter($_POST['tax']);
    $discount = filter($_POST['discount']);

    //now the data from the products sold
    $product_code[] = $_POST['product_code'];
    $product_name[] = $_POST['product_name'];
    $quantity[] = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $total[] = $_POST['total'];

    //check if all the items were not entered.
    $number = count($product_name[0]);
    $items = 0;
    for($i = 0; $i < $number; $i++)
    {
        $index = $product_name[0][$i];

        if(!empty($index))
        {
            $items++;
        }
    }

    if($items == 0)
    {
        $warning = "Sale Was not made. You did not enter any items";
    }

    else
    {
        $final_total = 0;
        $item_sold = 0;
        for($i = 0; $i < $number; $i++)
        {
            $index = $product_name[0][$i];

            if(!empty($index))
            {
                $item_sold++;


                //grab all the values.
                $mtotal = get_money(filter($total[0][$i]));
                $mcode  = filter($product_code[0][$i]);
                $mname = filter($product_name[0][$i]);
                $mquantity = filter($quantity[0][$i]);
                $mprice = filter($unit_price[$i]);

                $final_total = ($mtotal) + $final_total;

                //insert into the database;
                $query  = "INSERT INTO `sales` ("
                        . " `id`, `ref`, `date`, `product_code`, `product_name`, "
                        . " `quantity`, `unit_price`, `total`, "
                        . " `day`, `month`, `year`, `time_added`, `user_id`)"
                        . ""
                        . " VALUE( "
                        . " 0, '$ref', '$date', '$mcode', '$mname', '$mquantity', "
                        . " '$mprice', '$mtotal', '$day', "
                        . " '$month', '$year', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error");


                //get the product quantity;
                $qq = get_quantity($mcode); //current quantity in the database;

                //final quantity
                $fquantity = (int)$qq - (int)$mquantity;

                //move inventory here
                $comment = "Sales to " . $agent . " <br> With Receipt No " . $ref;

                //now move the inventory
                move_inventory($mcode, $qq, $fquantity, $comment);

                //now reduce the product quantity
                $query = "UPDATE `products` SET "
                        . " `quantity` = '$fquantity'"
                        . " WHERE `product_code` = '$mcode'";
                $result = mysqli_query($dbc, $query)
                        or die("Error");



            }
        }
        //now insert into sales referece table
        $query = "INSERT INTO `sales_ref` ("
                . " `id`, `ref`, `sales_agent`, `date`, `tax`, `discount`, "
                . " `total_price`, `items_sold`, `final_total`, `day`, "
                . " `month`, `year`, `time_added`, `user_id`)"
                . " "
                . " VALUES("
                . " 0, '$ref', '$agent', '$date', '$tax', '$discount', "
                . " '$final_total', '$item_sold', '0', '$day', "
                . " '$month', '$year', NOW(), '$user_id')";
        $result = mysqli_query($dbc, $query)
                or die("Error");

        $sale = $ref;

        $success = "Products Sold. ";
        $print_receipt = TRUE;
    }



}

$sales_ref = gen_sales_ref();

/**
 * set up page active links
 */
$sidebar = "sell";
$sublink = "sell_products";


/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<form action="sell_products.php" method="POST">
<div class="row">
    <div class="row">
        <div>
            <h1 class="page-header">Sell Products</h1>
        </div>
    </div>

    <?php
    require_once './includes/notifications.php';

    if(isset($print_receipt) && $print_receipt == TRUE)
    {
        ?>
    <div class="row text-center">
        <button class="btn btn-success"
                onclick="window.open('receipt.php?ref=<?php echo $sale; ?>', '', 'width=800,height=400')">
            <i class="fa fa-print"></i>
            Print Receipt
        </button>

    </div>
    <br>
        <?PHP
    }
    ?>


    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <table>
                <tr style='height:60px;'><td  style='width: 50px; margin-right: 50px;'>
                        <label for="exampleInputEmail1" style='font-weight:normal; margin-right: 50px;'>Ref </label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name='ref' style='width:180px; margin-right: 50px;'
                               required="" value="<?php echo $sales_ref; ?>" readonly="true"></td>
                    <td>
                        <label for="exampleInputEmail1" style='font-weight:normal; margin-left: 50px;'>Date</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name='date' style='width:180px; margin-left: 50px;'
                               value="<?php echo date("d/m/Y"); ?>">
                    </td>

                </tr>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6" style="margin-top: 10px;">
            <label class="col-md-4 text-right">
                Client Name:
            </label>
            <div class="col-md-8">
                <input type="text" name="agent" class="form-control"
                       style="border-bottom: 3px solid black;
                               border-top: transparent;
                               border-right: transparent;
                               border-left: transparent;
                               background-color: transparent;
                               font-size: 1em;
                               color: black;
                               font-weight: bold;
                               padding-bottom: 2px;
                               " placeholder="Enter Name" required="true" id="client" autocomplete="off">
            </div>
        </div>


        <div class="col-md-6">

            <label class="col-md-6 text-right">
                Available stock
            </label>
            <div class="col-md-6">
                <input type="text" name="stock" class="form-control" id="stock"
                       placeholder="">
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div >
                <table id="tb">
                    <tr>
                        <th style="text-align: center;">Product Code</th>
                        <th style="text-align: center;">Product Name</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: center;">Unit Price</th>
                        <th style="text-align: center;">Total</th>
                        <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More row">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </th>
                    </tr>

                   <?php
                   for($i = 1; $i < 6; $i++)
                   {
                       ?>
                    <tr>
                        <td><input type="text" name="product_code[]" class="form-control product_code" readonly="true"></td>
                        <td><input type="text" name="product_name[]" class="form-control product_name" autocomplete="off" ></td>
                        <td><input type="text" name="quantity[]" class="form-control quantity" autocomplete="off" ></td>
                        <td><input type="text" name="unit_price[]" class="form-control unit_price" readonly="true"></td>
                        <td><input type="text" name="total[]" class="form-control total" readonly="true"></td>
                        <td style="background-color: white; border-bottom:  2px solid #ccc;">
                            <a href='javascript:void(0);'  class='remove'>
                                <span class='glyphicon glyphicon-remove'></span>
                            </a>
                        </td>
                    </tr>
                        <?php
                   }
                   ?>

                </table>
            </div>
        </div>

   </div>
 </div>

<div class="row">
    <div class="">
        <div class="col-md-4 col-md-offset-1">
            <table>
                <tr>
                    <th style="text-align: center;">Sales Tax</th>
                    <td><input type="text" name="tax" class="form-control"></td>

                </tr>
                <tr>
                    <th style="text-align: center;">Discount</th>
                    <td><input type="text" name="discount" class="form-control"></td>

                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table>
                <tr>
                    <th style="text-align: center;">TOTAL</th>
                    <td>
                        <input type="text" style="margin-top: 10px;
                                    padding: 5px 10px; font-weight: bold; font-size: 1.5em;
                                    " name="final_total"  class="form-control"
                               id="final_total">
                    </td>

                </tr>

            </table>
        </div>
    </div>
    <br>
    <br>


    <div class="row">
        <div class="col-md-12">
            <div class="btn-group col-md-4" style="float: right;">
                <div class="btn-group">
                    <input  class="btn btn-success" style="margin-right: 10px;" type="submit" value="Sell" name="submit">

                    <a class="btn btn-success" style="margin-right: 10px;" href="sell_products.php">Cancel</a>

                    <a class="btn btn-success" style="margin-right: 10px;" href="index.php">Close</a>
                </div>
            </div>
        </div>
    </div>

</div>
</form>

<?php
if(isset($print_receipt) && $print_receipt == TRUE)
{
    ?>
<script>
    window.open('receipt.php?ref=<?php echo $sale; ?>', '', 'width=800,height=400')
</script>
    <?PHP
}
?>
<script>
    $(function () {
        $('#addMore').on('click', function () {
            var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
            data.find("input").val('');
        });
        $(document).on('click', '.remove', function () {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });

    $(document).ready(function(){
        $(".product_name").typeahead({
            source: function(key, result){
                $.ajax({
                    url: "get_product_names.php",
                    method: "POST",
                    data: {key:key},
                    dataType: "json",
                    success: function(data){
                        result($.map(data, function(item){
                            return item;
                        }));
                    }
                });
            }
        });

        $("#client").typeahead({
            source: function(key, result){
                $.ajax({
                    url: "get_customer_names.php",
                    method: "POST",
                    data: {key:key},
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                        result($.map(data, function(item){
                            return item;
                        }));
                    }
                });
            }
        });

        $(".product_name").focusout(function(){

            $product_exist = true;

            var product_name = $(this).val();
            var index = $(this).closest("tr").index();
            var $row = $("#tb tr:eq(" + index + ")");
            //now grab the index of that row.

            if(product_name != '')
            {
                $.ajax({
                   url: "get_product_code.php",
                   method: "POST",
                   data: {key: product_name},
                   dataType : "text",
                   success: function(data){
                       if(data == '')
                       {
                           //then the product does not exist.
                           $product_exist = false;
                           $row.find("input[name='product_name[]']").val('');
                       }
                       else
                       {
                            $row.find("input[name='product_code[]']").val(data);
                       }
                   }
               });

               if($product_exist == true)
               {
                    //get the unit price
                    $.ajax({
                        url: "get_unit_price.php",
                        method: "POST",
                        data: {key: product_name},
                        dataType : "text",
                        success: function(data){
                            $row.find("input[name='unit_price[]']").val(data);
                        }
                    });

                    //get the Available stock
                    $.ajax({
                        url: "get_quantity.php",
                        method: "POST",
                        data: {key: product_name},
                        dataType : "text",
                        success: function(data){
                            $("#stock").val(data);
                        }
                    });

               }
           }//end of if the product name is empty.
            }); //end of focus out for the product name


        $(".quantity").focusout(function(){
            var quantity = $(this).val();
            var left = $("#stock").val();

            var index = $(this).closest("tr").index();
            var $row = $("#tb tr:eq(" + index + ")");

            //if the quantity enter is greater than availabel. then alert
            if(+quantity > +left)
            {
                alert("The quantity Entered is greater than the stock available");
                $(this).val('');
                $(this).attr('autofocus', 'true');
            }
            else {
                //get the unit price
                var unit_price = $row.find("input[name='unit_price[]']").val();
                var total  = unit_price * quantity;
                $row.find("input[name='total[]']").val(total);

                update_final_total();
            }

        });

        function update_final_total()
        {
            var total = 0;

            $(".total").each(function(){
                var value = $(this).val();

                if(value != '')
                {
                    var int_value = parseInt(value);

                    total = total + int_value;
                }



            });

            var final = total + " FCFA";
            $("#final_total").val(final);
        }
    });
</script>
<?php
require_once './includes/bottom.php';
?>
