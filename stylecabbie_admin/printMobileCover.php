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


  function send_sms_for_order($order_id,$mobile){

      

          $msg="mahakaalstore.com Your Order:".$order_id." is shipped and ready to dispach.Expected delivery within 3 to 5 working days.";
          $msg = urlencode($msg);
          $curl = curl_init();
          $url="http://msg.smscluster.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=baed1c78daff684bf259af57d3ed78a9&message=$msg&senderId=MAHAKL&routeId=1&mobileNos=$mobile&smsContentType=english";
          //echo $url;
        curl_setopt_array($curl, array(
          CURLOPT_URL =>$url ,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        /*if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }*/
}



  ?>
 <style>


.a {
    -webkit-transform:rotateY(180deg);
    -moz-transform:rotateY(180deg);
    -o-transform:rotateY(180deg);
    -ms-transform:rotateY(180deg);
    transform:rotateY(180deg);
    unicode-bidi:bidi-override;
    direction:rtl;
}
.b {
    -webkit-transform:rotateY(180deg);
    -moz-transform:rotateY(180deg);
    -o-transform:rotateY(180deg);
    -ms-transform:rotateY(180deg);
    transform:rotateY(180deg);
}
.c {
    unicode-bidi:bidi-override;
    direction:rtl;
}

  </style>

        <?php if (isset($_POST['checked_id'])) {
          $idArr=$_POST['checked_id'];
          for ($i=0; $i <count($idArr) ; $i++) { 

            $result=mysqli_query($con,"select * from `mobileprint` WHERE `order_id`='".$idArr[$i]."'");
            $dataResult = mysqli_fetch_array($result);
            
            $outerheight=$dataResult['innerheight']+30;
            $outerwidth=$dataResult['innerwidth']+30;
            $outerheight=$outerheight.'mm';
            $outerwidth=$outerwidth.'mm';

            $innerwidth=$dataResult['innerwidth'];
            $innerwidth=$innerwidth.'mm';

            $resultmobileNumber=mysqli_query($con,"select * from `customorder` WHERE `customorder_id`='".$idArr[$i]."'");
            $dataResultNumber = mysqli_fetch_array($resultmobileNumber);
            $mobileNumber=$dataResultNumber['mobile'];
            send_sms_for_order($idArr[$i],$mobileNumber);

           $mobileResult=mysqli_query($con,"UPDATE customorder SET status='20' WHERE customorder_id='".$idArr[$i]."'");
           $mobilePrint=mysqli_query($con,"UPDATE mobileprint SET status='1' WHERE order_id='".$idArr[$i]."'");
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


