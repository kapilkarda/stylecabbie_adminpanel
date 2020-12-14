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

        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Top Product
              </div>                               
              <div class="actions">
                  <div class="btn-group">
                    <a class="btn mini green" href="addTopProduct.php">
                      <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Top Products
                    </a>    
                  </div>
              </div>
          </div>
          <div class="portlet-body" id="table_wrapper">
            <table class="table table-bordered table-hover table-responsive DynamicTable">
              <thead>
                <tr>
                  <th class="numeric">Top Product Id</th>
                  <th class="numeric">Product Name</th>
                  <th class="numeric">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query="select * from product where topProduct='1'";
                  $sql_con = mysqli_query($con,$query);
                  while($row_con = mysqli_fetch_array($sql_con)){
                ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $row_con['p_id'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                  <td class="center" class="numeric">
                    <a class='btn btn-info' title='edit' href="editTopProduct.php?topProduct_id=<?php echo $row_con['p_id'];  ?>"><i class='mdi-content-create'  >Edit</i></a>
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
    function delete_user(id){
      var result= confirm("Are you really want delete this Product?");
      if(result==true){
        $.ajax({
          type:'POST',
          url:'query.php',
          data:'method=3&id='+id,
          success:function(res){
           location.reload(); 
          }
        });
      }
    }       
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

