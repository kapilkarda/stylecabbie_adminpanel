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
  $date      = date('Y-m-d H:i:s');
  $name      = $_POST['name'];
  $firm_name = $_POST['firm_name'];
  $email     = $_POST['email'];
  $mobile    = $_POST['mobile'];
  $password  = $_POST['password'];
  $address   = $_POST['address'];
  $msg='';
  
 // echo"insert into `vendor` (`name`,`firm_name`,`email`,`mobile`,`password`,`address`,`created_at`)values('$name','$firm_name','$email','$mobile','$password','$address','$date')";exit;
  $query =mysqli_query($con,"insert into `vendor` (`name`,`firm_name`,`email`,`mobile`,`password`,`address`,`created_at`)values('$name','$firm_name','$email','$mobile','$password','$address','$date')");
  if ($query){
        header("location:vendorList.php");
      }else{
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
                <i class="fa fa-home"></i>Add Vendor
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Add Vendor</h3>
            </div>
          </div>
                    <div class="row">
          <div class="col-md-12">
                <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?></div><br/>
                <form  method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Name<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter vendor name" id="inputSuccess1" name="name" required>
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Firm name<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" placeholder="Enter firm name" name="firm_name" required>
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Email<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Mobile<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" placeholder="Enter mobile no" name="mobile" required>
                    </div><div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Password<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" placeholder="Enter password" name="password" required>
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Address<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" placeholder="Enter address" name="address" required>
                    </div>
                    <div class="form-group has-success col-md-6">
                        <button class="btn btn-danger" name="btn_add" type="submit">Add Vendor</button><br/><br/>
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

