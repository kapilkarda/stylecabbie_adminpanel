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
    $date=date('Y-m-d');
     $path1 = "img/".time().rand(10000,99999).".jpg";
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $path1)) {

         $sql ="UPDATE `slider` SET  slider='$path1',`date`='$date' where id='$id'";
     }else{
        $sql ="UPDATE `slider` SET  `date`='$date' where id='$id'";
      }
      
    $msg='';
    $query = mysqli_query($con, $sql);
    if ($query) {
    header("location:slider.php");
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
                <i class="fa fa-home"></i>Edit Slider 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Slider</h3>
            </div>
          </div>
              <?php
          if(isset($_GET['id']))
      {   
               $id= $_GET['id'];  
              $sql1="select * from slider where id='$id'";
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
                          <label class="control-label" for="inputSuccess1">Slider Image<span style="color:red;">*</span></label>
                          <input type="file" value="<?php echo $r3['slider'];?>" class="form-control" id="inputSuccess1" name="file" required>
                           <?php if (!empty($r3['slider'])) { ?>
                              <img src="<?php echo $r3['slider'];?>" style="height: 25%;width: 25%;">
                             <?php }else{ echo "";} ?>
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
