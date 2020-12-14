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
        $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
        $image = mysqli_real_escape_string($con, $_POST['image']);
        $varient_product_id = mysqli_real_escape_string($con, $_POST['varient_product_id']);
        $today = date("Y-m-d"); 

        $query_image =mysqli_query($con,"UPDATE `product_variant` SET `thumbnail`='$image' WHERE id='$varient_product_id'");

        if ($query_image) 
            {
                header("location:product_variable.php?id=".$product_id."");
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
                <input type="hidden" class="form-control" id="inputSuccess1" name="product_id" value="<?PHP echo $_GET['product_id'];?>" required>
                <input type="hidden" class="form-control" id="inputSuccess1" name="varient_product_id" value="<?PHP echo $_GET['id'];?>" required>
                <div class="form-group has-success col-md-12">
                  <label class="control-label" for="inputSuccess1">Images<span style="color:red;">*</span></label><br>
                  <?php $sql1 = "SELECT * FROM product_image WHERE product_id='".$_GET['product_id']."'";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>

                  <div class="form-group has-success col-md-3">

                    <img src="<?php echo "".$row1['image'];?>" style="height: 100px;width: 100px;">
                    <label class="control-label" for="inputSuccess1"><?php echo $row1['name']; ?></label>
                    <input type="checkbox" class="form-control" id="inputSuccess1" name="image" value="<?php echo $row1['id']; ?>" style="display: inline-block;width: 46% !important;">
                  </div>
                  <?php } ?>
                </div>
                
              <div class="form-group has-success col-md-6">
                <button class="btn btn-danger" name="btn_add" type="submit">Add Images</button><br/><br/>
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

