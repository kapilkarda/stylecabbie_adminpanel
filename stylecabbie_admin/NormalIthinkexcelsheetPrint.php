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
            <table id="example" class="table table-bordered table-hover table-responsive">
              <thead>
                <tr>
                  <th class="numeric">OrderType</th>
                  <th class="numeric">OrderNo</th>
                  <th class="numeric">SubOrderNo</th>
                  <th class="numeric">PaymentStatus</th>
                  <th class="numeric">CustomerName</th>
                  <th class="numeric">CustomerAddress</th>
                  <th class="numeric">CustomerAddress2</th>
                  <th class="numeric">CustomerAddress3</th>
                  <th class="numeric">CustomerCity</th>
                  <th class="numeric">CustomerState</th>
                  <th class="numeric">ZipCode</th>
                  <th class="numeric">CustomerMobileNo</th>
                  <th class="numeric">CustomerPhoneNo</th>
                  <th class="numeric">CustomerEmail</th>
                  <th class="numeric">ProductMRP</th>
                  <th class="numeric">ProductGroup</th>
                  <th class="numeric">ProductDesc</th>
                  <th class="numeric">Cod Payment</th>
                  <th class="numeric">OctroiMRP</th>
                  <th class="numeric">VolWeight(GMS)</th>
                  <th class="numeric">PhyWeight(GMS)</th>
                  <th class="numeric">ShipLength (CM)</th>
                  <th class="numeric">ShipWidth(CM)</th>
                  <th class="numeric">ShipHeight(CM)</th>
                  <th class="numeric">AirWayBillNO</th>
                  <th class="numeric">ServiceType</th>
                  <th class="numeric">Quantity</th>
                  <th class="numeric">CSTNumber</th>
                  <th class="numeric">TINNumber</th>
                  <th class="numeric">CGST</th>
                  <th class="numeric">SGST</th>
                  <th class="numeric">IGST</th>
                  <th class="numeric">invoiceno</th>
                  <th class="numeric">invoicedate</th>
                  <th class="numeric">Status</th>
                  <th class="numeric">OrderStatus</th>
                  <th class="numeric">Error</th>



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

                      $state_id=$row_con['state_id'];
                      $queryState="select * from `states` WHERE `state_id`='$state_id'";
                      $resState = mysqli_query($con,$queryState);
                      $resultState = mysqli_fetch_array($resState);

                      $city_id=$row_con['city_id'];
                      $queryCity="select * from `cities` WHERE `city_id`='$city_id'";
                      $resCity = mysqli_query($con,$queryCity);
                      $resultCity = mysqli_fetch_array($resCity);

                      $ProductName='';
                      $ProductSize='';
                      $ProductQty='';
                      $pro_type_final='';
                      $p_id=$row_con['p_id'];
                      $p_idArray=explode(',', $p_id);
                      for ($i=0; $i <count($p_idArray); $i++) { 

                          $p_idCity="select * from `cart` WHERE `cart_id`='".$p_idArray[$i]."'";
                          $p_idCity = mysqli_query($con,$p_idCity);
                          $resultp_idCity = mysqli_fetch_array($p_idCity);

                          $product_id=$resultp_idCity['product_id'];
                          $product_idQuery="select * from `product` WHERE `product_id`='".$product_id."'";
                          $productRes = mysqli_query($con,$product_idQuery);
                          $productResult = mysqli_fetch_array($productRes);

                          $cat_id=$productResult['cat_id'];
                          $queryCat="select * from `category` WHERE `cat_id`='$cat_id'";
                          $resCat = mysqli_query($con,$queryCat);
                          $resultCat = mysqli_fetch_array($resCat);

                          if($productResult['cat_id']==3){

                              $info=$resultp_idCity['brand'].'('.$resultp_idCity['model'].')';
                              $pro_type='M';

                          }else if($productResult['cat_id']==1){
                            $info=$resultp_idCity['size'];
                             $pro_type='T';
                          }else if($productResult['cat_id']==6){
                              $info=$resultp_idCity['size'].','.$resultp_idCity['brand'].'('.$resultp_idCity['model'].')';
                              $pro_type='combo';
                          }else if($productResult['cat_id']==8){
                            $info='keychain';
                            $pro_type='keychain';
                          }
                          
                          if($i==0){

                                  
                                  $ProductName=$productResult['name'];
                                  $ProductSize=$info;
                                  $ProductQty=$resultp_idCity['qty'];
                                  $pro_type_final=$pro_type;

                          }else{
                              $ProductName.=','.$productResult['name'];
                              $ProductSize.=','.$info;
                              $ProductQty.=','.$resultp_idCity['qty'];
                              $pro_type_final.=','.$pro_type;
                          }
                      
                   }

                ?>
                <tr id='trrow' >
                  <?php
                        if($row_con['order_type']=='cod'){
                                $order_type='COD';

                          }else{
                              $order_type='Prepaid';
                        }
                  ?>
                  <td class="center" class="numeric"><?php echo $order_type;?></td>
                  <td class="center" class="numeric">N<?php echo $row_con['order_id'];?></td>
                  <td class="center" class="numeric">A</td>
                  <td class="center" class="numeric"><?php echo $order_type;?></td>
                  <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['address'];?></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"><?php echo $resultCity['city_name'];?></td>
                  <td class="center" class="numeric"><?php echo $resultState['state_name'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['pin_code'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['mobile'];?></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"><?php echo $row_con['total_price'];?></td>
                  <td class="center" class="numeric"><?php echo $resultCat['cat_name'];?></td>
                  <td class="center" class="numeric"><?php echo $ProductName.'('.$ProductSize.')'.'('.$ProductQty.')';?></td>
                  <td class="center" class="numeric"><?php echo $row_con['total_price'];?></td>
                  <td class="center" class="numeric">0</td>
                  <td class="center" class="numeric">250</td>
                  <td class="center" class="numeric">250</td>
                  <td class="center" class="numeric">10</td>
                  <td class="center" class="numeric">8</td>
                  <td class="center" class="numeric">2</td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric">1</td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  <td class="center" class="numeric"></td>
                  
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

