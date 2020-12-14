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
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $s_price = mysqli_real_escape_string($con, $_POST['s_price']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
        // $product_type = mysqli_real_escape_string($con, $_POST['product_type']);
        // $des = mysqli_real_escape_string($con, $_POST['des']);
        // $category = mysqli_real_escape_string($con, $_POST['category']);
        // $subcategory = mysqli_real_escape_string($con, $_POST['subcategory']);
        $size_status = mysqli_real_escape_string($con, $_POST['size_status']);
        $colour_status = mysqli_real_escape_string($con, $_POST['colour_status']);
        $sleeve_status = mysqli_real_escape_string($con, $_POST['sleeve_status']);
        $size = mysqli_real_escape_string($con, $_POST['size']);
        $colour = mysqli_real_escape_string($con, $_POST['color']);
        $sleeve = mysqli_real_escape_string($con, $_POST['sleeve']);
        //$model_status = mysqli_real_escape_string($con, $_POST['model_status']);
        //$today = date("Y-m-d"); 

        

        $msg='';

        $query =mysqli_query($con,"insert into inventory_product(colour,sleeve,name,size_status,sleeve_status,price,sale_price,size,product_qty,colour_status)values('$colour','$sleeve','$name','$size_status','$sleeve_status','$price','$s_price','$size',$quantity,'$colour_status')");

          

            
            if ($query) 
            {
                header("location:inventory-product.php");
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
              <div class="form-group has-success col-md-8">
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Product Name<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" id="inputSuccess1" name="name" required>
                </div>
              <div class="" id="variable_product">
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Size Status<span style="color:red;">*</span></label><br>
                  <select class="form-control" name="size_status" >
                    <option value="">Select Status</option>
                    <option value="True">True</option>
                    <option value="False">False</option>
                  </select>
                </div> 
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Size<span style="color:red;">*</span></label><br>
                  <select class="form-control" id="type123" name="size" required>
                    <option value="">Select Size</option>
                  <?php $sql1 = "SELECT * FROM size";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                  <option value="<?php echo $row1['name'];?>"><?php echo $row1['name'];?></option>
                  <?php } ?>
                </select>
                </div>

                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Colour Status<span style="color:red;">*</span></label><br>
                    <select class="form-control" name="colour_status" >
                      <option value="">Select Status</option>
                      <option value="True">True</option>
                      <option value="False">False</option>
                    </select>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Colour<span style="color:red;">*</span></label><br>
                  <select class="form-control" id="type123" name="color" required>
                    <option value="">Select Colour</option>
                  <?php $sql1 = "SELECT * FROM colour";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                 <option value="<?php echo $row1['name'];?>"><?php echo $row1['name'];?></option>
                  <?php } ?>
                </select>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Sleeve Status<span style="color:red;">*</span></label><br>
                    <select class="form-control" name="sleeve_status" >
                      <option value="">Select Status</option>
                      <option value="True">True</option>
                      <option value="False">False</option>
                    </select>
                </div>
                <div class="form-group has-success col-md-8">
                  <label class="control-label" for="inputSuccess1">Sleeve<span style="color:red;">*</span></label><br>
                  <select class="form-control" id="type123" name="sleeve" required>
                    <option value="">Select Sleeve</option>
                  <?php $sql1 = "SELECT * FROM sleeves";
                  $result1 = mysqli_query($con,$sql1);
                  while($row1 = mysqli_fetch_assoc($result1)) {
                  ?>
                  <option value="<?php echo $row1['name'];?>"><?php echo $row1['name'];?></option>
                  <?php } ?>
                </select>
                </div>
              </div>

              <div class="form-group has-success col-md-8">
                <label class="control-label" for="inputSuccess1">Price<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="inputSuccess1" name="price" required>
              </div>
              <div class="form-group has-success col-md-8" id="row_dim" >
                <label class="control-label" for="inputSuccess1">Sales price<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="inputSuccess1" name="s_price" >
              </div>
              <div class="form-group has-success col-md-8"  >
                <label class="control-label" for="inputSuccess1">Product Quantity<span style="color:red;">*</span></label>
                <input type="number" class="form-control" id="inputSuccess1" name="quantity" >
              </div>
              <div class="form-group has-success col-md-6">
                <button class="btn btn-danger" name="btn_add" type="submit">Add Product</button><br/><br/>
              </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <?php //include('footer.php');?>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> 
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
  <!-- <script type="text/javascript">
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
  </script> -->
</body>
</html>

