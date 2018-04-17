<div class="table-links">
    <div class="row" >
        <div class="col-md-12" >
            <div class="heading" style="border-bottom: 2px solid black;">
                Customer
            </div>
        </div>
    </div>
    <div class="row"style="margin-top: 5px;">
        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "setup_customer") echo "sublink_active"; ?>" 
               href="setup_customer.php">
                Setup Customer
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "customer_list") echo "sublink_active"; ?>" 
               href="customer_list.php">
                Customer List
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "customer_transaction") echo "sublink_active"; ?>" 
               href="customer_transaction.php">
                Customer Transcation
            </a>
        </div>

        <div class="col-md-3">
            <button class="sublink btn-block dropdown-toggle link-btn" data-toggle="dropdown">
                More
                <span class="fa fa-caret-down"></span>
            </button>

            <ul class="dropdown-menu my_submenu">
                <li>
                    <a href="top10customers.php">
                        Top 10 Customers
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="product_units.php">
                        
                    </a>
                </li>
                
                
            </ul>
        </div>


    </div>


</div>