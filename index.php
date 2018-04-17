<?php
//just simply redirect to the home.php page
header("Location: home.php");

?>

<!DOCTYPE>

<html>
    <head>
        <meta charset="utf-8">
        <title> Smart Retail</title>
        
        <!--css style sheeted-->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/church.css" type="text/css">
        <link rel="stylesheet" href="css/font-awesome.css" type="text/css">
        <link rel="stylesheet" href="css/animate.css" type="text/css">
        <link rel="stylesheet" href="css/AdminLTE.css" type="text/css">
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
        <link rel="stylesheet" href="css/select2.css" type="text/css">
        <link rel="stylesheet" href="css/smart_retail.css" type="text/css">
        
        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/wow.js"></script>
        <script src="js/select2.full.js"></script>
        <script src="js/bootstrap3-typeahead.js"></script>
        <script src="js/jquery.preimage.js"></script>
    </head>
    
    <body>
        <div class="main">
            
            <!--page side bar-->
            <div class="sidebar">
                <div class="content">
                    
                    <div class="name">
                        SR <small class="small">Smart Retail </small>
                    </div>
                    
                    <ul>
                        <li>
                            <a href="#" class="sidebar-link">
                                <i class="fa fa-home"></i>
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="sell_products.php" class="sidebar-link">
                                Sell
                            </a>
                        </li>

                        <li>
                            <a href="new_product.phpw" class="sidebar-link">
                                Enter Inventory
                            </a>
                        </li>

                        <li>
                            <a href="issue_inventory.php" class="sidebar-link">
                                Issue Inventory
                            </a>
                        </li>
                        
                        <li>
                            <a href="#" class="sidebar-link">
                                Returned Inventory
                            </a>
                        </li>
                        
                        <li>
                            <a href="#" class="sidebar-link">
                                Reports
                            </a>
                        </li>
                        
                        <li>
                            <a href="setup_company.php" class="sidebar-link sidebar-active">
                                <i class="fa fa-gear fa-1x rotateItem"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end of side bar--> 
            
            <!--start of page main content-->
            <div class="main-content">
                
                <!--content goes here-->
                <div class="header-content">
                    <div class="main-header">
                        Sales & Inventory Management System
                    </div>
                    <div class="logo">
                        <div class="image-box">
                            <img src="images/no.jpg" alt="Logo">
                        </div>
                    </div>
                </div>
                
                <div class="page-heading">
                    <div class="">
                        
                        <div class="table-links">
                            <div class="row" >
                                <div class="col-md-12" >
                                    <div class="heading" style="border-bottom: 2px solid black;">
                                        Inventory
                                    </div>
                                </div>
                            </div>
                            <div class="row"style="margin-top: 5px;">
                                <div class="col-md-3">
                                    <a class="sublink sublink_active" href="#">
                                        Enter New Product
                                    </a>
                                </div>
                                
                                <div class="col-md-3">
                                    <a class="sublink" href="#">
                                        Enter New Product
                                    </a>
                                </div>
                                
                                <div class="col-md-3">
                                    <a class="sublink" href="#">
                                        Enter New Product
                                    </a>
                                </div>
                                
                                <div class="col-md-3">
                                    <button class="sublink btn-block dropdown-toggle link-btn" data-toggle="dropdown">
                                        Report
                                        <span class="fa fa-caret-down"></span>
                                    </button>
                                    
                                    <ul class="dropdown-menu my_submenu">
                                        <li>
                                            <a href="#">
                                                cedric
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Link 2
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                
                            </div>
                            
                            
                        </div>
                       
<!--                        <table class="table-links">
                            <tr>
                                <th>
                                    Inventory
                                </th>
                            </tr>
                            <tr>
                                <td class="sublink_td">
                                    <a class="sublink" href="#">
                                        Enter New Product
                                    </a>
                                </td>
                                <td class="sublink_td sublink_active">
                                    <a class="sublink " href="#">
                                        Inventory list
                                    </a>
                                </td>
                                <td class="sublink_td">
                                    <a class="sublink" href="#">
                                        Invent
                                    </a>
                                </td>
                                <td class="sublink_td">
                                    <button class="sublink btn-block dropdown-toggle" data-toggle="dropdown">
                                        Report
                                    </button>
                                    
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#">
                                                cedric
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>-->
                    </div>
                </div>
                
                <div class="myContent">
                    Hompage
                </div>
            </div>
        </div>
    </body>
</html>
