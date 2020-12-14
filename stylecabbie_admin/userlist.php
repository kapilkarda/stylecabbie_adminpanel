<style type="text/css">
  td {
    word-wrap:break-word!important;
  }
  .dataTables_filter{
    text-align: right;
  }
</style>
<?php 

  date_default_timezone_set('Asia/Kolkata');
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  if(!(isset($_SESSION['id']))){
      header("location:index.php");
   }
  include('db.php'); 
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
            <li class="current">Order Detail</li>
        </ul>
    </div>  <!-- End : Breadcrumbs -->
    <div class="page-header">   <!-- Start : Page Header -->
        <div class="page-title">
            <h3>Order Detail</h3>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">

          <form  method="GET" action="" enctype="multipart/form-data">
            
           
            <div class="form-group has-success col-md-2">
              <select class="form-control" name="order_type">
                <option value="">Select Order type</option>
                <option <?php if($_GET['order_type']=='CashOnDelivery'){ echo "selected"; } ?> value="CashOnDelivery">CashOnDelivery</option>
                <option <?php if($_GET['order_type']=='OnlinePayment'){ echo "selected"; } ?> value="OnlinePayment">OnlinePayment</option>
                
               
             </select>
            </div>
            <div class="form-group has-success col-md-2">
             <select class="form-control" name="status">
                <option value="">Select Status</option>
                <option <?php if($_GET['status']=='0'){ echo "selected"; } ?> value="0">Pending</option>
                <option <?php if($_GET['status']=='1'){ echo "selected"; } ?> value="1">COD Confirm</option>
                <option <?php if($_GET['status']=='9'){ echo "selected"; } ?> value="9">SP Confirm</option>
                <option <?php if($_GET['status']=='10'){ echo "selected"; } ?> value="10">NA Confirm</option>
                <option <?php if($_GET['status']=='11'){ echo "selected"; } ?> value="11">IND Confirm</option>
                <option <?php if($_GET['status']=='3'){ echo "selected"; } ?> value="3">SP Delivered</option>
                <option <?php if($_GET['status']=='2'){ echo "selected"; } ?> value="2">COD Delivered</option>
                <option <?php if($_GET['status']=='4'){ echo "selected"; } ?> value="4">Cancel</option>
                <option <?php if($_GET['status']=='5'){ echo "selected"; } ?> value="5">COD Return</option>
                <option <?php if($_GET['status']=='8'){ echo "selected"; } ?> value="8">SP Return</option>
                <option <?php if($_GET['status']=='6'){ echo "selected"; } ?> value="6">COD Payment</option>
                <option <?php if($_GET['status']=='7'){ echo "selected"; } ?> value="7">Not connected</option>
                
             </select>
            </div>
            <div class="form-group has-success col-md-2">
                <input class="form-control" value="<?php if(isset($_GET['date'])){ echo$_GET['date']; } ?>" type="date" name="date" placeholder="select date" >
            </div>
          
            <div class="form-group has-success col-md-2">
              <button class="btn btn-danger" name="btn_search" value="submint" type="submit">Submit</button><br/><br/>
            </div>
        </form>

        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Order Detail
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
                  <th class="numeric">S No</th>
                  <th class="numeric">Name</th>
                  <th class="numeric">Mobile</th>
                  <th class="numeric">Email</th>
                  <th class="numeric">Verify Status</th>
                  <th class="numeric">date</th>

                </tr>
              </thead>
              <tbody>
                <?php

              

                  $query="select * from `user`  ORDER BY user_id DESC";
                  $sql_con = mysqli_query($con,$query);
                  $i=1;
                  while($row_con = mysqli_fetch_array($sql_con)){

                      
                     
                        ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $i;?></td>
                  <td class="center" class="numeric"><?php echo $row_con['fullname'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['mobile'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['user_email'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['verify_status'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['datetime'];?></td>
               </tr>
                <?php 
                  $i++;
              }?>
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

