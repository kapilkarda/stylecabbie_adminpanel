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
             <select class="form-control" name="product">
                <option value="">Select product</option>
                <?php
                      $sqlProduct = mysqli_query($con,"select * from `product`");
                       while($rowProduct = mysqli_fetch_array($sqlProduct)){ 

                       
                         if($_GET['product']==$rowProduct['p_id'])
                          { 
                            echo'<option selected value="'.$rowProduct['p_id'].'">'.$rowProduct['name'].'</option>';
                          }else{
                             echo'<option value="'.$rowProduct['p_id'].'">'.$rowProduct['name'].'</option>';
                          }  
                       }
                ?>
                
             </select>
            </div>
            <div class="form-group has-success col-md-2">
             <select class="form-control" name="size">
                <option value="">Select size</option>
                <option <?php if($_GET['size']=='S (38)'){ echo "selected"; } ?> value="S (38)">S (38)</option>
                <option <?php if($_GET['size']=='M (40)'){ echo "selected"; } ?> value="M (40)">M (40)</option>
                <option <?php if($_GET['size']=='L (42)'){ echo "selected"; } ?> value="L (42)">L (42)</option>
                <option <?php if($_GET['size']=='XL (44)'){ echo "selected"; } ?> value="XL (44)">XL (44)</option>
               
             </select>
            </div>
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
                <option <?php if($_GET['status']=='1'){ echo "selected"; } ?> value="1">Confirm</option>
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
              <button class="btn btn-danger" name="btn_search" type="submit">Submit</button><br/><br/>
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
                  <th class="numeric">Order Id</th>
                  <th class="numeric">Product Id</th>
                  <th class="numeric">Name</th>
                  <th class="numeric">Address</th>
                  <th class="numeric">Mobile</th>
                  <th class="numeric">Pin Code</th>
                  <th class="numeric">State</th>
                  <th class="numeric">City</th>
                  <th class="numeric">Size</th>
                  <th class="numeric">Quantity</th>
                  <th class="numeric">OrderStatus</th>
                  <th class="numeric">Barcode</th>
                  <th class="numeric">date</th>
                  <th class="numeric">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

                if(isset($_GET['btn_search'])){

                    $where = array();

                    if($_GET['product']!=''){

                      array_push($where, "FIND_IN_SET(".$_GET['product'].",p_id)");

                    }if($_GET['size']!=''){

                      array_push($where, "size='".$_GET['size']."'");

                    }if($_GET['order_type']!=''){

                      if($_GET['order_type']='OnlinePayment'){
                          array_push($where, "order_type='".$_GET['order_type']."' and txnid!=''");
                      }else{
                        array_push($where, "order_type='".$_GET['order_type']."'");
                      }
                      

                    }if($_GET['status']!=''){

                      array_push($where, "status='".$_GET['status']."'");

                    }if($_GET['date']!=''){

                      $newDate = date("Y/m/d", strtotime($_GET['date']));
                      array_push($where, "date(created_at)='".$newDate."'");

                    }

                   $where_condition= implode(' and ', $where);
                    
                   
                    $query="select * from `order` where $where_condition";
                   

                }else{

                     $query="select * from `order`  ORDER BY order_id DESC";
                }

                  $sql_con = mysqli_query($con,$query);
                  while($row_con = mysqli_fetch_array($sql_con)){

                      $state_id=$row_con['state_id'];
                      $queryState="select * from `states` WHERE `state_id`='$state_id'";
                      $resState = mysqli_query($con,$queryState);
                      $resultState = mysqli_fetch_array($resState);

                      $city_id=$row_con['city_id'];
                      $queryCity="select * from `cities` WHERE `city_id`='$city_id'";
                      $resCity = mysqli_query($con,$queryCity);
                      $resultCity = mysqli_fetch_array($resCity);


                        ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $row_con['order_id'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['p_id'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['address'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['mobile'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['pin_code'];?></td>
                  <td class="center" class="numeric"><?php echo $resultState['state_name'];?></td>
                  <td class="center" class="numeric"><?php echo $resultCity['city_name'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['size'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['qty'];?></td>
                  <td class="center" class="numeric">
                    <select class="form-control" name="status" onChange="changeStatus(this.value,<?php echo $row_con['order_id'];?>);">
                      <option <?php if($row_con['status']=='0'){ echo "selected"; } ?> value="0"><?php echo 'Pending';?></option>
                      <option <?php if($row_con['status']=='1'){ echo "selected"; } ?> value="1"><?php echo 'Confirm';?></option>
                      <option <?php if($row_con['status']=='3'){ echo "selected"; } ?> value="3"><?php echo 'SP Delivered';?></option>

                      <option <?php if($row_con['status']=='2'){ echo "selected"; } ?> value="2"><?php echo 'COD Delivered';?></option>
                      <option <?php if($row_con['status']=='4'){ echo "selected"; } ?> value="4"><?php echo 'Cancel';?></option>
                      <option <?php if($row_con['status']=='5'){ echo "selected"; } ?> value="5"><?php echo 'COD Return';?></option>
                      <option <?php if($row_con['status']=='8'){ echo "selected"; } ?> value="8"><?php echo 'SP Return';?></option>
                      <option <?php if($row_con['status']=='6'){ echo "selected"; } ?> value="6"><?php echo 'COD Payment';?></option>
                      <option <?php if($row_con['status']=='7'){ echo "selected"; } ?> value="7"><?php echo 'Not connected';?></option>

                    </select>
                  </td>
                  <td class="center" class="numeric"><?php echo $row_con['barcode'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['created_at'];?></td>
                  <td class="center" class="numeric">
                    <a class='btn btn-info' title='edit' href="edit_order.php?order_id=<?php echo $row_con['order_id'];  ?>"><i class='mdi-content-create'  >Edit</i></a>
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

