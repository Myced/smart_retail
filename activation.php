<?php

require_once './includes/class.dbc.php';
require_once './includes/functions_home.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();


$one_day = (24*60*60);

///if a licence key has been entered. Then activate the product
if(isset($_POST['validate']))
{
    //grab the licence key sent
    $key = filter($_POST['licence']);
    
    $hash = hash_key($key);
    
    //check that this key has not been used yet.
    $query = "SELECT * FROM `activation` WHERE  `licence_key` = '$hash'";
    $result = mysqli_query($dbc, $query)
            or die("Could not validate key");
    
    if(mysqli_num_rows($result) == 0)
    {
        //first check for key validity
        $query = "SELECT * FROM `product_keys` WHERE `hash` = '$hash'";
        $result = mysqli_query($dbc, $query)
                or die("Could not verify product key");

        if(mysqli_num_rows($result) == 0)
        {
            //its not a valid key
            $activate_error = "Invalid Product Key";
        }
        else
        {
            //now check product validity and activate it.
            //now activate the product.
            //first check if the product had any active plan.

            $query = "SELECT * FROM `activation` ORDER BY `id` DESC LIMIT 1";
            $result = mysqli_query($dbc, $query)
                    or die("Could not check for product Activation");

            if(mysqli_num_rows($result) == 0)
            {
                //product has not been activated. 
                //so just activate it.

                //the currend date and time.
                $start_date = date("d/m/Y"); 
                $start_time = date("h:i:s a");

                //the end date will be the current date plus 365 days.
                $addition = 365 * (24 * 60 * 60);

                $now = date('m/d/Y H:i:s');

                $string_time = strtotime($now);

                //now get the expiry date and time.
                $end_string = $string_time + $addition;

                $end_date = date("d/M/Y", $end_string);
                $end_time = date("h:i:s a", $end_string);

                $end_date_time = date("m/d/Y H:i:s", $end_string);

                //now insert into the database.
                $query = "INSERT INTO `activation` "
                        . " (`id`, `licence_key`, `start_date`, `start_time`, "
                        . " `end_date`, `end_time`, `end_date_time`, `time_activated`, "
                        . " `previous_key_expiry`, `user_id`) "
                        . ""
                        . " VALUES ( "
                        . " 0, '$hash', '$start_date', '$start_time', "
                        . " '$end_date', '$end_time', '$end_date_time', NOW(), "
                        . " '', '$user_id' ) ";
                $result = mysqli_query($dbc, $query)
                        or die("Could not Activate product.");
                
                //go ahead and end the trial period. Then indicate product activated.
                //
                $query = "UPDATE `trial` SET `in_trial` = '0', `product_activated` = '1'"
                        . " WHERE `id` = '1'";
                $result = mysqli_query($dbc, $query)
                        or die("Cannot activated product key");
                
                //now update the system. Set first run to be false
                $query = "UPDATE `first_run` SET `first_run` = '0'";
                $result = mysqli_query($dbc, $query);
    //            
                $activate_success = "Congratulations. Product Activated";
            }
            else
            {
                
                /////////////ITEMS TO BE NEEDED ///////////////
                //the currend date and time.
                $start_date = date("d/m/Y"); 
                $start_time = date("h:i:s a");

                //the end date will be the current date plus 365 days.
                $one_day = (24*60*60);
                
                $days = 365;
                
                //now check if the key has expired. 
                $now = date('m/d/Y H:i:s');
                $now_string = strtotime($now);
                
                
                //get previos activation and add a year to it.
                $query = "SELECT * FROM `activation` ORDER BY `id` DESC LIMIT 1";
                $result = mysqli_query($dbc, $query)
                        or die("Could not check for product Activation");
                
                //get its end date time and check how many days were left.
                while($row = mysqli_fetch_array($result))
                {
                    $end_date_time_prev = $row['end_date_time'];
                    
                }
                
                $end_string_2 = strtotime($end_date_time_prev);
                
                //now check if the licence had expired.
                $diff = $now_string - $end_string_2;
                
                
                if($diff >= 0)
                {
                    //it means the product had expired. so just 
                    $days += 0;
                }
                else
                {
                    //it means the product had not expired.
                    //Calculate the number of days left. and add
                    $num_days = abs(ceil($diff / $one_day));
                    
                    $days += $num_days;
                }
                
                $addition = $days * $one_day; //the number of days to add to the new end date 
                
                //now get the expiry date and time.
                $end_string = $now_string + $addition;
                
                $end_date = date("d/M/Y", $end_string);
                $end_time = date("h:i:s a", $end_string);

                $end_date_time = date("m/d/Y H:i:s", $end_string);
                
                //now insert into the database.
                $query = "INSERT INTO `activation` "
                        . " (`id`, `licence_key`, `start_date`, `start_time`, "
                        . " `end_date`, `end_time`, `end_date_time`, `time_activated`, "
                        . " `previous_key_expiry`, `user_id`) "
                        . ""
                        . " VALUES ( "
                        . " 0, '$hash', '$start_date', '$start_time', "
                        . " '$end_date', '$end_time', '$end_date_time', NOW(), "
                        . " '', '$user_id' ) ";
                $result = mysqli_query($dbc, $query)
                        or die("Could not Activate product.");
                
                $query = "UPDATE `trial` SET `in_trial` = '0', `product_activated` = '1'"
                        . " WHERE `id` = '1'";
                $result = mysqli_query($dbc, $query);
                
                //now update the system. Set first run to be false
                $query = "UPDATE `first_run` SET `first_run` = '0'";
                $result = mysqli_query($dbc, $query);
    //            
                $activate_success = "Congratulations. Product Activated";
            }
        } //end of if the key is valid.
    } // end if the key result is zero in activation
    else
    {
        //the key has already been used. hence its invalid
        $activate_error = "Sorry. This key has already been used";
    }
    
} 

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<div class="row">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header" >Product Activation</h1>
        </div>
    </div>

    <?php
    require_once './includes/notifications.php';
    ?>

    <div class="row">
        <div class="col-md-6">
            <h2 class="page-header">
                Activation 
            </h2>
            
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="POST">
                        <div class="box box-warning box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Enter Licence Key</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body text-center">

                                <strong>
                                    Please Enter a Valid Licence Key
                                </strong>

                                <br>
                                <br>
                                <input type="text" class="form-control licence" name="licence" 
                                            placeholder="XX650-89FTG-G74JHF">

                                <br>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <div class="text-center">
                                    <button type="submit" name="validate" class="btn btn-success btn-block">
                                        <i class="fa fa-check"></i>
                                        Validate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.box -->
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <h2 class="page-header">
                Product Status
            </h2>
            
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Current Activation</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <?php
                //check avtivation.
    
                $query = "SELECT * FROM `trial` LIMIT 1";
                $result = mysqli_query($dbc, $query);

                if(mysqli_num_rows($result) == 1)
                {
                    //then check for values inside.
                    while($row = mysqli_fetch_array($result))
                    {
                        $in_trial = $row['in_trial'];
                        $expired = $row['expired'];
                        $start_date = $row['start_date'];
                        $end_date = $row['end_date'];
                        $end_date_time = $row['end_date_time'];
                        $product_activated = $row['product_activated'];
                    }

                    //first check if the product has been activated.
                    if($product_activated == TRUE)
                    {
                        //check if the key has expired.
                        $query = "SELECT * FROM `activation` "
                                . "     ORDER BY `id` DESC  LIMIT 1";
                        $result = mysqli_query($dbc, $query)
                                or die("Could not check product activation");

                        //if the number of rows is 1. else the key is not activated.
                        if(mysqli_num_rows($result) == 1)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                //grab values.
                                $activation_expired = $row['key_expired'];
                                $key_expired_date = $row['end_date'];
                                $key_expired_time = $row['end_time'];
                                $key_end_date_time = $row['end_date_time'];
                            }

                            //if the product has expired. then prompt for another key
                            if($activation_expired == TRUE)
                            {
                                $key_expired = TRUE;
                            }
                            else
                            {
                                $key_active = TRUE;
                                //calculate the number of days left.
                                $date = date("m/d/Y H:i:s");
                                $one_day = 24*60*60;
                                
                                
                                $e_day = strtotime($key_end_date_time); //string representation of ending timestamp
                                
                                $today = strtotime($date);

                                $diff = $today - $e_day;

                                $no_days = abs(ceil($diff / $one_day));

                                $days_left = $no_days;
                            }
                        }
                        else
                        {
                            $key_expired = TRUE;
                        }
                    }
                    else
                    {
                        //the product has not been activated. so check on the trial period.
                        if($expired == TRUE)
                        {
                            
                            $trial_expired = TRUE;
                            $trial_end_date = $end_date;
                            $trial_end_time = time_from_timestamp($end_date_time);
                        }
                        else
                        {
                            //Show the trial status
                            $trial_active = TRUE;
                            //Calculate the necessary items and show.
                            $trial_start_date = $start_date;
                            $trial_end_date = $end_date;
                            $trial_end_time = time_from_timestamp($end_date_time);
                            $date = date("m/d/Y H:i:s");
                            $one_day = 24*60*60;

                            $s_date = get_date($trial_start_date);

                            $s_string = strtotime($s_date);
                            $today = strtotime($date);

                            $diff = $today - $s_string;

                            $no_days = ceil($diff / $one_day);

                            $left = 30 - $no_days;
                        }
                    }

                }
                else
                {
                    //the person did not enter into a trial period
                    //check if the key has expired.
                    $query = "SELECT * FROM `activation` "
                            . "     ORDER BY `id` DESC  LIMIT 1";
                    $result = mysqli_query($dbc, $query)
                            or die("Could not check product activation");

                    //if the number of rows is 1. else the key is not activated.
                    if(mysqli_num_rows($result) == 1)
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            //grab values.
                            $activation_expired = $row['key_expired'];
                            $key_expired_date = $row['end_date'];
                            $key_expired_time = $row['end_time'];
                            $key_end_date_time = $row['end_date_time'];
                        }

                        //if the product has expired. then prompt for another key
                        if($activation_expired == TRUE)
                        {
                            $key_expired = TRUE;
                        }
                        else
                        {
                            $key_active = TRUE;
                            //calculate the number of days left.
                            $date = date("m/d/Y H:i:s");
                            $one_day = 24*60*60;


                            $e_day = strtotime($key_end_date_time); //string representation of ending timestamp

                            $today = strtotime($date);

                            $diff = $today - $e_day;

                            $no_days = abs(ceil($diff / $one_day));

                            $days_left = $no_days;
                        }
                    }
                    else
                    {
                        $no_plan = TRUE;
                    }
                }
                ?>
                <div class="box-body text-center">
                    <?php
                    if(isset($key_expired))
                    {
                        ?>
                    <h2 class="text-danger">
                            <i class="fa fa-times"></i>
                            Product has Expired
                        </h2>

                        <p class="error">
                            Your product key has expired.
                            
                            It expired  on 
                            <strong>
                                <?php echo $key_expired_date; ?>
                            </strong>
                            at 
                            <strong>
                                <?php echo $key_expired_time; ?>
                            </strong>

                            <br>

                            Please Enter a new product key to continue using the software

                            <br>
                            Thanks
                        </p>
                        <?php
                    }
                    
                    if(isset($key_active))
                    {
                        ?>
                    <h2 class="text-success">
                            <i class="fa fa-check"></i>
                            Product Activated.
                        </h2>

                        <p class="">
                            Your product key is still active
                            <br>
                            Your key will expire on 
                            <strong>
                                <?php echo $key_expired_date; ?>
                            </strong>
                            at 
                            <strong>
                                <?php echo $key_expired_time; ?>
                            </strong>

                            <br>

                            You have <strong> <?php echo $days_left; ?> days</strong> left

                            Thanks
                        </p>
                        <?php
                    }
                    
                    if(isset($trial_active))
                    {
                        ?>
                    <h2 class="">
                            <i class="fa "></i>
                            Trial Software
                        </h2>

                        <p class="">
                            Your are current using a trial of this software. Please consider purchasing a licence key
                            <br>
                            Your trial will end on
                            <strong>
                                <?php echo $trial_end_date; ?>
                            </strong>
                            at 
                            <strong>
                                <?php echo $trial_end_time; ?>
                            </strong>

                            <br>

                            You have <strong> <?php echo $left; ?> days</strong> left
                            <br>
                            Thanks
                        </p>
                        <?php
                    }
                    if(isset($trial_expired))
                    {
                        ?>
                    <h2 class="text-danger">
                            <i class="fa fa-times"></i>
                            Trial Over
                        </h2>

                        <p class="error">
                            Your trial Period is over. Please get a licence key to continue using the product.
                            <br>
                            It ended on 
                            <strong>
                                <?php echo $trial_end_date; ?>
                            </strong>
                            at 
                            <strong>
                                <?php echo $trial_end_time; ?>
                            </strong>

                            <br>
                            <strong>
                                Please enter a product key
                            </strong>

                            <br>
                            Thanks
                        </p>
                        <?php
                    }
                    if(isset($no_plan))
                    {
                        ?>
                    <h2 class="">
                            Not Activated
                        </h2>

                        <p class="">
                            You have not activated nor started a trial of the software.
                            <br>
                            Please enter your product key in the box beside to activate your product.
                            <br>
                            Or Start a trial by clicking on the button below.
                            <br>
                            <br>
                            <a href="home.php?start_trial=TRUE" class="btn btn-info">
                                Start Free Trial
                            </a>
                            <br>
                            <br>
                            Thanks
                        </p>
                        <?php
                    }
                    ?>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                     
                </div>
            </div>
        </div>
    </div>

</div>


<?php
require_once './includes/bottom.php';
?>