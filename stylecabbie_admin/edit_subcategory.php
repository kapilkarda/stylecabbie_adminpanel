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
    date_default_timezone_set('Asia/Calcutta');
    $date = date('Y-m-d H:i:s');
    $id = $_POST['id'];
    $category = $_POST['category'];
    $subcatname = $_POST['name'];
    $status = $_POST['status'];
    $myimg = $_FILES["file"]["name"];
    $path1 = "img/".time().rand(10000,99999).".jpg";
   
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) {

          $sql ="UPDATE `subcategory` SET  `cat_id`='$category',  `name`='$subcatname',`image`='$path1',`status`='$status',`date`='$date' where sub_id='$id'";
     }else{
          $sql ="UPDATE `subcategory` SET  `cat_id`='$category',  `name`='$subcatname',`status`='$status',`date`='$date' where sub_id='$id'";
      }
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
    header("location:subcategory.php");
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
                <i class="fa fa-home"></i>Edit Category 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Category</h3>
            </div>
          </div>
              <?php
          if(isset($_GET['id']))
      {   
               $id= $_GET['id'];  
              $sql1="select * from subcategory where sub_id='$id'";
              if ($result= mysqli_query($con,$sql1)) 
             {
                while ($r3 = mysqli_fetch_array($result))
                {   
                  
                  ?>
                    <div class="row">
                    <div class="col-md-12">
                      <form  method="POST" action="" enctype="multipart/form-data">
                      <span id="msg" style="color: red;"></span>
                         <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">

                         <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Category<span style="color:red;">*</span></label>
                        <select class="form-control" name="category" required="">
                        
                           <?php
                               $cat_query = mysqli_query($con, "SELECT * FROM category WHERE type='Normal' ");
                               while($row_cat = mysqli_fetch_array($cat_query)){
                               ?>
                          <option <?php if($row_cat['cat_id']==$r3['cat_id']){ echo 'selected';}?> value="<?php echo $row_cat['cat_id'];?>" ><?php echo $row_cat['cat_name'];?></option>
                           <?php }?>
                         
                        </select>
                    </div>

                       
                       <div class="form-group has-success col-md-8">
                          <label class="control-label" for="inputSuccess1">Category Name<span style="color:red;">*</span></label>
                          <input type="text" value="<?php echo $r3['name'];?>" class="form-control" id="inputSuccess1" name="name" required>
                          </div>
                          <div class="form-group has-success col-md-8">
                          <label class="control-label" for="inputSuccess1">Photo<span style="color:red;">*</span></label>
                          <input type="file" value="<?php echo $r3['image'];?>" class="form-control" id="inputSuccess1" name="file">
                          <?php if (!empty($r3['image'])) { ?>
                          <img src="<?php echo $r3['image'];?>" style="height: 25%;width: 25%;">
                          <?php }else{ echo '' ;} ?>
                          </div>
                         
                          <div class="form-group has-success col-md-8">
                          <label class="control-label" for="inputSuccess1">Status<span style="color:red;">*</span></label>
                            <select class="form-control" name="status" required="">
                              <option value="">Select Status</option>
                              <option <?php if($r3['status']=='true'){ echo 'selected';}?> value="true">True</option>
                              <option <?php if($r3['status']=='false'){ echo 'selected';}?> value="false">False</option>
                            </select>
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
  <?php include('footer.php');?>
</body>
</html>
