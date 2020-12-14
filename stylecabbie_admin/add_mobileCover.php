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

  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $status = '0';
  
  $msg='';
  
    $query =mysqli_query($con,"insert into cover_sub_category(cat_id,name,status)values('$brand','$model','$status')");
   
   if ($query) 
    {
        header("location:mobilecover.php");
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
                <i class="fa fa-home"></i>Add Mobile Cover 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Add Mobile Cover</h3>
            </div>
          </div>
                    <div class="row">
          <div class="col-md-12">
                <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?></div><br/>
                <form  method="POST" action="" enctype="multipart/form-data">
                   
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Brand<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="brand" required>
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Model<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="inputSuccess1" name="model" required>
                    </div>
                    
                    <div class="form-group has-success col-md-6">
                        <button class="btn btn-danger" name="btn_add" type="submit">Add Mobile cover</button><br/><br/>
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

`