<style type="text/css">
  td {
    word-wrap:break-word!important;
  }
  .dataTables_filter{
    text-align: right;
  }
</style>
<body >
<?php 
  date_default_timezone_set('Asia/Kolkata');
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  if(!(isset($_SESSION['id']))){
      header("location:index.php");
   }
  include('db.php'); ?>
 <style>
  </style>
        <?php if (isset($_POST['checked_id'])) {
          $idArr=$_POST['checked_id']; 


             
          for ($i=0; $i <count($idArr) ; $i++) { 
            $idArr[$i];
            $orderAndCart=explode(',', $idArr[$i]);

            $result1=mysqli_query($con,"select * from `mobileprint` WHERE `order_id`='".$orderAndCart[0]."'");

            $orderUpdate=mysqli_query($con,"UPDATE `order` SET `status`=20 WHERE `order_id`='".$orderAndCart[0]."'");

            $result=mysqli_query($con,"select * from `cart` WHERE `cart_id`='".$orderAndCart[1]."'");
            $dataResult = mysqli_fetch_array($result);
           
       
            ?>
            <div style="width:210mm;height:148.5mm;position: relative;">
            
               <span>Order Id:<?php echo $orderAndCart[0];?>&nbsp;&nbsp;Model:<?php echo $dataResult['brand'].'('.$dataResult['model'].')';?></span>


                  <?php 
                                   
                    $result = mysqli_query($con,"select * from `cover_sub_category` WHERE `cat_id`='".$dataResult['brand']."' and `name` = '".$dataResult['model']."' "); 
                 
                     $data = mysqli_fetch_array($result);
                     $cat_innerwidth= $data['innerwidth'];
                     $cat_innerheight= $data['innerheight'];
                     $cat_outerwidth= $data['outerwidth'];
                     $cat_outerheight=$data['outerheight'];
                     $product_id= $dataResult['product_id'];
                     

                    $Product_id="select * from `product` WHERE `product_id`='$product_id'";
                    $Product_id_s = mysqli_query($con,$Product_id);
                    $Product_id_result = mysqli_fetch_array($Product_id_s);
                    $printimagepdf=$Product_id_result['printimagepdf'];
                  ?>

              
                        
                          <div  style="width:200mm;height:130mm;position: absolute; background-color:black;text-align:center">

                             <img src="<?php echo $printimagepdf;?>" style="width:70mm;margin-top:30mm" >

                          </div>
                         
                        
                         
                </div>
           
          <?php 
        }
        }else{ 
               echo "";
            } ?>
   </body>  

 <!-- End : Inner Page container -->
   <!--  <a href="javascript:void(0);" class="scrollup">Scroll</a> -->
 <!-- End : Inner Page Content -->
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


