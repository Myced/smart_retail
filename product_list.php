<?php
require_once './includes/class.dbc.php';
require_once './includes/functions.php';

$db = new dbc();
$dbc = $db->connect();

//delete an account;
if(isset($_GET['idd']))
{
    $idd = filter($_GET['idd']);

    $action = filter($_GET['action']);

    if($action  == 'del')
    {
        //delete the item.
        $query = "DELETE FROM `products` WHERE `id` = '$idd'";
        $result = mysqli_query($dbc, $query)
            or die("Cannot Delete");

        $success = "Product  Deleted";
    }
}

//do page transactions here
//query initialisation
$results_per_page = 40; //number of results to show on a sigle page

//data manipulation
if(isset($_GET['page']))
{
    //get the page number
    $page_number = filter($_GET['page']);

    //Variable to maintain countring
    $inter  = $page_number - 1; //reduces the page numer in order to count
    $count = (int) ($inter * $results_per_page) + 1;
}
else
{
    $page_number = 1;

    //Variable to do countring
    $count = 1;
}

//START OF search results
if($page_number < 2)
{
    $start = 0;
}
 else {
     $start = (($page_number - 1) * ($results_per_page));
}

//total data in the database;
$query = "SELECT * from `products`";
$result  = mysqli_query($dbc, $query);

$total = mysqli_num_rows($result);

if($results_per_page >= 1)
{

   $number_of_pages = ceil($total/$results_per_page);

   if($number_of_pages < 1)
   {
       $page_count = 1;
   }
   else
   {
       $page_count = $number_of_pages;
   }

}
else
{
    $error = "Results Per page Cannot be zero or Less";
    $page_count = 1;
}
//end
$end = $results_per_page;

//now if page number is greater that
if($page_number > $page_count)
{
    $error = "That Page does not Exist";
}

//do the query here
$query = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT $start, $end";
$result = mysqli_query($dbc, $query)
        or die("Error");



/**
 * set up page active links
 */
$sidebar = "inventory";
$sublink = "product_list";


/******  END ****/

//now page content
require_once './includes/header.php';
require_once './includes/sidebar.php';
require_once './includes/heading.php';
?>

<br>
<div class="row">

    <br>
    <div class="row">
        <div class="text-center col-md-12">
            <h2 class="page-header"> Inventory List</h2>
        </div>
    </div>
    <br>
    <div class="row">
          <!--search bar-->
          <div class="col-md-5">
              <input type="search" class="form-control" name="search" placeholder="Search Here" id="search">
          </div>

          <div class="col-md-1">

          </div>

          <div class="col-md-6">

          </div>
      </div>

      <br>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
                  <div id="table_area">
                        <table class="table table-striped table-bordered text-center">
                            <tr style="background-color: inherit;">
                                <th> N<sup>o</sup> </th>
                                <th> Product Code</th>
                                <th> Product Name </th>
                                <th> Category</th>
                                <th> Unit</th>
                                <th> Quantity </th>
                                <th> Unit Price</th>
                                <th> Action </th>

                            </tr>

                          <?php



                          if(mysqli_num_rows($result) == 0)
                          {
                              ?>
                              <tr>
                                <td colspan="8" class="text-center">
                                  <strong class="text-primary">
                                      No Products Found!
                                  </strong>
                                </td>
                              </tr>
                              <?php
                          }
                          else
                          {

                            while ($row = mysqli_fetch_array($result))
                            {
                                ?>
                              <tr style="background-color:  white;">
                                <td>
                                  <?php echo $count++; ?>
                                </td>

                                <td>
                                    <?php echo $row['product_code']; ?>
                                </td>

                                <td>
                                  <?php echo $row['product_name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['category']; ?>
                                </td>

                                <td>
                                    <?php echo $row['measure_unit']; ?>
                                </td>

                                <td>
                                    <?php echo $row['quantity']; ?>
                                </td>

                                <td>
                                    <?php echo number_format($row['unit_price']); ?>
                                </td>

                                <td>
                                    <a href="edit_product.php?item=<?= $row['product_code']; ?>" class="btn btn-primary btn-xs" title="Edit this Product">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-xs btn-danger delete" href="#" title="Delete" data-id3="<?php echo $row['id']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                                <?php
                            }
                          }
                           ?>
                      </table>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="pull-right">
                      Page <?php echo $page_number; ?>/<?php echo $page_count; ?>
                  </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <?php
                        if($page_count > 1)
                        {
                            ?>
                        <ul class="pagination">
                            <?php
                            if($page_number != 1)
                            {
                                ?>
                            <li class="previous">
                                <a href="product_list.php?page=<?php echo $page_number - 1; ?>">Prev</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php
                            for($i = 1; $i <= $page_count; $i++)
                            {
                                ?>
                            <li class="<?php  $i == $page_number ? print 'active' : ''; ?>">
                                <a href="product_list.php?page=<?php echo $i; ?>" >
                                    <?php echo $i; ?>
                                </a>
                            </li>
                                <?php
                            }
                            ?>

                            <?php
                            //If the pages and page number are not the same then show the next button
                            if($page_number != $page_count)
                            {
                                ?>
                            <li class="next">
                                <a href="product_list.php?page=<?php echo $page_number + 1; ?>"> Next</a>
                            </li>
                                <?php
                            }
                            ?>

                        </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </section>

  <br><br>

  <div class="row">
      <div class="col-md-12">
          <div class="col-md-8">


          </div>
          <div class="col-md-4">
              <a href="#" class="btn btn-success"
                 onclick="window.open('print_inventory.php', '', 'width=800,height=400')"
                 >
                  <i class="fa fa-print"></i>
                  Print
              </a>

              <a href="home.php" class="btn btn-success">
                  <i class="fa fa-close"></i>
                  Close
              </a>
          </div>
      </div>
  </div>
</div>

<script>

    $(document).on('click', '.delete', function(){
        var id = $(this).data("id3");

        if(confirm("Are you sure you want to delete this Product ?"))
        {
            //redirect to the editing page
            window.location.href="product_list.php?action=del&idd="+id;
        }
    });

   $(document).ready(function(){
       //variables to keep track of events
       $search  = $("#search");
       $table_area = $("#table_area");

       $search.keyup(function(){
           var key = $search.val();


           //now search the results from the database
           $.ajax({
               url: "api/search_product.php",
               method: "POST",
               data: {search: key},
               dataType : "text",
               success: function(data){
                   showResults(data);
               }

           });
       });

       function showResults(output)
       {
           //show output
           $table_area.html(output);
       }


   })
</script>

<?php
require_once './includes/bottom.php';
?>
