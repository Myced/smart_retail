<div class="table-links">
    <div class="row" >
        <div class="col-md-12" >
            <div class="heading" style="border-bottom: 2px solid black;">
                Reports
            </div>
        </div>
    </div>
    <div class="row"style="margin-top: 5px;">
        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "purchase_history") echo "sublink_active"; ?>" 
               href="purchase_history.php">
                Purchase History
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "inventory_movement") echo "sublink_active"; ?>" 
               href="inventory_movement.php">
                Inventory Movement
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "available_stock") echo "sublink_active"; ?>" 
               href="available_stock.php">
                Available Stock
            </a>
        </div>

        <div class="col-md-3">
            <button class="sublink btn-block dropdown-toggle link-btn <?php if ($sublink == "more") echo "sublink_active"; ?>" data-toggle="dropdown">
                More Reports
                <span class="fa fa-caret-down"></span>
            </button>

            <ul class="dropdown-menu my_submenu">
                <li>
                    <a href="issued_stock_report.php">
                        Issued Stock Report
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="returned_stock.php">
                        Returned Stock Report
                    </a>
                </li>
                
                <li>
                    <a href="stock_count_control.php">
                        Inventory Valuation
                    </a>
                </li>
                
                <li>
                    <a href="inventory_expiry.php">
                        Inventory Expiry Report
                    </a>
                </li>
                
            </ul>
        </div>


    </div>


</div>