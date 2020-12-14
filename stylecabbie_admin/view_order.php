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
                        <li class="current">Order Detail</li>
                    </ul>
                </div>  <!-- End : Breadcrumbs -->
                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Order Detail</h3>
                    </div>
                </div>  <!-- End : Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i>Order Detail</div>                               
                                <!-- <div class="actions">
                                    <div class="btn-group">
                                      <a class="btn mini green" href="add_product.php" >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product
                                        </a>    
                                       </div>
                                </div> -->
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover DynamicTable">
                                    <thead>
                                        <tr>
                                            <th class="numeric">Product Id</th>
                                            <th class="numeric">Name</th>
                                            <th class="numeric">Color</th>
                                            <th class="numeric">Size</th>
                                            <th class="numeric">Sleeve</th>
                                            <th class="numeric">Quantity</th>
                                            <th class="numeric">Price</th>
                                            <th class="numeric">Sale Price</th>
                                            <th class="numeric">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php  $sql_con = mysqli_query($con,"SELECT * FROM `order` WHERE order_id='".$_GET['order_id']."' ");

                                      //echo "<pre>";
                                      //print_r($sql_con);die;
                                      while($row_con = mysqli_fetch_array($sql_con)) {
  											                   $cart_ids = explode(",", $row_con['cart_id']);

                                           foreach ($cart_ids as $keyc => $cart_id) {
                                              $cartId = $cart_id;
                                              $cart_list = mysqli_query($con,"SELECT * FROM `cart` WHERE cart_id='$cartId'");

                                             while($cart_listData = mysqli_fetch_array($cart_list)) {

                                                if($cart_listData['product_id'] == 0){
                                                  $product_variant_id = $cart_listData['product_variant_id'];
                                                  
                                                  $product_variant_data = mysqli_query($con,"SELECT * FROM `product_variant` WHERE id='$product_variant_id'");
                                                  while($final_data = mysqli_fetch_array($product_variant_data)) {
                                                    // echo $final_data['name']."<br>";
                                                    ?>
                                                      <tr id='trrow".$row_con['id']."' >
                                                   <td class="center" class="numeric"><?php echo $cart_listData['product_id'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['name'];?></td>
                                                  <td class="center" class="numeric"><?php echo $cart_listData['colour'];?></td>
                                                   <td class="center" class="numeric"><?php echo $cart_listData['size'];?></td>
                                                  <td class="center" class="numeric"><?php echo $cart_listData['sleeve'];?></td>
                                                   <td class="center" class="numeric"><?php echo $cart_listData['qty'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['price'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['sale_price'];?></td>
                                                   
                                                    <td class="center" class="numeric">
                                                      <a class='btn btn-info' title='student' href="edit_product_variable.php?id=<?php echo $final_data['id'];  ?>"><i class='mdi-content-create'>edit</i></a>
                                                      <a class='btn btn-danger'  onclick="delete_user('<?php echo $final_data['id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                                         </td>   
                                                 </tr>
                                                    <?php
                                                  }
                                                }else{
                                                  $product_id = $cart_listData['product_id'];
                                                  $product_data = mysqli_query($con,"SELECT * FROM `product` WHERE product_id='$product_id'");
                                                  while($final_data = mysqli_fetch_array($product_data)) {
                                                      //echo $final_data['product_id'];
                                                  ?>
                                                    <tr id='trrow".$row_con['id']."' >
                                                   <td class="center" class="numeric"><?php echo $cart_listData['product_id'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['name'];?></td>
                                                  <td class="center" class="numeric"><?php echo $cart_listData['colour'];?></td>
                                                   <td class="center" class="numeric"><?php echo $cart_listData['size'];?></td>
                                                  <td class="center" class="numeric"><?php echo $cart_listData['sleeve'];?></td>
                                                   <td class="center" class="numeric"><?php echo $cart_listData['qty'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['price'];?></td>
                                                   <td class="center" class="numeric"><?php echo $final_data['sale_price'];?></td>
                                                   
                                                    <td class="center" class="numeric">
                                                      <a class='btn btn-info' title='student' href="edit_product_variable.php?id=<?php echo $final_data['id'];  ?>"><i class='mdi-content-create'>edit</i></a>
                                                      <a class='btn btn-danger'  onclick="delete_user('<?php echo $final_data['id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                                         </td>   
                                                 </tr>
                                                  <?php
                                                        
                                                  }
                                                }
                                             }
                                           }

                                      		
                                      		// $row_cat = mysqli_fetch_array($cat);
                                      		// $cat_name=$row_cat['cat_name'];


                                      		// $sub_cat_id=$row_con['sub_cat_id'];
                                      		// $subcat = mysqli_query($con,"SELECT * FROM `subcategory` WHERE sub_id='$sub_cat_id'");
                                      		// $row_subcat = mysqli_fetch_array($subcat);
                                      		// $subcat_name=$row_subcat['name'];

                                      ?>
                               
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