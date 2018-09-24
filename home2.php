<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
include_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();

$one_day = (24*60*60);


function update_product_trial()
{
    global $dbc; //database connection
    global $one_day; // the value of a day

    //check if the product has started with the trial.
    $query = "SELECT * FROM `trial` ORDER BY `id` DESC"
            . " LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Could not check for product activation");
    if(mysqli_num_rows($result) == 1)
    {
        //now check for expiry.
        while($row = mysqli_fetch_array($result))
        {
            $key_id = $row['id'];
            $end_date_time = $row['end_date_time'];
        }

        //calculate the number of days left.
        $now = date('m/d/Y H:i:s');

        //convert the times to strings so we can easily calculate.
        $now_string = strtotime($now);
        $end_date_time_string = strtotime($end_date_time);


        $diff =  $end_date_time_string - $now_string;

        if($diff <= 0)
        {
            //it means the key has expired.
            // update the system indicating that the key has expired.
            $query = "UPDATE `trial` SET `expired` = '1', "
                    . "     `in_trial` = '0' "
                    . "     WHERE `id` = '$key_id'";
            $result = mysqli_query($dbc, $query)
                    or die("Error");
        }
        else
        {
            $query = "UPDATE `trial` SET `expired` = '0', "
                    . "     `in_trial` = '1' "
                    . "     WHERE `id` = '$key_id'";
            $result = mysqli_query($dbc, $query)
                    or die("Error");
        }

    }
}

function update_licence_key()
{
    //first check if a product key has been inserted.
    global $dbc; //database connection
    global $one_day; // the value of a day

    $query = "SELECT * FROM `activation` "
            . "     ORDER BY `id` DESC  LIMIT 1";
    $result = mysqli_query($dbc, $query)
            or die("Could not check product activation");

    if(mysqli_num_rows($result) == 0)
    {
        //do nothing.
        // it mean a key has not yet been inserted.
    }
    else
    {
        // a key has been inserted.
        //check if it has expired.
        //check if the key has expired.
        while($row = mysqli_fetch_array($result))
        {
            //get the time the product key is expiring.
            $key_id = $row['id'];
            $key_end_date_time = $row['end_date_time'];
        }

        //calculate the number of days left.
        $now = date('m/d/Y H:i:s');

        //convert the times to strings so we can easily calculate.
        $now_string = strtotime($now);
        $end_date_time_string = strtotime($key_end_date_time);


        $diff =  $end_date_time_string - $now_string;

        if($diff <= 0)
        {
            //it means the key has expired.
            // update the system indicating that the key has expired.
            $query = "UPDATE `activation` SET `key_expired` = '1'"
                    . " WHERE `id` = '$key_id'";
            $result = mysqli_query($dbc, $query)
                    or die("Error");
        }
        else
        {
            $query = "UPDATE `activation` SET `key_expired` = '0'"
                    . " WHERE `id` = '$key_id'";
            $result = mysqli_query($dbc, $query)
                    or die("Error");
        }
    }
}


//here. deal with the product keys.
update_licence_key();
update_product_trial();


//now if the get for trial is set then activate it
if(isset($_GET['start_trial']))
{
    //then start the one month free trial.
    $query = "SELECT * FROM `trial`";
    $result  = mysqli_query($dbc, $query);

    if(mysqli_num_rows($result) > 0)
    {
        //then  the trial period had been initiated.
        //don't do it again.
    }
    if(mysqli_num_rows($result) == 0)
    {
        //its the first time the trial is ran. so start the one month free trail.
        $start_date = date('d/m/Y');
        $s_date = get_date($start_date);

        $interval = 30 * 24 * 60 * 60;

        $start_string = strtotime($s_date);

        $end_string = $start_string + $interval;

        $end_date = date("d/m/Y", $end_string);


        //process the ending time.
        $s_date_time = date("Y-m-d H:i:s");

        $e_dat_time = strtotime($s_date_time) + $interval;

        $e_date_time = date("m/d/Y H:i:s", $e_dat_time);

        //now insert intot the database
        $query = "INSERT INTO `trial` (`start_date`, `start_date_time`, "
                . " `end_date`, `end_date_time`, "
                . " `in_trial`, `expired` ) "
                . " "
                . " VALUES ('$start_date', '$s_date_time', "
                . " '$end_date', '$e_date_time', "
                . " '1', '0' ) ";
        $result = mysqli_query($dbc, $query)
                or die("Could not start your trial");

        //now update the system. Set first run to be false
        $query = "UPDATE `first_run` SET `first_run` = '0'";
        $result = mysqli_query($dbc, $query);

        $success = " You have Started Your One month Free Trial. "
                . ""
                . " It will expire on <strong>" . $end_date . " </strong> at "
                . " <strong> " . time_from_timestamp($e_date_time) . " </strong> ";

    }
}

