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
  
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $s_price = $_POST['s_price'];
    $des = $_POST['des'];
    $cat = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $old_image = $_POST['old_image'];
    

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

    $myimg = $_FILES["file"]["name"];
      if($myimg!=''){

        
        $path1 = "img/".time().rand(10000,99999).".jpg";
         if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) 
         { 
           $path1;
            $query_image =mysqli_query($con,"insert into product_image(product_id,image)values('$product_id','$path1')");
            $thumb_img_id = mysqli_insert_id($con);
         }
      }else{
        $thumb_img_id =$old_image;
      }
        

         $sql ="UPDATE `product` SET  name='$name',photo='$thumb_img_id',price='$price',sale_price='$s_price',description='$des' ,cat_id='$cat',sub_cat_id='$subcategory',facebook_pic='$facebook_path1',printimagepdf='$print_pic_pdf'where product_id='$product_id'"; 
     
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
                    $sql1="select * from product where product_id='$id'";
                    if ($result= mysqli_query($con,$sql1)) 
                    {
                    $r3 = mysqli_fetch_array($result);   
                    $size1=$r3['product_size'];
                    $size=explode(',', $size1);
                    $colour1=$r3['colour'];
                    $colour=explode(',', $colour1);
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <form  method="POST" action="" enctype="multipart/form-data">
                          <span id="msg" style="color: red;"></span>
                             <input type="hidden" name="product_id" value="<?php echo $_GET['id'];?>">
                            
                           <div class="form-group has-success col-md-8" >
                                 <label class="control-label" for="inputSuccess1">Select category<span style="color:red;">*</span></label>
                                  <select class="form-control"  id="cat" name="category" required onchange="subcat_list()">
                                   <option value="">Select category</option>
                                  <?php $sql = "SELECT * FROM category";
                                  $result = mysqli_query($con,$sql);
                                   while($row = mysqli_fetch_assoc($result)) {
                                  ?>

                                    <option <?php if($row['cat_id']==$r3['cat_id']){ echo'selected'; } ?> value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
                                    

                                    <?php } ?>
                                  </select>
                              </div>

                              <div  id="subcat_id">
                                <?php 
                                  $sql = "SELECT * FROM subcategory WHERE `cat_id`='".$r3['cat_id']."'";
                                  $query1=mysqli_query($con, $sql);
                                  $row1=mysqli_num_rows($query1);
                                  if ($row1) {?>
                                <div class="form-group has-success col-md-8" >
                                    <label class="control-label" for="inputSuccess1">Select Sub category<span style="color:red;">*</span></label>
                                      <select class="form-control"  name="subcategory" required >
                                  
                                        <?php

                                         $sql = "SELECT * FROM subcategory WHERE `cat_id`='".$r3['cat_id']."'";
                                          $result = mysqli_query($con,"SELECT * FROM subcategory WHERE `cat_id`='".$r3['cat_id']."'");
                                          while($row = mysqli_fetch_array($result)) {?>
                                             <option <?php if($row['sub_id']==$r3['sub_cat_id']){ echo'selected'; } ?> value="<?php echo $row['sub_id'];?>"><?php echo $row['name'];?></option>
                                           <?php } ?>
                                             </select>
                                </div>
                                <?php }else{ echo'';}?>
                              </div>
                             <!--  <div  id="subcat_id_fetch">
                              </div> -->
                           <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                              </div>
                              <div class="form-group has-success col-md-8">
                                  <label class="control-label" for="inputSuccess1">Photo<span style="color:red;">*</span></label>
                                  <input type="file" value="<?php echo $r3['photo'];?>" class="form-control" id="inputSuccess1" name="file">
                                   <input type="hidden" value="<?php echo $r3['photo'];?>" class="form-control" id="inputSuccess1" name="old_image">
                                  
                                  <?php 
                                        $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$r3['photo']."'");
                                        $fetch_record_img = mysqli_fetch_array($get_record_img);
                                    ?>
                                    <img src="<?php echo "".$fetch_record_img['image'];?>" style="height: 100px;width: 100px;">
                              </div>
                              <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Facebook Photo<span style="color:red;">*</span></label>
                              <input type="hidden" value="<?php echo $r3['facebook_pic'];?>" class="form-control" id="inputSuccess1" name="facebook_url">
                              <input type="file" class="form-control" id="inputSuccess1" name="facebook_pic">
                              <?php if(!empty($r3['facebook_pic'])){?>
                              <img src="<?php echo $r3['facebook_pic'];?>" style="height: 25%;width: 25%;">
                            <?php }else{ echo'';}?>
                              </div>

                               <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Print Photo/Pdf<span style="color:red;">*</span></label>
                              <input type="hidden" value="<?php echo $r3['printimagepdf'];?>" class="form-control" id="inputSuccess1" name="printimagepdf">
                              <input type="file" class="form-control" id="inputSuccess1" name="printimagepdf">
                              <?php if(!empty($r3['printimagepdf'])){?>
                              <img src="<?php echo $r3['printimagepdf'];?>" style="height: 25%;width: 25%;">
                            <?php }else{ echo'';}?>
                              </div>

                              

                              <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Price<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['price'];?>" class="form-control" id="inputSuccess1" name="price" required>
                              </div>
                              <div class="form-group has-success col-md-8" id="row_dim">
                              <label class="control-label" for="inputSuccess1">Sales Price<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['sale_price'];?>" class="form-control" id="inputSuccess1" name="s_price" required>
                              </div>
                              <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Description<span style="color:red;">*</span></label>
                              <input type="text" value="<?php echo $r3['description'];?>" class="form-control" id="inputSuccess1" name="des" required>
                              </div>
                              <div class="form-group has-success col-md-6">
                             <button class="btn btn-danger" name="btn_update" type="submit">Update</button><br/><br/>
                           </div>
                          <?php 
                                  } 
                                }
                          ?>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption"><i class="fa fa-table"></i>Extra product image</div>                               
                                    <div class="actions">
                                        <div class="btn-group">
                                          <a class="btn mini green" href="add_productimage.php?id=<?php echo $_GET['id'];?>" >
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Add image
                                            </a>    
                                           </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                  <table class="table table-bordered table-hover DynamicTable">
                                        <thead>
                                              <tr>
                                                  <th class="numeric">Id</th>
                                                  <th class="numeric">Photo</th>
                                                  <th class="numeric">Action</th>
                                                  
                                              </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if( strpos($r3['images'], ',') !== false ) {
                                                $img_arr=explode(',', $r3['images']);

                                                 for ($i=0; $i <count($img_arr); $i++) { 

                                                    $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$img_arr[$i]."'");
                                                    $fetch_record_img = mysqli_fetch_array($get_record_img);

                                                            
                                                  ?>

                                              <tr>
                                                <td class="center" class="numeric"><?php echo $i;?></td>
                                              
                                                <td class="center" class="numeric"><img src="<?php echo $fetch_record_img['image'];?>" style="height: 100px;width: 100px;"></td>
                                             
                                                <td class="center" class="numeric">
                                                  <a class='btn btn-danger'   onclick="delete_user('<?php echo $img_arr[$i]; ?>','<?php echo $r3['product_id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                                </td>   
                                              </tr>

                                             <?php    }
                                            }else{
                                                $get_record_img         = mysqli_query($con, "SELECT * FROM `product_image` WHERE id = '".$r3['images']."'");
                                                    $fetch_record_img = mysqli_fetch_array($get_record_img);
                                              ?>

                                              <tr>
                                                <td class="center" class="numeric">1</td>
                                              
                                                <td class="center" class="numeric"><img src="<?php echo $fetch_record_img['image'];?>" style="height: 100px;width: 100px;"></td>
                                             
                                                <td class="center" class="numeric">
                                                  <a class='btn btn-danger'   onclick="delete_user('<?php echo $fetch_record_img['id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                                </td>   
                                              </tr>

                                          <?php  } ?>
                                          
                                        </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
      </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
</body>
</html>
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
    <script>
        $(document).ready(function(){
            App.init();
            DataTabels.init();
        });        
    </script>
<script type="text/javascript">

document.getElementById('type').addEventListener('change', function () {
  // alert('hi');
    var style = this.value == 2 ? 'block' : 'none';
    console.log(this.value);
    document.getElementById('row_dim').style.display = style;
});

</script>
<script>
     function delete_user(id,product_id){
            var result= confirm("Are you really want delete this Product?");
            if(result==true){
                $.ajax({
                    type:'POST',
                    url:'query.php',
                    data:'method=9&id='+id+'&product_id='+product_id,
                    success:function(res){
                      //console.log(res);
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
 <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=AIzaSyCA6lklAzTIeJvbpnGVuLwztXCXgZTq5W0" async defer></script>