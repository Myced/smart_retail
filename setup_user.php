<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();


$upload = FALSE;

function gen_id()
{
    global  $dbc;
    
    $query = "SELECT `user_id` FROM `users` ORDER BY `id` DESC LIMIT 1";
    $result  = mysqli_query($dbc, $query)
            or die("Error");
    
    //generate a random integer
    $random_int = rand(0, 9);
    
    if(mysqli_num_rows($result) == 1)
    {
        list($last_id ) = mysqli_fetch_array($result);
        
        
        //last id is of the form xxxx-mmYYS where s is a random integer
        //so we grab the first part and then increment it
        $part = substr($last_id, 0, 4);
        
        //convert it to an inter
        $value = (int)$part;
        
        ++$value;
        
        $mat = $value . '-' .  date("my") . $random_int; 
        
    }
    else
    {
        //the starting id is 1214;
        $start = 1214;

        $mat = $start . '-' . date("my") . $random_int; 
        
    }
    
    //return the id
    return $mat;
    
}

if(isset($_GET['user']))
{
    if(isset($_GET['action']))
    {
        //then get the user id and the action to be performed
        $user = filter($_GET['user']);
        $action = filter($_GET['action']);
        
        if($action == 'del')
        {
            //then deletet the user
            $query = "DELETE FROM `users` WHERE `user_id` = '$user'";
            $result = mysqli_query($dbc, $query)
                    or die("Error");
            
            $success = "User Deleted";
        }
    }
}

if(isset($_POST['submit']))
{

    //collect all the /dathadd
    $name = filter($_POST['worker_name']);
    $contact = filter($_POST['contact']);
    $position = filter($_POST['position']);
    
    $user = filter($_POST['user_id']);
    $username = filter($_POST['username']);
    $password = sha1(filter($_POST['password']));
    $repeat_password = filter($_POST['repeat_password']);
    
    //get the user preferences
    $sales = TRUE ? isset($_POST['sales']) : $sales = FALSE;
    $inventory = TRUE ? isset($_POST['inventory']) : $inventory = FALSE;
    $cash_management = TRUE ? isset($_POST['cash_management']) : $cash_management = FALSE;
    $customer = TRUE ? isset($_POST['customer']) : $customer = FALSE;
    $purchases = TRUE ? isset($_POST['purchases']) : $purchases = FALSE;
    $settings = TRUE ? isset($_POST['settings']) : $settings = FALSE;
    $reports = TRUE ? isset($_POST['reports']) : $reports = FALSE;
    
    //validate the username and pasword
    $query = "SELECT `username` FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($dbc, $query)
             or die("Error. Could not look up db");
    if(mysqli_num_rows($result) > 0)
    {
        $error = "This Username already exist. Choose another one";
    }
    
    $query = "SELECT `username` FROM `users` WHERE `name` = '$name'";
    $result = mysqli_query($dbc, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "This worker is already in the database. You can instead update his information";
    }
    
    //make sure the user_id is not in the database
    $query = "SELECT * FROM `users` WHERE `user_id` = '$user'";
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
            $destination = "images/files/user_photos/";
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
            $warning = "User's Photo has not been set. You might consider uploading it later";
        }
       
    }

    //check and validate
    if(!isset($name))
    {
        $error = "The Worker's name is required.";
    }
    if(isset($name) && empty($name))
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
                $query = "INSERT INTO `users` ("
                        . " `id`, `user_id`, `username`, `password`, `name`, "
                        . " `position`, `contact`, `photo`, `time_added`, `user_id_d` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$user', '$username', '$password', '$name', "
                        . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));
                
                
            }
            else
            {
                $warning = "Could not upload the picture";
                
                $photo_location = '';
                $query = "INSERT INTO `users` ("
                            . " `id`, `user_id`, `username`, `password`, `name`, "
                            . " `position`, `contact`, `photo`, `time_added`, `user_id_d` )"
                            . ""
                            . " VALUES ("
                            . " 0, '$user', '$username', '$password', '$name', "
                            . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error");
            }
        }
        else
        {
            $photo_location = '';
            $query = "INSERT INTO `users` ("
                        . " `id`, `user_id`, `username`, `password`, `name`, "
                        . " `position`, `contact`, `photo`, `time_added`, `user_id_d` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$user', '$username', '$password', '$name', "
                        . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
            $result = mysqli_query($dbc, $query)
                        or die("Error");
        }
        
        
        //now insert preferences
        $query = "INSERT INTO `user_prefs` ("
                . " `id`, `user_id`, `sales`, `inventory`, `cash_management`, "
                . " `customer`, `purchases`, `setting`, `reports` )"
                . ""
                . " VALUES ("
                . " 0, '$user', '$sales', '$inventory', '$cash_management', "
                . " '$customer', '$purchases', '$settings', '$reports')";
        $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));
        
        $success = "User Created Successfully";
    }
}