//check if its the first time of running the software
$query = "SELECT `first_run` FROM `first_run` WHERE `id` = '1'";
$result = mysqli_query($dbc, $query)
         or die("Error. Could not check first run");

list($first_run) = mysqli_fetch_array($result);

//if the first run is true. then we have the option of either
// activating or trying it out.

if($first_run == TRUE)
{
    $show_activation = TRUE;

}
else
{
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
                }

                //if the product has expired. then prompt for another key
                if($activation_expired == TRUE)
                {
                    $licence_expired = TRUE;
                }
            }
            else
            {
                $show_activation = TRUE;
            }
        }
        else
        {
            //the product has not been activated. so check on the trial period.
            if($expired == TRUE)
            {
                $trial_expired = TRUE;
            }
            else
            {
                //Show the trial status
                $trial = TRUE;
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
                $licence_expired = TRUE;
            }
            else
            {
                //
            }
        }
        else
        {
            $show_activation = TRUE;
        }
    }


}






if(!isset($_SESSION['user_id']))
{
    //sned the person bacl to login
    header("Location: login.php");
}

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<div class="row">
    <h2 class="page-header">
        Welcome to Smart Retail
    </h2>

    <!--row for activation-->
    <?php

    //requrie the notification bar
    require_once './includes/notifications.php';

    if(isset($show_activation) && $show_activation == TRUE)
    {
        ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Activation.</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    Thanks for using smart Retail. Your Product is not actiated. Please Select One.
                    <span class="pull-right">
                        <a href="home.php?start_trial=TRUE" class="btn btn-info">
                            Start Free Trial
                        </a>
                    </span>

                    <span class="pull-right">
                        <a href="activation.php" class="btn btn-success">
                            Enter Product Code
                        </a>
                    </span>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
        <?php
    }


    if(isset($licence_expired) && $licence_expired == TRUE)
    {
        ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Your Licence Has Expired</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            Thanks for using smart Retail. We are Sorry your Licence has Expired.
                            It Expired on <strong><?= $key_expired_date; ?> </strong>
                            at

                            <strong> <?= $key_expired_time; ?> </strong>
                            <br>
                            Enter a Licence Key to continue Using the Product.
                        </div>
                    </div>



                    <div class="row">
                        <span class="pull-right">
                            <a href="activation.php" class="btn btn-success">
                                Enter Product Code
                            </a>
                        </span>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
        <?php
    }


    if(isset($trial_expired) && $trial_expired == TRUE)
    {
        ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Your Trail Period is over</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            Thanks for trying smart Retail. Your trial Period is over
                            It ended on  <strong><?= $end_date; ?> </strong>
                            at

                            <strong> <?= time_from_timestamp($end_date_time); ?> </strong>
                            <br>
                            Enter a Licence Key to continue Using the Product.
                        </div>
                    </div>



                    <div class="row">
                        <span class="pull-right">
                            <a href="activation.php" class="btn btn-success">
                                Enter Product Code
                            </a>
                        </span>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
        <?php
    }
    ?>

    <!--row for trial period.-->

    <?php
    if(isset($trial))
    {
        ?>
    <div class="row">
        <div class="marquee">
            <marquee>
                <<<<<
                <span class=" text-bold"> Thank You for using Smart Retail. </span>
                ..... This is a trial version of the software.
                 You have <strong>30 days</strong> to try it out.
                 ......

                 <span class="text-danger">
                    Your trial will expire on
                    <strong> <?= $trial_end_date; ?> </strong>
                    at

                    <strong> <?= $trial_end_time; ?> </strong> ......
                 </span>

                 You have tried the software for
                 <strong> <?= $no_days; ?> days</strong>

                 ...   You are left with
                 <strong> <?= $left; ?> days </strong>

                 >>>>>>

            </marquee>
        </div>
    </div>
        <?php
    }
    ?>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="fa fa-address-book"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sales Today</span>
                <span class="info-box-number">
                    <?php
                    $today_total = 0;
                    $query = "SELECT * FROM `sales` "
                            . " WHERE `day` = '$day' AND `month` = '$month' AND `year` = '$year'"
                            . "ORDER BY `id` ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");

                    while($row = mysqli_fetch_array($result))
                    {
                        $today_total += $row['total'];
                    }

                    echo number_format($today_total);
                    ?>
                    <small> FCFA</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Month Sales</span>
                <span class="info-box-number">
                    <?php
                    $today_total = 0;
                    $query = "SELECT * FROM `sales` "
                            . " WHERE `month` = '$month' AND `year` = '$year'"
                            . "ORDER BY `id` ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");

                    while($row = mysqli_fetch_array($result))
                    {
                        $today_total += $row['total'];
                    }

                    echo number_format($today_total);
                    ?>
                    <small> FCFA</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">INVENTORY</span>
                <span class="info-box-number">
                    <?php
                    $today_total = 0;
                    $query = "SELECT * FROM `products` ";
                    $result = mysqli_query($dbc, $query)
                            or die("Error");


                    echo $num = mysqli_num_rows($result);

                    ?>
                    <small>ITEMS</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow">
                <i class="fa fa-file-text"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">REORDER ITEMS</span>
                <span class="info-box-number">
                    <?php
                        $today_total = 0;
                        $query = "SELECT * FROM `products` "
                                . "WHERE `quantity` < `reorder_level` ";
                        $result = mysqli_query($dbc, $query)
                                or die("Error");


                        echo $num = mysqli_num_rows($result);
                    ?>
                    <small>ITEMS</small>
                </span>

            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-3">
        <a class="btn btn-lg btn-info btn-flat btn-block" href="sell_products.php">
            Sell Products
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-lg btn-danger btn-flat btn-block" href="new_product.php">
            New Product
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-lg btn-success btn-flat btn-block" href="product_list.php">
            Product List
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-lg btn-warning btn-flat btn-block" href="purchase_history.php">
            Purchase History
        </a>
    </div>
