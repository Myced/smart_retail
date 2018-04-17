<div class="table-links">
    <div class="row" >
        <div class="col-md-12" >
            <div class="heading" style="border-bottom: 2px solid black;">
                Settings
            </div>
        </div>
    </div>
    <div class="row"style="margin-top: 5px;">
        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "setup_company") echo "sublink_active"; ?>" 
               href="setup_company.php">
                Setup Company
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "setup_agent") echo "sublink_active"; ?>" 
               href="setup_agent.php">
                Setup Agent
            </a>
        </div>

        <div class="col-md-3">
            <a class="sublink <?php if ($sublink == "setup_user") echo "sublink_active"; ?>" 
               href="setup_user.php">
                Setup User
            </a>
        </div>

        <div class="col-md-3">
            <button class="sublink btn-block dropdown-toggle link-btn" data-toggle="dropdown">
                More Settings
                <span class="fa fa-caret-down"></span>
            </button>

            <ul class="dropdown-menu my_submenu">
                <li>
                    <a href="categories.php">
                        Setup Product Categories
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="product_units.php">
                        Setup Product Units
                    </a>
                </li>
                
                
            </ul>
        </div>


    </div>


</div>