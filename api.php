<?php
include('connection.php');
require_once "Mail.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: *");

mysqli_query($con, "SET NAMES 'utf8'");
mysqli_query($con, 'SET CHARACTER SET utf8');
// $img_url='http://ec2-52-70-234-40.compute-1.amazonaws.com/dailyvegitable';

    function messageSend($message,$mobileNumber){
        //Your authentication key
        $authKey = "75568A0nZox8z9548029cb";
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "Foodfiz";

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
        return $json['type'];
    }

    /****************************
	 Mail
	********************************/

	function send_reset_pwd_mail($to,$otp_reset) {

		    require_once "Mail.php";
            $from = 'stylecabbie@gmail.com';
			$to = $to;
			$subject = 'Forgot Password';
			$body = '<!DOCTYPE html>
                            <html>
                              <head>
                              </head>
                            <body style=" margin: 0 auto;">
                            <div class="wrapper" style="width:100%;" >
                                <header style="width: 100%; float: left; background-color: #EA4335; clear: left; text-align: center;">
                                   <span style="padding: 10px;font-size: 40px;color: white;">Stylecabbie</span>
                                </header>
                                <section>
                                  <div class="container" style="width: 100%; margin: 0 auto;overflow: hidden; max-width: 1170px;">
                                    <div class="section">
                              
                                      <p style="font-size:24px;">Dear Customer</p>
                                      <p style="font-size:20px; ">Your Reset Password OTP is: '.$otp_reset.' </p>
                                      <p style="float:right; font-size:24px; margin-right:190px;">Thanks</p>
                                    </div>

                                  </div>
                                </section>


                            <footer style="  color: white; background-color: black; height: auto; width: 100%; float: left;">
                            <div class="container"  style="width: 100%; margin: 0 auto;overflow: hidden; max-width: 1170px;">
                              <div class="main-box" style=" width: 100%;">
                                
                                <div style=" width: 30%; float: right; margin-right: 125px; margin-top: 10px;
                            "> 
                                  <a href="#"><span class="text-right" style="float: right;font-size: 24px;margin-top: 5px; color:#fff;">www.stylecabbie.com</span></a>
                                </div>
                                </div>
                            </footer>


                            </div>
                            </body>
                            </html>';

			$headers = array(
				'MIME-Version' => '1.0rn',
        		'Content-Type' => "text/html; charset=ISO-8859-1rn",
			    'From' => $from,
			    'To' => $to,
			    'Subject' => $subject
			);

			$smtp = Mail::factory('smtp', array(
			        'host' => 'ssl://smtp.gmail.com',
			        'port' => '465',
			        'auth' => true,
			        'username' => 'stylecabbie@gmail.com',
			        'password' => 'Style@123#'
			    ));

			$mail = $smtp->send($to, $headers, $body);

			/*if (PEAR::isError($mail)) {
			    echo('<p>' . $mail->getMessage() . '</p>');
			} else {
			    echo('<p>Message successfully sent!</p>');
			}*/
    }

    $method = mysqli_real_escape_string($con, $_REQUEST['method']);

    /****************************
	 LogIn
	********************************/

	if($method=="LogIn")
	{    
	    if(isset($_POST['email']) && $_POST['email']!='' && isset($_POST['password']) && $_POST['password']!=''){

	     	$email=mysqli_real_escape_string($con,$_POST['email']);
	     	$password=mysqli_real_escape_string($con,md5($_POST['password']));

	     	$sel=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user WHERE `user_email`='$email' AND `pwd`='$password' "));
			$datatext=array();
			$datatext['result']=false;
			if($sel)
			{
				$datatext['result']=true;
				$datatext['msg']="Succesfully Login";
				$datatext['name']=$sel['fullname'];
				$datatext['user_id']=$sel['user_id'];

			}else{
				$datatext['result']=false;
				$datatext['msg']="Credentials not matched.";
			}
	     }else{
	     	$datatext['result']=false;
	     	$datatext['msg']="email and password should not be blank.";
	     }
	     
		 
		echo json_encode($datatext);
	}

    /****************************
	 SignUp
	********************************/
	if ($method == "SignUp") {
            $name       = mysqli_real_escape_string($con, $_POST['name']);
            $email      = mysqli_real_escape_string($con, $_POST['email']);
            $password   = mysqli_real_escape_string($con, md5($_POST['password']));
            $datatext   = array();
            
            $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user WHERE `user_email`='$email'"));
            if ($checkExist) {
                    $datatext['result'] = false;
                    $datatext['msg']     = "This email already exists.";
            } else {
                if($name!=''  && $email!='' && $password!='')
                {
                    
                    $insert = mysqli_query($con, "INSERT INTO `user`(`fullname`,`user_email`,`pwd`) VALUES ('$name','$email','$password')");
                    if ($insert) {
                            $datatext['result'] = true;
                            $datatext['msg']     = "succesfully Registered";
                            $datatext['user_id'] = mysqli_insert_id($con);
                    } else {
                    	    $datatext['result'] = false;
                            $datatext['msg'] = "Please Try again";
                    }
                }else
                {
                	 $datatext['result'] = false;
                     $datatext['msg'] = "All filed should not be blank.";
                }
            }
            echo json_encode($datatext);
    }


    /****************************
      Category and Subcategory
    ********************************/
    if ($method == "cat_subCatList") {

        $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `category`");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
            		$cat_id=$fetch_record['cat_id'];
            		$sub_record1 = mysqli_query($con, "SELECT * FROM `subcategory` WHERE `cat_id`='$cat_id'");
            			$sub_arr           = array();
		            while($sub_record = mysqli_fetch_array($sub_record1)) {

		            	$sub_arr[] = array(
		                            "sub_id"        => $sub_record['sub_id'],
		                            "cat_id"        => $sub_record['cat_id'],
		                            "name"          => $sub_record['name'],
                                    "type"          => $sub_record['type']
		                    );
		            }
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    $datatext['result']   = true;
                    $arr[]                = array(
                            "id" => $fetch_record['cat_id'],
                            "cat_name" =>$fetch_record['cat_name'],
                            "image" => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record['image'],
                            "sub_cat" =>$sub_arr
                    );
                    $datatext['category'] = $arr;
            }
            echo json_encode($datatext);
    }

    /****************************
    productListing by subCategory
    ********************************/

    if($method=="productListing"){

    	$cat_id        = mysqli_real_escape_string($con, $_POST['cat_id']);
        $sub_cat_id        = mysqli_real_escape_string($con, $_POST['sub_id']);
        $page              = mysqli_real_escape_string($con, $_POST['page']);
        // set the number of items to display per page
		$items_per_page = 10;
		$offset = ($page - 1) * $items_per_page;
        $datatext                = array();
        $datatext['results']     = false ;

        $popularList             = mysqli_query($con,"SELECT * FROM  `product` WHERE  sub_cat_id='$sub_cat_id' and cat_id='$cat_id' LIMIT " . $offset . "," . $items_per_page);

        /*=========for domain and image folder path ==========*/
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        /*=========for domain and image folder path ==========*/
        
        while($product           = mysqli_fetch_array($popularList)){

            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$product['photo']."'");
            $fetch_record_img = mysqli_fetch_array($get_record_img);

            $popularProductList[] =   array(
                'product_id'     => $product['product_id'],
                'name'      => $product['name'],
                'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                'description'    => $product['description'],
                'price'       => $product['price'],
                'sale_price'       => $product['sale_price'],
                'product_type' =>$product['product_type']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularProductList ;
        echo json_encode($datatext);
    }

    /****************************
    productListing by newest
    ********************************/

    if($method=="newProductListing"){

    	
        $page              = mysqli_real_escape_string($con, $_POST['page']);
        // set the number of items to display per page
		$items_per_page = 20;
		$offset = ($page - 1) * $items_per_page;
        $datatext                = array();
        $datatext['results']     = false ;

        $popularList             = mysqli_query($con,"SELECT * FROM  `product` ORDER BY product_id DESC LIMIT " . $offset . "," . $items_per_page);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        while($product           = mysqli_fetch_array($popularList)){

            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$product['photo']."'");
            $fetch_record_img = mysqli_fetch_array($get_record_img);

            $popularProductList[] =   array(
                'product_id'     => $product['product_id'],
                'name'      => $product['name'],
                'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                'description'    => $product['description'],
                'price'       => $product['price'],
                'sale_price'       => $product['sale_price'],
                "product_type" =>$product['product_type']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularProductList ;
        echo json_encode($datatext);
    }


    if($method=="featureProductListing"){

    	
        $page              = mysqli_real_escape_string($con, $_POST['page']);
        // set the number of items to display per page
		$items_per_page = 20;
		$offset = ($page - 1) * $items_per_page;
        $datatext                = array();
        $datatext['results']     = false ;

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $popularList             = mysqli_query($con,"SELECT * FROM  `product` WHERE is_feature='1' ORDER BY product_id DESC LIMIT " . $offset . "," . $items_per_page);
        while($product           = mysqli_fetch_array($popularList)){

            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$product['photo']."'");
            $fetch_record_img = mysqli_fetch_array($get_record_img);

            $popularProductList[] =   array(
                'product_id'     => $product['product_id'],
                'name'      => $product['name'],
                'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                'description'    => $product['description'],
                'price'       => $product['price'],
                'sale_price'       => $product['sale_price'],
                'product_type' =>$product['product_type']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularProductList ;
        echo json_encode($datatext);
    }


    /****************************
     Show Product Details
    ********************************/
    if ($method == "productDetails") {

        $product_id       = mysqli_real_escape_string($con, $_POST['product_id']);
        $product_type       = mysqli_real_escape_string($con, $_POST['product_type']);
        $datatext['results'] = false;

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $datatext           = array();
        $datatext['result'] = false;

        if($product_type=='simple'){
            $get_record         = mysqli_query($con, "SELECT * FROM `product` WHERE product_id = '$product_id' ");
        }
        if($product_type=='variable'){
            $get_record         = mysqli_query($con, "SELECT * FROM `product_variant` WHERE product_id = '$product_id' order by id desc limit 1");
        }
        if($product_type=='customize'){
            $get_record         = mysqli_query($con, "SELECT * FROM `product` WHERE product_id = '$product_id' ");
        }

            while ($fetch_record = mysqli_fetch_array($get_record)) {

                if($product_type=='variable'){
                    $varient_product_id=$fetch_record['id'];
                    $description=$fetch_record['Description'];
                    $product_type='variable';
                    $colour_status=$fetch_record['color_status'];
                    $size=$fetch_record['size'];
                    $sleeve=$fetch_record['sleeve'];
                    $color=$fetch_record['color'];
                    $brand=$fetch_record['brand'];
                }
                if($product_type=='simple'){
                    $varient_product_id='';
                    $description=$fetch_record['description'];
                    $product_type=$fetch_record['product_type'];
                    $colour_status=$fetch_record['colour_status'];
                    $size='';
                    $sleeve='';
                    $color='';
                    $brand='';
                }

                if( strpos($fetch_record['images'], ',') !== false ) {
                        $img_arr=explode(',', $fetch_record['images']);

                         for ($i=0; $i <count($img_arr); $i++) { 

                            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$img_arr[$i]."'");
                            $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    $arr_img[]                = array(
                                        'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image']
                                    );

                         }
                    }else{

                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$fetch_record['images']."'");
                            $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    $arr_img[]                = array(
                                        'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image']
                                    );

                    }
                    $datatext['result']   = true;
                    $arr[]                = array(
                            "varient_product_id" =>$varient_product_id,
                            "product_id" =>$fetch_record['product_id'],
                            "name" =>$fetch_record['name'],
                            'photo'     => $arr_img,
                            "price" =>$fetch_record['price'],
                            "sale_price" =>$fetch_record['sale_price'],
                            "description" =>$description,
                            "product_type" =>$product_type,
                            "colour_status" =>$colour_status,
                            "size_status" =>$fetch_record['size_status'],
                            "model_status" =>$fetch_record['model_status'],
                            "size" =>$size,
                            "sleeve" =>$sleeve,
                            "color" =>$color,
                            "brand" =>$brand,
                            "sleeve_status" =>$fetch_record['sleeve_status']
                    );
            }

            $get_record_colour         = mysqli_query($con, "SELECT * FROM `colour`");
            while ($fetch_record_colour = mysqli_fetch_array($get_record_colour)) {

                    $datatext['result']   = true;
                    $colorarr[]                = array(
                            "id" =>$fetch_record_colour['id'],
                            "name" =>$fetch_record_colour['name']
                    );
            }

             $get_record_brand         = mysqli_query($con, "SELECT * FROM `cover_category`");
            while ($fetch_record_brand = mysqli_fetch_array($get_record_brand)) {

                    $datatext['result']   = true;
                    $brandarr[]                = array(
                            "id" =>$fetch_record_brand['id'],
                            "name" =>$fetch_record_brand['name']
                    );
            }
            $get_record_size         = mysqli_query($con, "SELECT * FROM `size`");
            while ($fetch_record_size = mysqli_fetch_array($get_record_size)) {

                    $datatext['result']   = true;
                    $sizearr[]                = array(
                            "id" =>$fetch_record_size['id'],
                            "name" =>$fetch_record_size['name']
                    );
            }

            $get_record_sleeves         = mysqli_query($con, "SELECT * FROM `sleeves`");
            while ($fetch_record_sleeves = mysqli_fetch_array($get_record_sleeves)) {

                    $datatext['result']   = true;
                    $sleevearr[]                = array(
                            "id" =>$fetch_record_sleeves['id'],
                            "name" =>$fetch_record_sleeves['name']
                    );
            }
            $datatext['color'] = $colorarr;
            $datatext['brand'] = $brandarr;
            $datatext['size'] = $sizearr;
            $datatext['sleeve'] = $sleevearr;
            $datatext['data'] = $arr;
            echo json_encode($datatext);
    }


        /****************************
     Show Variable Product Details
    ********************************/
    if ($method == "variableProductDetails") {

        $product_id       = mysqli_real_escape_string($con, $_POST['product_id']);
        $color       = mysqli_real_escape_string($con, $_POST['color']);
        $size       = mysqli_real_escape_string($con, $_POST['size']);
        $sleeve       = mysqli_real_escape_string($con, $_POST['sleeve']);
        $brand       = mysqli_real_escape_string($con, $_POST['brand']);

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $datatext           = array();
        $datatext['result'] = false;
        $filter = array();
        if($color!=''){
            $cart[] = "color='".$color."'";
        }
        if($size!=''){
            $cart[] = "size='".$size."'";
        }
        if($sleeve!=''){
            $cart[] = "sleeve='".$sleeve."'";
        }

        $where=implode(' and ', $cart);
        $get_record         = mysqli_query($con, "SELECT * FROM `product_variant` WHERE product_id = '$product_id' AND $where ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $arr_img = array();

                    if( strpos($fetch_record['images'], ',') !== false ) {
                        $img_arr=explode(',', $fetch_record['images']);

                         for ($i=0; $i <count($img_arr); $i++) { 

                            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$img_arr[$i]."'");
                            $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    $arr_img[]                = array(
                                        'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image']
                                    );

                         }
                    }else{

                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$fetch_record['images']."'");
                            $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    $arr_img[]                = array(
                                        'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image']
                                    );

                    }


                    

                    $datatext['result']   = true;
                    $arr[]                = array(
                            "varient_product_id" =>$fetch_record['id'],
                            "product_id" =>$fetch_record['product_id'],
                            "name" =>$fetch_record['name'],
                            'photo'     => $arr_img,
                            "price" =>$fetch_record['price'],
                            "sale_price" =>$fetch_record['sale_price'],
                            "description" =>$fetch_record['Description'],
                            "colour_status" =>$fetch_record['color_status'],
                            "size_status" =>$fetch_record['size_status'],
                            "model_status" =>$fetch_record['model_status'],
                            "sleeve_status" =>$fetch_record['sleeve_status'],
                            "colour" =>$fetch_record['color'],
                            "size" =>$fetch_record['size'],
                            "model" =>$fetch_record['model'],
                            "sleeve" =>$fetch_record['sleeve']
                    );
            }
            $datatext['data'] = $arr;
            echo json_encode($datatext);
    }

   /****************************
     Add to Cart
    ********************************/
    if ($method == "addToCart") {
            $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
            $productid    = mysqli_real_escape_string($con, $_POST['product_id']);
            $product_variant_id    = mysqli_real_escape_string($con, $_POST['product_variant_id']);
            $qty           = mysqli_real_escape_string($con, $_POST['qty']);
            $product_type           = mysqli_real_escape_string($con, $_POST['product_type']);
            
            $datatext      = array();
            if($product_type=='simple'){

                $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM cart WHERE `user_id`='$user_id' AND `product_id`='$productid' AND `status`= 0 "));
                if ($checkExist) {
                        $datatext['result'] = false;
                        $datatext['msg']     = "This product already exists in your cart.";
                } else {

                    $get_record_var         = mysqli_query($con, "SELECT * FROM `product` WHERE product_id = '".$productid."'");
                    $fetch_record_var = mysqli_fetch_array($get_record_var);
                    $price=$fetch_record_var['sale_price'];

                    $insert=mysqli_query($con, "INSERT INTO cart (user_id,product_id,product_price,qty,product_type) VALUES ('$user_id','$productid','$price','$qty','$product_type')");
                        if ($insert) {
                                $datatext['result'] = true;
                                $datatext['msg']     = "succesfully add to cart";
                        } else {
                                $datatext['result'] = false;
                                $datatext['msg'] = "Please Try again";
                        }
                }

            }
            if($product_type=='variable'){
                $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM cart WHERE `user_id`='$user_id' AND `product_variant_id`='$product_variant_id' AND `status`= 0 "));
                if ($checkExist) {
                        $datatext['result'] = false;
                        $datatext['msg']     = "This product already exists in your cart.";
                } else {

                    $get_record_var         = mysqli_query($con, "SELECT * FROM `product_variant` WHERE id = '".$product_variant_id."'");
                    $fetch_record_var = mysqli_fetch_array($get_record_var);
                    $price=$fetch_record_var['sale_price'];
                    $size=$fetch_record_var['size'];
                    $sleeve=$fetch_record_var['sleeve'];
                    $color=$fetch_record_var['color'];


                    $insert=mysqli_query($con, "INSERT INTO cart (user_id,product_variant_id,product_price,qty,size,sleeve,colour,product_type) VALUES ('$user_id','$product_variant_id','$price','$qty','$size','$sleeve','$color','$product_type')");
                        if ($insert) {
                                $datatext['result'] = true;
                                $datatext['msg']     = "succesfully add to cart";
                        } else {
                                $datatext['result'] = false;
                                $datatext['msg'] = "Please Try again";
                        }
                }

            }
            
            echo json_encode($datatext);
    }

        /****************************
     cart update
    ********************************/

    if ($method == "cartUpdate") {

        $cart_id       = mysqli_real_escape_string($con, $_POST['cart_id']);
        $qty       = mysqli_real_escape_string($con, $_POST['qty']);

            $update = mysqli_query($con, "UPDATE `cart` SET `qty`='$qty' WHERE cart_id='$cart_id'");

            if ($update) {

                    $datatext['success'] = true;
                    $datatext['msg']     = "succesfully Edit Your cart";

            } else {

                    $datatext['msg'] = "Please Try again";
            }
            echo json_encode($datatext);
    }  

    /****************************
     Add Address
    ********************************/
    if ($method == "addAddress") {
            $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
            $first_name    = mysqli_real_escape_string($con, $_POST['first_name']);
            $last_name         = mysqli_real_escape_string($con, $_POST['last_name']);
            $company           = mysqli_real_escape_string($con, $_POST['company']);
            $street_address           = mysqli_real_escape_string($con, $_POST['street_address']);
            $city           = mysqli_real_escape_string($con, $_POST['city']);
            $state           = mysqli_real_escape_string($con, $_POST['state']);
            $zip_code           = mysqli_real_escape_string($con, $_POST['zip_code']);
            $phone_number           = mysqli_real_escape_string($con, $_POST['phone_number']);
            
            $datatext      = array();
            $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user_address WHERE `user_id`='$user_id' AND `first_name`='$first_name' AND `last_name`= '$last_name' "));
                if ($checkExist) {
                        $datatext['result'] = false;
                        $datatext['msg']     = "This address already exists.";
                } else {
                    $insert=mysqli_query($con, "INSERT INTO `user_address`(`user_id`, `first_name`, `last_name`, `company`, `street_address`, `city`, `state`, `zip_code`, `phone_number`) VALUES ('$user_id','$first_name','$last_name','$company','$street_address','$city','$state','$zip_code','$phone_number')");
                        if ($insert) {
                                $datatext['result'] = true;
                                $datatext['msg']     = "succesfully add address";
                        } else {
                                $datatext['result'] = false;
                                $datatext['msg'] = "Please Try again";
                        }
                }
            
            echo json_encode($datatext);
    }


    /****************************
     Show Address List
    ********************************/
    if ($method == "showAddressList") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $datatext['results'] = false;

        $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `user_address` WHERE user_id = '$user_id' ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    $datatext['result']   = true;
                    $arr[]                = array(
                                "id" =>$fetch_record['id'],
                                "user_id" =>$fetch_record['user_id'],
                                "first_name" =>$fetch_record['first_name'],
                                "last_name" =>$fetch_record['last_name'],
                                "company" =>$fetch_record['company'],
                                "street_address" =>$fetch_record['street_address'],
                                "city" =>$fetch_record['city'],
                                "state" =>$fetch_record['state'],
                                "zip_code" =>$fetch_record['zip_code'],
                                "phone_number" =>$fetch_record['phone_number']
                    );

                    
            }
            $datatext['address'] = $arr;
            echo json_encode($datatext);
    }

    if($method=="removeAddress"){
        $add_id       = mysqli_real_escape_string($con, $_POST['add_id']);
        $datatext                = array();
        $datatext['results']     = false ;
        $res                 = mysqli_query($con, "SELECT * FROM user_address WHERE `id`='$add_id'");
        if ($res){ 
            $user_info           = mysqli_query($con, "DELETE FROM user_address where `id`='$add_id'");
            $datatext['results'] = true;
            $datatext['msg']     = "Delete Address Successfully.";
        }
        else{
            $datatext['results']  = false;
            $datatext['msg']      = "No Address Exist.";
        }
        echo json_encode($datatext);
    }
               
    /****************************
     Show Cart List
    ********************************/
    if ($method == "cartList") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $datatext['results'] = false;

        //echo json_encode($user_id);

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $datatext           = array();
            $datatext['result'] = true;
            $get_record         = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id' and status=0");
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    if($fetch_record['product_type']=='simple'){
                        $product_id = $fetch_record['product_id'];
                        $sub_record1 = mysqli_query($con, "SELECT * FROM `product` WHERE product_id='$product_id'");
                        $fetch_record1 = mysqli_fetch_array($sub_record1);
                        $photo=$fetch_record1['photo'];
                        $size='';
                        $sleeve='';
                        $color='';
                    }

                    if($fetch_record['product_type']=='variable'){
                        $product_variant_id = $fetch_record['product_variant_id'];
                        $sub_record1 = mysqli_query($con, "SELECT * FROM `product_variant` WHERE id='$product_variant_id'");
                        $fetch_record1 = mysqli_fetch_array($sub_record1);
                        $photo=$fetch_record1['thumbnail'];

                        $size=$fetch_record1['size'];
                        $sleeve=$fetch_record1['sleeve'];
                        $color=$fetch_record1['color'];
                    }
                    

                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '$photo'");
                        $fetch_record_img = mysqli_fetch_array($get_record_img);

                        $datatext['result']   = true;

                            $arr[]                = array(
                                    "id" =>$fetch_record['cart_id'],
                                    "product_id" =>$fetch_record1['product_id'],
                                    "name" =>$fetch_record1['name'],
                                    'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                                    "price" =>$fetch_record1['sale_price'],
                                    "qty" =>$fetch_record['qty'],
                                    "product_type" =>$fetch_record['product_type'],
                                    "size" =>$size,
                                    "sleeve" =>$sleeve,
                                    "color" =>$color
                            );

                    
            }
            $datatext['cart'] = $arr;
            echo json_encode($datatext);
    }

    if($method=="removeCartItem"){
        $cart_id       = mysqli_real_escape_string($con, $_POST['cart_id']);
        $datatext                = array();
        $datatext['results']     = false ;
        $res                 = mysqli_query($con, "SELECT * FROM cart WHERE `cart_id`='$cart_id'");
        if ($res){ 
            $user_info           = mysqli_query($con, "DELETE FROM cart where `cart_id`='$cart_id'");
            $datatext['results'] = true;
            $datatext['msg']     = "Delete Cart Item Successfully.";
        }
        else{
            $datatext['results']  = false;
            $datatext['msg']      = "No Cart Exist.";
        }
        echo json_encode($datatext);
    }


     /****************************
     Show Checkout Details
    ********************************/
    if ($method == "showCheckOutDetails") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $add_id       = mysqli_real_escape_string($con, $_POST['add_id']);

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $datatext           = array();
        $datatext['result'] = false;
        $get_record         = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id' and status=0 ");
        $cart_sub_total=0;
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    if($fetch_record['product_type']=='simple'){
                        $product_id = $fetch_record['product_id'];
                        $sub_record1 = mysqli_query($con, "SELECT * FROM `product` WHERE product_id='$product_id'");
                        $fetch_record1 = mysqli_fetch_array($sub_record1);
                        $photo=$fetch_record1['photo'];
                        $size='';
                        $sleeve='';
                        $color='';
                    }

                    if($fetch_record['product_type']=='variable'){
                        $product_variant_id = $fetch_record['product_variant_id'];
                        $sub_record1 = mysqli_query($con, "SELECT * FROM `product_variant` WHERE id='$product_variant_id'");
                        $fetch_record1 = mysqli_fetch_array($sub_record1);
                        $photo=$fetch_record1['thumbnail'];

                        $size=$fetch_record1['size'];
                        $sleeve=$fetch_record1['sleeve'];
                        $color=$fetch_record1['color'];
                    }
                    

                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '$photo'");
                        $fetch_record_img = mysqli_fetch_array($get_record_img);

                        $cart_sub_total+=$fetch_record['product_price']*$fetch_record['qty'];

                        $datatext['result']   = true;
                        

                            $arr[]                = array(
                                    "id" =>$fetch_record['cart_id'],
                                    "product_id" =>$fetch_record1['product_id'],
                                    "name" =>$fetch_record1['name'],
                                    'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                                    "price" =>$fetch_record1['sale_price'],
                                    "qty" =>$fetch_record['qty'],
                                    "sub_total" =>$fetch_record1['sale_price']*$fetch_record['qty'],
                                    "size" =>$size,
                                    "sleeve" =>$sleeve,
                                    "color" =>$color
                            );

                    
            }

            $get_record         = mysqli_query($con, "SELECT * FROM `user_address` WHERE user_id = '$user_id' AND id = '$add_id' ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    $datatext['result']   = true;
                    $billing_arr[]                = array(
                                "id" =>$fetch_record['id'],
                                "user_id" =>$fetch_record['user_id'],
                                "first_name" =>$fetch_record['first_name'],
                                "last_name" =>$fetch_record['last_name'],
                                "company" =>$fetch_record['company'],
                                "street_address" =>$fetch_record['street_address'],
                                "city" =>$fetch_record['city'],
                                "state" =>$fetch_record['state'],
                                "zip_code" =>$fetch_record['zip_code'],
                                "phone_number" =>$fetch_record['phone_number']
                    );

                    
            }


            $datatext['billing_address'] = $billing_arr;
            $datatext['cart_details'] = $arr;
            $datatext['cart_sub_total'] =$cart_sub_total;
            $datatext['shipping_rate'] =50;
            $datatext['cod_charge'] =75;
            $datatext['total'] =50+$cart_sub_total;
            echo json_encode($datatext);
    }

    /****************************
     Checkout
    ********************************/
    if ($method == "checkOut") {

        $post                = file_get_contents('php://input');
        $val                 = json_decode($post);

            $buyer_id = mysqli_real_escape_string($con, $val->user_id);
            $datatext['results'] = false;

            //echo json_encode($buyer_id);die;

            $testcheck6 = mysqli_query($con, "SELECT * FROM `user` WHERE user_id = '$buyer_id' ");

            while ($row = mysqli_fetch_array($testcheck6)) {

                //echo json_encode($row);die;
                    $user_id = $row['user_id'];
                    $name    = $row['fullname'];
                    $email   = $row['user_email'];
                    $phone   = $row['mobile'];
                    $address = $row['address'];
                    $pincode = $row['pincode'];

            
            $insert  = mysqli_query($con, "INSERT INTO `order`(customer_id, name, email, address, mobile, pin_code) VALUES ('$user_id', '$name', '$email', '$address', '$phone', '$pincode')");

            $last_id = $con->insert_id;

            if ($insert) 
            {

                foreach ($val->product as $key => $value) {
                   $insert  = mysqli_query($con, "INSERT INTO `product_order`(order_id, product_id, price, qty) VALUES ('$last_id', '$value->product_id', '$value->price', '$value->qty')");
                }
                $datatext['results'] = true;
                $datatext['msg']     = "Congratulations!Order Placed";
            }
            else{
                $datatext['results'] = false;
                $datatext['msg']     = "Please Try again";
            }
                    
        }
        echo json_encode($datatext);
    }


    /****************************
     Place Order
    ********************************/
    if ($method == "placeOrder") {


        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $add_id       = mysqli_real_escape_string($con, $_POST['add_id']);
        $order_type       = mysqli_real_escape_string($con, $_POST['order_type']);
        $datatext           = array();
        $datatext['result'] = false;
        date_default_timezone_set('Asia/Calcutta');
           $date=date('Y/m/d h:i:s');

        if($user_id!='' && $add_id!='' && $order_type!=''){
           $select_query=mysqli_query($con, "SELECT * from cart where status = 0 and user_id ='$user_id'");
           $total_price=0;
           $grandtotal=0;
           $qty=0;
           $rowcount=mysqli_num_rows($select_query);
            if($rowcount>0){
                   while($row = mysqli_fetch_array($select_query)){
                    $sub_price=$row['qty']*$row['product_price'];
                    $total_price=$total_price+$sub_price;
                   //$total_qty+=$row['qty'];
                        $cart_idarry[]=$row['cart_id'];
                   }
                   
                   $cart_id=implode(",",$cart_idarry);
                   for($i = 0; $i <count($cart_idarry); $i++) {
                        $cart_id_f=$cart_idarry[$i];
                        $sql2=mysqli_query($con,"update `cart` set `status`='1' where cart_id='$cart_id_f'");
                    }
                

                    $get_record         = mysqli_query($con, "SELECT * FROM `user_address` WHERE user_id = '$user_id' AND id = '$add_id' ");
                    $rowcount_add=mysqli_num_rows($get_record);
                    if($rowcount_add>0){
                        $fetch_record = mysqli_fetch_array($get_record);
                        $first_name =$fetch_record['first_name'];
                        $last_name = $fetch_record['last_name'];
                        $company    = $fetch_record['company'];
                        $street_address   = $fetch_record['street_address'];
                        $city   = $fetch_record['city'];
                        $state = $fetch_record['state'];
                        $zip_code = $fetch_record['zip_code'];
                        $phone_number = $fetch_record['phone_number'];


                        $testcheck6 = mysqli_query($con, "SELECT * FROM `user` WHERE user_id = '$user_id' ");
                        $row = mysqli_fetch_array($testcheck6);
                        $email   = $row['user_email'];
                        $cod_charge=0;
                        $shipiing_charge=50;
                        $status=0;
                        if($order_type=='cod'){
                            $cod_charge=75;
                            $status=1;
                        }

                        $grandtotal=$total_price+$cod_charge+$shipiing_charge;


                        $insert  = mysqli_query($con, "INSERT INTO `order`(customer_id, cart_id, name, email, address, pin_code,state_id,mobile,price,delivery_charge,cod_charge,payment_status,order_date,status,order_type,total_price) VALUES ('$user_id', '$cart_id', '$first_name','$email', '$street_address', '$zip_code', '$state','$phone_number','$total_price','$shipiing_charge','$cod_charge','0','$date','$status','$order_type','$grandtotal')");

                        if ($insert) 
                        {
                            if($order_type=='prepaid'){
                                $order_id=mysqli_insert_id($con);
                                $datatext['url']     = "http://stylecabbie.in/stylecabbie_api/payment/pay.php?order_id=".$order_id;
                            }
                            
                            $datatext['result'] = true;
                            $datatext['msg']     = "Congratulations!Order Placed";
                            
                        }
                        else{
                            $datatext['results'] = false;
                            $datatext['msg']     = "Please Try again";
                        }
                    }else{
                        $datatext['results'] = false;
                        $datatext['msg']     = "Address not valid";
                    }
            }else{
                    $datatext['results'] = false;
                    $datatext['msg']     = "Invalid Request";
                }
        }else{
            $datatext['results'] = false;
            $datatext['msg']     = "Parameter missing.";
        }
        echo json_encode($datatext);
    }


    /****************************
     Order History
    ********************************/
       if ($method == "orderHistory") {

            $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);


            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

            $datatext           = array();
            $datatext['result'] = false;
            $get_record11         = mysqli_query($con, "SELECT * FROM `order` WHERE customer_id = '$user_id' order by order_id DESC ");
            $cart_sub_total=0;
                while ($fetch_record11 = mysqli_fetch_array($get_record11)) {

                        $cart_ids = $fetch_record11['cart_id'];
                        $myproduct=explode(',',$cart_ids);
                        
                        $arr = array();
                        for($i = 0; $i <count($myproduct); $i++) {

                            $query3 = mysqli_query($con, "SELECT * FROM `cart` where cart_id='$myproduct[$i]' ORDER BY cart_id asc" );
                                $fetch_record=mysqli_fetch_array($query3);
                                $produce_id=$fetch_record['product_id'];
                                $qty=$fetch_record['qty'];
                                $product_price=$fetch_record['product_price'];
                                
                                 if($fetch_record['product_type']=='simple'){
                                    $product_id = $fetch_record['product_id'];
                                    $sub_record1 = mysqli_query($con, "SELECT * FROM `product` WHERE product_id='$product_id'");
                                    $fetch_record1 = mysqli_fetch_array($sub_record1);
                                    $product_name=$fetch_record1['name'];
                                    $photo=$fetch_record1['photo'];
                                    $size='';
                                    $sleeve='';
                                    $color='';
                                }

                                if($fetch_record['product_type']=='variable'){
                                    $product_variant_id = $fetch_record['product_variant_id'];
                                    $sub_record1 = mysqli_query($con, "SELECT * FROM `product_variant` WHERE id='$product_variant_id'");
                                    $fetch_record1 = mysqli_fetch_array($sub_record1);
                                    $product_name=$fetch_record1['name'];
                                    $photo=$fetch_record1['thumbnail'];

                                    $size=$fetch_record1['size'];
                                    $sleeve=$fetch_record1['sleeve'];
                                    $color=$fetch_record1['color'];
                                }
                                

                                    $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '$photo'");
                                    $fetch_record_img = mysqli_fetch_array($get_record_img);

                            $arr[]                = array(
                                        "id" =>$myproduct[$i],
                                        "product_id" =>$produce_id,
                                        "name" =>$product_name,
                                        'photo'     =>$actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                                        "price" =>$product_price,
                                        "qty" =>$qty,
                                        "sub_total" =>$product_price*$qty,
                                        "size" =>$size,
                                        "sleeve" =>$sleeve,
                                        "color" =>$color
                                );

                

                        }

                        $datatext['result'] = true;

               $orderArr[]    = array(
                                "order_id" =>$fetch_record11['order_id'],
                                "total_price" =>$fetch_record11['total_price'],
                                "delivery_charge" =>$fetch_record11['delivery_charge'],
                                'cod_charge'     =>$fetch_record11['cod_charge'],
                                "status" =>$fetch_record11['status'],
                                "product_details" =>$arr
                            );

            }


                $datatext['order_history'] = $orderArr;
                echo json_encode($datatext);
        }
    
    
    /****************************
     Profile update
    ********************************/

    if ($method == "profileUpdate") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $fullname       = mysqli_real_escape_string($con, $_POST['fullname']);
        $mobile       = mysqli_real_escape_string($con, $_POST['mobile']);

        $checkExist = mysqli_query($con, "SELECT * FROM user WHERE `user_id`='$user_id'");

            //echo json_encode($checkExist);die;
            if ($row = mysqli_fetch_array($checkExist)) {

                    $update = mysqli_query($con, "UPDATE `user` SET `fullname`='$fullname',`mobile`='$mobile' WHERE user_id='$user_id'");

                    if ($update) {

                            $datatext['success'] = true;
                            $datatext['msg']     = "succesfully Edit Your Profile";

                    } else {

                            $datatext['msg'] = "Please Try again";
                    }
            } else {

                    $datatext['msg'] = "Please Try again";
            }
            echo json_encode($datatext);
    }  


    /****************************
     Show profile
    ********************************/
    if ($method == "showProfile") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $datatext['results'] = false;

        $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `user` WHERE user_id = '$user_id' ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    $datatext['result']   = true;
                    $arr                = array(
                                "user_id" =>$fetch_record['user_id'],
                                "first_name" =>$fetch_record['fullname'],
                                "user_email" =>$fetch_record['user_email'],
                                "mobile" =>$fetch_record['mobile'],
                                "profile_pic" =>$fetch_record['profile_pic']
                    );

                    
            }
            $datatext['profile'] = $arr;
            echo json_encode($datatext);
    }  


    /****************************
     Change Password
    ********************************/

    if($method=="ChangePwd")
    {    
        if(isset($_POST['user_id']) && $_POST['user_id']!='' && isset($_POST['old_password']) && $_POST['old_password']!='' && isset($_POST['new_password']) && $_POST['new_password']!=''){

            $user_id=mysqli_real_escape_string($con,$_POST['user_id']);
            $old_password=mysqli_real_escape_string($con,md5($_POST['old_password']));
            $new_password=mysqli_real_escape_string($con,md5($_POST['new_password']));
            $confirm_password=mysqli_real_escape_string($con,md5($_POST['confirm_password']));

            if($_POST['new_password']==$_POST['confirm_password']){
                $sel=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user WHERE `user_id`='$user_id' AND `pwd`='$old_password' "));
                $datatext=array();
                $datatext['result']=false;
                if($sel)
                {
                    $update = mysqli_query($con, "UPDATE `user` SET `pwd`='$new_password' WHERE user_id='$user_id'");
                    $datatext['result']=true;
                    $datatext['msg']="Password Changed Succesfully";

                }else{
                    $datatext['result']=false;
                    $datatext['msg']="Old password not matched.";
                }
            }else{
                    $datatext['result']=false;
                    $datatext['msg']="Confirm Password not matched.";
            }

         }else{
            $datatext['result']=false;
            $datatext['msg']="password should not be blank.";
         }
         
         
        echo json_encode($datatext);
    }


