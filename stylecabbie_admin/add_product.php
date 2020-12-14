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
 if (isset($_POST['btn_add'])){
  //$id = $_POST['id'];
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $s_price = mysqli_real_escape_string($con, $_POST['s_price']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
        $product_type = mysqli_real_escape_string($con, $_POST['product_type']);
        $des = mysqli_real_escape_string($con, $_POST['des']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $subcategory = mysqli_real_escape_string($con, $_POST['subcategory']);
        $size_status = mysqli_real_escape_string($con, $_POST['size_status']);
        $colour_status = mysqli_real_escape_string($con, $_POST['colour_status']);
        $sleeve_status = mysqli_real_escape_string($con, $_POST['sleeve_status']);
        $model_status = mysqli_real_escape_string($con, $_POST['model_status']);
        $today = date("Y-m-d"); 

        

        $msg='';
        $myimg = $_FILES["file"]["name"];
        $path1 = "img/".time().rand(10000,99999).".jpg";
         if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) 
         { 
           $path1;
            $query_image =mysqli_query($con,"insert into product_image(product_id,image)values('$product_id','$path1')");
            $thumb_img_id = mysqli_insert_id($con);
         }else{

           $path1='';
         }
         $facebook_pic = "img/facebook".time().rand(10000,99999).".jpg";
         if (move_uploaded_file($_FILES["facebook_pic"]["tmp_name"], $facebook_pic)) 
         {
            $facebook_pic;
         }else{
            $facebook_pic='';
         }
          $print_pic_pdf = "img/print".time().rand(10000,99999).".jpg";
         if (move_uploaded_file($_FILES["printimagepdf"]["tmp_name"], $print_pic_pdf)) 
         {
            $print_pic_pdf;
         }else{
            $print_pic_pdf='';
         }

        if($product_type=='simple'){
          $images='';
          for ($i=0; $i <count($_FILES['extra_file']['name']); $i++) { 

                 $path1 = "img/".time().rand(10000,99999).".jpg";
                 if(move_uploaded_file($_FILES["extra_file"]["tmp_name"][$i], $path1)){
                 $query_image =mysqli_query($con,"insert into product_image(product_id,image)values('$product_id','$path1')");
                 $img_id=mysqli_insert_id($con);
                 if($i==0){
                    $images = $img_id;
                 }else{
                    $images =$images.','.$img_id;
                 }
                 
               }

            }

            $query =mysqli_query($con,"insert into product(name,photo,price,sale_price,description,cat_id,product_qty,facebook_pic,printimagepdf,sub_cat_id,product_type,images)values('$name','$thumb_img_id','$price','$s_price','$des','$category','$quantity','$facebook_pic','$print_pic_pdf','$subcategory','$product_type','$images')");
            $product_id = mysqli_insert_id($con);

            

        }else if($product_type=='variable'){

          

          $query =mysqli_query($con,"insert into product(name,photo,price,sale_price,description,cat_id,product_qty,facebook_pic,printimagepdf,sub_cat_id,product_type,colour_status,size_status,model_status,sleeve_status)values('$name','$path1','$price','$s_price','$des','$category','$quantity','$facebook_pic','$print_pic_pdf','$subcategory','$product_type','$colour_status','$size_status','$model_status','$sleeve_status')");
            $product_id = mysqli_insert_id($con);

            for ($i=0; $i <count($_FILES['extra_file']['name']); $i++) { 

                 $path1 = "img/".time().rand(10000,99999).".jpg";
                 if(move_uploaded_file($_FILES["extra_file"]["tmp_name"][$i], $path1)){
                 $query_image =mysqli_query($con,"insert into product_image(product_id,image)values('$product_id','$path1')");
               }

            }

            if(isset($_POST['size'])){
                $s = $_POST['size'];
                //$size=implode(',', $s); 
              }else{
                $size="";
              } 

            if(isset($_POST['colour'])){
               $c = $_POST['colour'];
                //$colour=implode(',', $c);
            }else{
              $colour="";
            }

            if(isset($_POST['sleeve'])){
                $sl = $_POST['sleeve'];
                //$sleeve = implode(',', $c); 
            }else{
                $sleeve = "";
            }


            for ($j=0; $j <count($sl); $j++) {
              for ($i=0; $i <count($c); $i++) { 
                for ($sizek=0; $sizek <count($s); $sizek++) {   
                      
                      $query_image =mysqli_query($con,"insert into product_variant(product_id,color,sleeve,name,size_status,sleeve_status,price,sale_price,size,product_qty,color_status,model_status,description)values('$product_id','$c[$i]','$sl[$j]','$name','$size_status','$sleeve_status','$price','$s_price','$s[$sizek]',$quantity,'$colour_status','$model_status','$des')");
                    $product_variant_id = mysqli_insert_id($con);
                    $colour_images='colour_images_'.$c[$i];
                    for ($k=0; $k <count($_FILES[$colour_images]['name']); $k++) { 

                         $path1 = "img/".time().rand(10000,99999).".jpg";
                         if(move_uploaded_file($_FILES[$colour_images]["tmp_name"][$k], $path1)){
                         $query_image =mysqli_query($con,"insert into product_image(product_variant_id,image)values('$product_variant_id','$path1')");
                       }

                    }

                }
            }
          }

        }

          

            if ($query) 
            {
                header("location:product.php");
            } else {
                $msg="Try Again";
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
                    <i class="fa fa-home"></i>Add Product 
                </li>
              </ul>
            </div>
            <div class="page-header">
              <div class="page-title">
                <h3>Add Product</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?>
                </div>
              <br/>
              <form  method="POST" action="" enctype="multipart/form-data">
              <div class="form-group has-success col-md-8">
                  <div class="form-group has-success col-md-8">
                <label class="control-label" for="inputSuccess1">Product Type<span style="color:red;">*</span></label>
                <select onchange="myFunction()" class="form-control" id="product_type" name="product_type" >
                      <option value="simple">Simple Product</option>
                      <option value="variable">Variable Product</option>
                      <option value="customize">Customize Product</option>
                </select>
                </div>
                <div class="form-group has-success col-md-8" >
                  <label class="control-label" for="inputSuccess1">Select category<span style="color:red;">*</span></label>
                  <select class="form-control" id="type123" name="category" required>
                      <option value="">Select category</option>
                      <?php $sql = "SELECT * FROM category Order By cat_id ASC";
                      $result = mysqli_query($con,$sql);
                      while($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="form-group has-success col-md-8" >
                    <label class="control-label" for="inputSuccess1">Select Sub category<span style="color:red;">*</span></label>
                      <select class="form-control"  name="subcategory"  >
                        <option value="">Select category</option>
                        <?php

                          $result = mysqli_query($con,"SELECT * FROM subcategory ");
                          while($row = mysqli_fetch_array($result)) {?>
                             <option  value="<?php echo $row['sub_id'];?>"><?php echo $row['name'];?></option>
                           <?php } ?>
                             </select>
                </div>

                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" id="inputSuccess1" name="name" required>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Photo<span style="color:red;">*</span></label>
                  <input type="file" class="form-control" id="inputSuccess1" name="file">
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Product Extra Photo<span style="color:red;">*</span></label>
                  <input type="file" class="form-control" id="inputSuccess1" name="extra_file[]" multiple>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Facebook Photo<span style="color:red;">*</span></label>
                  <input type="file" class="form-control" id="inputSuccess1" name="facebook_pic">
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Print Photo/Pdf<span style="color:red;">*</span></label>
                  <input type="file" class="form-control" id="inputSuccess1" name="printimagepdf">
                </div>
              <div class="" id="variable_product" style="display: none;">
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Size Status<span style="color:red;">*</span></label><br>
                  <select class="form-control" name="size_status" >
                    <option value="">Select Status</option>
                    <option value="True">True</option>
                    <option value="False">False</option>
                  </select>
                </div> 
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Size<span style="color:red;">*</span></label><br>
                  <?php $sql1 = "SELECT * FROM size";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                  <input type="checkbox" class="form-control" id="inputSuccess1" name="size[]" value="<?php echo $row1['name']; ?>" style="display: inline-block;width: 5% !important;top: 2px !important;"> <?php echo $row1['name']; ?>
                  <?php } ?>
                </div>

                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Colour Status<span style="color:red;">*</span></label><br>
                    <select class="form-control" name="colour_status" >
                      <option value="">Select Status</option>
                      <option value="True">True</option>
                      <option value="False">False</option>
                    </select>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Colour<span style="color:red;">*</span></label><br>
                  <?php $sql1 = "SELECT * FROM colour";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                  <input type="checkbox" class="form-control" id="inputSuccess1" name="colour[]" value="<?php echo $row1['name']; ?>" style="display: inline-block;width: 5% !important;top: 2px !important;"> <?php echo $row1['name']; ?><input type="file" name="colour_images_<?php echo $row1['name']; ?>[]" multiple>
                  <?php } ?>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Sleeve Status<span style="color:red;">*</span></label><br>
                    <select class="form-control" name="sleeve_status" >
                      <option value="">Select Status</option>
                      <option value="True">True</option>
                      <option value="False">False</option>
                    </select>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Sleeve<span style="color:red;">*</span></label><br>
                  <?php $sql1 = "SELECT * FROM sleeves";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                  <input type="checkbox" class="form-control" id="inputSuccess1" name="sleeve[]" value="<?php echo $row1['name']; ?>" style="display: inline-block;width: 5% !important;top: 2px !important;"> <?php echo $row1['name']; ?>
                  <?php } ?>
                </div>

                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Model Status<span style="color:red;">*</span></label><br>
                  <select class="form-control" name="model_status" >
                    <option value="">Select Status</option>
                    <option value="True">True</option>
                    <option value="False">False</option>
                  </select>
                </div> 
              </div>

             <!--  <div class="form-group has-success col-md-8">
              <label class="control-label" for="inputSuccess1">Quantity<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="inputSuccess1" name="qty" required>
              </div>
               <div class="form-group has-success col-md-8" >
              <label class="control-label" for="inputSuccess1">Select Amount Type<span style="color:red;">*</span></label>
              <select class="form-control" id="type" name="aType" required>
              <option value="1">Price</option>
              <option value="2">Price at Sale</option>
              </select>
              </div>

              <div class="form-group has-success col-md-8" >
              <label class="control-label" for="inputSuccess1">Status<span style="color:red;">*</span></label>
              <select class="form-control" id="offline_status" name="offline_status" required>
              <option value="0">Online</option>
              <option value="1">Offline</option>
              </select>
              </div> -->

              <div class="form-group has-success col-md-8">
                <label class="control-label" for="inputSuccess1">Price<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="inputSuccess1" name="price" required>
              </div>
              <div class="form-group has-success col-md-8" id="row_dim" >
                <label class="control-label" for="inputSuccess1">Sales price<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="inputSuccess1" name="s_price" >
              </div>
              <div class="form-group has-success col-md-8"  >
                <label class="control-label" for="inputSuccess1">Product Quantity<span style="color:red;">*</span></label>
                <input type="number" class="form-control" id="inputSuccess1" name="quantity" >
              </div>
              <div class="form-group has-success col-md-8">
                <label class="control-label" for="inputSuccess1">Description<span style="color:red;">*</span></label>
                <textarea class="form-control" id="inputSuccess1" name="des" required></textarea>
              </div>
              <div class="form-group has-success col-md-6">
                <button class="btn btn-danger" name="btn_add" type="submit">Add Product</button><br/><br/>
              </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <?php include('footer.php');?>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> 
  <script type="text/javascript">
    function myFunction() {
      var x = document.getElementById("product_type").value;

      if (x == "variable") {

        $('#variable_product').show();

      }else if(x == 'cutomize'){

        $('#variable_product').show();

      }else{
        $('#variable_product').hide();
      }
      
    }
  </script>
</body>
</html>

