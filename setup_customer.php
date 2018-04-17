<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

function gen_id()
{
    global  $dbc;
    
    $query = "SELECT `customer_id` FROM `customers` ORDER BY `id` DESC LIMIT 1";
    $result  = mysqli_query($dbc, $query)
            or die("Error");
    
    $start_mat = date("dy");
    
    if(mysqli_num_rows($result) == 1)
    {
        list($last_id ) = mysqli_fetch_array($result);
        
        
        //last id is of the form 0117-001 where s is a random integer
        //so we grab the first part and then increment it
        $part = substr($last_id, 5, 3);
        
        //convert it to an inter
        $value = (int)$part;
        
        ++$value;
        $old_value = $value;
        
        if($value < 9)
        {
            $value = '00' . $old_value;
        }
        elseif($value < 100)
        {
            $value = '0' . $old_value;
        }
        else
        {
            $value = $old_value;
        }
        
        $mat = $start_mat . '-' . $value; 
        
    }
    else
    {
        //the starting id is 1214;
        $value = '001';

        $mat = $start_mat . '-' . $value ; 
        
    }
    
    //return the id
    return $mat;
    
}

if(isset($_POST['submit']))
{

    //collect all the /dathadd
    $customer_name = filter($_POST['customer_name']);
    $business_name = filter($_POST['business_name']);
    $contact = filter($_POST['contact']);
    $location = filter($_POST['location']);
    $customer_id = filter($_POST['customer_id']);
    
    $pobox = filter($_POST['pobox']);
    $email = filter($_POST['email']);
    
    $fax = filter($_POST['fax']);
    
    $credit_limit = get_money(filter($_POST['credit_limit']));
    $settlement_days = filter($_POST['settlement_days']);
    $discount_rate = filter($_POST['discount_rate']);
    
    
    //validate the username and pasword
    $query = "SELECT `customer_name` FROM `customers` WHERE `customer_name` = '$customer_name'";
   
    $result = mysqli_query($dbc, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "This Customer is already in the database. You can instead update his information";
    }
    
    //make sure the user_id is not in the database
    $query = "SELECT * FROM `customers` WHERE `customer_id` = '$customer_id'";
    $result = mysqli_query($dbc, $query)
             or die("Error. Could not look up db");
    
    if(mysqli_num_rows($result) > 0)
    {
        //generate a new id
        $user = gen_id();
    }
    
    //photo
    if(isset($_FILES['photo']))
    {
        //thne grab the filres
        //now grab photo options
        $photo_location = '';
        $file_name = $_FILES['photo']['name'];
        $tmp_name  = $_FILES['photo']['tmp_name'];
        $file_type = $_FILES['photo']['type'];
        $file_size = $_FILES['photo']['size'];

        $max_file_size = 20000000; //20Mb

        if(!empty($file_name))
        {
            //$error = "Sorry. You must upload a profile Picture";
            if($file_size > $max_file_size)
            {
                $error = "Sorry. File Size too large";
            }

            //Now validate the file format
            if($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/gif"
                    && $file_type != "image/png" && $file_type != "image/tiff" )
            {
                $error = "Sorry. Inappropriate File Type. Acceptable Picture formats include \"jpg, jpeg, png, gif\"  ";
            }

            //picture destination
            $destination = "images/files/agent_photos/";
            $date_string = date("Ymdhms") . '_';
            $final_name = $date_string . $file_name;

            $photo_location = $destination . $final_name;

            if(!isset($error))
            {
                $upload = TRUE;
            }
        }
        else
        {
            $upload = FALSE;
            $photo_location = '';
            $warning = "customer's Photo has not been set. You might consider uploading it later";
        }
       
    }

    //check and validate
    if(!isset($customer_name))
    {
        $error = "The customer's name is required.";
    }
    if(isset($customer_name) && empty($customer_name))
    {
        $error = "Sorry. The name is required";
    }
    
    //more validation
    
    if(!isset($error))
    {
        if($upload == TRUE)
        {
            
            if(move_uploaded_file($tmp_name, $photo_location))
            {
                $query = "INSERT INTO `customers` ("
                        . " `id`, `customer_id`, `customer_name`, `location`, `email`, "
                        . " `business_name`, `pobox`, `contact`, `fax`, `photo`, "
                        . " `credit_limit`, `discount_rate`, `settlement_days`,"
                        . " `day`, `month`, `year`, "
                        . "`time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$customer_id', '$customer_name', '$location', '$email', "
                        . " '$business_name', '$pobox', '$contact', '$fax', '$photo_location', "
                        . " '$credit_limit', '$discount_rate', '$settlement_days', "
                        . " '$day', '$month', '$year', "
                        . " NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));
                
                
            }
            else
            {
                $warning = "Could not upload the picture";
                
                $photo_location = '';
                $query = "INSERT INTO `customers` ("
                        . " `id`, `customer_id`, `customer_name`, `location`, `email`, "
                        . " `business_name`, `pobox`, `contact`, `fax`, `photo`, "
                        . " `credit_limit`, `discount_rate`, `settlement_days`,"
                        . " `day`, `month`, `year`, "
                        . "`time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$customer_id', '$customer_name', '$location', '$email', "
                        . " '$business_name', '$pobox', '$contact', '$fax', '$photo_location', "
                        . " '$credit_limit', '$discount_rate', '$settlement_days', "
                        . " '$day', '$month', '$year', "
                        . " NOW(), '$user_id')";
                
                $result = mysqli_query($dbc, $query)
                        or die("Error");
            }
        }
        else
        {
            $photo_location = '';
            $query = "INSERT INTO `customers` ("
                        . " `id`, `customer_id`, `customer_name`, `location`, `email`, "
                        . " `business_name`, `pobox`, `contact`, `fax`, `photo`, "
                        . " `credit_limit`, `discount_rate`, `settlement_days`,"
                        . " `day`, `month`, `year`, "
                        . "`time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$customer_id', '$customer_name', '$location', '$email', "
                        . " '$business_name', '$pobox', '$contact', '$fax', '$photo_location', "
                        . " '$credit_limit', '$discount_rate', '$settlement_days', "
                        . " '$day', '$month', '$year', "
                        . " NOW(), '$user_id')";
            $result = mysqli_query($dbc, $query)
                        or die("Error");
        }
        
        
        $success = "customer Added Successfully";
    }
}

