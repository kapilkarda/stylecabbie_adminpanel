<?php
include('db.php');



    function send_sms_for_order($order_id,$mobile,$barcode){
            $msg="Hope you enjoyed your shopping at mahakaal store ! Click these link and track your order https://www.delhivery.com/track/package/".$barcode."" ;

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

if(isset ($_GET['oid']))
{

  if($_GET['method']=='CustomOrder'){
        $oid=$_GET['oid'];
       
           $sq = mysqli_query($con,"SELECT * FROM `customorder` WHERE customorder_id='$oid'");
          $r=mysqli_fetch_array($sq);
          $barcode=$r['barcode'];
          $status=$r['status'];
          $mobile=$r['mobile'];
          if($status!='21' ){
            echo 0;
          }
        else if(empty($barcode)){
          echo 1;
        }else {
          echo 2;

          send_sms_for_order($oid,$mobile,$barcode);
        }
         
   }else{
       $sq = mysqli_query($con,"SELECT * FROM `order` WHERE order_id='".$_GET['oid']."'");
          $r=mysqli_fetch_array($sq);
          $barcode=$r['barcode'];
          $status=$r['status'];
          $mobile=$r['mobile'];
          if($status!='21' ){
            echo 0;
          }
        else if(empty($barcode)){
          echo 1;
        }else {
          echo 2;

          send_sms_for_order($oid,$mobile,$barcode);
        }
   }     


}

?>