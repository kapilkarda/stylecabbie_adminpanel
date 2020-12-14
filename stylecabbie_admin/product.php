<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
   if(!(isset($_SESSION['id'])))
   {
      header("location:index.php");
   }
   
include('db.php'); 

   ?>
 <style type="text/css">@media only screen and (max-width: 800px) {
  #unseen table td:nth-child(2), 
  #unseen table th:nth-child(2) {display: none;}
}
@media only screen and (max-width: 640px) {
  #unseen table td:nth-child(4),
  #unseen table th:nth-child(4),
  #unseen table td:nth-child(7),
  #unseen table th:nth-child(7),
  #unseen table td:nth-child(8),
  #unseen table th:nth-child(8){display: none;}
}
td {
    word-wrap:break-word!important;
}
.dataTables_filter{
  text-align: right;
}
    </style>
         <?php include('header.php');
               include('sidebar.php'); ?>            
       <!-- End : Side bar -->
        <div id="content">  <!-- Start : Inner Page Content -->
            <div class="container"> <!-- Start : Inner Page container -->
                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="current">Product Detail</li>
                    </ul>
                </div>  <!-- End : Breadcrumbs -->
                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Product Detail</h3>
                    </div>
                </div>  <!-- End : Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i>Product Detail</div>                               
                                <div class="actions">
                                    <div class="btn-group">
                                      <a class="btn mini green" href="add_product.php" >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product
                                        </a>    
                                       </div>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover DynamicTable">
                                    <thead>
                                        <tr>
                                            <th class="numeric">Product Id</th>
                                            <th class="numeric">Category</th>
                                            <th class="numeric">Sub Category</th>
                                            <th class="numeric">Name</th>
                                            <th class="numeric">Photo</th>
                                            <th class="numeric">Size</th>
                                            <th class="numeric">Quantity</th>
                                            <th class="numeric">Price</th>
                                            <th class="numeric">Sale Price</th>
                                            <th class="numeric">Description</th>
                                            <th class="numeric">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php  $sql_con = mysqli_query($con,"SELECT * FROM `product` order by `product_id` desc ");
                                      while($row_con = mysqli_fetch_array($sql_con)) {
                                          $cat_id=$row_con['cat_id'];
                                          $cat = mysqli_query($con,"SELECT * FROM `category` WHERE cat_id='$cat_id'");
                                          $row_cat = mysqli_fetch_array($cat);
                                          $cat_name=$row_cat['cat_name'];


                                          $sub_cat_id=$row_con['sub_cat_id'];
                                          $subcat = mysqli_query($con,"SELECT * FROM `subcategory` WHERE sub_id='$sub_cat_id'");
                                          $row_subcat = mysqli_fetch_array($subcat);
                                          $subcat_name=$row_subcat['name'];

                                      ?>
                               <tr id='trrow".$row_con['id']."' >
                                 <td class="center" class="numeric"><?php echo $row_con['product_id'];?></td>
                                 <td class="center" class="numeric"><?php echo $cat_name;?></td>
                                 <td class="center" class="numeric"><?php echo $subcat_name;?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                                  <td class="center" class="numeric">
                                    <?php 
                                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$row_con['photo']."'");
                                        $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    ?>
                                    <img src="<?php echo "".$fetch_record_img['image'];?>" style="height: 100px;width: 100px;"></td>
                                 <td class="center" class="numeric"><?php echo $row_con['product_size'];?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['product_qty'];?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['price'];?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['sale_price'];?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['description'];?></td>

                                  <td class="center" class="numeric">
                                    
                                    <?php
                                      $productId = $row_con['product_id'];
                                      $sql_con1 = mysqli_query($con,"SELECT * FROM `product_variant` WHERE  `product_id` = '$productId' ");

                                      $row_subcat1 = mysqli_num_rows($sql_con1);

                                      // echo "<pre>";
                                      // print_r($row_subcat);die;

                                      if ($row_subcat1 > 0) {
                                        
                                      ?>
                                      <a class='btn btn-info' title='student' href="product_variable.php?id=<?php echo $row_con['product_id'];  ?>"><i class='mdi-content-create'>View Product</i></a>
                                      <a class='btn btn-success' title='student' href="add_image_by_product.php?product_id=<?php echo $row_con['product_id'];  ?>"><i class='mdi-content-create'>Uplaod Images</i></a>
                                    <?php
                                      }
                                        ?>
                                        <a class='btn btn-info' title='student' href="edit_product.php?id=<?php echo $row_con['product_id'];  ?>"><i class='mdi-content-create'>edit</i></a>
                                       <a class='btn btn-danger'  onclick="delete_user('<?php echo $row_con['product_id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                       </td>   
                               </tr>
                               <?php }?>
                               
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>  <!-- End : Inner Page container -->
            <a href="javascript:void(0);" class="scrollup">Scroll</a>
        </div>  <!-- End : Inner Page Content -->
    </div>  <!-- End : container -->
    <!-- =====modal box===== -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.event.move.js"></script>
    <script type="text/javascript" src="assets/plugins/common/lodash.compat.js"></script>
    <script type="text/javascript" src="assets/plugins/common/respond.min.js"></script>
    <script type="text/javascript" src="assets/plugins/common/excanvas.js"></script>
    <script type="text/javascript" src="assets/plugins/common/breakpoints.js"></script>
    <script type="text/javascript" src="assets/plugins/common/touch-punch.min.js"></script>
    <script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/plugins/DataTables/js/DT_bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/plugins.js"></script>
    <script>
        $(document).ready(function(){
            App.init();
            DataTabels.init();
        });        
    </script>
    <script>
     function delete_user(id){
            var result= confirm("Are you really want delete this Product?");
            if(result==true){
                $.ajax({
                    type:'POST',
                    url:'query.php',
                    data:'method=1&id='+id,
                    success:function(res){
                     location.reload(); 
                    }
                });
            }
     }
</script>
        </body>  

</html>