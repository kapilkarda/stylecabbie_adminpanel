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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>           
<div id="content">  <!-- Start : Inner Page Content -->
  <div class="container"> <!-- Start : Inner Page container -->
    <div class="crumbs">    <!-- Start : Breadcrumbs -->
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="current">Normal mobile cover print</li>
        </ul>
    </div>  <!-- End : Breadcrumbs -->
    <div class="page-header">   <!-- Start : Page Header -->
        <div class="page-title">
            <h3>Normal mobile cover print</h3>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Normal mobile cover print
              </div>                               
             <!--  <div class="actions">
                  <div class="btn-group">
                    <a class="btn mini green" href="#" onclick="export_in_excel();" >
                      <i class="fa fa-plus-circle" aria-hidden="true"></i> Export in excel
                    </a>    
                  </div>
              </div> -->
          </div>
          <div class="portlet-body" id="table_wrapper" style="overflow: auto;">
            <form action="normalprintcover.php" method="post" onsubmit="return costommobile();" target="_blank">
              <button class='btn btn-success' type="submit" style="float: right;"><i class="fa fa print"></i>Print Mobile Cover</button>
              <table class="table table-bordered table-hover table-responsive DynamicTable">
                <thead>
                  <tr>
                    <th align="left"> <strong>Select All <input type="checkbox" name="select_all" id="select_all" value=""/> </strong> </th>
                    <th class="numeric">Image</th>
                    <th class="numeric">Order Id</th>
                    <th class="numeric">Product Name</th>
                    <th class="numeric">Product type</th>
                    <th class="numeric">Qty</th>
                    <th class="numeric">Brand</th>
                    <th class="numeric">Model</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- custom stock -->
                  <?php
                      $query1="select * from `order`  WHERE status='9'";
                            $sql_con1 = mysqli_query($con,$query1);
                            while($row_con1 = mysqli_fetch_array($sql_con1)){

                                      $order_id=$row_con1['order_id'];
                                      $p_id=$row_con1['p_id'];
                                      $p_idArray=explode(',', $p_id);
                                      
                     
                                    for ($i=0; $i <count($p_idArray); $i++) { 

                                        $p_idCity="select * from `cart` WHERE `cart_id`='".$p_idArray[$i]."'";
                                        $p_idCity = mysqli_query($con,$p_idCity);
                                        $resultp_idCity = mysqli_fetch_array($p_idCity);
                                        $ProductQty=$resultp_idCity['qty'];
                                        $product_id=$resultp_idCity['product_id'];
                                        $brand=$resultp_idCity['brand'];
                                        $model=$resultp_idCity['model'];
                                       

                                        $size=$resultp_idCity['size'];
                                        $brand=$resultp_idCity['brand'];
                                        if($size=='' && $brand!=''){
                                            $type='M';


                                        $Product_id="select * from `product` WHERE `product_id`='".$product_id."'";
                                        $Product_id_s = mysqli_query($con,$Product_id);
                                        $Product_id_result = mysqli_fetch_array($Product_id_s);
                                        $printimagepdf=$Product_id_result['printimagepdf'];
                                        $ProductName=$Product_id_result['name'];
                                        $data=$order_id.','.$p_idArray[$i]; 
                                ?>
                      

                                <tr id='trrow' >
                                  <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $data;?>"/></td>
                                      <td style="background-color: black;"><input type="hidden" name="printimagepdf">
                                        <img width="100px" src="<?php echo $printimagepdf;?>">
                                      <td class="center" class="numeric"><?php echo $order_id;?></td>
                                      <!-- <td class="center" class="numeric"><?php //echo $row_con1['customorder_id'];?>,<?php //echo $info;?></td> -->
                                      <td class="center" class="numeric"><?php echo $ProductName;?></td>
                                      <td class="center" class="numeric"><?php echo $type;?></td>
                                      <td class="center" class="numeric"><?php echo $ProductQty;?></td>
                                      <td class="center" class="numeric"><?php echo $brand;?></td>
                                      <td class="center" class="numeric"><?php echo $model;?></td>
                                      
                                      </tr>
                              <?php

                                    }
                                   } 
                            
                          }?>
                </tbody>
              </table>
            </form>
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
              document.getElementById('change_s'+oid).style.visibility = 'hidden';
              document.getElementById('change_sed'+oid).style.visibility = 'visible';
              // console.log('done');
           // location.reload();
            } else{
              alert('Status not update');
            }
          }
        });
      }
    }

     function changeStatusCus(status,oid){
      
      var result= confirm("Are you really want change status?");
      if(result==true){
        $.ajax({
          type:'GET',
          url: "updateStatus.php",
          data: "status="+status+"&oid="+oid+"&method=CustomOrder",
          success: function(response){
            // console.log(response);
            if (response==1) {
               document.getElementById('change_s'+oid).style.visibility = 'hidden';
              document.getElementById('change_sed'+oid).style.visibility = 'visible';
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

    function myFunction() {
      alert("Please upload print image!");
    }
</script>
<script type="text/javascript">
   function costommobile(){
      var chkCount1 = 0;
      var calorieCheckbox= document.getElementsByName("checked_id[]");
      for(var i=0; i<calorieCheckbox.length; i++){
         if(calorieCheckbox[i].checked) {
            chkCount1++;
         }
      }
      if (chkCount1 === 0){
         alert("Please select orders! ");
         return false;
      }
   }

</script>

