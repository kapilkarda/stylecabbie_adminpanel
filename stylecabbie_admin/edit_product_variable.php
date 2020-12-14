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
    //$product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $s_price = $_POST['s_price'];
    //$des = $_POST['des'];
    //$cat = $_POST['category'];
    //$subcategory = $_POST['subcategory'];
    //$topProduct = $_POST['topProduct'];
    
     if(isset($_POST['size'])){
    $s = $_POST['size'];
    $size=implode(',', $s); 
    }else{
    $size="";
    }

    if(isset($_POST['colour'])){
    $c = $_POST['colour'];
    $colour=implode(',', $c);
    }else{
    $colour="";
    }

    if(isset($_POST['sleeve'])){
    $c = $_POST['sleeve'];
    $colour=implode(',', $c);
    }else{
    $colour="";
    }
 
  
  $size_status = $_POST['size_status'];
  $colour_status = $_POST['colour_status'];
  $model_status = $_POST['model_status'];
    $myimg = $_FILES["file"]["name"];
    $path1 = "img/".time().rand(10000,99999).".jpg";

    

    if(!empty($_FILES["facebook_pic"]["name"])){
      $facebook_path1 = "img/facebook".time().rand(10000,99999).".jpg";
      move_uploaded_file($_FILES["facebook_pic"]["tmp_name"], $facebook_path1);

    }else{
        $facebook_path1 =$_POST['facebook_url'];
    }

    if(!empty($_FILES["printimagepdf"]["name"])){
      $print_pic_pdf = "img/print".time().rand(10000,99999).$_FILES["printimagepdf"]["name"];
      move_uploaded_file($_FILES["printimagepdf"]["tmp_name"], $print_pic_pdf);

    }else{
        $print_pic_pdf =$_POST['printimagepdf'];
    }
  
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) {

        echo $sql ="UPDATE `product` SET  name='$name',photo='$path1',product_size='$size',price='$price',sale_price='$s_price',description='$des' ,cat_id='$cat',sub_cat_id='$subcategory',facebook_pic='$facebook_path1',colour='$colour',size_status='$size_status',colour_status='$colour_status',model_status='$model_status',printimagepdf='$print_pic_pdf',topProduct='$topProduct' where product_id='$product_id'";
     }else{
        echo $sql ="UPDATE `product` SET   name='$name',product_size='$size',price='$price',sale_price='$s_price',description='$des',cat_id='$cat',sub_cat_id='$subcategory',facebook_pic='$facebook_path1',colour='$colour',size_status='$size_status',colour_status='$colour_status',model_status='$model_status',printimagepdf='$print_pic_pdf',topProduct='$topProduct' where product_id='$product_id'";
      }

      /*if (count($_FILES['extra_file']['name']!=0)) {


          $delete =mysqli_query($con,"DELETE FROM `product_image` WHERE `product_id`='$product_id'");
          for ($i=0; $i <count($_FILES['extra_file']['name']); $i++) { 

                $path1 = "img/".time().rand(10000,99999).".jpg";
                move_uploaded_file($_FILES["extra_file"]["tmp_name"][$i], $path1);
                $query_image =mysqli_query($con,"insert into product_image(product_id,image)values('$product_id','$path1')");
          }
          
         }*/

    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
    header("location:product.php");
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
 <style type="text/css">@media only screen and (max-width: 800px) {
  #unseen table td:nth-child(2), 
  #unseen table th:nth-child(2) {display: none;}
}
@media only screen and (max-width: 640px) {
  #unseen table td:nth-child(4),
  #unseen table th:nth-child(4),
  #unseen table td:nth-child(7),
  #unseen table th:nth-child(7),
  #unseen table td:nth-child(8),
  #unseen table th:nth-child(8){display: none;}
}
td {
    word-wrap:break-word!important;
}
.dataTables_filter{
  text-align: right;
}
    </style>
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
                      <i class="fa fa-home"></i>Edit Product 
                    </li>
                  </ul>
                </div>
                <div class="page-header">
                  <div class="page-title">
                    <h3>Edit product</h3>
                  </div>
                </div>
                    <?php
                    if(isset($_GET['id']))
                    {   
                    $id= $_GET['id'];  
                     $sql1="select * from product_variant where id='$id'";
                    if ($result= mysqli_query($con,$sql1)) 
                    {
                      while ($r3 = mysqli_fetch_array($result))
                      {   
                        $size=$r3['size'];
                        $colour=$r3['color'];
                        $sleeve=$r3['sleeve'];

                    //print_r($sleeve);die;
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <form  method="POST" action="" enctype="multipart/form-data">
                          <span id="msg" style="color: red;"></span>
                             <input type="hidden" name="product_id" value="<?php echo $_GET['id'];?>">
                           <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                              </div>
                              <div class="form-group has-success col-md-8">
                                <label class="control-label" for="inputSuccess1">Size Status<span style="color:red;">*</span></label><br>
                                <select class="form-control" name="size_status" required="">
                               
                               <?php if (!empty($r3['size_status'])) { ?>
                                 <option value="True" <?php if ($r3['size_status']=='True') { echo 'selected';}?>>True</option>
                                <option value="False" <?php if ($r3['size_status']=='False') { echo 'selected';}?>>False</option>
                                <?php  }else{ ?>
                                  <option value="">Select Status</option>
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                <?php }?>
                                </select>
                              </div>

                               <div class="form-group has-success col-md-8" >
                                  <label class="control-label" for="inputSuccess1">Select Size<span style="color:red;">*</span></label>
                                  <select class="form-control" id="type123" name="category" required>
                                      <option value="">Select category</option>
                                      <?php $sql = "SELECT * FROM size";
                                      $result = mysqli_query($con,$sql);
                                      while($row = mysqli_fetch_assoc($result)) {
                                      ?>
                                      <option <?php if ($row['name']==$size) { echo 'selected';}?> value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                                      <?php } ?>
                                  </select>
                                </div>
                            <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Colour Status<span style="color:red;">*</span></label><br>
                              <select class="form-control" name="colour_status" required="">
                           
                               <?php if (!empty($r3['colour_status'])) { ?>
                                 <option value="True" <?php if ($r3['colour_status']=='True') { echo 'selected';}?>>True</option>
                                <option value="False" <?php if ($r3['colour_status']=='False') { echo 'selected';}?>>False</option>
                                <?php  }else{ ?>
                                  <<option value="">Select Status</option>
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                <?php }?>
                              </select>
                            </div>

                            <div class="form-group has-success col-md-8" >
                                  <label class="control-label" for="inputSuccess1">Select Colour<span style="color:red;">*</span></label>
                                  <select class="form-control" id="type123" name="category" required>
                                      <option value="">Select category</option>
                                      <?php $sql_colour = "SELECT * FROM colour";
                                      $result_colour = mysqli_query($con,$sql_colour);
                                      while($row_colour = mysqli_fetch_assoc($result_colour)) {
                                      ?>
                                      <option <?php if ($row_colour['name']==$colour) { echo 'selected';}?> value="<?php echo $row_colour['name'];?>"><?php echo $row_colour['name'];?></option>
                                      <?php } ?>
                                  </select>
                            </div>


                          <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Sleeve Status<span style="color:red;">*</span></label><br>
                              <select class="form-control" name="colour_status" required="">
                           
                               <?php if (!empty($r3['sleeve_status'])) { ?>
                                 <option value="True" <?php if ($r3['sleeve_status']=='True') { echo 'selected';}?>>True</option>
                                <option value="False" <?php if ($r3['sleeve_status']=='False') { echo 'selected';}?>>False</option>
                                <?php  }else{ ?>
                                  <<option value="">Select Status</option>
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                <?php }?>
                              </select>
                            </div>

                            <div class="form-group has-success col-md-8" >
                                  <label class="control-label" for="inputSuccess1">Select Sleeve<span style="color:red;">*</span></label>
                                  <select class="form-control" id="type123" name="category" required>
                                      <option value="">Select Sleeve</option>
                                      <?php $sql_sleeves = "SELECT * FROM sleeves";
                                      $result_sleeves = mysqli_query($con,$sql_sleeves);
                                      while($row_sleeves = mysqli_fetch_assoc($result_sleeves)) {
                                      ?>
                                      <option <?php if ($row_sleeves['name']==$sleeve) { echo 'selected';}?> value="<?php echo $row_sleeves['name'];?>"><?php echo $row_sleeves['name'];?></option>
                                      <?php } ?>
                                  </select>
                            </div>

                              <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Price<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['price'];?>" class="form-control" id="inputSuccess1" name="price" required>
                              </div>
                              <div class="form-group has-success col-md-8" id="row_dim">
                              <label class="control-label" for="inputSuccess1">Sales Price<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['sale_price'];?>" class="form-control" id="inputSuccess1" name="s_price" required>
                              </div>
                              <div class="form-group has-success col-md-8" id="row_dim">
                              <label class="control-label" for="inputSuccess1">Quantity<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['product_qty'];?>" class="form-control" id="inputSuccess1" name="product_qty" required>
                              </div>
                              <div class="form-group has-success col-md-6">
                             <button class="btn btn-danger" name="btn_update" type="submit">Update</button><br/><br/>
                           </div>
                          <?php 
                                  } 
                                }
                              }
                          ?>
                        </form>
                      </div>
                    </div>
        </div>
      </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.event.move.js"></script>
    <script type="text/javascript" src="assets/plugins/common/lodash.compat.js"></script>
    <script type="text/javascript" src="assets/plugins/common/respond.min.js"></script>
    <script type="text/javascript" src="assets/plugins/common/excanvas.js"></script>
    <script type="text/javascript" src="assets/plugins/common/breakpoints.js"></script>
    <script type="text/javascript" src="assets/plugins/common/touch-punch.min.js"></script>
    <script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/plugins/DataTables/js/DT_bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/plugins.js"></script>
</body>
</html>
<script>
     function delete_user(id){
            var result= confirm("Are you really want delete this Product?");
            if(result==true){
                $.ajax({
                    type:'POST',
                    url:'query.php',
                    data:'method=9&id='+id,
                    success:function(res){
                     location.reload(); 
                    }
                });
            }
     }
</script>
<script type="text/javascript">

  function subcat_list() {
    var cat_id = $("#cat").val();
      $.ajax({
          url: "fetchsubcategory.php",
          type: 'POST',
          data: {
          
            value:cat_id,
          },
          success: function(data){
            //$("#addto").hide();
            $("#subcat_id").html(data);
             
          }
      });
  }
</script>