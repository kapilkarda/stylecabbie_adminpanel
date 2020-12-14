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
  include('db.php'); ?>
 <style>



  </style>

        <!-- <?php if (isset($_POST['checked_id'])) {
          $idArr=$_POST['checked_id'];
          for ($i=0; $i <count($idArr) ; $i++) { 

            $idArr[$i];
            $result=mysqli_query($con,"select * from `vendormobileprint` WHERE `order_id`='".$idArr[$i]."'");
            $dataResult = mysqli_fetch_array($result);
            //$model=$dataResult['brand'];
            //$brand_Model=$dataResult['brand_Model'];
           // $mobileResult=mysqli_query($con,"select * from `mobileprint` WHERE `brand`='".$model."' and `model`='".$brand_Model."'");
           // $rowcount=mysqli_num_rows($mobileResult);
          //  if($rowcount){
           // $mobileData = mysqli_fetch_array($mobileResult); 
           $mobileResult=mysqli_query($con,"UPDATE customordervendor SET status='1' WHERE id='".$idArr[$i]."'");
           $mobilePrint=mysqli_query($con,"UPDATE vendormobileprint SET status='1' WHERE order_id='".$idArr[$i]."'");
            ?>
            <div style="width:210mm;height:148.5mm;position: relative;">
               <span>Order Id:V<?php echo $dataResult['order_id'];?>&nbsp;&nbsp;Model:<?php echo $dataResult['brand'].'('.$dataResult['model'].')';?></span>
              <div style="position:relative;width:<?php echo $dataResult['outerheight'];?>;height:<?php echo $dataResult['outerwidth'];?>;margin-bottom: 10mm;"> 
                 <img src="<?php echo $dataResult['image'];?>" style="width:<?php echo $dataResult['outerheight'];?>;height:<?php echo $dataResult['outerwidth'];?>;position: absolute;filter: blur(5px);">
            
                <img src="<?php echo $dataResult['image'];?>" style="width:<?php echo $dataResult['innerheight'];?>;height:<?php echo $dataResult['innerwidth'];?>;position: absolute;top: 60px;right: 15mm;">
              </div>
            </div>
           
          <?php 
        }
        }else{ 
               echo "";
            } ?> -->



        <?php if (isset($_POST['checked_id'])) {
          $idArr=$_POST['checked_id'];
          for ($i=0; $i <count($idArr) ; $i++) { 

            $result=mysqli_query($con,"select * from `vendormobileprint` WHERE `order_id`='".$idArr[$i]."'");
            $dataResult = mysqli_fetch_array($result);
            
            $outerheight=$dataResult['innerheight']+30;
            $outerwidth=$dataResult['innerwidth']+30;
            $outerheight=$outerheight.'mm';
            $outerwidth=$outerwidth.'mm';

            $innerwidth=$dataResult['innerwidth'];
            $innerwidth=$innerwidth.'mm';

            $resultmobileNumber=mysqli_query($con,"select * from `customordervendor` WHERE `id`='".$idArr[$i]."'");
            $dataResultNumber = mysqli_fetch_array($resultmobileNumber);
            $mobileNumber=$dataResultNumber['mobile'];
            //send_sms_for_order($idArr[$i],$mobileNumber);

           $mobileResult=mysqli_query($con,"UPDATE customordervendor SET status='1' WHERE customorder_id='".$idArr[$i]."'");
           $mobilePrint=mysqli_query($con,"UPDATE vendormobileprint SET status='1' WHERE order_id='".$idArr[$i]."'");
            ?>
            <div style="width:210mm;height:150mm;position: relative; float:left;">

               <span  style="float:left" class="b" >Order Id:<?php echo $dataResult['order_id'];?>&nbsp;&nbsp;Model:<?php echo $dataResult['brand'].'('.$dataResult['model'].')';?></span>

              <div style="position:relative;width:<?php echo $outerheight;?>;height:<?php echo $outerwidth;?>; float:left; background:black;"> 

                <img src="<?php echo $dataResult['image'];?>" style="width:<?php echo $outerheight;?>;height:<?php echo $outerwidth;?>;position: absolute;filter: blur(5px);"> 

                <img src="<?php echo $dataResult['image'];?>" style="height:<?php echo $innerwidth;?>;position: absolute;top: 15mm;right: 15mm;">
              </div>
            </div>
           
          <?php 
        }
        }else{ 
               echo "";
            } ?>
     

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


