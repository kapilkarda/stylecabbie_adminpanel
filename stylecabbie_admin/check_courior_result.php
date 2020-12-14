<style type="text/css">
  td {
    word-wrap:break-word!important;
  }
  .dataTables_filter{
    text-align: right;
  }
</style>

<?php 
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js'></script>  
  <script type="text/javascript">
    
      //JsBarcode("#barcode", "YA778351560IN");
      function textToBase64Barcode(text){
        var canvas = document.createElement("canvas");
        JsBarcode(canvas, text, {format: "CODE39"});
        return canvas.toDataURL("image/png");
      }
    </script>     
<div id="content">  <!-- Start : Inner Page Content -->
  <div class="container"> <!-- Start : Inner Page container -->
    <div class="crumbs">    <!-- Start : Breadcrumbs -->
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="dashboard.php">Check Courier Result</a>
            </li>
            <li class="current">Check Courier Result</li>
        </ul>
    </div>  <!-- End : Breadcrumbs -->
    <div class="page-header">   <!-- Start : Page Header -->
        <div class="page-title">
            <h3>Check Courier Result</h3>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Check Courier Result
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
            <table id="example" class="table table-bordered table-hover table-responsive">
              <thead>
                <tr>
                  <th class="numeric">SL</th>
                  <th class="numeric">Pincode</th>
                  <th class="numeric">Couirer Name</th>
                </tr>
              </thead>
              <tbody>
                <?php

                if (isset($_POST['btn_add'])){
                $print=explode(",", $_POST['print']);
                 $i=1;
                foreach ($print as $value) {

                $sql_con = mysqli_query($con,"SELECT * FROM `order` where order_id='$value' ");
               
                $row_con = mysqli_fetch_array($sql_con);

                $pin_code=$row_con['pin_code'];

                $p_idCity="select * from `dtdc_pincode` WHERE `Postal_Code`='".$pin_code."'";
                $p_idCity = mysqli_query($con,$p_idCity);
                if($resultp_idCity = mysqli_fetch_array($p_idCity)){
                      $couirer_name='Fedex';
                }else{
                    $couirer_name='Indian post';
                }


               

                 ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $i;?></td>
                  <td class="center" class="numeric"><?php echo $pin_code;?></td>
                  <td class="center" class="numeric"><?php echo $couirer_name;?></td>
                  
                </tr>
                <?php 
            		$i++; 
            	}
            }
            ?>
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

