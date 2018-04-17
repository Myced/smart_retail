<!--<table class="table-links">
    <tr>
        <th>
            Sales
        </th>
    </tr>
    <tr>
        <td class="sublink_td <?php //if ($sublink == "sell_products") echo "sublink_active"; ?>">
            <a class="sublink" href="sell_products.php">
                Sell
            </a>
        </td>
        <td class="sublink_td  <?php //if ($sublink == "return_sales") echo "sublink_active"; ?>">
            <a class="sublink " href="return_products.php">
                Returned Sales
            </a>
        </td>
        <td class="sublink_td <?php //if ($sublink == "cash_withdrawal") echo "sublink_active"; ?>">
            <a class="sublink" href="withdrawal.php">
                Cash Withdrawal
            </a>
        </td>
        <td class="sublink_td">
            <a data-toggle="collapse" data-parent="#accordian" href="#user_panel" style="text-decoration: none;">
                <i class="fa fa-user" style="font-size: x-large"></i>
                Reports
                <i class="fa fa-caret-down" style="font-weight: bolder"></i>
            </a>

        </td>

    </tr>
</table>-->

<div class="table-links">
    <div class="row" >
        <div class="col-md-12" >
            <div class="heading" style="border-bottom: 2px solid black;">
                Sales
            </div>
        </div>
    </div>
    <div class="row"style="margin-top: 5px;">
        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "sell_products") echo "sublink_active"; ?>" 
               href="sell_products.php">
                Sell
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "return_sales") echo "sublink_active"; ?>" 
               href="return_products.php">
                Return Sales
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "sales_today") echo "sublink_active"; ?>" 
               href="today_sales.php">
                Sales Today
            </a>
        </div>

        <div class="col-md-3">
            <button class="sublink btn-block dropdown-toggle link-btn
                    <?php if ($sublink == "reports") echo "sublink_active"; ?>
                    " data-toggle="dropdown">
                Report
                <span class="fa fa-caret-down"></span>
            </button>

            <ul class="dropdown-menu my_submenu">
                <li>
                    <a href="general_sales_report.php">
                        General Sales Report
                    </a>
                </li>
                <li>
                    <a href="summary_sales_report.php">
                        Summary Sales Report
                    </a>
                </li>
                
                <li class="divider">
                    
                </li>
                <li class="dropdown-header text-center">
                    <strong>Other Reports</strong>
                </li>
                
                <li>
                    <a href="product_sales_report.php">
                        Product Sales Report
                    </a>
                </li>
                
                <li>
                    <a href="customer_sales_report.php">
                        Customer Sales Report
                    </a>
                </li>
                
                <li>
                    <a href="sales_agent_report.php">
                        Sales Agent Sales Report
                    </a>
                </li>
            </ul>
        </div>


    </div>


</div>
