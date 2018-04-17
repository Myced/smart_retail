<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

//database connection
$db = new dbc();
$dbc = $db->connect();

//function to get product quantity
require_once './get_product_quantity.php';

//now data manipulation
if(isset($_POST['submit']))
{
    //grab all the data
    $ref = filter($_POST['ref']);
    $date = filter($_POST['date']);
    
    $withdrawal = filter($_POST['withdrawal']);

    //now the data from the products sold
    $source[] = $_POST['source'];
    $quantity[] = $_POST['quantity'];
    $purpose = $_POST['purpose'];
    
    
    //check that this ref does not exist
    $query = "SELECT * FROM `withdrawal_ref` WHERE `ref` = '$ref'";
    $result = mysqli_query($dbc, $query)
            or die("Error");
    
    if(mysqli_num_rows($result) > 1)
    {
        $error = "Sorry. This Reference already exist. Try another one";
    }

    //check if all the items were not entered.
    $number = count($purpose);
    $items = 0;
    for($i = 0; $i < $number; $i++)
    {
        $index = $purpose[$i];
        
        if(!empty($index))
        {
            $items++;
        }
    }
    
    if($items == 0)
    {
        $warning = "Withdrawal Was not made. You did not enter any items";
    }
    
    else
    {
        if(!isset($error))
        {
            $final_total = 0;
            $item_sold = 0;
            for($i = 0; $i < $number; $i++)
            {
                $index = $purpose[$i];

                if(!empty($index))
                {
                    $item_sold++;


                    //grab all the values. 
                    $msource = $source[0][$i];
                    $mquantity = $quantity[0][$i];
                    $mpurpose = $purpose[$i]; 

                    //insert into the database;
                    $query  = "INSERT INTO `withdrawal` ("
                            . " `id`, `ref`, `date`, `withdrawal`, `source`, "
                            . " `quantity`, `purpose`,"
                            . " `day`, `month`, `year`, `time_added`, `user_id`)"
                            . ""
                            . " VALUE( "
                            . " 0, '$ref', '$date', '$withdrawal', '$msource', '$mquantity', "
                            . " '$mpurpose', '$day', "
                            . " '$month', '$year', NOW(), '$user_id')";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");


                    //get the product quantity;
    //                $qq = get_quantity($mcode); //current quantity in the database;
    //                
    //                //final quantity 
    //                $fquantity = (int)$qq - (int)$mquantity;
    //                
    //                //now reduce the product quantity
    //                $query = "UPDATE `products` SET "
    //                        . " `quantity` = '$fquantity'"
    //                        . " WHERE `product_code` = '$mcode'";
    //                $result = mysqli_query($dbc, $query)
    //                        or die("Error");



                }
            }
            //now insert into sales referece table
            $query = "INSERT INTO `withdrawal_ref` ("
                    . " `id`, `ref`, `withdrawal`, `date`, "
                    . " `item_total`, `day`, "
                    . " `month`, `year`, `time_added`, `user_id`)"
                    . " "
                    . " VALUES("
                    . " 0, '$ref', '$withdrawal', '$date', "
                    . " '$item_sold', '$day', "
                    . " '$month', '$year', NOW(), '$user_id')";
            $result = mysqli_query($dbc, $query)
                    or die("Error");

            $success = "Withdrawal Successful.";
        }
    }

    
    
}

/**
 * set up page active links
 */
$sidebar = "sell";
$sublink = "cash_withdrawal";


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
            <h1 class="page-header">Withdrawal</h1>
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
                        <input type="text" class="form-control" name='ref' style='width:180px; margin-right: 50px;' required=""></td>
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
                Withdrawal:
            </label>
            <div class="col-md-8">
                <input type="text" name="withdrawal" class="form-control"
                       style="border-bottom: 2px solid black;
                               border-top: transparent;
                               border-right: transparent;
                               border-left: transparent;
                               background-color: #64a7ee;
                               font-size: 1em;
                               color: black;
                               font-weight: bold;
                               padding-bottom: 2px;
                               " placeholder="" required="true">
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
                        <th style="text-align: center; width: 50%;" >Withdrawal Purpose</th>
                        <th style="text-align: center; width: 20%;">Amount</th>
                        <th style="text-align: center; width: 30%;">Source</th>

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
                        <td><input type="text" name="purpose[]" class="form-control " ></td>
                        <td><input type="text" name="quantity[]" class="form-control " ></td>
                        <td><input type="text" name="source[]" class="form-control"></td>

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
    
    <br>
    <div class="btn-group col-md-4" style="float: right;">
        <div class="btn-group">
            <input  class="btn btn-success" style="margin-right: 10px;" type="submit" value="Save" name="submit">

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
        
        
        
       
    });
</script>
<?php
require_once './includes/bottom.php';
?>