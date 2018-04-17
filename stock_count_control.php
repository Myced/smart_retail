<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

//database connection
$db = new dbc();
$dbc = $db->connect();

//function to get product quantity
require_once './get_product_quantity.php';

// FUNCTIO TO GETNERATE A UNIQUE ID
function gen_stock_count_id()
{
    global $dbc;
    
    $query = "SELECT `id` FROM `stock_count_ref` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    $constant = 'STKCT';
    
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

    //now the data from the products sold
    $product_code[] = $_POST['product_code'];
    $product_name[] = $_POST['product_name'];
    $squantity[] = $_POST['squantity'];
    $mquantity = $_POST['mquantity'];
    $difference[] = $_POST['diff'];
    

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
        $warning = "Stock Update Was not made. You did not enter any items";
    }
    
    else
    {
        $item_sold = 0;
        
        for($i = 0; $i < $number; $i++)
        {
            $index = $product_name[0][$i];

            if(!empty($index))
            {
                $item_sold++;
                
                
                //grab all the values. 
                $mcode  = filter($product_code[0][$i]);
                $mname = filter($product_name[0][$i]);
                $mquant = filter($mquantity[$i]);
                $squant = filter($squantity[0][$i]);
                $mdiff = filter($difference[0][$i]);
                
                //insert into the database;
                $query  = "INSERT INTO `stock_count` ("
                        . " `id`, `ref`, `date`, `product_code`, `product_name`, "
                        . " `s_quantity`, `m_quantity`, `difference`, "
                        . " `day`, `month`, `year`, `time_added`, `user_id`)"
                        . ""
                        . " VALUE( "
                        . " 0, '$ref', '$date', '$mcode', '$mname', '$mquant', "
                        . " '$squant', '$mdiff', '$day', "
                        . " '$month', '$year', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error1");
                
                
                
               
                
                //now reduce the product quantity
                $query = "UPDATE `products` SET "
                        . " `quantity` = '$mquant'"
                        . " WHERE `product_code` = '$mcode'";
                $result = mysqli_query($dbc, $query)
                        or die("Error2");
                
                
            }
        }
        //now insert into sales referece table
        $query = "INSERT INTO `stock_count_ref` ("
                . " `id`, `ref`, `date`,  `agent_name`,"
                . " `item_number`,  `day`, "
                . " `month`, `year`, `time_added`, `user_id`)"
                . " "
                . " VALUES("
                . " 0, '$ref', '$date',  '$agent',"
                . " '$item_sold',  '$day', "
                . " '$month', '$year', NOW(), '$user_id')";
        $result = mysqli_query($dbc, $query)
                or die("Error3");
        
        $success = "Stock Quantity has been Updated";
    }

    
    
}

/**
 * set up page active links
 */
$sidebar = "inventory";
$sublink = "inventory_list";

$ref_id = gen_stock_count_id();
/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<form action="" method="POST">
<div class="row">
    <div class="row">
        <div>
            <h1 class="page-header"> Stock Count Control</h1>
        </div>
    </div>

    <?php
    require_once './includes/notifications.php';
    ?>
    
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <table>
                <tr style='height:60px;'><td  style='width: 50px; margin-right: 50px;'>
                        <label for="exampleInputEmail1" style='font-weight:normal; margin-right: 50px;'>Ref </label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name='ref' style='width:180px; margin-right: 50px;'
                               required="" value="<?php echo $ref_id; ?>" readonly="true"></td>
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
                Sales Agent:
            </label>
            <div class="col-md-8">
                <input type="text" name="agent" class="form-control"
                       style="border-bottom: 3px solid black;
                               border-top: transparent;
                               border-right: transparent;
                               border-left: transparent;
                               background-color: #64a7ee;
                               font-size: 1em;
                               color: black;
                               font-weight: bold;
                               padding-bottom: 2px;
                               " placeholder="Enter Name" required="true">
            </div>
        </div>


        <div class="col-md-6">
           
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
                        <th style="text-align: center;">S - Quantity</th>
                        <th style="text-align: center;">M - Quantity</th>
                        <th style="text-align: center;">Difference</th>
                        <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More row">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </th>
                    </tr>

                   <?php
                   for($i = 1; $i < 11; $i++)
                   {
                       ?>
                    <tr>
                        <td><input type="text" name="product_code[]" class="form-control product_code" readonly="true"></td>
                        <td><input type="text" name="product_name[]" class="form-control product_name" ></td>
                        <td><input type="text" name="squantity[]" class="form-control sq" readonly="true"></td>
                        <td><input type="text" name="mquantity[]" class="form-control mq"></td>
                        <td><input type="text" name="diff[]" class="form-control diff" readonly="true"></td>
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
    <div class="container">
        <div class="container col-md-4 col-md-offset-1">
        
        </div>

        <div class="container col-md-6">
            
        </div>
    </div>
    <br>


    <div class="btn-group col-md-4" style="float: right;">
        <div class="btn-group">
            <input  class="btn btn-success" style="margin-right: 10px;" type="submit" value="Update Stock" name="submit">

            <a class="btn btn-success" style="margin-right: 10px;" href="">Cancel</a>

            <a class="btn btn-success" style="margin-right: 10px;" href="index.php">Close</a>
        </div>
    </div>

</div>
</form>
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
        
        $(".product_name").focusout(function(){
            var product_name = $(this).val();
            var index = $(this).closest("tr").index();
            var $row = $("#tb tr:eq(" + index + ")");
            //now grab the index of that row.
            
            $.ajax({
               url: "get_product_code.php",
               method: "POST",
               data: {key: product_name},
               dataType : "text",
               success: function(data){
                   $row.find("input[name='product_code[]']").val(data);
               }
           });
           
           $.ajax({
               url: "get_quantity.php",
               method: "POST",
               data: {key: product_name},
               dataType : "text",
               success: function(data){
                   $row.find("input[name='squantity[]']").val(data);
               }
           });
           
        }); //end of focus out for the product name
        
        $(".mq").focusout(function(){
            var quantity = $(this).val();
            var index = $(this).closest("tr").index();
            var $row = $("#tb tr:eq(" + index + ")");
            
            //get the unit price
            var sq = $row.find("input[name='squantity[]']").val();
            
            var dif  = quantity - sq;
            
            var diff = Math.abs(dif);
            
            $row.find("input[name='diff[]']").val(diff);
 
        });
        
        
    });
</script>
<?php
require_once './includes/bottom.php';
?>