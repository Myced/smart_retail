<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

// FUNCTION TO GETNERATE A UNIQUE ID
function gen_return_ref()
{
    global $dbc;

    $query = "SELECT `id` FROM `products` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Error");

    $constant = 'ITM-';

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

if(isset($_POST['upload']))
{
    //now work with the excell file
    /** Include path **/
    set_include_path(get_include_path() . PATH_SEPARATOR . 'php_excel/Classes/');

    /** PHPExcel_IOFactory */
    include 'php_excell/Classes/PHPExcel/IOFactory.php';

    if(isset($_FILES['sheet']))
    {
        //thne grab the filres
        //now grab sheet options
        $sheet_location = '';
        $file_name = $_FILES['sheet']['name'];
        $tmp_name  = $_FILES['sheet']['tmp_name'];
        $file_type = $_FILES['sheet']['type'];
        $file_size = $_FILES['sheet']['size'];

        $max_file_size = 200000000000; //200Mb

        if(!empty($file_name))
        {
            //$error = "Sorry. You must upload a profile Picture";
            if($file_size > $max_file_size)
            {
                $error = "Sorry. File Size too large";
            }

            //Now validate the file format
            if($file_type == "image/jpg" || $file_type == "image/jpeg" || $file_type == "image/gif"
                    || $file_type == "image/png" || $file_type == "image/tiff" )
            {
                $error = "Sorry. Pictures are not allowed";
            }


            //picture destination
            $destination = "uploads/files/excell/";
            $date_string = date("Ymdhms") . '_';
            $final_name = $date_string . $file_name;

            $sheet_location = $destination . $final_name;

            //now upload
            if(!isset($error))
            {
                if(move_uploaded_file($tmp_name, $sheet_location))
                {
                    //get the file and start working with it.

                    $inputFileName = $sheet_location;



                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                    //now go ahead and upload the names
                    $end = count($sheetData);

                    for ($i = 2; $i <= $end; $i++)
                    {
                        //get the default values first
                        //start grabint things
                        $ref = gen_return_ref();
                        $product_code = gen_product_ref();
                        $date = $date;

                        $barcode = '';

                        //grab the values and insert
                        $product_name = filter($sheetData[$i]['B']);
                        $quantity = filter($sheetData[$i]['C']);
                        $unit =  filter($sheetData[$i]['D']);
                        $category = filter($sheetData[$i]['E']);

                        $cost = filter($sheetData[$i]['F']);
                        $unit_price = filter($sheetData[$i]['G']);
                        $reorder_level = filter($sheetData[$i]['H']);
                        $suplier = filter($sheetData[$i]['I']);

                        //default values
                        $sup_location = '';
                        $sup_contact = '';

                        $product_status = TRUE;
                        $show_stock = TRUE;
                        $expiry_date = '';

                        $valuation = 'FIFO';

                        //insert your data
                        if(!empty($product_name))
                        {
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
                        }


                    }

                $success = "Products Uploaded";

                }

            }
            else {
                $warning = "Sorry, Could not upload file";
            }

        }
        else
        {
            $upload = FALSE;
            $sheet_location = '';
            $error = "Sorry. No file uploaded";
        }
    }
    else {
        $error = "No file uploaded";
    }
}

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<br>

<?php
//requrie the notification bar
require_once './includes/notifications.php';
 ?>

<div class="row">
     <div class="col-md-12">
         <h2 class="page-header">Upload Products from Excell</h2>
     </div>
</div>

<div class="row white-background padding-special">
    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info">
                <strong>Note !</strong>
                <br>
                Your Excell Spreadsheet must be of the following format
                <br>
                If there is no value for a cell, just leave it blank

                <br><br>
                <ul>
                    <li>Make sure the unit is a valid unit that has been added to the system</li>
                    <li>Make sure the category has also been added to the system</li>
                </ul>
            </div>
        </div>
    </div>

    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>S/N</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit </th>
                    <th>Category</th>
                    <th>Cost Price</th>
                    <th>Unit Price</th>
                    <th>Reorder Level</th>
                    <th>Supplier Name</th>
                </tr>

                <?php
                for ($i = 1; $i <= 4; $i++)
                {
                    ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td> Rice </td>
                    <td> 56</td>
                    <td> Bags </td>
                    <td> Food Category </td>
                    <td> 8,000 </td>
                    <td>10,500</td>
                    <td>50</td>
                    <td>Pa Rice</td>
                </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>

    <br>
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="control-label col-md-5"> Upload File</label>
                    <div class="col-md-7">
                        <input type="file" name="sheet" value="" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-md-5"> </label>
                    <div class="col-md-7">
                        <input type="submit" name="upload" value="Upload" class="btn btn-primary">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
            </div>
        </div>
    </form>

</div>

<?php
require_once './includes/bottom.php';
?>
