<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  include('db.php');
   if(!(isset($_SESSION['id'])))
   {
      header("location:index.php");
   }

   if (isset($_POST['btn_update'])) 
  {
   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $pin_code = $_POST['pin_code'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $delivery_charge = $_POST['delivery_charge'];
    $cod_charge = $_POST['cod_charge'];


    $product_name = $_POST['product_name'];
    $product_size = $_POST['product_size'];
    $product_qty = $_POST['product_qty'];

    date_default_timezone_set('Asia/Calcutta');
    $date=date('Y/m/d h:i:s');


    $ProductPricequery = mysqli_query($con,"SELECT * FROM `product` WHERE product_id='$product_name'");
    $resPrice = mysqli_fetch_array($ProductPricequery);
    $payment=$resPrice['sale_price'];

    $is_payment=$product_qty*$payment;

    $sqlCart ="INSERT into `cart` (`product_id`,`qty`,`size`,`is_payment`,`status`) VALUES ('$product_name','$product_qty','$product_size','$is_payment','1')";
    $queryCart = mysqli_query($con, $sqlCart);
    
    $total_price=$is_payment+$delivery_charge+$cod_charge;
    if($queryCart){

      $cart_id=mysqli_insert_id($con);

      $sqlInsert ="INSERT into `order` (`p_id`,`name`,`email`,`mobile`,`address`,`pin_code`,`state_id`,`city_id`,`delivery_charge`,`cod_charge`,`total_price`,`order_date`,`status`) VALUES ('$cart_id','$name','$email','$mobile','$address','$pin_code','$state','$city','$delivery_charge','$cod_charge',$total_price,'$date','1')";
      $queryInsert = mysqli_query($con, $sqlInsert);
      if($queryInsert){


           $msgmobile="Your Order has been Confirmed and will reach you by 7 to 10 days.";
           $authKey = "75568A0nZox8z9548029cb";
           //Sender ID,While using route4 sender id should be 6 characters long.
           $senderId = "BAMHKL";
           
           //Define route 
           $route = "4";
           
           //Prepare you post parameters
           $postData = array(
           'authkey' => $authKey,
           'mobiles' => $mobile,
           'message' => $msgmobile,
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
           //echo $output;
           //Print error if any
           // if(curl_errno($ch)){
           // echo 'error:' . curl_error($ch);
           // }
           
           curl_close($ch);
           header("location:order.php?order_type=&status=&date=&btn_search=");
      }
      

  }
}
   
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
      <title></title>
      <style>
.data-info
{
    margin: 0 auto;
    text-align: center;
    width: 350px;
}
select 
{
    margin: 25px;
    border: none;
    background: #f7f7f7;
    padding: 15px 10px;
    font-size: 16px;
    width:100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
 
}
</style>
<script type="text/javascript">
      function getCity(val) {
        console.log(val);
        $.ajax({
          type: "POST",
          url: "get_ajax_citydata.php",
          data: "state_id="+val,
          success: function(response){
             console.log(response);
              $('#city').html(response);
          }
        });
      } 
    </script>
    </head>
    <body>
      <!-- Start : Side bar -->
      <?php 
         include('header.php');
         include('sidebar.php'); 
         ?>
      <!-- End : Side bar -->
      <div id="content">
        <!-- Start : Inner Page Content -->
        <div class="container">
          <!-- Start : Inner Page container -->
          <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
              <li class="current">
                <i class="fa fa-home"></i>Create New Order
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Create New Order</h3>
            </div>
          </div>
          <div class="row">
            <div class="alert alert-success " style="display: none; text-align: center;" id="msg">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>No Data Found!!</strong>.
            </div>
            
          </div>
            <div class="row">
              <div class="col-md-12">

                <form  method="POST" action="">
                  
                  <!-- <input type="hidden" name="id" value="<?php echo $id;?>"> -->
                  <div class="form-group has-success col-md-3">
                    <label class="control-label" for="inputSuccess1">Mobile<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="mobile" name="mobile" onkeypress="javascript:return isNumber(event)" required>
                  </div>
                  <div class="form-group has-success col-md-1" style="margin-top: 18px;padding: 0px;">
                    <input type="button" value="Search" class="btn btn-primary" id="inputSuccess1" onclick="getInfo();" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Name<span style="color:red;">*</span></label>
                    <input type="text"  class="form-control" id="name" name="name" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Email<span style="color:red;">*</span></label>
                    <input type="email"  class="form-control" id="email" name="email" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Address<span style="color:red;">*</span></label><br>
                    <textarea class="form-control" id="address" name="address"></textarea>
                  </div>
                  
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Pin Code<span style="color:red;">*</span></label>
                    <input type="text"  class="form-control" id="pin" name="pin_code" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">State<span style="color:red;">*</span></label>
                     <select name="state" id="state" required="" class="form-control" onChange="getCity(this.value);">
                      <option>Select State</option>
                      <?php
                        include('db.php');
                        $query = mysqli_query($con,"SELECT * FROM `states` where country_id='101'");
                        if(mysqli_num_rows($query)>0){
                          while($state = mysqli_fetch_array($query)){
                        ?>
                        <option  value="<?php echo $state['state_id']; ?>"><?php echo $state['state_name']; ?></option>
                          <?php }}
                        else{
                          echo '<option value="">State not available</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">City<span style="color:red;">*</span></label>
                    <select name="city" id="city" placeholder="City" required="" class="form-control" required="">
                      
                      <option value="">Select City</option>
                    </select>
                  </div>

                  <div class="page-header">
                    <div class="page-title col-md-6">
                      <h3>Add Product</h3>
                    </div>
                  </div>

                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                     <select name="product_name" required class="form-control" >
                      <option>Select Product</option>
                      <?php
                        $Productquery = mysqli_query($con,"SELECT * FROM `product`");
                          while($resProduct = mysqli_fetch_array($Productquery)){
                            echo '<option value="'.$resProduct['product_id'].'">'.$resProduct['name'].'</option>';
                          }

                        ?>
                       
                    </select>
                  </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">Size<span style="color:red;">*</span></label>
                      <select name="product_size" required class="form-control" >
                        <option>Select Size</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                        <option>XXL</option>
                      </select>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Quantity<span style="color:red;">*</span></label>
                    <input type="number" class="form-control" id="inputSuccess1" name="product_qty" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">Delivery Charge<span style="color:red;">*</span></label>
                      <select name="delivery_charge" required class="form-control" >
                        <option value="0">No</option>
                        <option value="100" >Yes</option>
                        
                      </select>
                  </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">Cod Charge<span style="color:red;">*</span></label>
                      <select name="cod_charge" required class="form-control" >
                        <option value="150">Yes</option>
                        <option value="0">No</option>
                      </select>
                  </div>

                  <div class="form-group has-success col-md-6">
                   <button class="btn btn-danger" name="btn_update" type="submit">Submit</button><br/><br/>
                  </div>
                
                </form>
            
              </div>
            </div>

    <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>

  <?php include('footer.php');?>
</body>
</html>
<script type="text/javascript">
  function isNumber(evt) {
      var iKeyCode = (evt.which) ? evt.which : evt.keyCode
      if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
          return false;
      return true;
  } 
  function getInfo(){
    var mobile = document.getElementById('mobile').value;
    // alert(mobile);
    $.ajax({
      url: "get_ajax_citydata.php",
      type: 'POST',
      data: {
        mobile:mobile
      },
      success: function(data) {
        // console.log(data);
        var obj = JSON.parse(data);
        // console.log(obj['state']);
        if (obj['status']=='true') {
          document.getElementById('name').value=obj['name'];
          document.getElementById('email').value=obj['email'];
          document.getElementById('address').value=obj['address'];
          document.getElementById('pin').value=obj['pincode'];
          document.getElementById('state').value=obj['state'];
          $('#city').html('<option value="'+obj['city']+'">'+obj['city_name']+'</option>');
          $('#msg').css("display","none");
        }else{
          $('#msg').css("display","block");
          // location.reload(true);
        }
      }
    });
  }
</script>
