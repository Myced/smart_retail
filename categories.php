<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';
require_once './includes/day.php';

$db = new dbc();
$dbc = $db->connect();


$edit = FALSE;


if(isset($_GET['id']))
{
    //grab the id. then grab the action
    if(isset($_GET['id']))
    {
        $id = filter($_GET['id']);
    }
    else
    {
        $id = '';
    }
    
    if(isset($_GET['action']))
    {
        $action = filter($_GET['action']);
    }
    else
    {
        $action = '';
    }
    
    //now do the action
    if(isset($action))
    {
        if($action === 'del')
        {
            //delete the category
            $query = "DELETE FROM `categories` WHERE `id` = '$id'";
            $result = mysqli_query($dbc, $query);

            $success = "Category Deleted";
        }
        elseif($action === 'deact')
        {
            $query = "UPDATE `categories` SET `status` = '0'"
                    . " WHERE `id` = '$id'";
            $result = mysqli_query($dbc, $query);

            $success = "Category Deactivated ";
        }
        elseif($action === 'act')
        {
            $query = "UPDATE `categories` SET `status` = '1'"
                    . " WHERE `id` = '$id'";
            $result = mysqli_query($dbc, $query);

            $success = "Category Activated ";
        }
        elseif($action === 'edit')
        {
            $edit = TRUE;

            $query = "SELECT * FROM `categories` WHERE `id` = '$id'";
            $result = mysqli_query($dbc, $query);

            $edit_data = $result;
        }

        else
        {
            $warning = "Unknown Action";
        }
    }
    
}
else 
{
    //
    if(isset($_POST['update']))
    {
        //grab the variables and update
        $id = filter($_POST['edit_id']);
        $category = filter($_POST['category']);
        $status = filter($_POST['status']);
        
        $query = "UPDATE `categories` SET "
                . " `category` = '$category', "
                . " `status` = '$status'"
                . " WHERE `id` = '$id'";
        $result = mysqli_query($dbc, $query);
        
        $success = "Category Updated";
    }
    
    if(isset($_POST['save']))
    {
        //gather the things and insert
        $category = filter($_POST['category']);
        $status = filter($_POST['status']);
        
        $query = "INSERT INTO  `categories` SET "
                . " `id` = 0, "
                . " `category` = '$category', "
                . " `status` = '$status'";
        $result = mysqli_query($dbc, $query);
        
        $success = "Category Added";
    }
}

/**
 * set up page active links
 */
$sidebar = "settings";
$sublink = "more";

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>
<div class="row">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header" >Manage Categories</h1>
        </div>
    </div>

    <?php
    require_once './includes/notifications.php';
    ?>

    <div class="row">
        <div class="col-md-6">
            <?php 
            if(isset($edit) && $edit == TRUE)
            {
                ?>
            <h3 class="page-header">
                Edit Category
            </h3>
            
            <div class="row">
                <form class="form-horizontal" action="categories.php" method="POST">
                    <?php 
                    while($row = mysqli_fetch_array($edit_data))
                    {
                        ?>
                    
                    <input type="hidden" name="edit_id" 
                                value="<?php echo $row['id']; ?>">
                    
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Category Name
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="category" required="true"
                                   placeholder="Enter Category Name" value="<?php echo $row['category']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Status
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-7">
                            <select name="status" class="form-control">
                                <option value="--">--SELECT--</option>
                                <option value="1" <?php  if($row['status'] == 1) echo 'selected'?> >Active</option>
                                <option value="0" <?php  if($row['status'] == 0) echo 'selected' ?> >Deactivated</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            
                        </label>
                        <div class="col-md-8">
                            <input type="submit" class="btn btn-primary" name="update" value="Update"
                                   >
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
                <?php
            }
            else
            {
                ?>
            <h3 class="page-header">
                Add New Category
            </h3>
            
            <div class="row">
                <form class="form-horizontal" action="categories.php" method="POST">
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Category Name
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="category" required="true"
                                   placeholder="Enter Category Name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            Status
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-7">
                            <select name="status" class="form-control">
                                <option value="--">--SELECT--</option>
                                <option value="1">Active</option>
                                <option value="0">Deactivated</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">
                            
                        </label>
                        <div class="col-md-8">
                            <input type="submit" class="btn btn-primary" name="save" value="Save Category"
                                   >
                        </div>
                    </div>
                    
                </form>
            </div>
                <?php
            }
            
            ?>
        </div>
        
        <!--column to show categories.-->
        <div class="col-md-6">
            <h3 class="page-header">
                Manage Categories
            </h3>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed white-background">
                    <tr> 
                        <th class="text-center" colspan="4">
                            Active  Categories
                        </th>
                    </tr>
                    <tr>
                        <th>
                            N<sup>o</sup>
                        </th>
                        <th>
                            Category Name
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    
                    <?php
                    $dbc  = $db->connect();
                    
                    $query = "SELECT * FROM `categories` WHERE `status` = '1'";
                    $result = mysqli_query($dbc, $query);
                    
                    if(mysqli_num_rows($result) == 0)
                    {
                        ?>
                    <tr>
                        <td class="text-center" colspan="3">
                            <strong class="text-primary">No Active Categories</strong>
                        </td>
                    </tr>
                        <?php
                    }
                    else
                    {
                        $count = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>
                    <tr>
                        <td>
                            <?php echo $count++; ?>
                        </td>

                        <td>
                            <?php echo $row['category']; ?>
                        </td>

                        <td>
                            <a href="categories.php?id=<?php echo $row['id']; ?>&action=edit"
                               class="btn btn-xs btn-primary" title="Edit This Category name">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a href="categories.php?id=<?php echo $row['id']; ?>&action=deact"
                               class="btn btn-xs btn-warning" title="Deactivate This Category">
                                <i class="fa fa-times"></i>
                            </a>
                            
                            <a href="categories.php?id=<?php echo $row['id']; ?>&action=del"
                               class="btn btn-xs btn-danger" title="Delete This Category">
                                <i class="fa fa-trash"></i>
                            </a>
                            
                        </td>
                    <tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-condensed white-background">
                    
                    <tr>
                        <th class="text-center" colspan="4">
                            Deactivated Categories
                        </th>
                    </tr>
                    
                    <tr>
                        <th>
                            N<sup>o</sup>
                        </th>
                        <th>
                            Category Name
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    
                    <?php
                    $dbc  = $db->connect();
                    
                    $query = "SELECT * FROM `categories` WHERE `status` = '0'";
                    $result = mysqli_query($dbc, $query);
                    
                    if(mysqli_num_rows($result) == 0)
                    {
                        ?>
                    <tr>
                        <td class="text-center" colspan="3">
                            <strong class="text-primary">No Deactivated Categories</strong>
                        </td>
                    </tr>
                        <?php
                    }
                    else
                    {
                        $count = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>
                    <tr>
                        <td>
                            <?php echo $count++; ?>
                        </td>

                        <td>
                            <?php echo $row['category']; ?>
                        </td>

                        <td>
                            <a href="categories.php?id=<?php echo $row['id']; ?>&action=act"
                               class="btn btn-xs btn-success" title="Activate This Category">
                                <i class="fa fa-check"></i>
                            </a>
                            
                            <a href="categories.php?id=<?php echo $row['id']; ?>&action=del"
                               class="btn btn-xs btn-danger" title="Delete This Category">
                                <i class="fa fa-trash"></i>
                            </a>

                        </td>
                    <tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</div>


<?php
require_once './includes/bottom.php';
?>