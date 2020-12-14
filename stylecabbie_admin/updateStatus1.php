<?php
include('db.php');

function send_sms_for_order($order_id,$status,$mobile,$barcode){

			if($status=='9' || $status=='1'){
				   $msg="Your Order (ORDER ID:".$order_id.") has been confirmed and ready to dispatch.Please whatsApp your full address on 7974789076";
			  }else if($status=='21'){

			  	$msg="Your Order (ORDER ID:".$order_id.") has been dispatched.Hope you enjoyed your shopping at mahakaal store!Click these link and track your order https://www.delhivery.com/track/package/".$barcode."";

			  }/*else if($status=='4'){
			  	  $msg="Your Order (ORDER ID:".$order_id.") has been Cancel. if any problem please contact on 0731-4981691";
			  }*/
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

	if($_GET['method']=='CustomOrder'){

			$status=$_GET['status'];
		    $oid=$_GET['oid'];
		    if(isset($_GET['barcode'])){
		    	 $barcode=$_GET['barcode'];
		    	}else{
		    		$barcode="";
		    	}
		   
		    $date=date('Y-m-d h:i:s');

		   $sql = mysqli_query($con,"update `customorder` set status='$status',update_at='$date',barcode='$barcode' where customorder_id='$oid'");
		    if ($sql) {
		    	echo 1;
		    	$sq = mysqli_query($con,"SELECT * FROM `customorder` WHERE customorder_id='$oid'");
			    $r=mysqli_fetch_array($sq);
			    $mobile=$r['mobile'];
			    if($status=='21' || $status=='9' || $status=='1'){
			    	send_sms_for_order($oid,$status,$mobile,$barcode);
			    }
		    }else{
		    	echo 0;
		    }
		    
	}else{

		    $status=$_GET['status'];
		    $oid=$_GET['oid'];

		    if(isset($_GET['barcode'])){
		    	 $barcode=$_GET['barcode'];
		    	}else{
		    		$barcode="";
		    	}
		    	
		    $date=date('Y-m-d h:i:s');
		    $sql = mysqli_query($con,"update `order` set status='$status',updated_at='$date' where order_id='$oid'");
		    if ($sql) {
		    	echo 1;
		    	$sq = mysqli_query($con,"SELECT * FROM `order` WHERE order_id='$oid'");
			    $r=mysqli_fetch_array($sq);
			    $mobile=$r['mobile'];
			    if($status=='21' || $status=='9' ){
			    	
			    	send_sms_for_order($oid,$status,$mobile,$barcode);
			    }
			    
		    }else{
		    	echo 0;
		    }

	}
   
}
?>