</div>
<!-- /.row -->

<br>
<div class="row">
    <!-- BAR CHART -->
    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Monthly Sales Report (<?php echo date("Y"); ?>)
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-condensed">
                    <tr>
                        <th>
                            Month
                        </th>

                        <th>
                            Amount Sold
                        </th>
                    </tr>
                    <?php
                    $final_total = 0;
                    for($i = 1; $i <= 12; $i++)
                    {
                        //selec
                        $month_total = 0;

                        //get the sales summary for that month
                        $query = "SELECT * FROM `sales` WHERE `month` = '$i'"
                                . " AND  `year` = '$year';";
                        $result = mysqli_query($dbc, $query)
                                or die("Could not query");
                        while($row  = mysqli_fetch_array($result))
                        {
                            $month_total += $row['total'];
                        }


                        //now add final total
                        $final_total += $month_total;
                        ?>
                    <tr>
                        <td>
                            <?php echo get_month($i); ?>
                        </td>
                        <td>
                            <?php echo number_format($month_total) . ' FCFA';  ?>
                        </td>
                    </tr>
                    <?php

                    }
                    ?>
                    <tr>
                        <th>
                            Total
                        </th>
                        <th>
                            <?php echo number_format($final_total) . ' FCFA'; ?>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Monthly Profit Report (<?php echo date("Y"); ?>)
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-condensed">
                    <tr>
                        <th>
                            Month
                        </th>

                        <th>
                            Amount Sold
                        </th>

                        <th>
                            Cost
                        </th>

                        <th>
                            Profit
                        </th>
                    </tr>
                    <?php
                    $final_total = 0;
                    $final_cost = 0;
                    $final_profit = 0;

                    for($i = 1; $i <= 12; $i++)
                    {
                        //selec
                        $month_total = 0;
                        $month_cost = 0;
                        $month_profit = 0;

                        //get the sales summary for that month
                        $query = "SELECT * FROM `sales` WHERE `month` = '$i'"
                                . " AND  `year` = '$year';";
                        $result = mysqli_query($dbc, $query)
                                or die("Could not query");
                        while($row  = mysqli_fetch_array($result))
                        {
                            $product_code = $row['product_code'];
                            $quantity = $row['quantity'];
                            $sale_total = $row['total'];

                            $month_total += $row['total'];

                            //we need to get the cost of the items.
                            $query = "SELECT `cost` FROM `products` WHERE `product_code` = '$product_code'";
                            $res = mysqli_query($dbc, $query);

                            list($cost) = mysqli_fetch_array($res);

                            $total_cost = $quantity * $cost;

                            $profit = $sale_total - $total_cost;

                            $month_cost += $total_cost;
                            $month_profit += $profit;
                        }


                        //now add final total
                        $final_total += $month_total;
                        $final_cost += $month_cost;
                        $final_profit += $month_profit;
                        ?>
                    <tr>
                        <td>
                            <?php echo get_month($i); ?>
                        </td>
                        <td>
                            <?php echo number_format($month_total);  ?>
                        </td>
                        <td>
                            <?php echo number_format($month_cost); ?>
                        </td>
                        <td>
                            <strong class="text-success">
                                <?php echo number_format($month_profit) . ' FCFA'; ?>
                            </strong>
                        </td>
                    </tr>
                    <?php

                    }
                    ?>
                    <tr>
                        <th>
                            Total
                        </th>
                        <th>
                            <?php echo number_format($final_total) . ' FCFA'; ?>
                        </th>
                        <th>
                            <?php echo number_format($final_cost) . ' FCFA'; ?>
                        </th>
                        <th>
                            <?php echo number_format($final_profit) . ' FCFA'; ?>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Sales</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Receipt N<sup>o</sup></th>
                                <th>Client</th>
                                <th>Items</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM `sales_ref`ORDER BY `id` DESC LIMIT 7";
                            $result = mysqli_query($dbc, $query);

                            while($row = mysqli_fetch_array($result))
                            {
                                ?>
                            <tr>
                                <td>
                                    <a href="#">
                                        <?php echo $row['ref']; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $row['sales_agent']; ?>
                                </td>
                                <td>
                                    <span class="label label-success">
                                        <?php echo $row['items_sold']; ?>
                                    </span>
                                </td>
                                <td>
                                   <?php echo number_format($row['total_price']) . ' FCFA'; ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="sell_products.php" class="btn btn-sm btn-info btn-flat pull-left">Sell</a>
                <a href="summary_sales_report.php" class="btn btn-sm btn-default btn-flat pull-right">View All Sales</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recently Added Products</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="products-list product-list-in-box">
                    <?php
                    $query = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT 6";
                    $result = mysqli_query($dbc, $query);
                    while($row = mysqli_fetch_array($result))
                    {
                    ?>
                    <li class="item">
                        <div class="product-img">

                        </div>
                        <div class="product-info">
                            <a href="#" class="product-title">
                                <?php echo $row['product_code']; ?>

                                <span class="label label-default pull-right">
                                    <?php echo number_format($row['unit_price']) . ' FCFA'; ?>
                                </span>
                            </a>
                            <span class="product-description">
                                <?php echo $row['product_name']; ?>
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    <?php
                    }
                    ?>

                </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="product_list.php" class="uppercase">View All Products</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?php
require_once './includes/bottom.php';
?>
