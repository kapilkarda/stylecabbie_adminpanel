<?php

	require_once('db.php');

	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');

	$method = $_GET['method'];	

	function messageSend($message, $mobileNumber){
		//Your authentication key
		$authKey = "75568A0nZox8z9548029cb";
		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = "scrbtk";

		//Define route 
		$route = "4";

		//Prepare you post parameters
		$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route,
			'response'=> 'json',
			'ignoreNdnc'=>1
		);

		//API URL
		$url="https://control.msg91.com/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//get response
		$output = curl_exec($ch);

		//Print error if any
		if(curl_errno($ch)){
			echo 'error:' . curl_error($ch);
		}

		curl_close($ch);

		$json = json_decode($output, true);
		//return $json['type'];
	}


	function registerUser($mobile, $name){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "9090",
		  CURLOPT_URL => "http://52.87.213.172:9090/plugins/restapi/v1/users",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\r\n    \"username\": \"$mobile\",\r\n    \"password\": \"123456\",\r\n    \"name\": \"$name\"\r\n}",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic YWRtaW46a2FwaWxraw==",
		    "content-type: application/json",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
	}

	if($method=="barcode"){
		$datatext = array();
		$datatext['results'] = false;
		$code  			= mysqli_real_escape_string($con, $_REQUEST['code']);

		$sql = mysqli_query($con,"SELECT * FROM barcode WHERE `code`='$code'");
		if($row1=mysqli_fetch_array($sql)){
			$datatext['results'] = false;
			$datatext['msg'] = 'Already exist';
		}else{
			$insert=mysqli_query($con, "INSERT INTO `barcode`(`code`) VALUES ('$code')");
			if($insert){
				$datatext['results'] = true;
				$datatext['msg'] = 'Successfully insert.';
			}else{
				$datatext['results'] = false;
				$datatext['msg'] = 'Try again.';
			}
		}
		echo json_encode($datatext);
	}


?>