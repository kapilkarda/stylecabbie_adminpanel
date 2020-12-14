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
    $paytry = $_POST['paytry'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $whatsapp_mobile = $_POST['whatsapp_mobile'];
    $address = $_POST['address'];
    $remark = $_POST['remark'];
    $pin_code = $_POST['pin_code'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $barcode = $_POST['barcode'];
    $order_type = $_POST['order_type'];
    $date=date('YDMHIS');

    if (!empty($_FILES['pic_upload']['name'])) {
        $path1 = "../customeImg/".$date.$_FILES["pic_upload"]["name"];
        move_uploaded_file($_FILES["pic_upload"]["tmp_name"], $path1);
        $path1 = "customeImg/".$date.$_FILES["pic_upload"]["name"];
    }else{
        $path1 = $_POST['old_pic'];
    }

    $brand = $_POST['brand'];
    $model = $_POST['model'];


    
     $sql ="UPDATE `customorder` SET paytry='$paytry',name='$name',address='$address',mobile='$mobile',whatsapp_mobile='$whatsapp_mobile',pincode='$pin_code',state_id='$state',city_id='$city',barcode='$barcode',customPic='$path1',brand='$brand',brand_Model='$model',remark='$remark',order_type='$order_type' where customorder_id='$id'";
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
     header("location:edit_custom_order.php?order_id=".$id);
    } else {
    echo"try latter";
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
                  $sql1="select * from `customorder` where customorder_id='$id'";
                  if ($result= mysqli_query($con,$sql1)) {
                     if ($r3 = mysqli_fetch_array($result)) {   
                  
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
                    <?php if($r3['status']=='8'){ $status="Return"; } ?>
                    <?php if($r3['status']=='6'){ $status="COD Payment"; } ?>
                    <?php if($r3['status']=='7'){ $status="Not connected"; } ?>
                    <?php if($r3['status']=='12'){ $status="DTDC Delivered"; } ?>
                          
                          <div class="well col-md-3">
                              <span style="font-size: 20px;font-weight: 700;">Date:</span>
                               <span><?php echo$r3['order_date']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Status:</span>
                               <span><?php echo$status; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Total Price:</span>
                               <span>₹ <?php echo$r3['price']; ?></span>
                          </div>
                          <div class="well col-md-3">
                              <span style="font-size: 20px;font-weight: 700;">Delivry Charge:</span>
                                <span>₹ <?php echo$r3['delivery_charges']; ?></span>
                          </div>
                          <div class="well col-md-2">
                              <span style="font-size: 20px;font-weight: 700;">Grand Total:</span>
                              <span>₹ <?php echo$r3['total_price']; ?></span>
                          </div>
                </div>
                <div class="col-md-12">
                              <span style="font-size: 20px;font-weight: 700;">Payment Url:</span>
                              <?php  $cus_id=base64_encode($id);
                                     $f_customer_id=base64_encode($customer_id);  ?>
                              <span>https://www.mahakaalstore.com/payment_by_whatsapp.php?string=<?php echo$cus_id; ?>&string1=<?php echo$f_customer_id; ?></span>
                  </div></br>

                <form  method="POST" action="" enctype="multipart/form-data">
                  <span id="msg" style="color: red;"></span>
                  <input type="hidden" name="id" value="<?php echo $id;?>">
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">paytry<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['paytry'];?>" class="form-control" id="inputSuccess1" name="paytry" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Name<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Mobile<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['mobile'];?>" class="form-control" id="inputSuccess1" name="mobile" required>
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Whatsapp Mobile<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['whatsapp_mobile'];?>" class="form-control" id="inputSuccess1" name="whatsapp_mobile" >
                  </div>
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Address<span style="color:red;">*</span></label><br>
                    <textarea class="form-control" id="inputSuccess1" name="address"><?php echo $r3['address'];?></textarea>
                  </div>
                  
                  <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Pin Code<span style="color:red;">*</span></label>
                    <input type="text" value="<?php echo $r3['pincode'];?>" class="form-control" id="inputSuccess1" name="pin_code" required>
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

                  <!-- <div class="form-group col-sm-4">
                       <div class="select">
                          <span class="option-label">Custom Image</span> 
                          <?php if (!empty($r3['customPic'])) { ?>
                           
                          <img width="100px" src="../<?php echo $r3['customPic'];?>">
                          <input type="hidden" name="old_pic" value="<?php echo $r3['customPic'];?>" />
                        <?php } else {echo '';}?>
                       </div>
                    </div> -->

                    <div class="form-group col-sm-4">
                       <div class="select">
                          <span class="option-label">Custom Image</span> 
                          <?php  if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$r3['customPic'])) {
                            if (!empty($r3['customPic'])) { ?>
                           
                          <img width="100px" src="../<?php echo $r3['customPic'];?>">
                          <input type="hidden" name="old_pic" value="<?php echo $r3['customPic'];?>" />
                        <?php }else{ echo '';} }else{  if (!empty($r3['customPic'])) { ?>
                          <img width="100px" src="<?php echo $r3['customPic'];?>">
                          <input type="hidden" name="old_pic" value="<?php echo $r3['customPic'];?>" />
                        <?php }else{ echo '';} }?>
                       </div>
                    </div>

                  <div class="form-group col-sm-4">
                       <div class="select">
                          <span class="option-label">Upload Your Picture:</span> 
                          <input type="file" name="pic_upload" />
                       </div>
                    </div>
                  <div class="form-group has-success col-md-4">
                     <label class="control-label" for="inputSuccess1">Brand<span style="color:red;">*</span></label>
                      <select class="form-control"  id="brand" name="brand"  onchange="model_list()">
                         <option value="">Select Brand</option>
                         <?php
                            $cover_query = mysqli_query($con, "SELECT * FROM cover_sub_category GROUP BY cat_id ");
                            
                              while($row_cover = mysqli_fetch_array($cover_query)){
                            ?>
                         <option <?php if($r3['brand']==$row_cover['cat_id']){ echo'selected'; }?>  value="<?php echo $row_cover['cat_id'];?>"><?php echo $row_cover['cat_id'];?></option>
                         <?php }?>
                      </select>
                  </div>
                   <div class="form-group col-sm-4">
                    <label class="control-label" for="inputSuccess1">Model<span style="color:red;">*</span></label>
                       <div class="select-wrapper">
                          <select   class="form-control" id="model" name="model" >
                             <option value="<?php echo$r3['brand_Model'];?>"><?php echo$r3['brand_Model'];?></option>
                          
                          </select>
                       </div>
                    </div>
                    <div class="form-group col-sm-4">
                    <label class="control-label" for="inputSuccess1">Order type<span style="color:red;">*</span></label>
                       <div class="select-wrapper">
                          <select   class="form-control" id="order_type" name="order_type" >
                             <option <?php if($r3['order_type']=='cod'){ echo'selected'; }?> value="cod">cod</option>
                             <option <?php if($r3['order_type']=='paytm'){ echo'selected'; }?> value="paytm">paytm</option>
                          
                          </select>
                       </div>
                    </div>

                    <div class="form-group has-success col-md-4">
                    <label class="control-label" for="inputSuccess1">Remark<span style="color:red;">*</span></label><br>
                    <textarea class="form-control" id="inputSuccess1" name="remark"><?php echo $r3['remark'];?></textarea>
                  </div>


                  <div class="form-group has-success col-md-6">
                   <button class="btn btn-danger" name="btn_update" type="submit" style="margin-top: 6%;">Update</button><br/><br/>
                  </div>
                
                </form>
              <?php 
                  } 
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
