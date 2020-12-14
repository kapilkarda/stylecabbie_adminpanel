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
    $quantity = $_POST['quantity'];
    $des = $_POST['des'];
   /* echo$cat = $_POST['category'];exit();*/
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
 
  
  $size_status = $_POST['size_status'];
  $colour_status = $_POST['colour_status'];
  $model_status = $_POST['model_status'];
  $Sdate = $_POST['Sdate'];
  $Edate = $_POST['Edate'];
    $myimg = $_FILES["file"]["name"];
    $path1 = "img/".time().rand(10000,99999).".jpg";

    

    if(!empty($_FILES["facebook_pic"]["name"])){
      $facebook_path1 = "img/facebook".time().rand(10000,99999).".jpg";
      move_uploaded_file($_FILES["facebook_pic"]["tmp_name"], $facebook_path1);

    }else{
        $facebook_path1 =$_POST['facebook_url'];
    }
  
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) {

         $sql ="UPDATE `daily_dhamaka` SET  name='$name',photo='$path1',product_size='$size',price='$price',sale_price='$s_price',description='$des' ,facebook_pic='$facebook_path1',colour='$colour',size_status='$size_status',colour_status='$colour_status',model_status='$model_status',product_qty='$quantity',Startdate='$Sdate',Enddate='$Edate' where id='$product_id'";
     }else{
         $sql ="UPDATE `daily_dhamaka` SET   name='$name',product_size='$size',price='$price',sale_price='$s_price',description='$des',facebook_pic='$facebook_path1',colour='$colour',size_status='$size_status',colour_status='$colour_status',model_status='$model_status',product_qty='$quantity',Startdate='$Sdate',Enddate='$Edate' where id='$product_id'";
      }

      if (count($_FILES['extra_file']['name']!=0)) {


          $delete =mysqli_query($con,"DELETE FROM `daily_dhamaka_image` WHERE `product_id`='$product_id'");

          for ($i=0; $i <count($_FILES['extra_file']['name']); $i++) { 
                
                $path1 = "img/".time().rand(10000,99999).".jpg";
                move_uploaded_file($_FILES["extra_file"]["tmp_name"][$i], $path1);
                $query_image =mysqli_query($con,"insert into daily_dhamaka_image(product_id,image)values('$product_id','$path1')");
          }
          
         }

    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
    header("location:daily_dhamaka.php");
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
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  
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
                <i class="fa fa-home"></i>Edit Dhamaka Product 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Dhamaka Product</h3>
            </div>
          </div>
              <?php
          if(isset($_GET['id']))
      {   
               $id= $_GET['id'];  
              $sql1="select * from daily_dhamaka where id='$id'";
              if ($result= mysqli_query($con,$sql1)) 
             {
                while ($r3 = mysqli_fetch_array($result))
                {   
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
                                <select class="form-control" id="type123" name="category" required disabled="">
                                 
                                <?php $sql = "SELECT * FROM category";
                                $result = mysqli_query($con,$sql);
                                 while($row = mysqli_fetch_assoc($result)) {
                                ?>
                               

                                  <option <?php if($row['cat_id']==$r3['cat_id']){ echo'selected'; } ?> value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
                                  

                                  <?php } ?>
                                </select>
                            </div>
                         <div class="form-group has-success col-md-8">
                            <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                            <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                            </div>
                            <div class="form-group has-success col-md-8">
                            <label class="control-label" for="inputSuccess1">Photo<span style="color:red;">*</span></label>
                            <input type="file" value="<?php echo $r3['photo'];?>" class="form-control" id="inputSuccess1" name="file">
                            <?php if (!empty($r3['photo'])) { ?>
                              <img src="<?php echo $r3['photo'];?>" style="height: 25%;width: 25%;">
                             <?php }else{ echo "";} ?>
                            
                            </div>
                             <!-- <div class="form-group has-success col-md-8">
                               <label class="control-label" for="inputSuccess1">Product Extra Photo<span style="color:red;">*</span></label>
                                <input type="file" class="form-control" id="inputSuccess1" name="extra_file[]" multiple>
                                <?php $sql = "SELECT * FROM daily_dhamaka_image WHERE `product_id`='$id'";
                                $result1 = mysqli_query($con,$sql);
                                 while($row1 = mysqli_fetch_assoc($result1)) {
                                ?>

                                <img src="<?php echo $row1['image'];?>" style="height: 25%;width: 25%;">
                                <a href="#" onclick="delete_user('<?php echo $row1['id']; ?>')" title='Delete'><i >Delete</i></a>
                                <?php } ?>
                            </div> -->
                            <div class="form-group has-success col-md-8">
                            <label class="control-label" for="inputSuccess1">Facebook Photo<span style="color:red;">*</span></label>
                            <input type="hidden" value="<?php echo $r3['facebook_pic'];?>" class="form-control" id="inputSuccess1" name="facebook_url">
                            <input type="file" class="form-control" id="inputSuccess1" name="facebook_pic">
                            <?php if(!empty($r3['facebook_pic'])){ ?> 
                            <img src="<?php echo $r3['facebook_pic'];?>" style="height: 25%;width: 25%;">
                            <?php }else{ echo '';} ?>
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
                            
                            <div class="form-group has-success col-md-8">
                             <label class="control-label" for="inputSuccess1">Size<span style="color:red;">*</span></label><br>
                         
                              <?php $sql1 = "SELECT * FROM size";
                              $result1 = mysqli_query($con,$sql1);
                              while($row1 = mysqli_fetch_assoc($result1)) {
                              ?>
                              <input type="checkbox" class="form-control" id="inputSuccess1" name="size[]" <?php if(in_array($row1['name'],$size)){ echo'checked'; } ?> value="<?php echo $row1['name']; ?>" style="display: inline-block;width: 3% !important;top: 2px !important;"> <?php echo $row1['name']; ?>
                              <?php } ?>
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
                          <div class="form-group has-success col-md-8">
                          <label class="control-label" for="inputSuccess1">Colour<span style="color:red;">*</span></label><br>
                          <?php $sql1 = "SELECT * FROM colour";
                          $result1 = mysqli_query($con,$sql1);
                          while($row1 = mysqli_fetch_assoc($result1)) {
                          ?>
                          <input type="checkbox" class="form-control" id="inputSuccess1" name="colour[]" value="<?php echo $row1['name']; ?>" <?php if(in_array($row1['name'],$colour)){ echo'checked'; } ?> style="display: inline-block;width: 3% !important;top: 2px !important;"> <?php echo $row1['name']; ?>
                        
                          <?php } ?>
                          </div>

                            <div class="form-group has-success col-md-8">
                              <label class="control-label" for="inputSuccess1">Model Status<span style="color:red;">*</span></label><br>
                              <select class="form-control" name="model_status" required="">
                              
                             <?php if (!empty($r3['model_status'])) { ?>
                                 <option value="True" <?php if ($r3['model_status']=='True') { echo 'selected';}?>>True</option>
                                <option value="False" <?php if ($r3['model_status']=='False') { echo 'selected';}?>>False</option>
                                <?php  }else{ ?>
                                  <<option value="">Select Status</option>
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                <?php }?>
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
                              <div class="form-group has-success col-md-8"  >
                              <label class="control-label" for="inputSuccess1">Product Quantity<span style="color:red;">*</span></label>
                              <input type="number" class="form-control" id="inputSuccess1" name="quantity"  value="<?php echo $r3['product_qty'];?>">
                              </div>
                            <div class="form-group has-success col-md-8">
                            <label class="control-label" for="inputSuccess1">Description<span style="color:red;">*</span></label>
                            <input type="text" value="<?php echo $r3['description'];?>" class="form-control" id="inputSuccess1" name="des" required>
                            </div>
                           <div class="form-group has-success col-md-8">
                             <label class="control-label" for="inputSuccess1">Start date time<span style="color:red;">*</span></label>
                           </div>
                            <div class="form-group input-group date form_datetime col-md-8"  data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                
                                <input class="form-control" size="16" type="text" value="<?php echo $r3['Startdate'];?>" name="Sdate">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                  <input type="hidden" id="dtp_input1" value="" /><br/>
                            </div>
                             <div class="form-group has-success col-md-8">
                             <label class="control-label" for="inputSuccess1">End date time<span style="color:red;">*</span></label>
                           </div>

                             <div class="form-group input-group date form_datetime col-md-8"  data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                
                                <input class="form-control" size="16" type="text" value="<?php echo $r3['Enddate'];?>" name="Edate" >
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                  <input type="hidden" id="dtp_input1" value="" /><br/>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption"><i class="fa fa-table"></i>Extra product image</div>                               
                                    <div class="actions">
                                        <div class="btn-group">
                                          <a class="btn mini green" href="adddhamaka_image.php?id=<?php echo $_GET['id'];?>" >
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
                                            <?php $sql = "SELECT * FROM daily_dhamaka_image WHERE `product_id`='$id'";
                                            $i=0;
                                            $result1 = mysqli_query($con,$sql);
                                            while($row1 = mysqli_fetch_assoc($result1)) {
                                            $i++;
                                            ?>
                                          <tr>
                                            <td class="center" class="numeric"><?php echo $i;?></td>
                                          
                                            <td class="center" class="numeric"><img src="<?php echo $row1['image'];?>" style="height: 100px;width: 100px;"></td>
                                         
                                            <td class="center" class="numeric">
                                              <a class='btn btn-danger'   onclick="delete_user('<?php echo $row1['id']; ?>')" title='Delete'><i class='mdi-content-create'>Delete</i></a>
                                            </td>   
                                          </tr>
                                          <?php }?>
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
  <?php include('footer.php');?>
  <script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
 
</script>
</body>
</html>
<script type="text/javascript">

    document.getElementById('type').addEventListener('change', function () {
      // alert('hi');
        var style = this.value == 2 ? 'block' : 'none';
        console.log(this.value);
        document.getElementById('row_dim').style.display = style;
    });

</script>
<script>
     function delete_user(id){
            var result= confirm("Are you really want delete this Product?");
            if(result==true){
                $.ajax({
                    type:'POST',
                    url:'query.php',
                    data:'method=10&id='+id,
                    success:function(res){
                     location.reload(); 
                    }
                });
            }
     }
</script>

 