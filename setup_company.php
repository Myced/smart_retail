<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';


//database connections

$db = new dbc();
$dbc = $db->connect();

//gather and save data
if(isset($_POST['submit']))
{
    //grab all teh data values.
    
    $company_name = filter($_POST['business_name']);
    $location = filter($_POST['location']);
    $email = filter($_POST['email']);
    
    $pobox = filter($_POST['pobox']);
    $contact = filter($_POST['contact']);
    
    $activity = filter($_POST['activity']);
    
    $manager = filter($_POST['manager']);
    $manager_contact = filter($_POST['manager_contact']);
    $manager_email = filter($_POST['manager_email']);
    
    $tax_regime = filter($_POST['tax_regime']);
    $tax_number = filter($_POST['tax_number']);
    $fiscal_year = filter($_POST['financial_year']);
    
    $upload = FALSE;
    
    //now work with the image if it is set
    if(isset($_FILES['logo']))
    {
        //thne grab the filres
        //now grab photo options
        $photo_location = '';
        $file_name = $_FILES['logo']['name'];
        $tmp_name  = $_FILES['logo']['tmp_name'];
        $file_type = $_FILES['logo']['type'];
        $file_size = $_FILES['logo']['size'];

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
            $destination = "images/files/company/";
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
            $warning = "Company Logo has not been Changed";
        }
        

        
    }
    
    if(empty($company_name))
    {
        $error = "Sorry. You must provide the Business Name. Consider coming later to update it";
    }
    
    //now check if you are updating or inserting
    $query  = "SELECT * FROM `company` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($dbc, $query);
    
    if(mysqli_num_rows($result) == 0)
    {
        //insert into the database
        if(!isset($error))
        {
            //save the data
            if($upload == TRUE)
            {
                //upload photo before saving
                if(move_uploaded_file($tmp_name, $photo_location))
                {
                    //insert into the db
                    $query = "INSERT INTO `company` ("
                            . " `id`, `company_name`, `location`, `email`, `contact`, "
                            . " `pobox`, `photo`, `activity`, `manager`, `manager_email`, "
                            . " `manager_contact`, `tax_regime`, `tax_number`, `financial_year`)"
                            . " "
                            . " VALUES ("
                            . " 0, '$company_name', '$location', '$email', '$contact', "
                            . " '$pobox', '$photo_location', '$activity', '$manager', '$manager_email', "
                            . " '$manager_contact', '$tax_regime', '$tax_number', '$fiscal_year')";
                    $result  = mysqli_query($dbc, $query)
                            or die("Error");

                    $success = "Company Information Saved";
                }
                else
                {
                    $error = "Could not Upload file";
                }
            }
            else
            {
                //just save the data
                //insert into the db
                $query = "INSERT INTO `company` ("
                        . " `id`, `company_name`, `location`, `email`, `contact`, "
                        . " `pobox`, `photo`, `activity`, `manager`, `manager_email`, "
                        . " `manager_contact`, `tax_regime`, `tax_number`, `financial_year`)"
                        . " "
                        . " VALUES ("
                        . " 0, '$company_name', '$location', '$email', '$contact', "
                        . " '$pobox', '$photo_location', '$activity', '$manager', '$manager_email', "
                        . " '$manager_contact', '$tax_regime', '$tax_number', '$fiscal_year')";
                $result = mysqli_query($dbc, $query);

                $success = "Company Information Saved";
            }
        }
    }
    
    else
    {
        //update the item.
        
        //check if the file was uploaded. if yes update it. 
        // else don't
        if($upload == TRUE)
        {
            //update logo too
            
            //upload photo before saving
            if(move_uploaded_file($tmp_name, $photo_location))
            {
                //update the database
                $query = "UPDATE `company` SET "
                        . " `company_name` = '$company_name', `location` = '$location', "
                        . " `email` = '$email', `contact` = '$contact', "
                        . " `pobox` = '$pobox', `photo` = '$photo_location', "
                        . " `activity` = '$activity', `manager` = '$manager', "
                        . " `manager_email` = '$manager_email', `manager_contact` = '$manager_contact', "
                        . " `tax_regime` = '$tax_regime', `tax_number` = '$tax_number', "
                        . " `financial_year` = '$fiscal_year'"
                        . ""
                        . " WHERE `id` = '1'";
                $result  = mysqli_query($dbc, $query)
                        or die("Error");

                $success = "Company Information Saved";
            }
            else
            {
                $error = "Could not Upload file";
            }
        }
        else
        {
            //dont update the logo.
            //update the database
                $query = "UPDATE `company` SET "
                        . " `company_name` = '$company_name', `location` = '$location', "
                        . " `email` = '$email', `contact` = '$contact', "
                        . " `pobox` = '$pobox', "
                        . " `activity` = '$activity', `manager` = '$manager', "
                        . " `manager_email` = '$manager_email', `manager_contact` = '$manager_contact', "
                        . " `tax_regime` = '$tax_regime', `tax_number` = '$tax_number', "
                        . " `financial_year` = '$fiscal_year'"
                        . ""
                        . " WHERE `id` = '1'";
                $result  = mysqli_query($dbc, $query)
                        or die("Error");

                $success = "Company Information Saved";
        }
        
    }
    
    
    
    
}