/****************************
     forget Password Otp
********************************/

    if ($method == "forgetPasswordOtp") {
        $email       = mysqli_real_escape_string($con, $_POST['email']);
        $datatext            = array();
        $datatext['result'] = false;
        $chk = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user WHERE `user_email`='$email'"));
        if ($chk>0){ 
            $datatext['result']  = true;
            $email                = $chk['user_email'];

            $six_digit_random_number = mt_rand(100000,999999);

            send_reset_pwd_mail($email,$six_digit_random_number);

            $user_info = mysqli_query($con, "update user set `otp_pwd_reset`='$six_digit_random_number'  where `user_email`='$email'");
            if($user_info){
                
                    $datatext['msg']          = "Otp sent on mail please check mail.";
                }else{
                    $datatext['msg']      = "Something Went wrong.";
                }
            }else {
                $datatext['result']  = false;
                $datatext['msg']      = "Invalid email.";
            }
            echo json_encode($datatext);
        }

    /****************************
     Verify and forgot Password
    ********************************/

    if($method=="VerifyForgotPwd")
    {    
        if(isset($_POST['email']) && $_POST['email']!='' && isset($_POST['otp']) && $_POST['otp']!='' && isset($_POST['confirm_password']) && $_POST['confirm_password']!='' && isset($_POST['new_password']) && $_POST['new_password']!=''){

            $email=mysqli_real_escape_string($con,$_POST['email']);
            $otp=mysqli_real_escape_string($con,$_POST['otp']);
            $new_password=mysqli_real_escape_string($con,md5($_POST['new_password']));
            $confirm_password=mysqli_real_escape_string($con,md5($_POST['confirm_password']));

            if($_POST['new_password']==$_POST['confirm_password']){
                $sel=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user WHERE `user_email`='$email' AND `otp_pwd_reset`='$otp' "));
                $datatext=array();
                $datatext['result']=false;
                if($sel)
                {
                    $update = mysqli_query($con, "UPDATE `user` SET `pwd`='$new_password',`otp_pwd_reset`='' WHERE user_email='$email'");
                    $datatext['result']=true;
                    $datatext['msg']="Forgot Password Succesfully.";

                }else{
                    $datatext['result']=false;
                    $datatext['msg']="Otp not matched.";
                }
            }else{
                    $datatext['result']=false;
                    $datatext['msg']="Confirm Password not matched.";
            }

         }else{
            $datatext['result']=false;
            $datatext['msg']="password,email,otp should not be blank.";
         }
         
         
        echo json_encode($datatext);
    }

    /****************************
    searching by subCategory
    ********************************/

    if($method=="searching"){

        $keyword        = mysqli_real_escape_string($con, $_POST['keyword']);
        // set the number of items to display per page
        /*$items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;
        $datatext                = array();*/
        $datatext['results']     = false ;

        $popularList             = mysqli_query($con,"SELECT * FROM  `product` WHERE name like '%".$keyword."%' ");

        /*=========for domain and image folder path ==========*/
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        /*=========for domain and image folder path ==========*/
        
        while($product           = mysqli_fetch_array($popularList)){

            $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$product['photo']."'");
            $fetch_record_img = mysqli_fetch_array($get_record_img);

            $popularProductList[] =   array(
                'product_id'     => $product['product_id'],
                'name'      => $product['name'],
                'photo'     => $actual_link."/stylecabbie_api/stylecabbie_admin/".$fetch_record_img['image'],
                'description'    => $product['description'],
                'price'       => $product['price'],
                'sale_price'       => $product['sale_price'],
                'product_type' =>$product['product_type']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularProductList ;
        echo json_encode($datatext);
    }


        /****************************
     Profile update
    ********************************/

    if ($method == "profileImageUpdate") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $datatext['success'] = false;

        $checkExist = mysqli_query($con, "SELECT * FROM user WHERE `user_id`='$user_id'");

            //echo json_encode($checkExist);die;
            if ($row = mysqli_fetch_array($checkExist)) {

                $myimg = $_FILES["file"]["name"];
                $path1 = "stylecabbie_admin/img/".time().rand(10000,99999).".jpg";
                 if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) 
                 {
                 }else{
                    echo json_encode($datatext);exit;
                 }

                 /*=========for domain and image folder path ==========*/
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                /*=========for domain and image folder path ==========*/

                    $update = mysqli_query($con, "UPDATE `user` SET `profile_pic`='$path1' WHERE user_id='$user_id'");

                    if ($update) {

                            $datatext['success'] = true;
                            $datatext['msg']     = "succesfully Edit Your Profile Picture.";
                            $datatext['profile_url']     = $actual_link."/stylecabbie_api/".$path1;

                    } else {

                            $datatext['msg'] = "Please Try again";
                    }
            } else {

                    $datatext['msg'] = "Please Try again";
            }
            echo json_encode($datatext);
    } 

    /****************************
     Show Address List
    ********************************/
    if ($method == "getNotificationList") {

        $user_id       = mysqli_real_escape_string($con, $_POST['user_id']);
        $datatext['results'] = false;

        $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `notification` WHERE user_id = '$user_id' ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {

                    $datatext['result']   = true;
                    $arr[]                = array(
                                "id" =>$fetch_record['n_id'],
                                "title" =>$fetch_record['title'],
                                "message" =>$fetch_record['message'],
                                "date" =>$fetch_record['date']
                    );

                    
            }
            $datatext['notification'] = $arr;
            echo json_encode($datatext);
    }

?>