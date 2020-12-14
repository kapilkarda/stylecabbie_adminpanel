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
  <div class="container" > <!-- Start : Inner Page container -->
          <?php
            $sql = "UPDATE `customorder` SET status='20' WHERE customorder_id='".$_GET["order"]."'";
            $sql_con1 = mysqli_query($con,$sql);

            $product_idQuery="select * from `customorder` WHERE `customorder_id`='".$_GET["order"]."'";
            $productRes = mysqli_query($con,$product_idQuery);
            $productResult = mysqli_fetch_array($productRes);
            $ProductImage=$productResult['customPic'];
         
            ?>
        <?php if (!empty($ProductImage)) { ?>
                 Order Id:- <?php echo $_GET['order'];?>
                 Size:- <?php echo $_GET['size'];?>
                <img src="<?php echo "https://www.mahakaalstore.com/".$ProductImage?>"  style="width:794px; height:1122px "> 
         
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


