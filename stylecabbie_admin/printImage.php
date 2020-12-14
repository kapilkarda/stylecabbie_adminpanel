<style type="text/css">
  td {
    word-wrap:break-word!important;
  }
  .dataTables_filter{
    text-align: right;
  }

</style>
<?php 

  date_default_timezone_set('Asia/Kolkata');
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  if(!(isset($_SESSION['id']))){
      header("location:index.php");
   }
  include('db.php'); 
  include('header.php');
  include('sidebar.php'); ?>            
<div id="content">  <!-- Start : Inner Page Content -->
  <div class="container"> <!-- Start : Inner Page container -->
   <!-- End : Breadcrumbs -->
   

     
            <?php
            $sql = "UPDATE `order` SET status='20' WHERE order_id='".$_GET["order"]."'";
            $sql_con1 = mysqli_query($con,$sql);

            $product_idQuery="select * from `product` WHERE `product_id`='".$_GET["prodict_id"]."'";
            $productRes = mysqli_query($con,$product_idQuery);
            $productResult = mysqli_fetch_array($productRes);
            $ProductImage=$productResult['printimagepdf'];
         
            ?>
        <?php if (!empty($ProductImage)) { ?>
      
             Order Id:- <?php echo $_GET['order'];?>
        
              Size:- <?php echo $_GET['size'];?>
                <img src="<?php echo "https://www.mahakaalstore.com/afterfeed_admin/".$ProductImage?>"> 
             
 
        <?php } ?>
     

  </div>  <!-- End : Inner Page container -->
    <a href="javascript:void(0);" class="scrollup">Scroll</a>
</div>  <!-- End : Inner Page Content -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
<script type="text/javascript" src="assets/plugins/common/breakpoints.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
