<style type="text/css">
  td {
    word-wrap:break-word!important;
  }
  .dataTables_filter{
    text-align: right;
  }
</style>
<?php 
  
  include('db.php'); 
  date_default_timezone_set('Asia/Kolkata');
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  if(!(isset($_SESSION['id']))){
      header("location:index.php");
   }


   if (isset($_POST['btn_submit'])) 
  {
   
    $mobile = $_POST['mobile'];
    date_default_timezone_set('Asia/Calcutta');
    $date=date('Y/m/d h:i:s');

    $mobile=explode(",", $_POST['mobile']);
    foreach ($mobile as $value) {
      $queryCheck = mysqli_query($con, "SELECT * from `callback_order` WHERE `mobile`='$value'");
        if(mysqli_num_rows($queryCheck)==0){

        $sqlCart ="INSERT into `callback_order` (`mobile`,`created_at`,`status`) VALUES ('$value','$date','3')";
        $queryCart = mysqli_query($con, $sqlCart);
      }
    }
    if($queryCart){

        header("location:callback_order_b.php");
      }
      

  }

    if (isset($_POST['delete'])) 
  {
   
        $id = $_POST['id'];
        $sqlCart ="UPDATE `callback_order` SET `status`='2' WHERE id='$id'";
        $queryDelete = mysqli_query($con, $sqlCart);
    if($queryDelete){

        header("location:callback_order_b.php");
      }
      

  }

    if (isset($_POST['notConnect'])) 
  {
   
        $id = $_POST['id'];
        $sqlCart ="UPDATE `callback_order` SET `status`='1' WHERE id='$id'";
        $queryDelete = mysqli_query($con, $sqlCart);
    if($queryDelete){

        header("location:callback_order_b.php");
      }
      

  }
  

  include('header.php');
  include('sidebar.php'); ?>            
<div id="content">  <!-- Start : Inner Page Content -->
  <div class="container"> <!-- Start : Inner Page container -->
    <div class="crumbs">    <!-- Start : Breadcrumbs -->
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="current">Call back order</li>
        </ul>
    </div>  <!-- End : Breadcrumbs -->
    <div class="page-header">   <!-- Start : Page Header -->
        <div class="page-title">
            <h3>Call back order</h3>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">

          <form  method="POST" action="" enctype="multipart/form-data">
            
           
            <div class="form-group has-success col-md-4">
              <label class="control-label" for="inputSuccess1">Mobile<span style="color:red;">*</span></label>
                <textarea class="form-control" rows="5" id="inputSuccess1" name="mobile" required></textarea>
            </div>
            <div class="form-group has-success col-md-2">
              <button class="btn btn-danger" name="btn_submit" value="submint" type="submit">Submit</button><br/><br/>
            </div>
        </form>

        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Call back order
              </div>                               
              <div class="actions">
                  <div class="btn-group">
                    <a class="btn mini green" href="#" onclick="export_in_excel();" >
                      <i class="fa fa-plus-circle" aria-hidden="true"></i> Export in excel
                    </a>    
                  </div>
              </div>
          </div>
          <div class="portlet-body" id="table_wrapper" style="overflow: auto;">
            <table class="table table-bordered table-hover table-responsive DynamicTable">
              <thead>
                <tr>
                  <th class="numeric">Mobile</th>
                  <th class="numeric">Date</th>
                  <th class="numeric">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

                  $query="select * from `callback_order` WHERE `status`='3' ORDER BY id DESC";
                     $sql_con = mysqli_query($con,$query);
                     while($row_con = mysqli_fetch_array($sql_con)){
                 ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $row_con['mobile'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['created_at'];?></td>
                  <td class="center" class="numeric">
                    <form  method="POST" action="">
                     <input type="hidden" name="id" value="<?php echo $row_con['id'];?>">
                     <button class="btn btn-danger" name="delete" value="submint" type="submit">Delete</button>
                    </form>
                    <form  method="POST" action="">
                     <input type="hidden" name="id" value="<?php echo $row_con['id'];?>">
                     <button class="btn btn-danger" name="notConnect" value="submint" type="submit">Not connect</button>
                    </form>
                  </td> 
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  <!-- End : Inner Page container -->
    <a href="javascript:void(0);" class="scrollup">Scroll</a>
</div>  <!-- End : Inner Page Content -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
<script type="text/javascript" src="assets/plugins/common/breakpoints.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        App.init();
        DataTabels.init();
    });        
    function changeStatus(status,oid){
      var result= confirm("Are you really want change status?");
      if(result==true){
        $.ajax({
          type:'GET',
          url: "updateStatus.php",
          data: "status="+status+"&oid="+oid,
          success: function(response){
            // console.log(response);
            if (response==1) {
              // console.log('done');
           // location.reload();
            } else{
              alert('Status not update');
            }
          }
        });
      }
    }
    function export_in_excel(){
       //getting data from our table
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('table_wrapper');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');

    var a = document.createElement('a');
    a.href = data_type + ', ' + table_html;
    a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
    a.click();
    }
</script>

