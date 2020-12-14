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
                <i class="fa fa-home"></i>Agent Print 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Agent Print</h3>
            </div>
          </div>
                    <div class="row">
                    <div class="col-md-12">
                      <form  method="POST" action="fedex_agent_print.php" enctype="multipart/form-data">
                        <div class="form-group has-success col-md-8">
                          <div class="form-group has-success col-md-8">
                           <label class="control-label" for="inputSuccess1">Print<span style="color:red;">*</span></label>
                            <textarea class="form-control" rows="5" id="inputSuccess1" name="print" required></textarea>
                        </div>
            <div class="form-group has-success col-md-6">
              <button class="btn btn-danger" name="btn_add" type="submit">Print</button><br/><br/>
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
