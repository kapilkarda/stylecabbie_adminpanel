<?php 
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  include('db.php');
  if(!(isset($_SESSION['id']))){
    header("location:index.php");
  }
  if (isset($_POST['btn_add'])) {
    $topProduct_product_id = $_POST['topProductId'];
    $msg='';
    $sqlProduct ="UPDATE `product` SET topProduct='1' where p_id='$topProduct_product_id'";
    $query = mysqli_query($con, $sqlProduct);
    if ($query) {
    header("location:topProduct.php");
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
                <i class="fa fa-home"></i>Add TOP Product 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Add TOP Product</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div style="margin-left: 4%; color: red;"><?php if (isset($msg)){echo $msg;} ?></div><br/>
              <form  method="POST">
                <div class="form-group has-success col-md-8" >
                  <label class="control-label" for="inputSuccess1">Select Product Id<span style="color:red;">*</span></label>
                  <select class="form-control" id="type123" name="topProductId" required>
                    <?php $sql = "SELECT * FROM product";
                      $result = mysqli_query($con,$sql);
                       while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $row['p_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group has-success col-md-6">
                  <button class="btn btn-danger" name="btn_add" type="submit">Add Top Product</button><br/><br/>
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