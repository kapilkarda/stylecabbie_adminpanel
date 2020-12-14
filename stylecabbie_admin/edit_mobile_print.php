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
  $id          = $_POST['id'];
  $brand       = $_POST['brand'];
  $model       = $_POST['model'];
  $innerwidth  = $_POST['innerwidth'];
  $innerheight = $_POST['innerheight'];
  $outerwidth  = $_POST['outerwidth'];
  $outerheight = $_POST['outerheight'];
  $date        =date('Y-m-d');
  
  $msg='';
  // echo "SELECT * FROM `mobileprint` WHERE `model`='$model' AND `status` = '1'";exit;
 
         $sql ="UPDATE `mobileprint` SET `brand`='$brand',`model`='$model',`innerwidth`='$innerwidth',`innerheight`='$innerheight',`outerwidth`='$outerwidth',`outerheight`='$outerheight' where id='$id'";
       $query1 = mysqli_query($con, $sql);
     if ($query1) 
      {
          header("location:mobileprint.php");
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
                <i class="fa fa-home"></i>Edit Mobile print
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Edit Mobile print</h3>
            </div>
          </div>
                    <div class="row">
                <div class="col-md-12">
                <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?></div><br/>
                <?php
                if(isset($_GET['id']))
                {   
                $id= $_GET['id'];  
                $sql1="select * from mobileprint where id='$id'";
                if ($result= mysqli_query($con,$sql1)) 
                {
                while ($row = mysqli_fetch_array($result))
                {   

                ?>
                <form  method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="form-control" required="" value="<?php echo $row['id'];?>">
                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Brand Name<span style="color:red;">*</span></label>
                        <select class="form-control" required id="brand" name="brand"  onchange="model_list()">
                            <option value="">Select Brand</option>
                            <?php
                               $cover_query = mysqli_query($con, "SELECT * FROM cover_sub_category GROUP BY cat_id ");
                               while($row_cover = mysqli_fetch_array($cover_query)){
                               ?>
                               <option <?php if($row_cover['cat_id']==$row['brand']){ echo'selected'; } ?>  value="<?php echo $row_cover['cat_id'];?>"><?php echo $row_cover['cat_id'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Model Name<span style="color:red;">*</span></label>
                        <select  required class="form-control" id="model" name="model" >
                            <?php
                                $model_query = mysqli_query($con, "SELECT * FROM cover_sub_category WHERE `cat_id`='".$row['brand']."' ");
                                echo '<option value="">Select Model</option>';
                                while($row_model = mysqli_fetch_array($model_query)){
                            ?>
                             <option <?php if($row['model']==$row_model['name']){ echo'selected'; } ?> value="<?php echo $row_model['name'];?>"><?php echo $row_model['name'];?></option>
                           <?php } ?>
                           
                        </select>
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Inner width (px)<span style="color:red;">*</span></label>
                        <input type="text" name="innerwidth" class="form-control" required="" value="<?php echo $row['innerwidth'];?>">
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Inner Height (px)<span style="color:red;">*</span></label>
                        <input type="text" name="innerheight" class="form-control" required="" value="<?php echo $row['innerheight'];?>">
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Outer width (px)<span style="color:red;">*</span></label>
                        <input type="text" name="outerwidth" class="form-control" required="" value="<?php echo $row['outerwidth'];?>">
                    </div>

                    <div class="form-group has-success col-md-8">
                       <label class="control-label" for="inputSuccess1">Outer Height (px)<span style="color:red;">*</span></label>
                        <input type="text" name="outerheight" class="form-control" required="" value="<?php echo $row['outerheight'];?>">
                    </div>
                    
                    <div class="form-group has-success col-md-6">
                        <button class="btn btn-danger" name="btn_add" type="submit">Edit</button><br/><br/>
                    </div>
                </form>
              <?php }}}?>
        </div>
      </div>
    </div>
      </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <?php include('footer.php');?>
</body>
<script type="text/javascript">
   function model_list() {
   
           var brand = $("#brand").val();
           $.ajax({
             url: "query.php",
             type: 'POST',
             data: {action:'brand',
             brand:brand,
         
             },
             success: function(data) {
             //$("#addto").hide();
             $("#model").html(data);       
         
             }
           });
       }
</script>
</html>

`