<?php
include('db.php');

function send_sms_for_order($order_id,$status,$mobile){

			if($status=='2'){
				   $msg="Your Order (ORDER ID:".$order_id.") is ready to Delivery.Please pick up at store.";
			  }
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

				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				  echo $response;
				}
}

if(isset($_GET['status']) && ($_GET['oid']))
{

	

			$status=$_GET['status'];
		    $oid=$_GET['oid'];
		    $date=date('Y-m-d h:i:s');

		   $sql = mysqli_query($con,"update `customordervendor` set status='$status',update_at='$date' where id='$oid'");
		    if ($sql) {
		    	echo 1;
		    	$sq = mysqli_query($con,"SELECT * FROM `customordervendor` WHERE id='$oid'");
			    $r=mysqli_fetch_array($sq);
			    $mobile=$r['mobile'];
			    if($status=='2'){
			    	//send_sms_for_order($oid,$status,$mobile);
			    }
		    }else{
		    	echo 0;
		    }
		    
	
   
}
?>