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
    
    $query = "SELECT `agent_id` FROM `agents` ORDER BY `id` DESC LIMIT 1";
    $result  = mysqli_query($dbc, $query)
            or die("Error");
    
    $start_mat = "AG-";
    //generate a random integer
    $random_int = rand(0, 9);
    
    if(mysqli_num_rows($result) == 1)
    {
        list($last_id ) = mysqli_fetch_array($result);
        
        
        //last id is of the form AGxxx-mmYYS where s is a random integer
        //so we grab the first part and then increment it
        $part = substr($last_id, 3, 3);
        
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
        
        $mat = $start_mat . $value . '-' .  date("my") . $random_int; 
        
    }
    else
    {
        //the starting id is 1214;
        $value = '001';

        $mat = $start_mat . $value . '-' . date("my") . $random_int; 
        
    }
    
    //return the id
    return $mat;
    
}

if(isset($_POST['submit']))
{

    //collect all the /dathadd
    $agent_name = filter($_POST['agent_name']);
    $contact = filter($_POST['contact']);
    $position = filter($_POST['position']);
    
    $agent_id = filter($_POST['agent_id']);
    
    $sale_area = filter($_POST['sale_area']);
    
    //validate the username and pasword
    $query = "SELECT `agent_name` FROM `agents` WHERE `agent_name` = '$agent_name'";
   
    $result = mysqli_query($dbc, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
        $error = "This Agent is already in the database. You can instead update his information";
    }
    
    //make sure the user_id is not in the database
    $query = "SELECT * FROM `agents` WHERE `agent_id` = '$agent_id'";
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
            $warning = "Agent's Photo has not been set. You might consider uploading it later";
        }
       
    }

    //check and validate
    if(!isset($agent_name))
    {
        $error = "The Agent's name is required.";
    }
    if(isset($agent_name) && empty($agent_name))
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
                $query = "INSERT INTO `agents` ("
                        . " `id`, `agent_id`, `agent_name`, `sale_area`, "
                        . " `position`, `contact`, `photo`, `time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$agent_id', '$agent_name', '$sale_area',"
                        . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error" . mysqli_error($dbc));
                
                
            }
            else
            {
                $warning = "Could not upload the picture";
                
                $photo_location = '';
                $query = "INSERT INTO `agents` ("
                        . " `id`, `agent_id`, `agent_name`, `sale_area`, "
                        . " `position`, `contact`, `photo`, `time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$agent_id', '$agent_name', '$sale_area',"
                        . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
                $result = mysqli_query($dbc, $query)
                        or die("Error");
            }
        }
        else
        {
            $photo_location = '';
            $query = "INSERT INTO `agents` ("
                        . " `id`, `agent_id`, `agent_name`, `sale_area`, "
                        . " `position`, `contact`, `photo`, `time_added`, `user_id` )"
                        . ""
                        . " VALUES ("
                        . " 0, '$agent_id', '$agent_name', '$sale_area',"
                        . " '$position', '$contact', '$photo_location', NOW(), '$user_id')";
            $result = mysqli_query($dbc, $query)
                        or die("Error");
        }
        
        
        $success = "Agent Added Successfully";
    }
}

$id = gen_id();

$sidebar = "settings";
$sublink = "setup_agent";

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="row">
            <h1 class="page-header" >Setup Agent</h1>
        </div>
        
        <?php
        require_once './includes/notifications.php';
        ?>
        
        
        <div class="row">
            <div class="col-md-5">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">
                            Name of Agent
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="agent_name" required="true">
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
                            Agent ID
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="agent_id" readonly="true" 
                                   required="true" value="<?php echo $id; ?>">
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
                        <input type="file" name="photo" class="file form-control" id="file1">
                        <div id="prev_file1"></div><br/>
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
                <h4>Sale Area</h4>
                <div class="col-md-12">
                    <textarea name="sale_area" class="form-control" rows="7"></textarea>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive text-center">
                    <table class="table table-bordered text-center" style="background-color: white;">
                        <tr>
                            <th colspan="5">
                                <h3>Display Board</h3>
                            </th>
                        </tr>
                        <tr>
                            <th>N<sup>o</sup></th>
                            <th>Agent Name</th>
                            <th>Agent ID</th>
                            <th>Sale Area</th>
                        </tr>
                        
                        <?php
                        $dbc = $db->connect();
                        
                        $query = "SELECT * FROM `agents`";
                        $result = mysqli_query($dbc, $query);
                        
                        if(mysqli_num_rows($result) == 0)
                        {
                            ?>
                        <tr>
                            <td colspan="5" class="text-primary">
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
                                <?php echo $row['agent_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['agent_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['sale_area']; ?>
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

                <a class="btn btn-success" style="margin-right: 10px;" href="">Cancel</a>

                <a class="btn btn-success" style="margin-right: 10px;" href="index.php">CLose</a>
            </div>
        </div>
    </div>
</form>


<?php
require_once './includes/bottom.php';
?>