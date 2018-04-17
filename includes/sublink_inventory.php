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
            <a class="sublink <?php if ($sublink == "new_product") echo "sublink_active"; ?>" 
               href="new_product.php">
                New Product
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "product_list") echo "sublink_active"; ?>" 
               href="product_list.php">
                Product List
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "issue_inventory") echo "sublink_active"; ?>" 
               href="issue_inventory.php">
                Issue Inventory
            </a>
        </div>

        <div class="col-md-3">
            <button class="sublink btn-block dropdown-toggle link-btn
                    <?php if ($sublink == "more") echo "sublink_active"; ?>
                    " data-toggle="dropdown" style="padding-top: 3px;">
                More on Inventory
                <span class="fa fa-caret-down"></span>
            </button>

            <ul class="dropdown-menu my_submenu">
                <li>
                    <a href="return_inventory.php">
                        Return Inventory
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="returned_inventory.php">
                        Returned Inventory
                    </a>
                </li>
                
                <li>
                    <a href="stock_count_control.php">
                        Stock Count / Control
                    </a>
                </li>
                
                <li>
                    <a href="stock_count_history.php">
                        Stock Count History
                    </a>
                </li>
                
                <li>
                    <a href="purchase_order.php">
                        Purchase Order
                    </a>
                </li>
            </ul>
        </div>


    </div>


</div>