$id = gen_id();

/**
 * set up page active links
 */
$sidebar = "settings";
$sublink = "setup_user";


//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<form action="setup_user.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="row">
            <h1 class="page-header" >Setup User</h1>
        </div>
        
        <?php
        require_once './includes/notifications.php';
        ?>
        
        
        <div class="row">
            <div class="col-md-5">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">
                            Name of Worker
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="worker_name" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">
                            Position
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="position" required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">
                            Contact
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="contact" required="true">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4"> 
                            User ID
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="user_id" readonly="true" 
                                   required="true" value="<?php echo $id; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Username
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="username" required="true"
                                   placeholder="Username used to login">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Password
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="password" required="true">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Repeat Password
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="repeat_password" required="true">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
    <!--            <div style="margin-top:10px; float:left; width: 100px; height: 105px; border:1px solid #ccc; text-align: center; margin-left: 30px;">

                    <input type="file" name="photo" class="form-control">
                </div>-->


                <div class="row">
                    <div class="col-md-12">
                        <input type="file" name="photo" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <strong>Picture </strong>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4">
                <h4>User Preference</h4>
                <div class="col-md-8 col-md-offset-2">
                    <div class=" form-group">
                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="sales">
                                Sales
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="inventory">
                                Inventory
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="cash_management">
                                Cash Management
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="customer">
                                Customer
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="purchases">
                                Purchases
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="settings">
                                Setting
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" name="reports">
                                Reports
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive text-center">
                    <table class="table table-bordered text-center" style="background-color: white;">
                        <tr>
                            <th colspan="6">
                                <h3>Display Board</h3>
                            </th>
                        </tr>
                        <tr>
                            <th>N<sup>o</sup></th>
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Position</th>
                            <th>
                                Actn
                            </th>
                        </tr>
                        
                        <?php
                        $dbc = $db->connect();
                        
                        $query = "SELECT * FROM `users`";
                        $result = mysqli_query($dbc, $query);
                        
                        if(mysqli_num_rows($result) == 0)
                        {
                            ?>
                        <tr>
                            <td colspan="6" class="text-primary">
                                <strong class="text-primary">No Users Yet</strong>
                            </td>
                        </tr>
                            <?php
                        }
                        else
                        {
                            $count = 1;
                            
                            while($row = mysqli_fetch_array($result))
                            {
                            ?>
                        <tr>
                            <td>
                                <?php echo $count++; ?>
                            </td>
                            <td>
                                <?php echo $row['name']; ?>
                            </td>
                            <td>
                                <?php echo $row['user_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['username']; ?>
                            </td>
                            <td>
                                <?php echo $row['position']; ?>
                            </td>
                            <td>
                                <a href="setup_user.php?user=<?php echo $row['user_id']; ?>&action=del"
                                   class="btn btn-danger btn-xs" title="Delete this user">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                            <?php
                            }
                        }
                        ?>


                    </table>
                </div>
            </div>

        </div>


        <div class="btn-group col-md-4" style="float: right;">
            <div class="btn-group">
                <button class="btn btn-success" style="margin-right: 10px;" type="submit" name="submit">Save</button>

                <a class="btn btn-success" style="margin-right: 10px;" href="setup_user.php">Cancel</a>

                <button class="btn btn-success" style="margin-right: 10px;">CLose</button>
            </div>
        </div>
    </div>
</form>


<?php
require_once './includes/bottom.php';
?>