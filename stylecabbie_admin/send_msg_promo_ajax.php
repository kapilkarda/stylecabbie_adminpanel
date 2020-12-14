<?php
    include_once 'db.php';   
    
    	$sql = mysqli_query($con,"SELECT * FROM `user` where `promo_sms_status`='0'");
     	if($row=mysqli_fetch_array($sql)){

            $user_id=$row['user_id'];
            //$mobile='9826085023';
            $mobile=$row['mobile'];
            $updatesql=mysqli_query($con,"UPDATE `user` SET `promo_sms_status`='1' where user_id='$user_id'");

             $msg="MAHAKAAL STORE:make your mobile case with your picture &design(MRP-499 Offer Price-149)Home Delivery and COD Available Click for Order https://goo.gl/FkgBiS";

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
            echo '1';

            /*if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }*/

        }else{
            echo '0';
        }



        
?>

