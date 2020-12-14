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
 if (isset($_POST['btn_add'])) 
{
  //$id = $_POST['id'];
  date_default_timezone_set('Asia/Calcutta');
  $date = date('Y-m-d H:i:s');
  $name = mysqli_real_escape_string($con, $_POST['name']);
  //$name = $_POST['name'];
 /* $url = $_POST['url'];*/
  $type = mysqli_real_escape_string($con, $_POST['type']);
  $type = $_POST['type'];
  $myimg = $_FILES["file"]["name"];
  $path1 = "img/".time().rand(10000,99999).".jpg";
  
  $msg='';
  
   
     if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) {

         $query =mysqli_query($con,"insert into category(cat_name,image,type,datetime)values('$name','$path1','$type','$date')");
     }else{
         $query =mysqli_query($con,"insert into category(cat_name,type,datetime)values('$name','$type','$date')");
      }
   
   if ($query) 
    {
        header("location:category.php");
    } else {
        $msg="Try Again";
    }
 // }
  
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
                <i class="fa fa-home"></i>Add Category
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Add Category</h3>
            </div>
          </div>
                    <div class="row">
          <div class="col-md-12">
                <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?></div><br/>
                <form  method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group has-success col-md-8">
                        <select class="form-control" name="type" required="">
                          <option value="">Select Type</option>
                          <option value="Normal">Normal</option>
                          <option value="Variable">Variable</option>
                          <option value="Custom">Custom</option>
                          <option value="Daily-Dhamaka">Daily Dhamaka</option>
                          <option value="Offer">Offer</option>
                        </select>
                    </div>
            
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Category Name<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="name" required>
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Photo<span style="color:red;">*</span></label>
                        <input type="file" class="form-control" id="inputSuccess1" name="file">
                    </div>
                    <!-- <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Url<span style="color:red;"></span></label>
                        <input type="url" class="form-control" id="inputSuccess1" name="url" >
                    </div> -->
                    <div class="form-group has-success col-md-6">
                        <button class="btn btn-danger" name="btn_add" type="submit">Add Category</button><br/><br/>
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
</body>
</html>

