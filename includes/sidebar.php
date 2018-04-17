<!--sidebar--> 
        <div class="container-fluid">
            <div class="side-navbar showHalfMenu showFullMenu" id="sideNav">
                <div class="side-nave-iner">
                    <ul>
                        <li class="side-li ">
                            <a href="home.php"><i class="fa fa-home text-gray" aria-hidden="true"> </i> <span class="showText">Home</span></a></li>
                        
                        <li> 
                            <a href="#" data-toggle="collapse" data-target="#products" class="collapsed" > 
                                <i class="fa fa-dollar text-danger"></i> <span class="nav-label">Sell</span> 
                                <span class="fa fa-caret-down pull-right fa-lg"></span> 
                            </a>
                            <ul class="sub-menu collapse" id="products">

                                <li><a href="sell_products.php">Sell</a></li>
                                <li><a href="return_products.php">Return Sales</a></li>
                                <li><a href="today_sales.php">Sales Today</a></li>
                                <li>
                                    <a href="#"data-toggle="collapse" data-target="#sales_report" class="collapsed active">Sales Reports
                                        <span class="fa fa-caret-down pull-right"></span>
                                    </a>
                                </li>
                                <ul class="sub-menu collapse second" id="sales_report">
                                    <li><a href="general_sales_report.php">General Sales Report</a></li>
                                    <li><a href="summary_sales_report.php">Summary Sales Report</a></li>
                                    <li class="divider"></li>
                                    <li><a href="product_sales_report.php">Product Sales Report</a></li>
                                    <li><a href="customer_sales_report.php">Customer Sales Report</a></li>
                                    <li><a href="sales_agent_report.php">Sales AGent Sales Report</a></li>
                                </ul>

                            </ul>
                      </li>
                        
                        <li class="side-li">
                            <a href="#" data-toggle="collapse" data-target="#inventory" class="collapsed active">
                                <i class="fa fa-gift text-aqua" aria-hidden="true"></i>
                                <span class="showText"> Inventory</span>
                                <span class="fa fa-caret-down pull-right fa-lg"></span> 
                            </a>
                            
                            <ul class="sub-menu collapse" id="inventory">
                          
                                <li><a href="new_product.php">New Product</a></li>
                                <li><a href="product_list.php">Product List</a></li>
                                <li><a href="stock_update.php">Add Stock</a></li>
                                <li><a href="issue_inventory.php">Issue Inventory</a></li>
                                <li><a href="return_inventory.php">Return Inventory</a></li>
                                <li>
                                    <a href="#"data-toggle="collapse" data-target="#more_inventory" class="collapsed active">More on Inventory
                                        <span class="fa fa-caret-down pull-right"></span>
                                    </a>
                                </li>
                                <ul class="sub-menu  menu2  collapse second" id="more_inventory">
                                    <li><a href="returned_inventory.php">Returned Inventory</a></li>
                                    <li><a href="stock_count_control.php">Stock count / Control</a></li>
                                    <li><a href="stock_count_history.php">Stock count History</a></li>
                                    <li><a href="stock_update_report.php">Stock Addition Report</a></li>
                                    <li><a href="purchase_order.php">Purchase Order</a></li>
                                </ul>
                            </ul>
                        </li>
                        
                        <li class="side-li">
                            <a href="#" data-toggle="collapse" data-target="#customer" class="collapsed active">
                                <i class="fa fa-user text-lime" aria-hidden="true"></i>
                                <span class="showText"> Customers</span>
                                <span class="fa fa-caret-down pull-right "></span> 
                            </a>
                            
                            <ul class="sub-menu collapse" id="customer">
                          
                                <li><a href="setup_customer.php">Set Up Customer</a></li>
                                <li><a href="customer_list.php">Customer List</a></li>
                                <li><a href="customer_transaction_report.php">Customer Transaction Report</a></li>
                            </ul>
                        </li>
                        
                        <li class="side-li">
                            <a href="#" data-toggle="collapse" data-target="#reports" class="collapsed active">
                                <i class="fa fa-files-o text-orange" aria-hidden="true"></i>
                                <span class="showText"> Reports</span>
                                <span class="fa fa-caret-down pull-right fa-lg"></span> 
                            </a>
                            
                            <ul class="sub-menu collapse" id="reports">
                          
                                <li><a href="purchase_history.php">Purchase History</a></li>
                                <li><a href="available_stock.php">Available Stock</a></li>
                                <li><a href="returned_products.php">Returned Items Reports</a></li>
                                <li><a href="issued_stock_report.php">Issued Inventory Report</a></li>
                                <li><a href="returned_inventory.php">Returned Inventory Report</a></li>
                                <li>
                                    <a href="#"data-toggle="collapse" data-target="#more_reports" class="collapsed active">More on Inventory
                                        <span class="fa fa-caret-down pull-right"></span>
                                    </a>
                                </li>
                                <ul class="sub-menu collapse second" id="more_reports">
                                    
                                    <li><a href="inventory_expiry.php">Product Expiry</a></li>
                                    <li><a href="available_stock.php">Available Stock</a></li>
									<li><a href="group_movement.php">Inventory Movement</a></li>
									<li><a href="inventory_movement.php">Product Movement</a></li>
                                    <li><a href="inventory_valuation.php">Inventory Valuation</a></li>
                                </ul>
                            </ul>
                        </li>
                        
                        
                        <li class="side-li active_sidebar">
                            <a href="#" data-toggle="collapse" data-target="#settings" class="collapsed active">
                                <i class="fa fa-gear text-red" aria-hidden="true"></i>
                                <span class="showText"> Settings</span>
                                <span class="fa fa-caret-down pull-right "></span> 
                            </a>
                            
                            <ul class="sub-menu collapse" id="settings">
                          
                                <li><a href="setup_company.php">Setup Company</a></li>
                                <li><a href="setup_agent.php">Setup Agent</a></li>
                                <li><a href="setup_user.php">Setup User</a></li>
                                <li><a href="categories.php">Setup Product Categories</a></li>
                                <li><a href="product_units.php">Setup Product Units</a></li>
                                
                            </ul>
                        </li>
                        
                        <li class="side-li">
                            <a href="activation.php">
                                <i class="fa fa-key text-aqua" aria-hidden="true"> </i>
                                <span class="showText">Activation</span>
                            </a>
                        </li>
                        
                        <li class="side-li lastt ">
                            <a href="#" id="about_btn"><i class="fa fa-question-circle text-primary" aria-hidden="true"></i>
                                <span class="showText"> About</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">