$cus_id = gen_id();

$sidebar = "customer";
$sublink = "setup_customer";

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<form action="setup_customer.php" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="page-header">
        <h2>Setup Customer</h2>
    </div>

<?php
require_once './includes/notifications.php';
?>

<div class="row">
    <div class="col-md-12">
        <table style="margin-top:50px; float:left; margin-right:50px;">
            <td>
                <label for="exampleInputEmail1" style='font-weight:normal;'>Customer Name</label></td>
            <td>
                <input type="text" class="form-control" name='customer_name' style='width:300px; border-bottom:1px solid #ccc; margin-left: 10px;'></td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>Business Name
                    </label></td>
                <td>
                    <input type="text" class="form-control" name='business_name' style='width: 180px; margin-left: 10px;'></td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>Location</label></td>
                <td>
                    <input type="text" class="form-control" name='location'  style='width: 180px; margin-left: 10px;'></td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>Email: </label></td>
                <td>
                    <input type="text" class="form-control" name='email'  style='width: 180px; margin-left: 10px;'></td></tr>

        </table>


        <table style="margin-top:50px; float:left; margin-right:50px;">
            <td>
                <label for="exampleInputEmail1" style='font-weight:normal;'>Customer ID</label></td>
            <td>
                <input type="text" class="form-control" name='customer_id'  style='width:180px; margin-left: 10px;'</td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>Contact:</label></td>
                <td>
                    <input type="text" class="form-control" name='contact'  style='width: 180px; margin-left: 10px;'></td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>P O Box:</label></td>
                <td>
                    <input type="text" class="form-control" name='pobox' style='width: 180px; margin-left: 10px;'></td></tr>

            <tr><td>
                    <label for="exampleInputEmail1" style='font-weight:normal;'>Fax:</label></td>
                <td>
                    <input type="text" class="form-control" name='fax' id="exampleInputEmail1" style='width: 180px; margin-left: 10px;'></td></tr>

        </table>

            <div style="margin-top:10px; float:left; width: 200px; height: 205px; border:1px solid #ccc; text-align: center; margin-left: 30px;">
                <input type="file" name="photo" class="file form-control" id="file1">
                <h3>Photo</h3>

            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <table style="margin-top:50px; float:left; margin-right:50px;">
                    <td>
                        <label for="exampleInputEmail1" style='font-weight:normal;'>Credit Limit</label></td>
                    <td>
                        <input type="text" class="form-control" name='credit_limit' style='width:180px; border-bottom:1px solid #ccc; margin-left: 10px;'></td></tr>

                </table>


                <table style="margin-top:50px; float:left; margin-right:50px;">
                    <td>
                        <label for="exampleInputEmail1" style='font-weight:normal;'>Discount Rate % </label></td>
                    <td>
                        <input type="text" class="form-control" name='discount_rate' style='width:180px; border-bottom:1px solid #ccc; margin-left: 10px;'></td></tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table style="margin-top:50px; float:left; margin-right:5px;">
                    <td>
                        <label for="exampleInputEmail1" style='font-weight:normal;'>Settlement Days</label></td>
                    <td>
                        <input type="text" class="form-control" name='settlement_days' id="exampleInputEmail1" required='required' style='width:180px; border-bottom:1px solid #ccc; margin-left: 10px;'></td></tr>


                </table>
            </div>
        </div>


        <div class="btn-group col-md-4" style="float: right;">
            <div class="btn-group">
                <button class="btn btn-success" style="margin-right: 10px;" type="submit" name="submit">Save</button>

                <a class="btn btn-success" style="margin-right: 10px;" href="">Cancel</a>

                <a class="btn btn-success" style="margin-right: 10px; margin-bottom: 20px;" href="index.php">Close</a>
            </div>
        </div>
    </div>
</div>
    
</form>

<?php
require_once './includes/bottom.php';
?>