//get the company info
$query  = "SELECT * FROM `company` ORDER BY `id` DESC LIMIT 1";
$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) == 1)
{
    while($row = mysqli_fetch_array($result))
    {
        //get all the results.
        $company_name = $row['company_name'];
        $location = $row['location'];
        $email = $row['email'];

        $pobox = $row['pobox'];
        $activity = $row['activity'];
        $contact = $row['contact'];

        $manager = $row['manager'];
        $manager_contact = $row['manager_contact'];
        $manager_email = $row['manager_email'];

        $tax_regime = $row['tax_regime'];
        $tax_number = $row['tax_number'];
        $financial_year = $row['financial_year'];

        $photo = $row['photo'];
    }
}
else
{
    //get all the results.
        $company_name = '';
        $location = '';
        $email = '';

        $pobox = '';
        $activity = '';
        $contact = '';

        $manager = '';
        $manager_contact = '';
        $manager_email = '';

        $tax_regime = '';
        $tax_number = '';
        $financial_year = '';

        $photo = '';
}

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>



<form action="setup_company.php" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="page-header">
        <h3>Setup Company</h3>
    </div>
    <div class="row">
        
        <?php
        require_once './includes/notifications.php';
        ?>
        
        
        <div class="col-md-5">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="control-label col-md-3">
                        Business Name
                        <span class="text-danger text-bold">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="business_name" required="true"
                               value="<?php echo $company_name; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-md-3">
                        Location
                        <span class="text-danger text-bold">*</span>
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="location" required="true"
                               value="<?php echo $location; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-md-3">Email:</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email"
                               value="<?php echo $email; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="control-label col-md-5">
                        Contact:
                        <span class="text-danger text-bold">*</span>
                    </label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="contact" required="true"
                               value="<?php echo $contact; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-md-5">P O Box:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="pobox"
                               value="<?php echo $pobox; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="">
                <input type="file" class="form-control" name="logo">
                <strong>Logo</strong>
                
                <div class="im" style="height: 70px;">
                    <img src="<?php echo $photo; ?>" alt="Company Logo" style="height: 70px;">
                </div>
            </div>
        </div>

    </div>


    <div class="row" style="margin-top: 10px">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="control-label col-md-9">Business Activity</label>
                <div class="col-md-10 col-md-offset-1">
                    <textarea name="activity" class="form-control" rows="6" 
                              placeholder="Enter the activities of your business here"
                              
                              ><?php echo $activity; ?></textarea>
                </div>
                
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="control-label col-md-9">Business Manager/Owner</label>
                <div class="col-md-11">
                    <input type="text" class="form-control" name="manager"
                           value="<?php echo $manager; ?>" >
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-3">contact</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="manager_contact"
                           value="<?php echo $manager_contact; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-md-3">Email:</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" name="manager_email"
                           value="<?php echo $manager_email; ?>">
                </div>
            </div>   
        </div>

    </div>


    <div class="row">
        <div class="col-md-7 col-md-offset-2" style="margin-top: 20px;">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="control-label col-md-3">Taxt Regime</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="tax_regime"
                               value="<?php echo $tax_regime; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-md-3">Tax Payer Number</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="tax_number"
                               value="<?php echo $tax_number; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-md-3">Financial Year</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="financial_year"
                               value="<?php echo $financial_year; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="btn-group col-md-4" style="float: right;">
        <div class="btn-group">
            <input class="btn btn-success" style="margin-right: 10px;" value="Save" name="submit" type="submit">

            <a class="btn btn-success" style="margin-right: 10px;" href="setup_company.php" title="Cancel and Start Again">Cancel</a>

            <a class="btn btn-success" style="margin-right: 10px;" href="index.php" title="Close">CLose</a>
        </div>
    </div>
</div>
    
</form>

<?php
require_once './includes/bottom.php';
?>