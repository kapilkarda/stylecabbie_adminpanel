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
    $id = $_POST['id'];
    $p_id = $_POST['p_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $remark = $_POST['remark'];
    $mobile = $_POST['mobile'];
    $pin_code = $_POST['pin_code'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $barcode = $_POST['barcode'];
    
     $sql ="UPDATE `order` SET name='$name',address='$address',mobile='$mobile',pin_code='$pin_code',state_id='$state',city_id='$city',barcode='$barcode',remark='$remark' where order_id='$id'";
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
     header("location:edit_order.php?order_id=".$id);
    } else {
    echo"try latter";
    }
  } 

  if (isset($_POST['pro_update'])) 
  {
    $cart_id = $_POST['cart_id'];
    $product_name = $_POST['product_name'];
    
    if(isset($_POST['product_size'])){
      $product_size = $_POST['product_size'];
      $brand = '';
      $model = '';
    }

    if(isset($_POST['brand'])){
      
      $brand = $_POST['brand'];
      $model = $_POST['model'];
      $product_size = '';
    }
    
    
    $qty = $_POST['qty'];
    
    $id = $_POST['id'];
    
     $sql ="UPDATE `cart` SET product_id='$product_name',size='$product_size',qty='$qty',brand='$brand',model='$model' where cart_id='$cart_id'";
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
     header("location:edit_order.php?order_id=".$id);
    } else {
    echo"try latter";
    }
  } 






  /*if (isset($_POST['btn_add_product'])) 
  {
      $id = $_POST['id'];
      $product_name = $_POST['product_name'];
      $product_size = $_POST['product_size'];
      $product_qty = $_POST['product_qty'];
      $customer_id = $_POST['customer_id'];

      $ProductPricequery = mysqli_query($con,"SELECT * FROM `product` WHERE product_id='$product_name'");
      $resPrice = mysqli_fetch_array($ProductPricequery);
      $payment=$resPrice['sale_price'];

      $is_payment=$product_qty*$payment;

      $sql ="INSERT into `cart` (`user_id`,`product_id`,`qty`,`size`,`is_payment`,`status`) VALUES ('$customer_id','$product_name','$product_qty','$product_size','$is_payment','1')";
      $query = mysqli_query($con, $sql);
      $cart_id=mysqli_insert_id($con);

      $orderquery = mysqli_query($con,"SELECT * FROM `order` where order_id='$id'");
      $resorder= mysqli_fetch_array($orderquery);
      $p_id=$resorder['p_id'].','.$cart_id;
      $total_price=$resorder['total_price']+$is_payment;

      $sqlupdate ="UPDATE `order` SET p_id='$p_id',total_price='$total_price' where order_id='$id'";
      $sqlupdatequery = mysqli_query($con, $sqlupdate);


      if ($sqlupdatequery) {
            header("location:edit_order.php?order_id=".$id);
      } else {
      echo"try latter";
      }
  }
  if (isset($_POST['btn_delete_product'])) 
  {
      $order_id = $_POST['order_id'];
      $cart_id = $_POST['cart_id'];
      $is_payment = $_POST['is_payment'];



      
     $Cartquery = mysqli_query($con,"DELETE from `cart` WHERE cart_id='$cart_id'");
      if($Cartquery){

          $Orderquery = mysqli_query($con,"SELECT * FROM `order` WHERE order_id='$order_id'");
          $resOrder = mysqli_fetch_array($Orderquery);
          $p_id=$resOrder['p_id'];
          $total_price=$resOrder['total_price']-$is_payment;

          $cart_idArray=explode(',', $p_id);

          for ($i=0; $i <COUNT($cart_idArray); $i++) {

                if($cart_id==$cart_idArray[$i]){
                   unset($cart_idArray[$i]);
                 }
          }
          $cart_ids=implode(',', $cart_idArray);
          $sqlupdate ="UPDATE `order` SET p_id='$cart_ids',total_price='$total_price' where order_id='$order_id'";
          $sqlupdatequery = mysqli_query($con, $sqlupdate);
          if($sqlupdatequery){
            header("location:edit_order.php?order_id=".$order_id);
          }


      }
  }  */
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
  <?php
      if(isset($_GET['order_id'])) {   
        $id= $_GET['order_id'];  
            
    ?>
      <div id="content">
        <!-- Start : Inner Page Content -->
        <div class="container">
          <!-- Start : Inner Page container -->
          <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
              <li class="current">
                <i class="fa fa-home"></i>Edit Order (Order Id:<?php echo$id; ?>)
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Order Of  <b>(Order Id:<?php echo$id; ?>)</b></h3>
            </div>
          </div>
              
            <div class="row">
              <div class="col-md-12">

              <?php  
                  $sql1="select * from `order` where order_id='$id'";
                  if ($result= mysqli_query($con,$sql1)) {
                     if ($r3 = mysqli_fetch_array($result)) {   
                     $q=$r3['p_id'];
                     $customer_id=$r3['customer_id'];
              ?>

               <div class="col-md-12">
                    <?php if($r3['status']=='0'){ $status="Pending"; } ?>
                    <?php if($r3['status']=='1'){ $status="COD Confirm"; } ?>
                    <?php if($r3['status']=='9'){ $status="SP Confirm"; } ?>
                    <?php if($r3['status']=='10'){ $status="NA Confirm"; } ?>
                    <?php if($r3['status']=='11'){ $status="IND Confirm"; } ?>
                    <?php if($r3['status']=='3'){ $status="SP Delivered"; } ?>
                    <?php if($r3['status']=='2'){ $status="COD Delivered"; } ?>
                    <?php if($r3['status']=='4'){ $status="Cancel"; } ?>
                    <?php if($r3['status']=='5'){ $status="COD Return"; } ?>
                    <?php if($r3['status']=='8'){ $status="SP Return"; } ?>
                    <?php if($r3['status']=='6'){ $status="COD Payment"; } ?>
                    <?php if($r3['status']=='7'){ $status="Not connected"; } ?>
                    <?php if($r3['status']=='12'){ $status="DTDC Delivered"; } ?>
                          
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Date:</span>
                               <span><?php echo$r3['order_date']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Status:</span>
                               <span><?php echo$status; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Total Price:</span>
                               <span>₹ <?php echo$r3['total_price']-$r3['delivery_charge']-$r3['cod_charge']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Delivry Charg:</span>
                                <span>₹ <?php echo$r3['delivery_charge']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">COD Charges:</span>
                              <span>₹ <?php echo$r3['cod_charge']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Grand Total:</span>
                              <span>₹ <?php echo$r3['total_price']; ?></span>
                          </div>
                </div>

                <form  method="POST" action="">
                  <span id="msg" style="color: red;"></span>
                  <input type="hidden" name="id" value="<?php echo $id;?>">
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Name<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Mobile<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['mobile'];?>" class="form-control" id="inputSuccess1" name="mobile" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Address<span style="color:red;">*</span></label><br>
                    <textarea class="form-control" id="inputSuccess1" name="address"><?php echo $r3['address'];?></textarea>
                  </div>
                  
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Pin Code<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['pin_code'];?>" class="form-control" id="inputSuccess1" name="pin_code" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">State<span style="color:red;">*</span></label>
                     <select name="state" id="state" required="" class="form-control" onChange="getCity(this.value,<?php echo $id; ?>);">
                      <option>Select State</option>
                      <?php
                        include('db.php');
                        $query = mysqli_query($con,"SELECT * FROM `states` where country_id='101'");
                        if(mysqli_num_rows($query)>0){
                          while($state = mysqli_fetch_array($query)){
                        ?>
                        <option <?php if($state['state_id']==$r3['state_id']){ echo'selected'; }?> value="<?php echo $state['state_id']; ?>"><?php echo $state['state_name']; ?></option>
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
                      <?php 
                      include('db.php');
                      $city_id=$r3['city_id'];
                      $query = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `cities` where city_id='$city_id'"));
                      ?>
                      <option value="<?php echo$query['city_id'];?>"><?php echo$query['city_name'];?></option>
                    </select>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Barcode<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['barcode'];?>" class="form-control" id="inputSuccess1" name="barcode" >
                  </div>

                   <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Remark<span style="color:red;">*</span></label><br>
                    <textarea class="form-control" id="inputSuccess1" name="remark"><?php echo $r3['remark'];?></textarea>
                  </div>

                   <div class="form-group has-success">
                   <button class="btn btn-danger" name="btn_update" type="submit" style="margin-top: 3%;">Update</button><br/><br/>
                  </div>


                
                </form>
              <?php 
                  } 
                }
              ?>
              </div>

             

              <div class="col-md-12" style="float: left;margin-top: 5%;">

               <?php
                   
                      $cart_ids=explode(',', $q);
                    for ($i=0; $i <count($cart_ids); $i++) { 
                        $cart_id=$cart_ids[$i];
                        $cartsql="select * from `cart` where cart_id='$cart_id'";
                        $resultCart= mysqli_query($con,$cartsql);
                        $cartResId = mysqli_fetch_array($resultCart); 
                        $product_id=$cartResId['product_id'];

                        $productsql="select * from `product` where product_id='$product_id'";
                        $resultproduct= mysqli_query($con,$productsql);
                        $productResId = mysqli_fetch_array($resultproduct); 
                      
                    

                      
                  ?>

              <form method="POST" action="" style="width: 100%;float: left;">
                 <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Product<span style="color:red;">*</span></label>

                     <select name="product_name" required class="form-control" >
                      <option>Select Product</option>
                      <?php
                        $Productquery = mysqli_query($con,"SELECT * FROM `product`");
                          while($resProduct = mysqli_fetch_array($Productquery)){
                            if($resProduct['product_id']==$product_id){

                              echo '<option selected  value="'.$resProduct['product_id'].'">'.$resProduct['name'].'</option>';

                            }else{
                                 echo '<option  value="'.$resProduct['product_id'].'">'.$resProduct['name'].'</option>';
                            }
                           
                          }

                        ?>
                       
                    </select>
                  </div>
                  <?php if($cartResId['size']!='') {   ?>

                    <div class="form-group has-success col-md-2">
                      <label class="control-label" for="inputSuccess1">Size<span style="color:red;">*</span></label>
                      <input type="text" value="<?php echo $cartResId['size'];?>" class="form-control" id="inputSuccess1" name="product_size" required>

                    </div>


                  <?php } ?>

                 <?php if($cartResId['size']=='') {   ?>

                  <div class="form-group has-success col-md-3">
                     <label class="control-label" for="inputSuccess1">Brand<span style="color:red;">*</span></label>
                      <select class="form-control"  id="brand" name="brand"  onchange="model_list()">
                         <option value="">Select Brand</option>
                         <?php
                            $cover_query = mysqli_query($con, "SELECT * FROM cover_sub_category GROUP BY cat_id ");
                            
                              while($row_cover = mysqli_fetch_array($cover_query)){
                            ?>
                         <option <?php if($cartResId['brand']==$row_cover['cat_id']){ echo'selected'; }?>  value="<?php echo $row_cover['cat_id'];?>"><?php echo $row_cover['cat_id'];?></option>
                         <?php }?>
                      </select>
                  </div>
                   <div class="form-group col-sm-3">
                    <label class="control-label" for="inputSuccess1">Model<span style="color:red;">*</span></label>
                       <div class="select-wrapper">
                          <select   class="form-control" id="model" name="model" >
                             <option value="<?php echo$cartResId['model'];?>"><?php echo$cartResId['model'];?></option>
                          
                          </select>
                       </div>
                    </div>

                <?php } ?>

                 <div class="form-group has-success col-md-2">
                    <label class="control-label" for="inputSuccess1">Qty<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $cartResId['qty'];?>" class="form-control" id="inputSuccess1" name="qty" required>

                  </div>

                  <input type="hidden" value="<?php echo $cartResId['cart_id'];?>" class="form-control" id="inputSuccess1" name="cart_id" >

                  <div class="form-group has-success col-md-6">
                   <button class="btn btn-danger" name="pro_update" type="submit">Update</button><br/><br/>
                  </div>

              </form>

          <?php
              } 
             ?>
            </div>
            </div>

    <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <?php
    } 
   ?>
  <?php include('footer.php');?>
</body>
</html>

<script type="text/javascript">

  function model_list() {
   
           var brand = $("#brand").val();
           $.ajax({
             url: "../logic.php",
             type: 'POST',
             data: {action:'brand',
             brand:brand,
         
             },
             success: function(data) {
             //$("#addto").hide();
             $("#model").html(data);       
         
             }
           });
       }
</script>
