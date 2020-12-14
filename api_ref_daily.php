<?php
include('connection.php');
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
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

    $method = mysqli_real_escape_string($con, $_REQUEST['method']);

    //image upload 
    if($method=="profile_upload"){
        if(!empty($_FILES['file']['name'])){
            $path1 = "../DWadmin/assets/img/".time().rand(10000,99999).".jpg";
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)){
                $data_result['result'] = "true";
                $data_result['data']   = 'http://dailywale.com/'.$path1;
                // $data_result['data']   = 'http://localhost/dailywaleApi/'.$path1;
                $data_result['msg']    = "Image Upload Successfully!";
            }else{
                $picture               = '';
                $data_result['msg']    = "Image not Upload Successfully!";
            }
        }else{
            $data_result['msg']        = "Please Select Image !";
            $data_result['result']     = "false";
        }
        echo json_encode($data_result);
    }

    //Edit Profile
    if($method=="editProfile"){
        $post                = file_get_contents('php://input');
        $val                 = json_decode($post);
        $id                  = $val->id;
        $name                = $val->name;
        $phone               = $val->phone;
        $profile             = $val->profile;
        date_default_timezone_set('Asia/Calcutta');
        $updated_at          = date('Y-m-d H:i');

        $datatext            =array();
        $datatext['results'] = false ;

        $updateCiUser        =   mysqli_query($con,"UPDATE ci_user SET name='$name' ,phone='$phone',profile='$profile', updated_at='$updated_at' where id='$id' ");
        if ($updateCiUser) {
            $chkUser = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$id' "));
            if ($chkUser){
              $datatext['results']      = true;
              $datatext['user_id']      = $chkUser['id'];
              $datatext['phone']        = $chkUser['phone'];
              $datatext['name']         = $chkUser['name'];
              $datatext['img']          = $chkUser['profile'];
              $datatext['email']        = $chkUser['email'];
              $datatext['msg']          = "Edit Your Profile Successfully!!";
            }else{
                $datatext['results']    = false;
                $datatext['msg']        = "Not Found.";
            }
        }else{
          $datatext['results'] = false ;
          $datatext['msg']     = 'Profile Not Edit Successfully!!';
        }
        echo json_encode($datatext);    
    }

    /****************************
      Change Password
    ********************************/
    if ($method == "changePassword") {
        $post                = file_get_contents('php://input');
        $val                 = json_decode($post);
        $user_id             = $val->user_id;
        $newpwd              = $val->newpwd;
        $oldpwd              = $val->oldpwd;
        $datatext            = array();
        $datatext['results'] = false;
        $res                 = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$user_id' and `password`='$oldpwd'");
        if ($chk = mysqli_fetch_array($res)){ 
            $user_info           = mysqli_query($con, "update ci_user set `password`='$newpwd' where `id`='$user_id'");
            $datatext['results'] = true;
            $datatext['msg']     = "Password Changed Successfully.";
        }
        else{
            $datatext['results']  = false;
            $datatext['msg']      = "Old password not valid.";
        }
        echo json_encode($datatext);
    }

    /****************************
      Forgot password
    ********************************/
    if ($method == "forgetPassword") {
        $post                = file_get_contents('php://input');
        $val                 = json_decode($post);
        $email               = $val->email;
        $datatext            = array();
        $datatext['results'] = false;
        $chk = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_user WHERE `email`='$email'"));
        if ($chk>0){ 
            $datatext['results']  = true;
            $email                = $chk['email'];

            $six_digit_random_number = mt_rand(100000, 999999);

            $user_info = mysqli_query($con, "update ci_user set `password`='$six_digit_random_number'  where `email`='$email'");
            if($user_info){
                $to      = $email;
                $subject = 'Dailywale Password Reset';

                $headers = "From: " . strip_tags('noreply@Dailywale.com') . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                // $message .= '<!DOCTYPE html>
                $message = '<!DOCTYPE html>
                            <html>
                              <head>
                              </head>
                            <body style=" margin: 0 auto;">
                            <div class="wrapper" style="width:100%;" >
                                <header style="width: 100%; float: left; background-color: #EA4335; clear: left; text-align: center;">
                                   <span style="padding: 10px;font-size: 40px;color: white;">Dailywale</span>
                                </header>
                                <section>
                                  <div class="container" style="width: 100%; margin: 0 auto;overflow: hidden; max-width: 1170px;">
                                    <div class="section">
                              
                                      <p style="font-size:24px;">Dear Customer</p>
                                      <p style="font-size:20px; ">Your new Dailywale Password is: '.$six_digit_random_number.'. </p>
                                      <p style="float:right; font-size:24px; margin-right:190px;">Thanks</p>
                                    </div>

                                  </div>
                                </section>


                            <footer style="  color: white; background-color: black; height: auto; width: 100%; float: left;">
                            <div class="container"  style="width: 100%; margin: 0 auto;overflow: hidden; max-width: 1170px;">
                              <div class="main-box" style=" width: 100%;">
                                
                                <div style=" width: 30%; float: right; margin-right: 125px; margin-top: 10px;
                            "> 
                                  <a href="#"><span class="text-right" style="float: right;font-size: 24px;margin-top: 5px; color:#fff;">www.Dailywale.com</span></a>
                                </div>
                                </div>
                            </footer>


                            </div>
                            </body>
                            </html>';
                mail($to, $subject, $message, $headers);
                $datatext['msg']          = "Password sent Successfully.";
                $datatext['New_password'] = $six_digit_random_number;
                }else{
                    $datatext['msg']      = "Something Went wrong.";
                }
            }else {
                $datatext['results']  = false;
                $datatext['msg']      = "Invalid email.";
            }
            echo json_encode($datatext);
        }

    //populor list with item and prices
    if($method=="popularProduct"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $popular                 = mysqli_query($con,"SELECT * FROM  populor");
        while($pop               = mysqli_fetch_array($popular)){
            $section_id          = $pop['section_id'];
            $subcat_id           = $pop['subcat_id'];
            $cat_id              = $pop['cat_id'];
            $section             = mysqli_query($con,"SELECT * FROM  section where id='$section_id'");
            if($sectionData      = mysqli_fetch_assoc($section)){
                $section_name    = $sectionData['name'];
            } else{
                $section_name    = 'no data found';
            }  
            $subcatId            = mysqli_query($con,"SELECT * FROM  ci_subcategory where id='$subcat_id'");
            if($subcat           = mysqli_fetch_assoc($subcatId)){
                $item_id         = $subcat['id'];
                $item_name       = $subcat['item_name'];
                $item_price      = $subcat['item_price'];
                $description     = $subcat['description'];
                $item_img        = 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$subcat['img'];
                
                $catId           = mysqli_query($con,"SELECT * FROM  ci_categories where id='$cat_id'");
                if($cat          = mysqli_fetch_assoc($catId)){
                    $cat_name    = $cat['cat_name'];
                }else{
                    $cat_name    = "No category name";
                }
            } else{
                $name            = 'no data found';
            }  
            $popularList[]       =   array(
                'product_id'     =>  $item_id,
                'popular_id'     =>  $pop['id'],
                'section_id'     =>  $section_id,
                'section_name'   =>  $section_name,
                'cat_id'          => $cat_id,
                'cat_name'        => $cat_name,
                'item_id'         => $subcat_id,
                'item_name'       => $item_name,
                'item_price'      => $item_price,
                'item_img'        => $item_img,
                'item_description'=> $description
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularList ;
        echo json_encode($datatext);
    }

    //product list with item and prices
    if($method=="productListing"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $popularList             = mysqli_query($con,"SELECT * FROM  ci_subcategory");
        while($popular           = mysqli_fetch_array($popularList)){
            $cat_id              = $popular['cat_id'];

            $catId               = mysqli_query($con,"SELECT * FROM  ci_categories where id='$cat_id'");
            if($cat              = mysqli_fetch_assoc($catId)){
                $cat_name        = $cat['cat_name'];
            }else{
                $cat_name        = "No category name";
            }
              
            $popularProductList[] =   array(
                'product_id'     => $popular['id'],
                'cat_id'         => $cat_id,
                'cat_name'       => $cat_name,
                'item_name'      => $item_name,
                'item_price'     => $item_price,
                'description'    => $description,
                'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$popular['img'],
                'units'          => $units,
                'weight'         => $weight,
                'in_stock'       => $in_stock,
                'discount'       => $discount,
                'extra_charge'   => $extra_charge,
                'stock'          => $stock
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $popularProductList ;
        echo json_encode($datatext);
    }

    //remove cart item 
    if($method=="removeCartItem"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $cart_id                 = $val->cart_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $res                 = mysqli_query($con, "SELECT * FROM ci_cart WHERE `id`='$cart_id'");
        if ($res){ 
            $user_info           = mysqli_query($con, "DELETE FROM ci_cart where `id`='$cart_id'");
            $datatext['results'] = true;
            $datatext['msg']     = "Delete Cart Item Successfully.";
        }
        else{
            $datatext['results']  = false;
            $datatext['msg']      = "No Cart Exist.";
        }
        echo json_encode($datatext);
    }

    //add to cart
    if ($method == "addToCart") {
        $post                = file_get_contents('php://input');
        $val                 = json_decode($post);
        $buyer_id            = $val->user_id;
        $quantity            = $val->quantity;
        $item_id             = $val->item_id;
        $price               = $val->price;
        $total_amount        = $val->total_amount;
        $SelectedType        = $val->SelectedType;
        // print_r($val->ScheduleOn);exit();
         // $day[0] = '';
        $datatext            = array();
        $datatext['results'] = false;
        //echo"SELECT * FROM add_cart WHERE `cart_id`='$cart_id'";exit;
        
            // echo"INSERT INTO ci_cart(`buyer_id`,`item_id`,`quantity`,`price`,`total_amount`) VALUES('$buyer_id','$item_id','$quantity','$price','$total_amount')";exit;
            if ($SelectedType == "Tomorrow") {
                $ScheduleOn   = 'Next Morning';
            }else if ($SelectedType == "ScheduleDate") {
                $ScheduleOn   = $val->ScheduleOn;
            }else {
                $value = $val->ScheduleOn;
                // print_r($value[0]->Sunday);
                if ($value[0]->Sunday=='true') {
                    $day[] = 'Sun';
                }
                if ($value[0]->Monday=='true') {
                    $day[] = 'Mon';
                }
                if ($value[0]->Tuesday=='true') {
                    $day[] = 'Tue';
                }
                if ($value[0]->Wednesday=='true') {
                    $day[] = 'Wed';
                }
                if ($value[0]->Thrusday=='true') {
                    $day[] = 'Thr';
                }
                if ($value[0]->Friday=='true') {
                    $day[] = 'Fri';
                }
                if ($value[0]->Saturday=='true') {
                    $day[] = 'Sat';
                }
                // $ScheduleOn   = $val->ScheduleOn;
                // print_r($day);
                $ScheduleOn = implode(',',$day);
                // print_r($ScheduleOn);
            }
        // exit;
             $cart_info = mysqli_query($con, "INSERT INTO ci_cart(`buyer_id`,`item_id`,`quantity`,`price`,`total_amount`,`schedule_for`) VALUES('$buyer_id','$item_id','$quantity','$price','$total_amount','$ScheduleOn')");

            if ($cart_info){
                $id=mysqli_insert_id($con);
                //echo "SELECT * FROM add_cart WHERE `cart_id`='$id'";exit;
                $show_info = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ci_cart WHERE `id`='$id'"));
                $datatext['results']        = true;
                // $datatext['cart_id']        = $id;
                // $datatext['user_id']        = $show_info['user_id'];
                // $datatext['product_id']     = $show_info['product_id'];
                // $datatext['shop_id']        = $show_info['shop_id'];
                $datatext['cartData']      =  $show_info;
                
                $datatext['msg']            = "Product add Successfully";
            }else { 
                $datatext['results']        = false;
                $datatext['msg']        = "doesn't add.";
                
                }
        echo json_encode($datatext);
    }

    //List of cart Acc to user id 
    if($method=="cartListAccToUser"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $buyer_id                = $val->user_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $res                     = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$buyer_id' and payment_status!='1' ");
        $count                   = mysqli_num_rows($res);
        if ($count>0) {
            while($res1 = mysqli_fetch_assoc($res)){ 
                $subId                  = mysqli_query($con,"SELECT * FROM   ci_subcategory where id='".$res1['item_id']."'");
                if($sub                 = mysqli_fetch_assoc($subId)){
                    $item_name          = $sub['item_name'];
                    $item_img           = 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$sub['img'];
                }else{
                    $item_name          = "No item name";
                }
                  
                $datatext['results']    = true;
                 $carAccToUser[]        =   array(
                    'cart_id'           => $res1['id'],
                    'buyer_id'          => $res1['buyer_id'],
                    'item_id'           => $res1['item_id'],
                    'item_name'         => $item_name,
                    'quantity'          => $res1['quantity'],
                    'price'             => $res1['price'],
                    'item_img'          => $item_img,
                    'payment_status'    => $res1['payment_status'],
                    'total_amount'      => $res1['total_amount']
                );
            }
            $datatext['results']        = true ;
            $datatext['data']           = $carAccToUser ;
            $datatext['msg']            = 'User Cart List' ;
        }else{
            $datatext['results']        = false ;
            $datatext['msg']            = 'No Cart Data Exists' ;           
        }
        echo json_encode($datatext);
    }

    //List of order Acc to user id 
    if($method=="orderListAccToUser"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $user_id                 = $val->user_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $res                     = mysqli_query($con, "SELECT * FROM order WHERE `user_id`='$user_id'");
        $count                   = mysqli_num_rows($res);
        if ($count>0) {
            while($res1 = mysqli_fetch_assoc($res)){ 
                $subId                  = mysqli_query($con,"SELECT * FROM ci_user where id='".$res1['item_id']."'");
                if($sub                 = mysqli_fetch_assoc($subId)){
                    $item_name          = $sub['item_name'];
                }else{
                    $item_name          = "No item name";
                }
                  
                $datatext['results']    = true;
                 $carAccToUser[]        =   array(
                    'cart_id'           => $res1['id'],
                    'buyer_id'          => $res1['buyer_id'],
                    'item_id'           => $res1['item_id'],
                    'item_name'         => $item_name,
                    'quantity'          => $res1['quantity'],
                    'price'             => $res1['price'],
                    'total_amount'      => $res1['total_amount']
                );
            }
            $datatext['results']        = true ;
            $datatext['data']           = $carAccToUser ;
            $datatext['msg']            = 'User Cart List' ;
        }else{
            $datatext['results']        = false ;
            $datatext['msg']            = 'No User Order Exists' ;           
        }
        echo json_encode($datatext);
    }

    //Category list 
    if($method=="categoryListing"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $popularList             = mysqli_query($con,"SELECT * FROM  ci_categories");
        while($popular           = mysqli_fetch_array($popularList)){
            $section_id          = $popular['section_id'];

            $catId               = mysqli_query($con,"SELECT * FROM  section where id='$section_id'");
            if($cat              = mysqli_fetch_assoc($catId)){
                $section_name    = $cat['name'];
            }else{
                $section_name    = "No Section name";
            }
              
            $catList[] =   array(
                'cat_id'         => $popular['id'],
                'cat_name'       => $popular['cat_name'],
                'cat_des'        => $popular['cat_des'],
                'cat_img'        => 'http://www.dailywale.com/DWadmin/assets/CategoryImg/'.$popular['img'],
                'cat_img_banner' => 'http://www.dailywale.com/DWadmin/assets/CategoryImg/'.$popular['img_banner'],
                'section_id'     => $section_id,
                'section_name'   => $section_name
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $catList ;
        echo json_encode($datatext);
    }

    //product list with item and prices Acco. to cat_id
    if($method=="productListingAccToCategory"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $cat_id                  = $val->cat_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $subcat                     = mysqli_query($con,"SELECT * FROM  ci_subcategory where cat_id='$cat_id'");
        $count                   = mysqli_num_rows($subcat);
        if ($count>0) {
            while($popular = mysqli_fetch_assoc($subcat)){
                // $cat_id              = $popular['cat_id'];

                $catId               = mysqli_query($con,"SELECT * FROM  ci_categories where id='$cat_id'");
                if($cat              = mysqli_fetch_assoc($catId)){
                    $cat_name        = $cat['cat_name'];
                }else{
                    $cat_name        = "No category name";
                }
                  
                $catProductList[] =   array(
                    'product_id'     => $popular['id'],
                    'cat_id'         => $cat_id,
                    'cat_name'       => $cat_name,
                    'item_name'      => $popular['item_name'],
                    'item_price'     => $popular['item_price'],
                    'description'    => $popular['description'],
                    'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$popular['img'],
                    'units'          => $popular['units'],
                    'weight'         => $popular['weight'],
                    'in_stock'       => $popular['in_stock'],
                    'discount'       => $popular['discount'],
                    'extra_charge'   => $popular['extra_charge'],
                    'stock'          => $popular['stock']
                );
            }   
            $datatext['results']      = true ;
            $datatext['data']         = $catProductList ;
        }else{
            $datatext['results']      = false ;
            $datatext['data']         = 'No data Found According to Category Id' ;
        }
        echo json_encode($datatext);
    }

    //product list with item and prices Acco. to product_id
    if($method=="productListingAccToProductId"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $product_id              = $val->product_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $subcat                     = mysqli_query($con,"SELECT * FROM  ci_subcategory where id='$product_id'");
        $count                   = mysqli_num_rows($subcat);
        if ($count>0) {
            while($popular = mysqli_fetch_assoc($subcat)){
                $cat_id              = $popular['cat_id'];

                $catId               = mysqli_query($con,"SELECT * FROM  ci_categories where id='$cat_id'");
                if($cat              = mysqli_fetch_assoc($catId)){
                    $cat_name        = $cat['cat_name'];
                }else{
                    $cat_name        = "No category name";
                }
                  
                $catProductList      =   array(
                    'product_id'     => $popular['id'],
                    'cat_id'         => $cat_id,
                    'cat_name'       => $cat_name,
                    'item_name'      => $popular['item_name'],
                    'item_price'     => $popular['item_price'],
                    'description'    => $popular['description'],
                    'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$popular['img'],
                    'units'          => $popular['units'],
                    'weight'         => $popular['weight'],
                    'in_stock'       => $popular['in_stock'],
                    'discount'       => $popular['discount'],
                    'extra_charge'   => $popular['extra_charge'],
                    'stock'          => $popular['stock']
                );
            }   
            $datatext['results']      = true ;
            $datatext['data']         = $catProductList ;
        }else{
            $datatext['results']      = false ;
            $datatext['data']         = 'No data Found According to Product Id' ;
        }
        echo json_encode($datatext);
    }

    //popular product list with item and prices Acco. to product_id
    if($method=="popularProductListingAccToProductId"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $product_id              = $val->product_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $popularr                = mysqli_query($con,"SELECT * FROM  populor where id='$product_id'");
        $count                   = mysqli_num_rows($popularr);
        if ($count>0) {
            while($popular = mysqli_fetch_assoc($popularr)){
                $cat_id              = $popular['cat_id'];
                $subcat_id           = $popular['subcat_id'];
                $section_id          = $popular['section_id'];

                $catId               = mysqli_query($con,"SELECT * FROM  ci_categories where id='$cat_id'");
                if($cat              = mysqli_fetch_assoc($catId)){
                    $cat_name        = $cat['cat_name'];
                }else{
                    $cat_name        = "No category name";
                }

                $subcatId            = mysqli_query($con,"SELECT * FROM  ci_subcategory where id='$subcat_id'");
                if($subcat           = mysqli_fetch_assoc($subcatId)){
                    $item_id         = $subcat['id'];
                    $item_name       = $subcat['item_name'];
                    $item_price      = $subcat['item_price'];
                    $item_img        = $subcat['img'];
                    $description     = $subcat['description'];
                    $units           = $subcat['units'];
                    $weight          = $subcat['weight'];
                    $in_stock        = $subcat['in_stock'];
                    $discount        = $subcat['discount'];
                    $stock           = $subcat['stock'];
                    $extra_charge    = $subcat['extra_charge'];
                }else{
                    $subcat_name     = "No category name";
                }
                  
                $PopularProductList  =   array(
                    'product_id'     => $popular['id'],
                    'cat_id'         => $cat_id,
                    'cat_name'       => $cat_name,
                    'item_name'      => $item_name,
                    'item_price'     => $item_price,
                    'description'    => $description,
                    'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$item_img,
                    'units'          => $units,
                    'weight'         => $weight,
                    'in_stock'       => $in_stock,
                    'discount'       => $discount,
                    'extra_charge'   => $extra_charge,
                    'stock'          => $stock
                );
            }   
            $datatext['results']      = true ;
            $datatext['data']         = $PopularProductList ;
        }else{
            $datatext['results']      = false ;
            $datatext['data']         = 'No data Found According to Product Id' ;
        }
        echo json_encode($datatext);
    }

    //wallet Insert list
    if($method=="orderInsert"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $user_id                 = $val->user_id;
        $grandTotal              = $val->grandTotal;
        $address_id              = $val->address_id;
        $cart_id                 = $val->item;
        $order_id                = mt_rand(1000000000000,99999999999999);
        // echo"INSERT INTO order (user_id,address,payable_amt,paymentStatus) VALUES ('$user_id','$address_id','$grandTotal','1')";
        $add                  = mysqli_query($con,"INSERT INTO `order` (user_id,address,payable_amt,paymentStatus,order_id) VALUES ('$user_id','$address_id','$grandTotal','1','$order_id')");
        if($add){
            $cart = explode(',',$cart_id);
            for ($i=0; $i <count($cart); $i++) { 
                $update              = mysqli_query($con,"UPDATE ci_cart SET payment_status='1' WHERE id='".$cart[$i]."' ");
            }
            if($update){
                $ad             = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM  dv_wallets WHERE user_id='$user_id'"));
                if($ad){
                    $amount              = $ad['wallet_balance'];
                    $amt                 = $amount-$grandTotal;
                    $update1              = mysqli_query($con,"UPDATE dv_wallets SET wallet_balance='$amt' WHERE user_id='$user_id' ");
                    if($update1){
                        $datatext['results']  = true ;
                        $datatext['msg']      = 'Order Succesfully';
                    }else{
                        $datatext['results']  = false ;
                        $datatext['msg']      = 'Your Order Failed';
                    }
                }else{
                    $datatext['results']  = false ;
                    $datatext['msg']      = 'Not user Found';
                }
            }else{
                $datatext['results']  = false ;
                $datatext['msg']      = 'Cart Not Updated';
            }
        }else{
            $datatext['results']  = false ;
            $datatext['msg']      = 'Order not Added' ;
        }    
        echo json_encode($datatext);
    }

    //Order History
    if($method=="orderHistory"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $user_id                 = $val->user_id;
        $datatext                = array();
        $datatext['results']     = false ;
        $order                   = mysqli_query($con,"SELECT * FROM  `order` where user_id='$user_id' and paymentStatus='1'");
        $orderCount              = mysqli_num_rows($order);
        if ($orderCount>0) {
           while($orderData      = mysqli_fetch_assoc($order)) {

                $subcatId        = mysqli_query($con,"SELECT * FROM  `ci_cart` where buyer_id='$user_id' and payment_status='1'");
                $cartCount       = mysqli_num_rows($order);
                while($res1      = mysqli_fetch_assoc($subcatId)){

                    $itemId      = mysqli_query($con,"SELECT * FROM  `ci_subcategory` where id='".$res1['item_id']."'");
                    $productCount= mysqli_num_rows($itemId);
                    while($product  = mysqli_fetch_assoc($itemId)){

                        $catId      = mysqli_query($con,"SELECT * FROM  `ci_categories` where id='".$product['cat_id']."'");
                        $catCount= mysqli_num_rows($catId);
                        while($cat  = mysqli_fetch_assoc($catId)){
                            $catt[]            = array(
                                'cat_id'       => $cat['id'],
                                'cat_name'     => $cat['cat_name'],
                                'cat_img'      => 'http://www.dailywale.com/DWadmin/assets/CategoryImg/'.$cat['img']
                            ); 
                        }
                        if (isset($catt)) {
                            $item[]              = array(
                                'item_id'        => $product['id'],
                                'item_name'      => $product['item_name'],
                                'item_price'     => $product['item_price'],
                                'description'    => $product['description'],
                                'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$product['img'],
                                'units'          => $product['units'],
                                'weight'         => $product['weight'],
                                'in_stock'       => $product['in_stock'],
                                'discount'       => $product['discount'],
                                'extra_charge'   => $product['extra_charge'],
                                'stock'          => $product['stock'],
                                'category'       => $catt
                            ); 
                            unset($catt);
                        }else{
                            $item[]              = array(
                                'item_id'        => $product['id'],
                                'item_name'      => $product['item_name'],
                                'item_price'     => $product['item_price'],
                                'description'    => $product['description'],
                                'item_img'       => 'http://www.dailywale.com/DWadmin/assets/subcategoryImg/'.$product['img'],
                                'units'          => $product['units'],
                                'weight'         => $product['weight'],
                                'in_stock'       => $product['in_stock'],
                                'discount'       => $product['discount'],
                                'extra_charge'   => $product['extra_charge'],
                                'stock'          => $product['stock'],
                                'category'       => []
                            ); 
                        }
                    }
                    if (isset($item)) {
                       $cart[]                 = array(
                            'cart_id'           => $res1['id'],
                            'buyer_id'          => $res1['buyer_id'],
                            'item_id'           => $res1['item_id'],
                            'quantity'          => $res1['quantity'],
                            'price'             => $res1['price'],
                            'total_amount'      => $res1['total_amount'],
                            'item'              => $item
                        );  
                        unset($item);
                    }else{
                        $cart[]                 = array(
                            'cart_id'           => $res1['id'],
                            'buyer_id'          => $res1['buyer_id'],
                            'item_id'           => $res1['item_id'],
                            'quantity'          => $res1['quantity'],
                            'price'             => $res1['price'],
                            'total_amount'      => $res1['total_amount'],
                            'item'              => []
                        );   
                    }
                    
                }
                if(isset($cart)){
                    $orderListings[]        = array(
                        'order_id'          => $orderData['order_id'],
                        'order_date'        => date('d-m-Y', strtotime($orderData['date'])),
                        'payable_amt'       => $orderData['payable_amt'],
                        'debit_amt'         => $orderData['debit_amt'],
                        'est_total'         => $orderData['est_total'],
                        'note'              => $orderData['note'],
                        'order_status'      => $order_status,
                        'accept_by'         => $orderData['accept_by'],
                        'dispatched_by'     => $orderData['dispatched_by'],
                        'delivered_by'      => $orderData['delivered_by'],
                        'cancelled_by'      => $orderData['cancelled_by'],
                        'cartItems'         => $cart
                    );
                    unset($cart);
                }else{
                    $orderListings[]        = array(
                        'order_id'          => $orderData['order_id'],
                        'order_date'        =>  date('d-m-Y', strtotime($orderData['date'])),
                        'payable_amt'       => $orderData['payable_amt'],
                        'debit_amt'         => $orderData['debit_amt'],
                        'est_total'         => $orderData['est_total'],
                        'note'              => $orderData['note'],
                        'order_status'      => $order_status,
                        'accept_by'         => $orderData['accept_by'],
                        'dispatched_by'     => $orderData['dispatched_by'],
                        'delivered_by'      => $orderData['delivered_by'],
                        'cancelled_by'      => $orderData['cancelled_by'],
                        'cartItems'         => []
                    );
                }
            }
        }else{
            $datatext['results'] = false ;
            $datatext['msg']     = 'No Order Found!' ;
        }
        $datatext['results']      = true ;
        $datatext['data']         = $orderListings ;
        echo json_encode($datatext);
    }
    
    //Slider list
    if($method=="sliderListing"){
        $datatext                = array();
        $datatext['results']     = false ;
        $list                    = mysqli_query($con,"SELECT * FROM  slider");
        while($Sliders           = mysqli_fetch_array($list)){
            $section_id          = $Sliders['section_id'];

            $sec                 = mysqli_query($con,"SELECT * FROM  section where id='$section_id'");
            if($sect             = mysqli_fetch_assoc($sec)){
                $section_name    = $sect['name'];
            }else{
                $section_name    = "No Section";
            }
              
            $sliderList[]        =   array(
                'slider_id'      => $Sliders['id'],
                'section_id'     => $section_id,
                'section_name'   => $section_name,
                'title'          => $Sliders['title'],
                'titlecolor'     => $Sliders['titlecolor'],
                'slogan'         => $Sliders['slogan'],
                'slogancolor'    => $Sliders['slogancolor'],
                'item_img'       => 'http://www.dailywale.com/DWadmin/assets/SliderImg/'.$Sliders['img']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $sliderList ;
        echo json_encode($datatext);
    }

    //Zone list
    if($method=="zoneListing"){
        $datatext                = array();
        $datatext['results']     = false ;
        $zoneOflist              = mysqli_query($con,"SELECT * FROM  ci_zone");
        while($zones             = mysqli_fetch_array($zoneOflist)){
            $zoneList[]          = array(
                'zone_id'        => $zones['id'],
                'city_name'      => $zones['city_id'],
                'zone'           => $zones['zone']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $zoneList ;
        echo json_encode($datatext);
    }

    //Sub zone list
    if($method=="subZoneListing"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $zone_id                 = $val->zone_id;
        $subZones                = mysqli_query($con,"SELECT * FROM  ci_subzone WHERE zone_id='$zone_id'");
        while($subZone           = mysqli_fetch_array($subZones)){

            $sec                 = mysqli_query($con,"SELECT * FROM  ci_zone where id='$zone_id'");
            if($sect             = mysqli_fetch_assoc($sec)){
                $zone_name       = $sect['zone'];
            }else{
                $zone_name       = "No zone";
            }
              
            $subzoneList[]        =   array(
                'subzone_id'     => $subZone['id'],
                'zone_id'        => $zone_id,
                'zone_name'      => $zone_name,
                'sub_zone'       => $subZone['sub_zone']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $subzoneList ;
        echo json_encode($datatext);
    }

    //Address Insert list
    if($method=="addressInsert"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $user_id                 = $val->user_id;
        $zone                    = $val->zone;
        $subZone                 = $val->subZone;
        $house_no                = $val->house_no;
        $address                 = $val->address;
        $pincode                 = $val->pincode;
        $add                     = mysqli_query($con,"INSERT INTO ci_address (user_id,zone,subZone,house_no,address,pincode) VALUES ('$user_id','$zone','$subZone','$house_no','$address','$pincode')");
        if($add){
            $last_id              = mysqli_insert_id($con);
            $addresss             = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM  ci_address WHERE address_id='$last_id'"));
            if($addresss){
                $datatext['results']  = true ;
                $datatext['data']     = $addresss ;
                $datatext['msg']      = 'Address Add Succesfully';
            }else{
                $datatext['results']  = false ;
                $datatext['msg']      = 'Address not Found';
            }
        }else{
            $datatext['results']  = false ;
            $datatext['msg']      = 'Address not Added' ;
        }   
        echo json_encode($datatext);
    }

    //Address list acc to user
    if($method=="addressListAccToUserId"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $user_id                 = $val->user_id;
        $user                    = mysqli_query($con,"SELECT * FROM  ci_address WHERE user_id='$user_id'");
        while($userAdd           = mysqli_fetch_array($user)){
            $zone                = $userAdd['zone'];
            $sec                 = mysqli_query($con,"SELECT * FROM  ci_zone where id='$zone'");
            if($sect             = mysqli_fetch_assoc($sec)){
                $zone_name       = $sect['zone'];
            }else{
                $zone_name       = "No zone";
            }
            
            $sec1                = mysqli_query($con,"SELECT * FROM  ci_subzone where id='".$userAdd['subZone']."'");
            if($sect1            = mysqli_fetch_assoc($sec1)){
                $subzone_name    = $sect1['sub_zone'];
            }else{
                $subzone_name    = "No subzone";
            }

            $addList[]           =   array(
                'address_id'     => $userAdd['address_id'],
                'zone_id'        => $userAdd['zone'],
                'zone_name'      => $zone_name,
                'subzone_id'     => $userAdd['subZone'],
                'subzone_name'   => $subzone_name,
                'house_no'       => $userAdd['house_no'],
                'address'       => $userAdd['address'],
                'pincode'       => $userAdd['pincode']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $addList ;
        echo json_encode($datatext);
    }

    //wallet Insert list
    if($method=="walletInsert"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $user_id                 = $val->user_id;
        $wallet_balance          = $val->wallet;
        $wal                     = mysqli_query($con,"SELECT * FROM  dv_wallets WHERE user_id='$user_id'");
        $count                   = mysqli_num_rows($wal);
        if ($count>0) {
            $data                = mysqli_fetch_assoc($wal);
            $amount              = $data['wallet_balance'];
            $sum                 = $wallet_balance+$amount;
            $update              = mysqli_query($con,"UPDATE dv_wallets SET wallet_balance='$sum' WHERE user_id='$user_id' ");
            if($update){
                $ad             = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM  dv_wallets WHERE user_id='$user_id'"));
                if($ad){
                    $datatext['results']  = true ;
                    $datatext['data']     = $ad;
                    $datatext['msg']      = 'Updated Wallet Amount Succesfully';
                }else{
                    $datatext['results']  = false ;
                    $datatext['msg']      = 'Not Record Found';
                }
            }else{
                $datatext['results']  = false ;
                $datatext['msg']      = 'Not Updated';
            }
        }else{
           $add                  = mysqli_query($con,"INSERT INTO dv_wallets (user_id,wallet_balance) VALUES ('$user_id','$wallet_balance')");
            if($add){
                $last_id              = mysqli_insert_id($con);
                $walletAmount         = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM  dv_wallets WHERE id='$last_id'"));
                if($walletAmount){
                    $datatext['results']  = true ;
                    $datatext['data']     = $walletAmount ;
                    $datatext['msg']      = 'Add Wallet Amount Succesfully';
                }else{
                    $datatext['results']  = false ;
                    $datatext['msg']      = 'Not Record Found';
                }
            }else{
                $datatext['results']  = false ;
                $datatext['msg']      = 'Wallet Amount not Added' ;
            }    
        }
        
        echo json_encode($datatext);
    }

    //Wallet acc to user 
    if($method=="wallet"){
        $post                    = file_get_contents('php://input');
        $val                     = json_decode($post);
        $datatext                = array();
        $datatext['results']     = false ;
        $user_id                 = $val->user_id;
        $wal                     = mysqli_query($con,"SELECT * FROM  dv_wallets WHERE user_id='$user_id'");
        while($wallet            = mysqli_fetch_array($wal)){
            $walletList[]       =   array(
                'wallet_id'      => $wallet['id'],
                'wallet_balance' => $wallet['wallet_balance'],
                'credit'         => $wallet['credit'],
                'debit'          => $wallet['debit'],
                'user_id'        => $wallet['user_id']
            );
        }   
        $datatext['results']      = true ;
        $datatext['data']         = $walletList ;
        echo json_encode($datatext);
    }

   /****************************
	 LogIn
	********************************/

	if($method=="LogIn")
	{    
	    if(isset($_REQUEST['email']) && $_REQUEST['email']!='' && !isset($_REQUEST['password']) && $_REQUEST['password']!=''){

	     	$doctor_email=mysqli_real_escape_string($con,$_REQUEST['email']);
	     	$password=mysqli_real_escape_string($con,md5($_REQUEST['password']));

	     	$sel=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user WHERE `user_email`='$doctor_email' AND `pwd`='$password' "));
			$datatext=array();
			$datatext['result']=false;
			if($sel)
			{
				$datatext['result']=true;
				$datatext['msg']="Succesfully Login";

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
    if ($method == "222") {
            $name       = mysqli_real_escape_string($con, $_REQUEST['name']);
            $email      = mysqli_real_escape_string($con, $_REQUEST['email']);
            $phone      = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $password   = mysqli_real_escape_string($con, $_REQUEST['password']);
            $address    = mysqli_real_escape_string($con, $_REQUEST['address']);
            $city_id    = mysqli_real_escape_string($con, $_REQUEST['city_id']);
            
            $city       = mysqli_real_escape_string($con, $_REQUEST['city']);
            $pincode    = mysqli_real_escape_string($con, $_REQUEST['pincode']);
            $zone       = mysqli_real_escape_string($con, $_REQUEST['zone']);
            $img        = mysqli_real_escape_string($con, $_REQUEST['img']);
            $street     = mysqli_real_escape_string($con, $_REQUEST['street']);
            $subzone    = mysqli_real_escape_string($con, $_REQUEST['subzone']);
            $landmark     = mysqli_real_escape_string($con, $_REQUEST['landmark']);
            $house_no    = mysqli_real_escape_string($con, $_REQUEST['house_no']);
            //$img        = mysqli_real_escape_string($con, $_REQUEST['img']);
            $datatext   = array();
            
            $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_user WHERE `phone`='$phone'"));
            if ($checkExist) {
                    $datatext['success'] = false;
                    $datatext['msg']     = "This phone number already exists.";
            } else {
                if($name!='' && $phone!='' && $email!='' && $password!='')
                {
                    $verify_no = substr(str_shuffle($phone), 5);
                    $message   = "Your DW Verification Code is " . $verify_no;
                   
                    $contacts  = $phone;

                    /*
                     $api_key   = '25867B50EDEA0F';
                     $from      = 'DailyVegetable';
                    $sms_text  = urlencode($message);
                    //Submit to server
                    $ch        = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://app.mysmsmart.com/app/smsapi/index.php");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=28&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    echo $response;*/

                    // messageSend($message,$contacts);
                    $insert = mysqli_query($con, " INSERT INTO `ci_user`(`name`,`phone`,`email`,`password`,`address`,`street`,`pincode`,`zone`,`sub_zone`,`city_id`,`city`,`is_verify`,`otp`,`landmark`,`house_no`) VALUES ('$name','$phone','$email','$password','$address','$street','$pincode','$zone','$subzone','$city_id','$city','1','$verify_no','$landmark','$house_no')");
                    if ($insert) {
                            $datatext['success'] = true;
                            $datatext['msg']     = "succesfully Registered";
                            $datatext['user_id'] = mysqli_insert_id($con);
                            $uid                 = mysqli_insert_id($con);
                    } else {
                            $datatext['msg'] = "Please Try again";
                    }
                }else
                {
                     $datatext['msg'] = "data is blank";
                }
            }
            echo json_encode($datatext);
    }
    if ($method == "otp") {
            $phone               = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $code                = mysqli_real_escape_string($con, $_REQUEST['code']);
            $contents            = array();
            $contents['results'] = false;
            $sqlquery            = mysqli_query($con, "SELECT * FROM ci_user where `otp`='$code' and `phone`='$phone'");
            if ($rowquery = mysqli_fetch_array($sqlquery)) {
                    $sqlUpdate = mysqli_query($con, "update ci_user set is_verify='1' where `phone`='$phone' ");
                    if ($sqlUpdate) {
                            $contents['results'] = true;
                            $contents['msg']     = "Succesfully Verified";
                            $contents['user_id'] = $rowquery['id'];
                    } else {
                            $contents['results'] = "true";
                            $contents['msg']     = "Incorrect OTP";
                    }
            } else {
                    $contents['results'] = "false";
                    $contents['msg']     = "Incorrect OTP";
            }
            echo json_encode($contents);
    }
    // if($method="resend")
    // {}
    if ($method == "resend") {
            $phone      = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $datatext   = array();
            $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_user WHERE `phone`='$phone'"));
            if ($checkExist) {
                    $user_id   = $checkExist['id'];
                    $verify_no = substr(str_shuffle($phone), 5);
                    $message   = "Your DV Verification Code is " . $verify_no;
                    $api_key   = '25867B50EDEA0F';
                    $contacts  = $phone;
                    $from      = 'DailyVegetable';
                    $sms_text  = urlencode($message);
                    //Submit to server
                    $ch        = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://app.mysmsmart.com/app/smsapi/index.php");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=28&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    //echo $response;
                    $insert = mysqli_query($con, " UPDATE `ci_user` SET otp='$verify_no' WHERE id='$user_id' ");
                    if ($insert) {
                            $datatext['success'] = true;
                            $datatext['msg']     = "successfully send OTP to your registered mobile number";
                            $datatext['user_id'] = $user_id;
                            $uid                 = mysqli_insert_id($con);
                    } else {
                            $datatext['msg'] = "Please Try again";
                    }
            }
            echo json_encode($datatext);
    }
    if ($method == "3") {

        $section_id               = mysqli_real_escape_string($con, $_REQUEST['section_id']);

            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_categories` WHERE section_id='$section_id'");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result']   = true;
                    $cat_name             = $fetch_record['cat_name'];
                    $cat_des              = $fetch_record['cat_des'];
                    $img                  = $img_url."/DWadmin/assets/CategoryImg/" . $fetch_record['img'];
                    $id                   = $fetch_record['id'];
                    $arr[]                = array(
                            "id" => $id,
                            "cat_name" => $cat_name,
                            "cat_des" => $cat_des,
                            "img" => $img
                    );
                    $datatext['category'] = $arr;
            }
            echo json_encode($datatext);
    }
    if ($method == "4") {
            $cat_id             = mysqli_real_escape_string($con, $_REQUEST['cat_id']);

            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_subcategory` Where cat_id='$cat_id' ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                   
                    $datatext['result']      = true;
                    $cat_id                  = $fetch_record['cat_id'];
                    $item_id                 = $fetch_record['id'];
                    $item_name               = $fetch_record['item_name'];
                    $item_price              = $fetch_record['item_price'];
                    $description             = $fetch_record['description'];
                     $stock                  = $fetch_record['in_stock'];
                     if($stock=='1')
                     {
                            $stock="Out Of Stock";
                     }else
                     {
                            $stock="In Stock";
                     }
                    $img                     = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record['img'];
                    $unit                    = $fetch_record['units'];
                    $arr[]                   = array(
                            "item_id"       => $item_id,
                            "item_name"     => $item_name,
                            "cat_id"        => $cat_id,
                            "item_price"    => $item_price,
                            "unit"          => $unit,
                            "description"   => $description,
                            "img"           => $img,
                            "stock"         => $stock,
                            "extra_charge"  => $fetch_record['extra_charge'],
                            "discount"  => $fetch_record['discount']
                    );
                    $datatext['subcategory'] = $arr;
            }
            echo json_encode($datatext);
    }
    if ($method == "5") {
            $cat_name           = mysqli_real_escape_string($con, $_REQUEST['search']);
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE `item_name` LIKE '$cat_name%'");
            $fetch_record11     = mysqli_num_rows($get_record);
            if ($fetch_record11 != '') {
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $datatext['result'] = true;
                            $id                 = $fetch_record['id'];
                            $cat_id             = $fetch_record['cat_id'];
                            $item_name          = $fetch_record['item_name'];
                            $price              = $fetch_record['item_price'];
                            $description        = $fetch_record['description'];
                            $unit               = $fetch_record['units'];
                             $stock             = $fetch_record['in_stock'];
                     if($stock=='1')
                     {
                            $stock="Out Of Stock";
                     }else
                     {
                            $stock="In Stock";
                     }
                            $img                = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $arr[]              = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "price"         => $price,
                                    "unit"          => $unit,
                                    "description"   => $description,
                                    "img"           => $img,
                                     "stock"        => $stock,
                                     "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                    }
            } else {
                    $arr[] = array(
                            "msg" => "No results found"
                    );
            }
            $datatext['category'] = $arr;
            echo json_encode($datatext);
    }
    if ($method == "6") {
            $cat_id             = mysqli_real_escape_string($con, $_REQUEST['cat_id']);
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE `cat_id`='$cat_id'");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result']   = true;
                    $id                   = $fetch_record['id'];
                    $cat_id               = $fetch_record['cat_id'];
                    $item_name            = $fetch_record['item_name'];
                    $price                = $fetch_record['item_price'];
                    $description          = $fetch_record['description'];
                    $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                    $arr[]                = array(
                            "id"            => $id,
                            "cat_id"        => $cat_id,
                            "item_name"     => $item_name,
                            "price"         => $price,
                            "description"   => $description,
                            "img"           => $img
                    );
                    $datatext['category'] = $arr;
            }
            echo json_encode($datatext);
    }
    if ($method == "10") {
        $cat_name='';
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_categories` ORDER BY `id` DESC LIMIT 50");
           $catnum = mysqli_num_rows($get_record);
           //mysqli_fetch_all($result,MYSQLI_ASSOC);
            while ($fetch_record = mysqli_fetch_array($get_record,MYSQLI_ASSOC)) {

                 $check=1;
                    $check=count($catnum);
                    if(isset($id))
                    {
                        $id           = $fetch_record['id'];
                    
                    $cat_name           = $fetch_record['cat_name'];
                    }else
                    {
                    $cat_name           = 'popular product';
                    }
            $datatext['result'] = true;
                   $c=$fetch_record['cat_name'];
                    $id=$fetch_record['id'];
                    
                    // if($c!='')
                    // {$cat_name           = $fetch_record['cat_name'];

                    //  }else
                    //  {$cat_name           = 'popular product';

                    //  }
                    $cat_des            = $fetch_record['cat_des'];
                    $img                = $img_url."/DWadmin/assets/CategoryImg/" . $fetch_record['img'];
                    $id                 = $fetch_record['id'];
                    
                    $data               = array();
                    if ($cat_name == 'popular product') {

                            $get_record12 = mysqli_query($con, "SELECT * FROM `populor`");
                            while ($fetch_record12 = mysqli_fetch_array($get_record12)) {

                                    $subid        = $fetch_record12['subcat_id'];
                                    $get_record13 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE id='$subid' AND in_stock!='1'");
                                    while ($fetch_record13 = mysqli_fetch_array($get_record13)) {
                                            $subid       = $fetch_record13['id'];
                                            $cid         = $fetch_record13['cat_id'];
                                            $item_name   = $fetch_record13['item_name'];
                                            $item_price  = $fetch_record13['item_price'];
                                            $description = $fetch_record13['description'];
                                            $unit        = $fetch_record13['units'];
                                            $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record13['img'];
                                            $arr2        = array(
                                                    'SubID'         => $subid,
                                                    'ItemName'      => $item_name,
                                                    'ItemPrice'     => $item_price,
                                                    'unit'          => $unit,
                                                    'Description'   => $description,
                                                    'Img'           => $img11
                                            );
                                            $data[]      = $arr2;
                                            //print_r($data2);
                                    }
                            }
                    } else {
                            $get_record11 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE cat_id='$id'  AND in_stock!='1'");
                            $fetch_numrow = mysqli_num_rows($get_record11);
                            if($fetch_numrow!='')
                            {
                            while ($fetch_record11 = mysqli_fetch_array($get_record11)) {
                                    $subid       = $fetch_record11['id'];
                                    $cid         = $fetch_record11['cat_id'];
                                    $item_name   = $fetch_record11['item_name'];
                                    $item_price  = $fetch_record11['item_price'];
                                    $description = $fetch_record11['description'];
                                    $unit        = $fetch_record13['units'];
                                    $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record11['img'];
                                    $arr1        = array(
                                            'SubID'         => $subid,
                                            'ItemName'      => $item_name,
                                            'ItemPrice'     => $item_price,
                                            'unit'          => $unit,
                                            'Description'   => $description,
                                            'Img'           => $img11
                                    );
                                    $data[]      = $arr1;

                            }
                        }else
                        {
                            $img11       = $img_url."/DWadmin/assets/subcategoryImg/Modern Milk bread.png";
                                    $arr1        = array(
                                            'SubID'         => '1',
                                            'ItemName'      => 'Grocery',
                                            'ItemPrice'     => '40',
                                            'unit'          => 'kg',
                                            'Description'   => 'Best sell',
                                            'Img'           => $img11
                                    );
                                    $data[]      = $arr1;
                        }
                    }

                    $arr[]                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );
                    $main[]               = array(
                            $arr
                    );
                    $datatext['category'] = $arr;
            }
            echo json_encode($datatext);
    }
    if ($method == "popularp") {

            $section_id               = mysqli_real_escape_string($con, $_REQUEST['section_id']);

            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `populor` WHERE section_id='$section_id' ORDER BY id desc  ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result'] = true;
                    $subcat_id           = $fetch_record['subcat_id'];
                   
                    $data               = array();
                    
                                    
                                    $get_record13 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE id='$subcat_id' AND in_stock!='1'");
                                    $fetch_record13 = mysqli_fetch_array($get_record13);

                                            $subid       = $fetch_record13['id'];
                                            $cid         = $fetch_record13['cat_id'];
                                            $item_name   = $fetch_record13['item_name'];
                                            $item_price  = $fetch_record13['item_price'];
                                            $description = $fetch_record13['description'];
                                            $unit        = $fetch_record13['units'];
                                            $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record13['img'];
                                            $arr2[]        = array(
                                                    'SubID'         => $subid,
                                                    'ItemName'      => $item_name,
                                                    'ItemPrice'     => $item_price,
                                                    'unit'          => $unit,
                                                    'Description'   => $description,
                                                    'Img'           => $img11,
                                                    "extra_charge"  => $fetch_record13['extra_charge'],
                                                    "discount"  => $fetch_record13['discount']
                                            );
                       }
             $datatext['popular'] = $arr2;
            echo json_encode($datatext);
    }
    if ($method == "15") {
            // $order              = mysqli_real_escape_string($con, $_REQUEST['order']);
            // $high__to_low       = mysqli_real_escape_string($con, $_REQUEST['high__to_low']);
            // $low_to_high        = mysqli_real_escape_string($con, $_REQUEST['low_to_high']);
            // $category           = mysqli_real_escape_string($con, $_REQUEST['category']);
            // $popular            = mysqli_real_escape_string($con, $_REQUEST['popular']);
            $sorting            = mysqli_real_escape_string($con, $_REQUEST['sorting']);
            $datatext           = array();
            $datatext['result'] = false;
            if ($sorting == '1') {
                    $get_record = mysqli_query($con, "SELECT * FROM `ci_subcategory` ORDER BY item_name ASC");
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $datatext['result']   = true;
                            $id                   = $fetch_record['id'];
                            $cat_id               = $fetch_record['cat_id'];
                            $item_name            = $fetch_record['item_name'];
                            $price                = $fetch_record['item_price'];
                            $description          = $fetch_record['description'];
                            $unit                 = $fetch_record['units'];
                            $stock                = $fetch_record['in_stock'];
                            $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $arr[]                = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "item_price"         => $price,
                                    "unit"          => $unit,
                                    "description"   => $description,
                                    "img"           => $img,
                                    "stock"         => $stock,
                                    "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                            $datatext['category'] = $arr;
                    }
            }
            /*high to low*/
            elseif ($sorting == '5') {
                    $get_record = mysqli_query($con, "SELECT * FROM ci_subcategory  order by item_price DESC");
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $datatext['result']   = true;
                            $id                   = $fetch_record['id'];
                            $cat_id               = $fetch_record['cat_id'];
                            $item_name            = $fetch_record['item_name'];
                            $price                = $fetch_record['item_price'];
                            $description          = $fetch_record['description'];
                            $unit                 = $fetch_record['units'];
                            $stock                = $fetch_record['in_stock'];
                            $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $arr[]                = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "item_price"         => $price,
                                    "unit"          => $unit,
                                    "description"   => $description,
                                    "img"           => $img,
                                    "stock"         => $stock,
                                    "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                            $datatext['category'] = $arr;
                    }
            } /*low to high*/ elseif ($sorting == '4') {
                    $get_record = mysqli_query($con, "SELECT * FROM ci_subcategory  order by item_price ASC");
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $lat1                 = $fetch_record['txt_lat'];
                            $lng1                 = $fetch_record['txt_lng'];
                            $datatext['result']   = true;
                            $id                   = $fetch_record['id'];
                            $cat_id               = $fetch_record['cat_id'];
                            $item_name            = $fetch_record['item_name'];
                            $price                = $fetch_record['item_price'];
                            $description          = $fetch_record['description'];
                            $unit                 = $fetch_record['units'];
                            $stock                = $fetch_record['in_stock'];
                            $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $arr[]                = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "item_price"         => $price,
                                    "description"   => $description,
                                    "img"           => $img,
                                    "unit"          => $unit,
                                    "stock"         => $stock,
                                    "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                            $datatext['category'] = $arr;
                    }
            } /*popularty*/ elseif ($sorting == '2') {
                    $get_record = mysqli_query($con, "SELECT * FROM `ci_subcategory` group by id order by id DESC");
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $datatext['result']   = true;
                            $id                   = $fetch_record['id'];
                            $cat_id               = $fetch_record['cat_id'];
                            $item_name            = $fetch_record['item_name'];
                            $price                = $fetch_record['item_price'];
                            $description          = $fetch_record['description'];
                            $stock                = $fetch_record['in_stock'];
                            $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $unit                 = $fetch_record['units'];
                            $arr[]                = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "item_price"         => $price,
                                    "unit"          => $unit,
                                    "description"   => $description,
                                    "img"           => $img,
                                    "stock"         => $stock,
                                    "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                            $datatext['category'] = $arr;
                    }
            } /*category*/ elseif ($sorting == '3') {
                    $get_record = mysqli_query($con, "SELECT * FROM `ci_subcategory`  order by `item_name` DESC");
                    while ($fetch_record = mysqli_fetch_array($get_record)) {
                            $datatext['result']   = true;
                            $id                   = $fetch_record['id'];
                            $cat_id               = $fetch_record['cat_id'];
                            $item_name            = $fetch_record['item_name'];
                            $price                = $fetch_record['item_price'];
                            $description          = $fetch_record['description'];
                            $img                  = $img_url.'/DWadmin/assets/subcategoryImg/' . $fetch_record['img'];
                            $unit                 = $fetch_record['units'];
                            $stock                = $fetch_record['in_stock'];
                            $arr[]                = array(
                                    "id"            => $id,
                                    "cat_id"        => $cat_id,
                                    "item_name"     => $item_name,
                                    "item_price"         => $price,
                                    "unit"          => $unit,
                                    "description"   => $description,
                                    "img"           => $img,
                                    "stock"         => $stock,
                                    "extra_charge"  => $fetch_record['extra_charge'],
                                    "discount"  => $fetch_record['discount']
                            );
                            $datatext['category'] = $arr;
                    }
            }
            echo json_encode($datatext);
    }
    /*Add To Cart */
    if ($method == "7") {
            $buyer_id = mysqli_real_escape_string($con, $_REQUEST['buyer_id']);
            $item_id  = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $price    = mysqli_real_escape_string($con, $_REQUEST['price']);
            $qty      = mysqli_real_escape_string($con, $_REQUEST['qty']);
            if ($qty == '1' OR $qty == '2') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * 1000 * $qty;
            } elseif ($qty == '250' OR $qty == '500') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * $qty;
            }
            // $date      = date('Y-m-d H:i:s');
            // $orderdate = explode('-',date('Y-m-d'));
            // $orderdate1 = explode(':',date('H:i:s'));
            // $month = $orderdate[0];
            // $day   = $orderdate[1];
            // $year  = $orderdate[2];
            // $hour  = $orderdate1[0];
            // $minute  = $orderdate1[1];
            // $second  = $orderdate1[2];
            // $dat2="#".$month.$day.$year.$month.$day.$minute.$second;
            $testcheck6 = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$buyer_id' ");
            if ($row = mysqli_fetch_array($testcheck6)) {
                    $name      = $row['name'];
                    $email     = $row['email'];
                    $phone     = $row['phone'];
                    $address   = $row['address'];
                    $city      = $row['city'];
                    $pincode   = $row['pincode'];
                    $zone      = $row['zone'];
                    $testcheck = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$buyer_id' AND `item_id`='$item_id' AND `status`='on' AND `buy_now`='no' "));
                    if (isset($testcheck)) {
                            $insert = mysqli_query($con, "UPDATE `ci_cart` SET `fname`='$name',`email`='$email',`phone`='$phone',`address`='$address',`city`='$city',`pincode`='$pincode',`zone`='$zone',`quantity`='$qty',`total_amount`='$total_price',`updated_at`='$date',`buy_now`='no'  WHERE `buyer_id`='$buyer_id' AND `item_id`='$item_id'");
                            if ($insert) {
                                    $datatext['results']     = true;
                                    $datatext['msg']         = "succesfully update cart";
                                    $datatext['total_price'] = $total_price;
                                    $datatext['quantity']    = $qty;
                                    $datatext['OrderID']     = $testcheck['order_id'];
                            } else {
                                    $datatext['results'] = false;
                                    $datatext['msg']     = "Please Try again";
                            }
                    } else {
                            $insert = mysqli_query($con, "INSERT INTO `ci_cart`(`buyer_id`, `fname`, `email`, `phone`, `address`, `city`, `pincode`, `zone`, `item_id`, `cart_items`, `price`, `schedule_for`, `img`, `quantity`, `total_amount`, `created_at`, `updated_at`, `status`, `payment_status`, `delivery_status`, `is_read`,`buy_now`,`order_id`) VALUES ('$buyer_id','$name','$email','$phone','$address','$city','$pincode','$zone','$item_id','','$price','No Schedule Available','','$qty','$total_price','$date','','on','','','','no','')");
                            if ($insert) {
                                    $datatext['results']     = true;
                                    $datatext['msg']         = "Added Succesfully";
                                    $datatext['total_price'] = $total_price;
                                    $datatext['quantity']    = $qty;
                                    //$datatext['OrderID']    = '';
                            } else {
                                    $datatext['results'] = false;
                                    $datatext['msg']     = "Please Try again";
                            }
                    }
            } else {
                    $datatext['msg'] = 'error';
            }
            echo json_encode($datatext);
    }
    /*Add To Cart */
    if ($method == "8") {
            $price = mysqli_real_escape_string($con, $_REQUEST['price']);
            $qty   = mysqli_real_escape_string($con, $_REQUEST['qty']);
            //$unit      = mysqli_real_escape_string($con, $_REQUEST['unit']);
            if ($qty == '1' OR $qty == '2') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * 1000 * $qty;
            } elseif ($qty == '250' OR $qty == '500') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * $qty;
            }
            $datatext['results']      = true;
            $datatext['quantity']     = $qty;
            $datatext['total_amount'] = $total_price;
            echo json_encode($datatext);
    }
    /*Add To Unit */
    if ($method == "33") {
            $price                    = mysqli_real_escape_string($con, $_REQUEST['price']);
            $unit                     = mysqli_real_escape_string($con, $_REQUEST['unit']);
            $total_price              = $price * $unit;
            $datatext['results']      = true;
            $datatext['unit']         = $unit;
            $datatext['total_amount'] = $total_price;
            echo json_encode($datatext);
    }
   
    /*Show Cart Data */
    if ($method == "9") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist          = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$user_id' AND `status`='on' AND `buy_now`='no' AND `order_id`=''  ORDER BY id DESC");
            $cnt                 = mysqli_num_rows($checkExist);
            if ($cnt != '') {
                    while ($row = mysqli_fetch_array($checkExist)) {
                            //$img="http://www.dailyvegetable.com/DWadmin/assets/subcategoryImg/".$row['img'];
                            $datatext['results'] = true;
                            $datatext['msg']     = 'success';
                            $item_id             = $row['item_id'];
                            $quantity            = $row['quantity'];
                            if ($quantity == '250' OR $quantity == '500') {
                                    $quantity1 = $row['quantity'] . "gm/ml";
                            } elseif ($quantity == '1' OR $quantity == '2') {
                                    $quantity1 = $row['quantity'] . "kg/ltr";
                            }
                            $checkExist11     = mysqli_query($con, "SELECT * FROM ci_subcategory WHERE `id`='$item_id'");
                            $row11            = mysqli_fetch_array($checkExist11);
                            $dataveget        = $row11['item_name'];
                            $img              = $img_url."/DWadmin/assets/subcategoryImg/" . $row11['img'];
                            $arr[]            = array(
                                    'item_id'       => $row['item_id'],
                                    'item_name'     => $dataveget,
                                    'img'           => $img,
                                    'qty'           => $quantity1,
                                    'total_amount'  => $row['total_amount'],
                                    'schedule_for'  => $row['schedule_for']
                            );
                            //  if($row['schedule_for']!='No Schedule Available')
                            // {
                            //     $arr[]=array('item_id' =>$row['item_id'],'item_name' =>$dataveget,'img' =>$img,'qty' =>$quantity1,'total_amount' =>$row['total_amount'],'schedule_for'=>$row['schedule_for']);
                            // }else
                            // {
                            //      $arr[]=array('item_id' =>$row['item_id'],'item_name' =>$dataveget,'img' =>$img,'qty' =>$quantity1,'total_amount' =>$row['total_amount']);
                            // }
                            $datatext['data'] = $arr;
                    }
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = 'No data Into Your Cart';
            }
            echo json_encode($datatext);
    }
    if ($method == "11") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $item_id             = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist          = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$user_id' AND `item_id`='$item_id'");
            if ($row = mysqli_fetch_array($checkExist)) {
                    $checkExist11 = mysqli_query($con, "DELETE FROM ci_cart WHERE `buyer_id`='$user_id' AND `item_id`='$item_id'");
                    if (isset($checkExist11)) {
                            $datatext['results'] = true;
                            $datatext['msg']     = "Deleted Succesfully";
                    } else {
                            $datatext['results'] = false;
                            $datatext['msg']     = "Please try again";
                    }
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = "Please try again";
            }
            echo json_encode($datatext);
    }
    /*Update Profile*/
    if ($method == "12") {
            $username = mysqli_real_escape_string($con, $_REQUEST['username']);
            $user_id  = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $email    = mysqli_real_escape_string($con, $_REQUEST['email']);
            $phone    = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $img      = mysqli_real_escape_string($con, $_REQUEST['img']);
            if($_FILES['img']['tmp_name'] == "") {
                    $s     = mysqli_query($con, "SELECT * FROM `ci_user` WHERE `id`='$hidden_id'");
                    $rs    = mysqli_fetch_array($s);
                    $path1 = $rs['profile'];
            } else{
                    $attachment = $_FILES['img']['tmp_name'];
                    $path1      = 'img/' . time() . $_FILES['img']['name'];
                    //$path1 ='images/'.time().'.jpg';
                    move_uploaded_file($attachment, $path1);
            }
            $checkExist = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$user_id'");
            if ($row = mysqli_fetch_array($checkExist)) {
                    $update = mysqli_query($con, "UPDATE `ci_user` SET `profile`='$path1', `name`='$username',`phone`='$phone',`email`='$email' WHERE id='$user_id'");
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
    /*Change  Password*/
    if ($method == "13") {
            $old_password = mysqli_real_escape_string($con, $_REQUEST['old_password']);
            $new_password = mysqli_real_escape_string($con, $_REQUEST['new_password']);
            $user_id      = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $checkExist   = mysqli_query($con, "SELECT * FROM ci_user WHERE `password`='$old_password' AND `id`='$user_id'");
            if ($row = mysqli_fetch_array($checkExist)) {
                    $update = mysqli_query($con, "UPDATE `ci_user` SET `password`='$new_password' WHERE id='$user_id'");
                    if ($update) {
                            $datatext['success'] = true;
                            $datatext['msg']     = "succesfully Change Your Password";
                    } else {
                            $datatext['success'] = false;
                            $datatext['msg'] = "Your Password Not Change Please Try Again";
                    }
            } else {
                    $datatext['success'] = false;
                    $datatext['msg'] = "Please Enter Correct Old Password";
            }
            echo json_encode($datatext);
    }
    /*Sider Image*/
    if ($method == "14") {

        $section_id               = mysqli_real_escape_string($con, $_REQUEST['section_id']);

        $datatext            = array();
        $datatext['results'] = false;
        $checkExist          = mysqli_query($con, "SELECT * FROM slider WHERE section_id='$section_id'");
        while ($row = mysqli_fetch_array($checkExist)) {
                $datatext['results'] = true;
                $img                 = $img_url."/DWadmin/assets/SliderImg/" . $row['img'];
                $arr[]               = array(
                        'slider_img'    => $img,
                        'title'         => $row['title']
                );
        }
        $datatext['data'] = $arr;
        echo json_encode($datatext);
    }
    /*Add Schedule*/
    if ($method == "16") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $item_id             = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $schedue_id          = mysqli_real_escape_string($con, $_REQUEST['schedue_id']);
            //$schedueid=implode(',',$_REQUEST['schedue_id']);
            $datatext            = array();
            $datatext['results'] = false;
            $info                = mysqli_query($con, "UPDATE `ci_cart` SET `schedule_for`='$schedue_id' WHERE buyer_id='$user_id'  AND item_id='$item_id'");
            if ($info) {
                    //$datatext['current_song'] = mysqli_insert_id($con);
                    $datatext['results'] = "true";
                    $datatext['msg']     = "Succesfully Set Your Schedule";
            } else {
                    $datatext['msg'] = "Please try again";
            }
            // $datatext['data']=$arr;
            echo json_encode($datatext);
    }
    // /***********************************
    // Method = 17
    // function = Forgate password
    // Parameter = 
    // *******************************************/
    // if ($method == "17") {
    //     $u_mail              = mysqli_real_escape_string($con, $_REQUEST['mail_id']);
    //     $datatext            = array();
    //     $datatext['results'] = false;
    //     $countChk            = 0;
    //     $select_mailId       = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_user WHERE `email`='$u_mail'"));
    //     if (isset($select_mailId)) {
    //         $to      = $select_mailId['email'];
    //         $pass    = $select_mailId['password'];
    //         $subject = "Receive password";
    //         $message = 'Your Password is:' . $pass . " \n";
    //         if (mail($to, $subject, $message)) {
    //             $countChk            = 1;
    //             $datatext['results'] = true;
    //             $datatext['msg']     = "Check Your Email For Password";
    //         }
    //     } else {
    //         $datatext['msg'] = "Your Email Is Not Exist. ";
    //     }
    //     echo json_encode($datatext);
    // }
    /*
     */
    /***********************************
    Method = 17
    function = Forgate password
    Parameter = 
    *******************************************/
    if ($method == "17") {
            $phone      = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $datatext   = array();
            $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_user WHERE `phone`='$phone'"));
            if ($checkExist) {
                    $user_id   = $checkExist['id'];
                    $verify_no = substr(str_shuffle($phone), 5);
                    $message   = "Your DV Verification Code is " . $verify_no;
                    $api_key   = '25867B50EDEA0F';
                    $contacts  = $phone;
                    $from      = 'DailyVegetable';
                    $sms_text  = urlencode($message);
                    //Submit to server
                    $ch        = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://app.mysmsmart.com/app/smsapi/index.php");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=28&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    //echo $response;
                    $insert = mysqli_query($con, " UPDATE `ci_user` SET otp='$verify_no' WHERE phone='$phone' AND id='$user_id'  ");
                    if ($insert) {
                            $datatext['success'] = true;
                            $datatext['msg']     = "successfully send OTP to your registered mobile number";
                            $datatext['user_id'] = $user_id;
                            //$uid=mysqli_insert_id($con);
                    } else {
                            $datatext['msg'] = "Please Try again";
                    }
            }
            echo json_encode($datatext);
    }
    /*
    32 Change Password
    */
    /*Change  Password*/
    if ($method == "32") {
            $new_password = mysqli_real_escape_string($con, $_REQUEST['new_password']);
            $user_id      = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $checkExist   = mysqli_query($con, "SELECT * FROM ci_user WHERE  `id`='$user_id'");
            if ($row = mysqli_fetch_array($checkExist)) {
                    $update = mysqli_query($con, "UPDATE `ci_user` SET `password`='$new_password' WHERE id='$user_id'");
                    if ($update) {
                            $datatext['success'] = true;
                            $datatext['msg']     = "succesfully Change Your Password";
                    } else {
                            $datatext['msg'] = "Please Try again";
                    }
            } else {
                    $datatext['msg'] = "Please Try again";
            }
            echo json_encode($datatext);
    }
    if ($method == "18") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist          = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$user_id' AND `status`!='off' AND `buy_now`!='yes' AND `order_id`='' ");
            $cnt                 = mysqli_num_rows($checkExist);
            if ($cnt != '') {
                    if ($row = mysqli_fetch_array($checkExist)) {
                            $datatext['results']   = true;
                            $datatext['cartcount'] = $cnt;
                    }
            } else {
                    $datatext['results']   = true;
                    $datatext['cartcount'] = '0';
            }
            //$datatext['cartcount']=$cnt;
            //$datatext['data']=$arr;
            echo json_encode($datatext);
    }
    /*Remove  Schedule Data */
    if ($method == "19") {
            $item_id             = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $status              = mysqli_real_escape_string($con, $_REQUEST['status']);
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext['results'] = false;
            $datatext            = array();
            $datatext['results'] = true;
            $checkExist11        = mysqli_query($con, "UPDATE `ci_cart` SET `schedule_for`='No Schedule Available',status='$status' WHERE buyer_id='$user_id' AND item_id='$item_id'");
            $datatext['msg']     = 'Succesfully Delete Your Schedule';
            echo json_encode($datatext);
    }
    // /*SELECT ZONE */
    if ($method == "20") {
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist11        = mysqli_query($con, "SELECT * FROM  `ci_city` ");
            $cnt                 = mysqli_num_rows($checkExist11);
            if ($cnt != '') {
                    while ($checkExist12 = mysqli_fetch_array($checkExist11)) {
                            $datatext['results'] = true;
                            $arr[]               = array(
                                    'city_id'   => $checkExist12['id'],
                                    'state'     => $checkExist12['state_id'],
                                    'city'      => $checkExist12['city_name']
                            );
                    }
                    $datatext['data'] = $arr;
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = 'Please try again';
            }
            echo json_encode($datatext);
    }
    // /*SELECT ZONE */
    if ($method == "21") {
            $city_name           = mysqli_real_escape_string($con, $_REQUEST['city_name']);
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist11        = mysqli_query($con, "SELECT * FROM  `ci_zone` WHERE city_id='$city_name' ");
            $cnt                 = mysqli_num_rows($checkExist11);
            if ($cnt != '') {
                    while ($checkExist12 = mysqli_fetch_array($checkExist11)) {
                            $datatext['results'] = true;
                            $datatext['msg']     = 'success';
                            $arr[]               = array(
                                    'zone_id'   => $checkExist12['id'],
                                    'zone'      => $checkExist12['zone']
                            );
                            $datatext['data']    = $arr;
                    }
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = 'Please try again';
            }
            echo json_encode($datatext);
    }
    // /*SELECT SubZONE */
    if ($method == "26") {
            $zone_id             = mysqli_real_escape_string($con, $_REQUEST['zone_id']);
            $datatext['results'] = false;
            $datatext            = array();
            $checkExist11        = mysqli_query($con, "SELECT * FROM  `ci_subzone` WHERE zone_id='$zone_id' ");
            $cnt                 = mysqli_num_rows($checkExist11);
            if ($cnt != '') {
                    while ($checkExist12 = mysqli_fetch_array($checkExist11)) {
                            $datatext['results'] = true;
                            $arr[]               = array(
                                    'subzone_id' => $checkExist12['id'],
                                    'subzone'    => $checkExist12['sub_zone']
                            );
                            $datatext['data']    = $arr;
                    }
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = 'Please try again';
            }
            echo json_encode($datatext);
    }
    // /*Empty Cart */
    if ($method == "22") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            //$item_id             = explode(',', $_REQUEST['item_id']);
            $datatext            = array();
            $datatext['results'] = false;
            //$date      = date('Y-m-d H:i:s');
            $orderdate           = explode('-', date('Y-m-d'));
            $orderdate1          = explode(':', date('H:i:s'));
            $month               = $orderdate[0];
            $day                 = $orderdate[1];
            $year                = $orderdate[2];
            $hour                = $orderdate1[0];
            $minute              = $orderdate1[1];
            $second              = $orderdate1[2];
            $min                 = rand(5, 15);
            $dat2                =  $month . $day . $year . $month . $day . $min;
            // $dat2="#".$month.$day.$year.$month.$day.$second;
            //echo$sd="SELECT * FROM `ci_cart`  WHERE `status`='off' AND `buyer_id`='$user_id' ";
            $info11              = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE `status`='off' AND `buyer_id`='$user_id'");
            if ($row11 = mysqli_fetch_array($info11)) {
                    $datatext['results'] = "false";
                    $datatext['msg']     = "Your Cart Is Empty One";
            } else {
                    //echo $j= "SELECT * FROM `ci_cart`  WHERE item_id='". $item_id[$i]. "' AND `buyer_id`='user_id'";
                    $info12 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND status='on' ");
                    if ($row12 = mysqli_fetch_array($info12)) {
                            $info                = mysqli_query($con, "UPDATE `ci_cart` SET status='off',`order_id`='$dat2'  WHERE `buyer_id`='$user_id' ");
                            // if ( $info ) {
                            //$datatext['current_song'] = mysqli_insert_id($con);
                            $datatext['results'] = "true";
                            $datatext['msg']     = "Succesfully Order placed";
                            // } 
                    }
            }
            echo json_encode($datatext);
    }
    if ($method == "23") {
            $file       = mysqli_real_escape_string($con, $_REQUEST['file']);
            $datatext   = array();
            $attachment = $_FILES['file']['tmp_name'];
            $path1      = 'img/' . time() . $_FILES['file']['name'];
            //$path1 ='images/'.time().'.jpg';
            if (move_uploaded_file($attachment, $path1)) {
                    $datatext['results'] = true;
                    $datatext['msg']     = "succesfully Add";
            } else {
                    $datatext['msg'] = "Try again";
            }
            echo json_encode($datatext);
    }
    /*Add To Cart */
    if ($method == "24") {
            $buyer_id  = mysqli_real_escape_string($con, $_REQUEST['buyer_id']);
            $name      = mysqli_real_escape_string($con, $_REQUEST['name']);
            $email     = mysqli_real_escape_string($con, $_REQUEST['email']);
            $phone     = mysqli_real_escape_string($con, $_REQUEST['phone']);
            $address   = mysqli_real_escape_string($con, $_REQUEST['address']);
            $city      = mysqli_real_escape_string($con, $_REQUEST['city']);
            $pincode   = mysqli_real_escape_string($con, $_REQUEST['pincode']);
            $zone      = mysqli_real_escape_string($con, $_REQUEST['zone']);
            $testcheck = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$buyer_id'"));
            if (isset($testcheck)) {
                    $insert = mysqli_query($con, "UPDATE `ci_cart` SET `fname`='$name',`email`='$email',`phone`='$phone', `address`='$address',`city`='$city',`pincode`='$pincode',`zone`='$zone'  WHERE `buyer_id`='$buyer_id' ");
                    if ($insert) {
                            $datatext['results'] = true;
                            $datatext['msg']     = "succesfully Change data into your cart";
                    } else {
                            $datatext['results'] = false;
                            $datatext['msg']     = "Please Try again";
                    }
            }
            echo json_encode($datatext);
    }
    /*Buy Now */
    if ($method == "25") {
            $buyer_id = mysqli_real_escape_string($con, $_REQUEST['buyer_id']);
            $item_id  = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $price    = mysqli_real_escape_string($con, $_REQUEST['price']);
            $qty      = mysqli_real_escape_string($con, $_REQUEST['qty']);
            if ($qty == '1' OR $qty == '2' OR $qty == '3' OR $qty == '4') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * 1000 * $qty;
            } elseif ($qty == '250' OR $qty == '500') {
                    $price1      = $price / 1000;
                    $total_price = $price1 * $qty;
            }
            // $orderdate = explode('-',date('Y-m-d'));
            //  $orderdate1 = explode(':',date('H:i:s'));
            //  $month = $orderdate[0];
            //  $day   = $orderdate[1];
            //  $year  = $orderdate[2];
            //  $hour  = $orderdate1[0];
            //  $minute  = $orderdate1[1];
            //  $second  = $orderdate1[2];
            //  $min=rand(000,999);
            //  $dat2="#".$month.$day.$year.$month.$day.$min;
            $today      = date("Y-m-d H:i:s");
            $today1     = explode('', $today);
            $today2     = explode('-', $today1[0]);
            $today3     = explode(':', $today1[1]);
            $orderid    = $today2[0].$today2[1].$today2[2].$today3[0].$today3[1].$today3[2];
            $testcheck6 = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$buyer_id' ");
            while ($row = mysqli_fetch_array($testcheck6)) {
                    $name    = $row['name'];
                    $email   = $row['email'];
                    $phone   = $row['phone'];
                    $address = $row['address'];
                    $city    = $row['city'];
                    $pincode = $row['pincode'];
                    $zone    = $row['zone'];
                    // $testcheck = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$buyer_id' AND `item_id`='$item_id' AND `status`='on' AND `buy_now`='yes'  "));
                    // if (isset($testcheck)) {
                    //     // $insert = mysqli_query($con, "UPDATE `ci_cart` SET `fname`='$name',`email`='$email',`phone`='$phone',`address`='$address',`city`='$city',`pincode`='$pincode',`zone`='$zone',`quantity`='$qty',`total_amount`='$total_price',`updated_at`='$date',`buy_now`='yes'  WHERE `buyer_id`='$buyer_id' AND `item_id`='$item_id'");
                    //     // if ($insert) {
                    //         $datatext['results']     = true;
                    //         $datatext['msg']         = "You have already Purchase This Product";
                    //         $datatext['name'] = $testcheck['fname'];
                    //         $datatext['email'] = $testcheck['email'];
                    //         $datatext['phone'] = $testcheck['phone'];
                    //         $datatext['address'] = $testcheck['address'];
                    //         $datatext['total_price'] = $testcheck['total_amount'];
                    //         $datatext['quantity']    = $testcheck['quantity'];
                    //         $datatext['item_id'] = $testcheck['item_id'];
                    //          $datatext['OrderID']    = $testcheck['order_id'];
                    //     // } else {
                    //         // $datatext['results'] = false;
                    //         // $datatext['msg']     = "Please Try again";
                    //     }
                    // else {
                    // $checkExist = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$buyer_id'"));
                    // if ($checkExist) {
                    $insert  = mysqli_query($con, "INSERT INTO `ci_cart`(`buyer_id`, `fname`, `email`, `phone`, `address`, `city`, `pincode`, `zone`, `item_id`, `cart_items`, `price`, `schedule_for`, `img`, `quantity`, `total_amount`, `created_at`, `updated_at`, `status`, `payment_status`, `delivery_status`, `is_read`, `buy_now`,`order_id`) VALUES ('$buyer_id','$name','$email','$phone','$address','$city','$pincode','$zone','$item_id','','$price','No Schedule Available','','$qty','$total_price','$date','','on','','','','yes','$orderid')");
                    if ($insert) {
                            $datatext['results'] = true;
                            $datatext['msg']     = "Congratulations!Order Placed";
                            $datatext['cart_id'] = mysqli_insert_id($con);
                            $cart_id             = mysqli_insert_id($con);
                            $selectrow           = mysqli_query($con, "SELECT * FROM ci_cart WHERE id='$cart_id'");
                            if ($rowchk = mysqli_fetch_array($selectrow)) {
                                    $datatext['name']        = $rowchk['fname'];
                                    $datatext['email']       = $rowchk['email'];
                                    $datatext['item_id']     = $rowchk['item_id'];
                                    $datatext['phone']       = $rowchk['phone'];
                                    $datatext['address']     = $rowchk['address'];
                                    $datatext['total_price'] = $rowchk['total_amount'];
                                    $datatext['quantity']    = $rowchk['quantity'];
                                    $datatext['OrderID']     = $rowchk['order_id'];
                            }
                    } else {
                            $datatext['results'] = false;
                            $datatext['msg']     = "Please Try again";
                    }
                    // }
            }
            echo json_encode($datatext);
    }
    /* Checked Cart*/
    if ($method == "27") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext            = array();
            $datatext['results'] = false;
            // $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE `status`='off' AND `buyer_id`='$user_id'");
            // $num = mysqli_num_rows($info11);
            // if ($row11 = mysqli_fetch_array($info11)) {
            //      $datatext['results'] = "false";
            //     $datatext['msg'] = "Your Cart Is Empty One";
            // } else {
            $info12              = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE `status`='on' AND `buyer_id`='$user_id'");
            $num1                = mysqli_num_rows($info12);
            if ($row12 = mysqli_fetch_array($info12)) {
                    $datatext['results'] = "true";
                    $datatext['msg']     = "Add Some Item Into Your Cart";
            } else {
                    $datatext['results'] = "false";
                    $datatext['msg']     = "Your Cart Is Empty One";
            }
            // }
            echo json_encode($datatext);
    }/* Summary2*/
    if ($method == "35") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $item_id             = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $status              = mysqli_real_escape_string($con, $_REQUEST['status']);
            $datatext            = array();
            $datatext['results'] = false;
            if($status == 'bn') {
                    $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND `buy_now`='yes' AND  `item_id`='$item_id'");
                    while ($row11 = mysqli_fetch_array($info11)) {
                            $datatext['results'] = "true";
                            $datatext['msg']     = "success";
                            $item                = $row11['item_id'];
                 $info19 = mysqli_query($con, "SELECT * FROM `ci_subcategory`  WHERE  `id`='$item_id' ");
                  while($row19 = mysqli_fetch_array($info19)){
                   
                $category                   = $row19['item_name'];
                    $qty                    = $row11['quantity'];
                            $price=$row11['price'];
                            $arr=array("category"=>$category,"qty"=>$qty,"price"=>$price);
                            
                            $arr1[]=$arr;
                            }
                    }
            } elseif ($status == 'atc') {
                 $arr1=array();
                    $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND `status`='off'");
                    while ($row11 = mysqli_fetch_array($info11)) {
                            $datatext['results'] = "true";
                            $datatext['msg']     = "success";
                            $item                = $row11['item_id'];
                            $info19 = mysqli_query($con, "SELECT * FROM `ci_subcategory`  WHERE  `id`='$item_id' ");
                  while($row19 = mysqli_fetch_array($info19)){
                   
                $category                = $row19['item_name'];
                    $qty               = $row11['quantity'];
                            $price=$row11['price'];
                            $arr=array("category"=>$category,"qty"=>$qty,"price"=>$price);
                            
                            $arr1[]=$arr;
                            }
                           
                            $info15              = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `order_id`='$order' AND `status`='off' ");
                            if ($row15 = mysqli_fetch_array($info15)) {
                                    for ($i = 0; $i < count($order); $i++) {
                                            $total_amount += $row15['total_amount'];
                                    }
                            }
                            
                    
                    }
            }
            $datatext['data'] = $arr1;
            echo json_encode($datatext);
    }


    /* Summary*/
    if ($method == "28") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $item_id             = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $status              = mysqli_real_escape_string($con, $_REQUEST['status']);
            $datatext            = array();
            $datatext['results'] = false;
            if ($status == 'bn') {
                    $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND `buy_now`='yes' AND  `item_id`='$item_id'");
                    while ($row11 = mysqli_fetch_array($info11)) {
                            $datatext['results'] = "true";
                            $datatext['msg']     = "success";
                            $item                = $row11['item_id'];
                            $name                = $row11['fname'];
                            $email               = $row11['email'];
                            $number              = $row11['phone'];
                            $address             = $row11['address'];
                            $total_amount        = $row11['total_amount'];
                            $arr                 = array(
                                    'name' => $name,
                                    'email' => $email,
                                    'number' => $number,
                                    'address' => $address,
                                    'total_amount' => $total_amount
                            );
                    }
            } elseif ($status == 'atc') {
                    $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND `status`='off'");
                    while ($row11 = mysqli_fetch_array($info11)) {
                            $datatext['results'] = "true";
                            $datatext['msg']     = "success";
                            $item                = $row11['item_id'];
                            $order               = $row11['order_id'];
                            $name                = $row11['fname'];
                            $email               = $row11['email'];
                            $number              = $row11['phone'];
                            $address             = $row11['address'];
                            $info15              = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `order_id`='$order' AND `status`='off' ");
                            if ($row15 = mysqli_fetch_array($info15)) {
                                    for ($i = 0; $i < count($order); $i++) {
                                            $total_amount += $row15['total_amount'];
                                    }
                            }
                            $arr = array(
                                    'name'          => $name,
                                    'email'         => $email,
                                    'number'        => $number,
                                    'address'       => $address,
                                    'total_amount'  => $total_amount
                            );
                    }
            }
            $datatext['data'] = $arr;
            echo json_encode($datatext);
    }
    /* Update Address*/
    if ($method == "29") {
            $user_id    = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $address    = mysqli_real_escape_string($con, $_REQUEST['address']);
            $city_id    = mysqli_real_escape_string($con, $_REQUEST['city_id']);
            $city       = mysqli_real_escape_string($con, $_REQUEST['city']);
            $pincode    = mysqli_real_escape_string($con, $_REQUEST['pincode']);
            $zone       = mysqli_real_escape_string($con, $_REQUEST['zone']);
            $street     = mysqli_real_escape_string($con, $_REQUEST['street']);
            $subzone    = mysqli_real_escape_string($con, $_REQUEST['subzone']);
            $house_no     = mysqli_real_escape_string($con, $_REQUEST['house_no']);
            $landmark    = mysqli_real_escape_string($con, $_REQUEST['landmark']);
            $checkExist = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$user_id'");
            if ($row = mysqli_fetch_array($checkExist)) {
                    $update = mysqli_query($con, "UPDATE `ci_user` SET `address`='$address',`city_id`='$city_id',`city`='$city',`pincode`='$pincode' ,`zone`='$zone' ,`street`='$street' ,`sub_zone`='$subzone',`house_no`='$house_no',`landmark`='$landmark' WHERE id='$user_id'");
                    if ($update) {
                            $datatext['success'] = true;
                            $update1             = mysqli_query($con, "UPDATE `ci_cart` SET `address`='$address',`city`='$city',`pincode`='$pincode' ,`zone`='$zone',`subzone`='$subzone',`street`='$street',`house_no`='$house_no',`landmark`='$landmark'  WHERE buyer_id='$user_id'");
                            if ($update1) {
                                    $datatext['msg'] = "succesfully Edit ";
                            }
                    } else {
                            $datatext['success'] = false;
                            $datatext['msg'] = "Please Try again";
                    }
            } else {
                    $datatext['success'] = false;
                    $datatext['msg'] = "Please Try again";
            }
            echo json_encode($datatext);
    }
    /* Final Submit*/
    // if ($method == "30") {
    //     $user_id  = mysqli_real_escape_string($con, $_REQUEST['user_id']);
    //     $status  = mysqli_real_escape_string($con, $_REQUEST['status']);
    //     if($status=='bn')
    //     {
    //         $orderdate = explode('-',date('Y-m-d'));
    //         $orderdate1 = explode(':',date('H:i:s'));
    //         $month = $orderdate[0];
    //         $day   = $orderdate[1];
    //         $year  = $orderdate[2];
    //         $hour  = $orderdate1[0];
    //         $minute  = $orderdate1[1];
    //         $second  = $orderdate1[2];
    //         $min=rand(5,15);
    //     $dat2="#".$month.$day.$year.$month.$day.$min;
    //     $testcheck6 = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$user_id'");
    //     while($row=mysqli_fetch_array($testcheck6)){
    //    $item_id=$row['item_id'];
    //     $insert = mysqli_query($con, "UPDATE `ci_cart` SET `updated_at`='$date',`buy_now`='yes' ,order_id='$dat2' WHERE `buyer_id`='$buyer_id' AND `item_id`='$item_id'");
    //         if ($insert) {
    //             $datatext['results']     = true;
    //             $datatext['msg']         = "Succesfully Order placed";
    //             $datatext['name'] = $row['fname'];
    //             $datatext['email'] = $row['email'];
    //             $datatext['phone'] = $row['phone'];
    //             $datatext['address'] = $row['address'];
    //             $datatext['total_price'] = $row['total_amount'];
    //             $datatext['quantity']    = $row['quantity'];
    //             $datatext['item_id'] = $row['item_id'];
    //              $datatext['OrderID']    = $row['order_id'];
    //         } else {
    //             $datatext['results'] = false;
    //             $datatext['msg']     = "Please Try again";
    //         }
    //     }
    // }elseif($status=='atc')
    //     {
    //         $orderdate = explode('-',date('Y-m-d'));
    //     $orderdate1 = explode(':',date('H:i:s'));
    //     $month = $orderdate[0];
    //     $day   = $orderdate[1];
    //     $year  = $orderdate[2];
    //     $hour  = $orderdate1[0];
    //     $minute  = $orderdate1[1];
    //     $second  = $orderdate1[2];
    //     $min=rand(5,15);
    //     $dat2="#".$month.$day.$year.$month.$day.$min;
    //    // $dat2="#".$month.$day.$year.$month.$day.$second;
    //         //echo$sd="SELECT * FROM `ci_cart`  WHERE `status`='off' AND `buyer_id`='$user_id' ";
    //         // $info11 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE `status`='off' AND `buyer_id`='$user_id'");
    //         // if ($row11 = mysqli_fetch_array($info11)) {
    //         //      $datatext['results'] = "false";
    //         //     $datatext['msg'] = "Your Cart Is Empty One";
    //         // } else {
    //             //echo $j= "SELECT * FROM `ci_cart`  WHERE item_id='". $item_id[$i]. "' AND `buyer_id`='user_id'";
    //             $info12 = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND status='on' ");
    //             if ($row12 = mysqli_fetch_array($info12)) {
    //                 $info                = mysqli_query($con, "UPDATE `ci_cart` SET status='off',`order_id`='$dat2'  WHERE `buyer_id`='$user_id' ");
    //                 // if ( $info ) {
    //                 //$datatext['current_song'] = mysqli_insert_id($con);
    //                 $datatext['results'] = "true";
    //                 $datatext['msg']     = "Succesfully Order placed";
    //                 // } 
    //             //}
    //         }
    //     }
    //     echo json_encode($datatext);
    // }
    // /*Empty Cart */
    if ($method == "30") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $status              = mysqli_real_escape_string($con, $_REQUEST['status']);
            //$item_id             = explode(',', $_REQUEST['item_id']);
            $datatext            = array();
            $datatext['results'] = false;
            //  //$date      = date('Y-m-d H:i:s');
            // $orderdate = explode('-',date('Y-m-d'));
            // $orderdate1 = explode(':',date('H:i:s'));
            // $month = $orderdate[0];
            // $day   = $orderdate[1];
            // $year  = $orderdate[2];
            // $hour  = $orderdate1[0];
            // $minute  = $orderdate1[1];
            // $second  = $orderdate1[2];
            // $min=rand(000,999);
            // $dat2="#".$month.$day.$year.$month.$day.$min;
            $today               = date("Y-m-d H:i:s");
            $today1              = explode('', $today);
            $today2              = explode('-', $today1[0]);
            $today3              = explode(':', $today1[1]);
            $orderid             =$today2[0].$today2[1].$today2[2].$today3[0].$today3[1].$today3[2];
            $infouser              = mysqli_query($con, "SELECT * FROM `ci_user`  WHERE  `id`='$user_id' ");
            while ($rowuser = mysqli_fetch_array($infouser)) {
            $info12              = mysqli_query($con, "SELECT * FROM `ci_cart`  WHERE  `buyer_id`='$user_id' AND status='on' ");
           $row12 = mysqli_fetch_array($info12);
                    $item_id                  = $row12['item_id'];
                    $info                     = mysqli_query($con, "UPDATE `ci_cart` SET status='off',`order_id`='$orderid'  WHERE `buyer_id`='$user_id' AND `item_id`='$item_id' ");
                    $OrderID                  = $row12['order_id'];
                    $info15                   = mysqli_query($con, "SELECT *,SUM(total_amount) AS AMOUNT FROM `ci_cart`  WHERE  `order_id`='$orderid' AND `status`='off' ");
                    $row15                    = mysqli_fetch_array($info15);
                    //$total_amount=$row15['AMOUNT'];
                   // $datatext['current_song'] = mysqli_insert_id($con);
                    $datatext['results']      = "true";
                    $datatext['msg']          = "Congratulations!Order Placed";
                    $datatext['name']         = $rowuser['name'];
                    $datatext['email']        = $rowuser['email'];
                    $datatext['phone']        = $rowuser['phone'];
                    $datatext['address']      = $rowuser['address'];
                    $datatext['total_price']  = $row15['AMOUNT'];
                    $datatext['quantity']     = $row15['quantity'];
                    $datatext['item_id']      = $row15['item_id'];
                    $datatext['OrderID']      = $row15['order_id'];

                    //$order=$row12['']
                    
              //           $to      = $row15['email'];
              //          $from_email = "orders.dailyvegetable.com";
              //           $message ="Daily Vegetable";
              //           $message="'Dear Customer, your Ordered has been Accepted.' .' '. ' We are on our way to deliver your Package to our Schedule 7 to 10 AM'."\r\n".
              // ' Product Name : '.$item_name."\r\n".' Product Price :'.$rows->total_amount."\r\n".
              // ' Quantity : '.$quantity."\r\n".
              // ' Delivery Address :'. $rows->address ."\r\n" . $rows->zone."\r\n". $rows->city"
              //           $subject = "Receive password";
              //           $message = 'Your Password is:' . $pass . " \n";
              //           if (mail($to, $subject, $message)) {
              //               $countChk            = 1;
              //               $datatext['results'] = true;
              //               $datatext['msg']     = "Check Your Email For Password";
              //           }
                    
                }
            echo json_encode($datatext);
    }
    /*History */
    if ($method == "31") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext            = array();
            $datatext['results'] = false;
            $test                = mysqli_query($con, "SELECT * FROM ci_cart WHERE `buyer_id`='$user_id' AND order_id!=''  ");
            $testcheck11         = mysqli_num_rows($test);
            if ($testcheck11 != '') {
                    $datatext['results'] = true;
                    $datatext['msg']     = "success";
                    while ($testcheck = mysqli_fetch_array($test)) {
                            $order_id = $testcheck['order_id'];
                            $item_id  = $testcheck['item_id'];
                            //echo "SELECT * FROM ci_subcategory WHERE id='$item_id'";
                            $querr    = mysqli_query($con, "SELECT * FROM ci_subcategory WHERE id='$item_id'");
                            $row      = mysqli_fetch_array($querr);
                            $arr[]    = array(
                                    'item_id'       => $item_id,
                                    'item_name'     => $row['item_name'],
                                    'img'           => $img_url."/DWadmin/assets/subcategoryImg/" . $row['img'],
                                    'qty'           => $testcheck['quantity'],
                                    'total_amount'  => $testcheck['total_amount'],
                                    'date'          => $testcheck['created_at'],
                                    'schedule_for'  => $testcheck['schedule_for']
                            );
                    }
                    $datatext['data'] = $arr;
            } else {
                    $datatext['results'] = false;
                    $datatext['msg']     = "No results found";
            }
            echo json_encode($datatext);
    }
    /*Add To Cart */
    if ($method == "34") {
            $buyer_id    = mysqli_real_escape_string($con, $_REQUEST['buyer_id']);
            $item_id     = mysqli_real_escape_string($con, $_REQUEST['item_id']);
            $schedule       = mysqli_real_escape_string($con, $_REQUEST['schedule']);
            $qty        = mysqli_real_escape_string($con, $_REQUEST['qty']);
            $amount = mysqli_real_escape_string($con, $_REQUEST['amount']);
            $debit = mysqli_real_escape_string($con, $_REQUEST['debit']);
            $est_amount = mysqli_real_escape_string($con, $_REQUEST['est_amount']);
            $payble_amt = mysqli_real_escape_string($con, $_REQUEST['payble_amt']);


            $testcheck6  = mysqli_query($con, "SELECT * FROM ci_user WHERE `id`='$buyer_id' ");
            if ($row = mysqli_fetch_array($testcheck6)) {
                    $name      = $row['name'];
                    $email     = $row['email'];
                    $phone     = $row['phone'];
                    $address   = $row['address'];
                    $city      = $row['city'];
                    $pincode   = $row['pincode'];
                    $zone      = $row['zone'];
                    $date      = date('Y-m-d H:i:s');


                    $today = date("Y:m:d H:i:s"); 
                    $today1=explode(' ',$today);
                    $today2=explode(':',$today1[0]);
                    $today3=explode(':',$today1[1]);
                    $orderid=$today2[0].$today2[1].$today2[2].$today3[0].$today3[1].$today3[2];

                   $item_aaray= explode(',',$item_id);
                   $schedule_aaray= explode('/',$schedule);
                   $qty_aaray= explode(',',$qty);
                   $amount_aaray= explode(',',$amount);
                   for ($i=0; $i < count($item_aaray); $i++) {

                        $insert = mysqli_query($con, "INSERT INTO `ci_cart`(`buyer_id`, `fname`, `email`, `phone`, `address`, `city`, `pincode`, `zone`, `item_id`, `cart_items`, `price`, `schedule_for`, `img`, `quantity`, `total_amount`, `created_at`, `updated_at`, `status`, `payment_status`, `delivery_status`, `is_read`,`buy_now`,`order_id`) VALUES ('$buyer_id','$name','$email','$phone','$address','$city','$pincode','$zone','$item_aaray[$i]','','','$schedule_aaray[$i]','','$qty_aaray[$i]','$amount_aaray[$i]','$date','','on','','','','no','$orderid')");
                            
                       
                   }
                    if ($insert) {
                                    $datatext['results']     = true;
                                    $datatext['msg']         = "Added Succesfully";
                                    
                                    //$datatext['OrderID']    = '';
                            } else {
                                    $datatext['results'] = false;
                                    $datatext['msg']     = "Please Try again";
                            }

                    
                    $insert_order = mysqli_query($con,"INSERT INTO `order` (`user_id`,`order_id`,`debit_amt`,`payable_amt`,`est_total`) VALUES ('$buyer_id','$orderid','$debit','$payble_amt','$est_amount')");

                     $insert_dv = mysqli_query($con,"INSERT INTO `dv_wallets` (`debit`,`user_id`) VALUES ('$debit','$buyer_id')");

                    $order_cart_sche  = mysqli_query($con, "SELECT * FROM ci_cart WHERE `order_id`='$orderid' ");
                        while($row_schedule = mysqli_fetch_array($order_cart_sche)) {

                                  $sch_item_id=$row_schedule['item_id'];
                                   $cart_id=$row_schedule['id'];
                                  $sch_order_id=$row_schedule['order_id'];
                                  $sch_schedule_for=$row_schedule['schedule_for'];
                                  $uid=$row_schedule['buyer_id'];
                                  if($sch_schedule_for!='No Schedule Available'){

                                            $sch_schedule_array = explode(',', $sch_schedule_for);
                                            for ($i=0; $i < count($sch_schedule_array); $i++) { 
                                                       $day=$sch_schedule_array[$i];
                                                            if($day=='Su'){

                                                              $nextSunday = date("Y-m-d", strtotime('next sunday'));

                                                                $date = strtotime($nextSunday);

                                                                $date1 = strtotime("+7 day", $date);
                                                                $date_sun2= date('Y-m-d', $date1);

                                                                $date2 = strtotime("+14 day", $date);
                                                                $date_sun3= date('Y-m-d', $date2);

                                                                $date3 = strtotime("+21 day", $date);
                                                                $date_sun4= date('Y-m-d', $date3);

                                                                $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextSunday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sun2','$cart_id')");

                                                                $query115 = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sun3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sun4','$cart_id')");


                                                            }else if($day=='Mo'){

                                                              $nextMonday = date("Y-m-d", strtotime('next monday'));
                                                                $datemo = strtotime($nextMonday);

                                                                $date1mo = strtotime("+7 day", $datemo);
                                                                $date_mo2= date('Y-m-d', $date1mo);

                                                                $date2mo = strtotime("+14 day", $datemo);
                                                                $date_mo3= date('Y-m-d', $date2mo);

                                                                $date3mo = strtotime("+21 day", $datemo);
                                                                $date_mo4= date('Y-m-d', $date3mo);

                                                                $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextMonday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_mo2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_mo3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_mo4','$cart_id')");
                                                              
                                                            }else if($day=='Tu'){

                                                              $nextTuesday = date("Y-m-d", strtotime('next tuesday'));
                                                                $datetu = strtotime($nextTuesday);

                                                                $date1tu = strtotime("+7 day", $datetu);
                                                                $date_tu2= date('Y-m-d', $date1tu);

                                                                $date2tu = strtotime("+14 day", $datetu);
                                                                $date_tu3= date('Y-m-d', $date2tu);

                                                                $date3tu = strtotime("+21 day", $datetu);
                                                                $date_tu4= date('Y-m-d', $date3tu);

                                                                $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextTuesday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_tu2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_tu3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_tu4','$cart_id')");
                                                              
                                                            }else if($day=='We'){

                                                              $nextWednesday = date("Y-m-d", strtotime('next wednesday'));

                                                              $datewe = strtotime($nextWednesday);

                                                                $date1we = strtotime("+7 day", $datewe);
                                                                $date_we2= date('Y-m-d', $date1we);

                                                                $date2we = strtotime("+14 day", $datewe);
                                                                $date_we3= date('Y-m-d', $date2we);

                                                                $date3we = strtotime("+21 day", $datewe);
                                                                $date_we4= date('Y-m-d', $date3we);


                                                                 $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextWednesday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_we2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_we3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_we4','$cart_id')");
                                                              
                                                            }else if($day=='Th'){

                                                               $nextThrusday = date("Y-m-d", strtotime('next thrusday'));

                                                               $dateth = strtotime($nextThrusday);

                                                                $date1th = strtotime("+7 day", $dateth);
                                                                $date_th2= date('Y-m-d', $date1th);

                                                                $date2th = strtotime("+14 day", $dateth);
                                                                $date_th3= date('Y-m-d', $date2th);

                                                                $date3th = strtotime("+21 day", $dateth);
                                                                $date_th4= date('Y-m-d', $date3th);


                                                                $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextThrusday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_th2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_th3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_th4','$cart_id')");
                                                              
                                                            }else if($day=='Fr'){

                                                               $nextFriday = date("Y-m-d", strtotime('next friday'));

                                                               $datefr = strtotime($nextFriday);

                                                                $date1fr = strtotime("+7 day", $datefr);
                                                                $date_fr2= date('Y-m-d', $date1fr);

                                                                $date2fr = strtotime("+14 day", $datefr);
                                                                $date_fr3= date('Y-m-d', $date2fr);

                                                                $date3fr = strtotime("+21 day", $datefr);
                                                                $date_fr4= date('Y-m-d', $date3fr);

                                                                $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextFriday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_fr2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_fr3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_fr4','$cart_id')");
                                                              
                                                            }else if($day=='Sa'){

                                                              $nextSaturday = date("Y-m-d", strtotime('next saturday'));

                                                              $datesa = strtotime($nextSaturday);

                                                                $date1sa = strtotime("+7 day", $datesa);
                                                                $date_sa2= date('Y-m-d', $date1sa);

                                                                $date2sa = strtotime("+14 day", $datesa);
                                                                $date_sa3= date('Y-m-d', $date2sa);

                                                                $date3sa = strtotime("+21 day", $datesa);
                                                                $date_sa4= date('Y-m-d', $date3sa);

                                                                  $query113  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$nextSaturday','$cart_id')");

                                                                $query114  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sa2','$cart_id')");

                                                                $query115  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sa3','$cart_id')");

                                                                $query116  = mysqli_query($con,"INSERT INTO `schedule` (`user_id`,`item_id`,`order_id`,`schedule_date`,`cart_id`) VALUES ('$uid','$sch_item_id','$sch_order_id','$date_sa4','$cart_id')");
                                                              
                                                            }
                                                      
                                                          
                                                         // echo date_format($date, 'Y-m-d');
                                                       
                                                    }
                                     }
                            }

                    if($insert_dv){

                         $insert_dv_update = mysqli_query($con,"update ci_user set balance=balance-$debit where id='$buyer_id'");
                    }




                } else {
                    $datatext['results'] = false;
                                    $datatext['msg']     = "User not exists";
            }
            echo json_encode($datatext);
    }
    if ($method == "36") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext['results'] = false;
            $datatext            = array();


            $checkExist          = mysqli_query($con, "SELECT * FROM dv_wallets WHERE `user_id`='$user_id'");
             if($newbal=mysqli_fetch_array($checkExist)) {
                            $datatext['results']   = true;
                            $datatext['wallet_balance'] =$newbal['wallet_balance'];
                            $datatext['updat_date'] = $newbal['updat_date'];
                
             }else{
                $datatext['results'] = false;
                 $datatext['wallet_balance'] ='0';
             }
            echo json_encode($datatext);
    }
    // if ($method == "21") {
    //     $file       = mysqli_real_escape_string($con, $_REQUEST['file']);
    //     $imagef=$_FILES['file']['tmp_name'];
    //     $imagef1=$_FILES['file']['name'];
    //     $path="img/".$_FILES['file']['name'];
    //     if(move_uploaded_file($_FILES['file']['tmp_name'],  $path)){
    // $datatext['msg']='Succesfully upload your file';
    // }
    //     echo json_encode($datatext);
    // }
    // if($method=="21")
    // {
    //     //$file         = mysqli_real_escape_string($con, $_REQUEST['file']);
    //     if(isset($_POST['submit']))
    //     {
    //   if (move_uploaded_file($_FILES['file']['tmp_name'], __DIR__.'img/'. $_FILES["file"]['name'])) {
    //     echo "Uploaded";
    // } else {
    //    echo "File was not uploaded";
    // }
    //  }  
    //     echo'<form action="Api.php" method="post" enctype="multipart/form-data">
    // <input type="file" name="file" id="file">
    // <input type="submit" value="Upload Image" name="submit">
    // </form>';
    //     echo json_encode($datatext);
    // }
    //=======================OFFER NOTIFICATION====================//
    if ($method == "37") {
            $select        = mysqli_query($con, "SELECT * FROM  `discount` ");
            if($select!=''){
                while ($selectinfo = mysqli_fetch_array($select)) {
                        $datatext['results'] = true;
                        $arr[]               = array(
                            'min_amount'    => $selectinfo['min_amount'],
                            'max_amount'    => $selectinfo['max_amount'],
                            'discount'      => $selectinfo['discount'],
                            'msg'           => 'Get '.$selectinfo['discount'].'% Discount on Minimum Purchase Of '.$selectinfo['min_amount']
                        );
                }
                    $datatext['data']    = $arr;
           }else{
                    $datatext['results'] = false;
                    $datatext['msg']     = "No Discount found";
                 }
                 
            echo json_encode($datatext);
    }
    if ($method == "38") {
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_categories` ORDER BY id desc  ");
            while ($fetch_record = mysqli_fetch_array($get_record)) 
            {
                $datatext['result'] = true;
                $cat_name           = $fetch_record['cat_name'];
                $cat_des            = $fetch_record['cat_des'];
                $img                = $img_url."/DWadmin/assets/CategoryImg/" . $fetch_record['img'];
                $id                 = $fetch_record['id'];
                $data               = array();
                    
                $get_record11 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE cat_id='$id'  AND in_stock!='1'");
                $fetch_recordnumrow = mysqli_num_rows($get_record11);
                if($fetch_recordnumrow!=''){
                $fetch_record11 = mysqli_fetch_array($get_record11);
                                    $subid       = $fetch_record11['id'];
                                    $cid         = $fetch_record11['cat_id'];
                                    $item_name   = $fetch_record11['item_name'];
                                    $item_price  = $fetch_record11['item_price'];
                                    $description = $fetch_record11['description'];
                                    $unit        = $fetch_record13['units'];
                                    $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record11['img'];
                                    $arr1        = array(
                                            'SubID'         => $subid,
                                            'ItemName'      => $item_name,
                                            'ItemPrice'     => $item_price,
                                            'unit'          => $unit,
                                            'Description'   => $description,
                                            'Img'           => $img11
                                    );
                                    $data[]      = $arr1;
                                    $arr[]                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );
                            
                        }else
                        {
                            $arr[]                = array(
                            "msg"        => 'Please try again',
                           
                    );
                        }

                    }
                    
                    $main[]               = array(
                            $arr
                    );
                    $datatext['category'] = $main;
           
            echo json_encode($datatext);
    }
    if ($method == "39") {
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_categories` ORDER BY id desc  ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result'] = true;
                     $main               = array();
                     $arr10               = array();
                    if($cat_name!='')
                    {
                         $cat_name           = $fetch_record['cat_name'];
                     }else
                     {
                         $cat_name           = 'Popular Product';
                     }
                    $cat_des            = $fetch_record['cat_des'];
                    $img                = $img_url."/DWadmin/assets/CategoryImg/" . $fetch_record['img'];
                    $id                 = $fetch_record['id'];
                    $data               = array();

                    if ($cat_name == 'Popular Product') {

                            $get_record12 = mysqli_query($con, "SELECT * FROM `populor`");
                            while ($fetch_record12 = mysqli_fetch_array($get_record12)) {

                                    $subid        = $fetch_record12['subcat_id'];
                                    $get_record13 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE id='$subid' AND in_stock!='1'");
                                    while ($fetch_record13 = mysqli_fetch_array($get_record13)) {
                                            $subid       = $fetch_record13['id'];
                                            $cid         = $fetch_record13['cat_id'];
                                            $item_name   = $fetch_record13['item_name'];
                                            $item_price  = $fetch_record13['item_price'];
                                            $description = $fetch_record13['description'];
                                            $unit        = $fetch_record13['units'];
                                            $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record13['img'];
                                            $arr2        = array(
                                                    'SubID'         => $subid,
                                                    'ItemName'      => $item_name,
                                                    'ItemPrice'     => $item_price,
                                                    'unit'          => $unit,
                                                    'Description'   => $description,
                                                    'Img'           => $img11
                                            );
                                            $data[]      = $arr2;
                                            //print_r($data2);
                                            $arr                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );
                             
                             $arr10[]=$arr9;               
                                    }
                            }
                    } else {
                            $get_record11 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE cat_id='$id'  AND in_stock!='1'");
                             $fetch_recordnumrow = mysqli_num_rows($get_record11);
                if($fetch_recordnumrow!=''){
                            while ($fetch_record11 = mysqli_fetch_array($get_record11)) {
                                    $subid       = $fetch_record11['id'];
                                    $cid         = $fetch_record11['cat_id'];
                                    $item_name   = $fetch_record11['item_name'];
                                    $item_price  = $fetch_record11['item_price'];
                                    $description = $fetch_record11['description'];
                                    $unit        = $fetch_record13['units'];
                                    $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record11['img'];
                                    $arr1        = array(
                                            'SubID'         => $subid,
                                            'ItemName'      => $item_name,
                                            'ItemPrice'     => $item_price,
                                            'unit'          => $unit,
                                            'Description'   => $description,
                                            'Img'           => $img11
                                    );
                                    $data[]      = $arr1;
                            }
                                      $arr                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );
                             
                             $arr10[]=$arr9;
                    }else{$arr                = array(
                            "MSG"        => "Please TRY AGAIN",
                            
                    );}
                }
                    // $arr[]                = array(
                    //         "id"        => $id,
                    //         "cat_name"  => $cat_name,
                    //         "cat_des"   => $cat_des,
                    //         "img"       => $img,
                    //         "subdata"   => $data
                    // );
                    $main[]               = $arr;
                    $datatext['category'] = $main;
            }
            echo json_encode($datatext);
    }

    if ($method == "38") {
            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `ci_categories` ORDER BY id desc  ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result'] = true;
                $arr=array();
                    if($cat_name!='')
                    {
                         $cat_name           = $fetch_record['cat_name'];
                     }else
                     {
                         $cat_name           ='popular product';
                     }
                    $cat_des            = $fetch_record['cat_des'];
                    $img                = $img_url."/DWadmin/assets/CategoryImg/".$fetch_record['img'];
                    $id                 = $fetch_record['id'];
                    $data               = array();
                    if ($cat_name == 'popular product') {

                            $get_record12 = mysqli_query($con, "SELECT * FROM `populor`");
                            while ($fetch_record12 = mysqli_fetch_array($get_record12)) {

                                    $subid        = $fetch_record12['subcat_id'];
                                    $get_record13 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE id='$subid' AND in_stock!='1'");
                                    while ($fetch_record13 = mysqli_fetch_array($get_record13)) {
                                            $subid       = $fetch_record13['id'];
                                            $cid         = $fetch_record13['cat_id'];
                                            $item_name   = $fetch_record13['item_name'];
                                            $item_price  = $fetch_record13['item_price'];
                                            $description = $fetch_record13['description'];
                                            $unit        = $fetch_record13['units'];
                                            $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record13['img'];
                                            $arr2        = array(
                                                    'SubID'         => $subid,
                                                    'ItemName'      => $item_name,
                                                    'ItemPrice'     => $item_price,
                                                    'unit'          => $unit,
                                                    'Description'   => $description,
                                                    'Img'           => $img11
                                            );
                                            $data[]      = $arr2;
                                            //print_r($data2);
                                            $arr                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );

                                    }
                            }
                    } else {
                            $get_record11 = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE cat_id='$id'  AND in_stock!='1'");
                            while ($fetch_record11 = mysqli_fetch_array($get_record11)) {
                                    $subid       = $fetch_record11['id'];
                                    $cid         = $fetch_record11['cat_id'];
                                    $item_name   = $fetch_record11['item_name'];
                                    $item_price  = $fetch_record11['item_price'];
                                    $description = $fetch_record11['description'];
                                    $unit        = $fetch_record13['units'];
                                    $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $fetch_record11['img'];
                                    $arr1        = array(
                                            'SubID'         => $subid,
                                            'ItemName'      => $item_name,
                                            'ItemPrice'     => $item_price,
                                            'unit'          => $unit,
                                            'Description'   => $description,
                                            'Img'           => $img11
                                    );
                                    $data[]      = $arr1;
                            }
                             $arr[]                = array(
                            "id"        => $id,
                            "cat_name"  => $cat_name,
                            "cat_des"   => $cat_des,
                            "img"       => $img,
                            "subdata"   => $data
                    );
                    }
                    
                    $main[]               = array(
                            $arr
                    );
                    $datatext['category'] = $arr;
            }
            echo json_encode($datatext);
    }

    if ($method == "40") {
            $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $select        = mysqli_query($con, "SELECT * FROM  `dv_wallets` WHERE `user_id`='$user_id' ");
            if($select!=''){
                if ($selectinfo = mysqli_fetch_array($select)) {
                        $datatext['results'] = true;
                        $arr               = array(
                            'balance'    => $selectinfo['wallet_balance']
                        );
                }else{
                    $datatext['results'] = true;
                    $arr               = array(
                            'balance'    => 0
                        );
                }
                   
                    $datatext['data']    = $arr;
           }else{
                    $datatext['results'] = false;
                    $datatext['msg']     = "No balance found";
                 }
                 
            echo json_encode($datatext);
    }

    if ($method == "41") {
        $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext           = array();
            $get_record         = mysqli_query($con, "SELECT * FROM `schedule` WHERE `user_id`='$user_id' GROUP BY schedule_date ORDER BY schedule_date ASC ");
            while ($fetch_record = mysqli_fetch_array($get_record)) {


                     $yrdata= strtotime($fetch_record['schedule_date']);
                     $date_sch=date('d-M-Y', $yrdata);
                     $fetch_record_schedule_date=$fetch_record['schedule_date'];
                     $get_record1 = mysqli_query($con, "SELECT * FROM `schedule` WHERE `user_id`='$user_id' and  `schedule_date`='$fetch_record_schedule_date' ");
                     while($get_item1 = mysqli_fetch_array($get_record1)){
                        $item_ci=$get_item1['item_id'];
                        $get_record11  = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE `id`='$item_ci'");
                        $get_item = mysqli_fetch_array($get_record11);
                        $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $get_item['img'];

                        ${"file" .$fetch_record['id']}[] = array('item_name' => $get_item['item_name'],'item_price' => $get_item['item_price'],'description' => $get_item['description'],'img' => $img11,'cart_id' => $get_item1['cart_id']);


                     }

                    $arr2[]        = array('date' => $date_sch,'schedule' => $fetch_record['id'],'item' => ${"file" .$fetch_record['id']});
                   $datatext['results'] = true;                         
            }
             $datatext['data'] = $arr2; 

            echo json_encode($datatext);
    }
    if ($method == "42") {
          $datatext['results'] = false;  
            $schedule_id             = mysqli_real_escape_string($con, $_REQUEST['schedule_id']);
            $date             = mysqli_real_escape_string($con, $_REQUEST['date']);
            $datatext           = array();
            $get_record         = mysqli_query($con, "UPDATE  `schedule` SET `schedule_date`='$date' WHERE `id`='$schedule_id'"); 
            if($get_record){
                $datatext['results'] = true;  
            }
                   

            echo json_encode($datatext);
    }
    if ($method == "43") {
          $datatext['results'] = false;  
            $schedule_id             = mysqli_real_escape_string($con, $_REQUEST['schedule_id']);
            $datatext           = array();
            $get_record         = mysqli_query($con, "DELETE FROM `schedule` WHERE `id`='$schedule_id'"); 
            if($get_record){
                $datatext['results'] = true;  
            }
                   

            echo json_encode($datatext);
    }

    if ($method == "44") {
        $user_id             = mysqli_real_escape_string($con, $_REQUEST['user_id']);
            $datatext           = array();
            $get_record         = mysqli_query($con, "SELECT * FROM `order` WHERE `user_id`='$user_id' ORDER BY id  DESC");
            while ($fetch_record = mysqli_fetch_array($get_record)) {


                     $order_id= $fetch_record['order_id'];
                     $get_record1 = mysqli_query($con, "SELECT * FROM `ci_cart` WHERE `order_id`='$order_id'");
                     while($get_item1 = mysqli_fetch_array($get_record1)){

                        $item_ci=$get_item1['item_id'];
                        $get_record11  = mysqli_query($con, "SELECT * FROM `ci_subcategory` WHERE `id`='$item_ci'");
                        $get_item = mysqli_fetch_array($get_record11);
                        $img11       = $img_url."/DWadmin/assets/subcategoryImg/" . $get_item['img'];

                        ${"file" .$fetch_record['id']}[] = array('item_name' => $get_item['item_name'],'item_price' => $get_item['item_price'],'description' => $get_item['description'],'img' => $img11,'cart_id' => $get_item1['id']);
                     }

                    $arr2[]        = array('order_id' => $fetch_record['order_id'],'date' => $fetch_record['date'],'total_price' => $fetch_record['est_total'],'item' => ${"file" .$fetch_record['id']});
                   $datatext['results'] = true;                         
            }
             $datatext['data'] = $arr2; 

            echo json_encode($datatext);
    }

    if ($method == "45") {

            $datatext           = array();
            $datatext['result'] = false;
            $get_record         = mysqli_query($con, "SELECT * FROM `section`");
            while ($fetch_record = mysqli_fetch_array($get_record)) {
                    $datatext['result']   = true;
                    $cat_name             = $fetch_record['name'];
                    $id                   = $fetch_record['id'];
                    $arr[]                = array(
                            "id" => $id,
                            "name" => $cat_name
                    );
                    $datatext['section'] = $arr;
            }
            echo json_encode($datatext);
    }
?>