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
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $innerwidth = $_POST['innerwidth'];
    $innerheight = $_POST['innerheight'];
    $sensor = $_POST['sensor'];
    
    
     $sql ="UPDATE `cover_sub_category` SET `cat_id`='$brand',`name`='$model',`innerwidth`='$innerwidth',`innerheight`='$innerheight',`sensor`='$sensor' where id='$id'";
      
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
    header("location:mobilecover.php");
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
                <i class="fa fa-home"></i>Edit Size 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Size</h3>
            </div>
          </div>
              <?php
          if(isset($_GET['id']))
      {   
               $id= $_GET['id'];  
              $sql1="select * from cover_sub_category where id='$id'";
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
                       <label class="control-label" for="inputSuccess1">Brand<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="brand" required value="<?php echo $r3['cat_id'];?>">
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Model<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="model" required value="<?php echo $r3['name'];?>">
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Width<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="innerwidth"  value="<?php echo $r3['innerwidth'];?>">
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Height<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="innerheight"  value="<?php echo $r3['innerheight'];?>">
                    </div>
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Sensor<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="sensor"  value="<?php echo $r3['sensor'];?>">
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