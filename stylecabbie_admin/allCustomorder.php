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

          <!-- <form  method="GET" action="" enctype="multipart/form-data">
            
           
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
                <option <?php if($_GET['status']=='20'){ echo "selected"; } ?> value="20">In Process</option>
                 <option <?php if($_GET['status']=='21'){ echo "selected"; } ?> value="21">Dispached</option>
                <option <?php if($_GET['status']=='3'){ echo "selected"; } ?> value="10">Delivered</option>
                <option <?php if($_GET['status']=='4'){ echo "selected"; } ?> value="11">Cancel</option>
                <option <?php if($_GET['status']=='22'){ echo "selected"; } ?> value="22">Out of stock</option>
                
             </select>
            </div>
            <div class="form-group has-success col-md-2">
                <input class="form-control" value="<?php if(isset($_GET['date'])){ echo$_GET['date']; } ?>" type="date" name="date" placeholder="select date" >
            </div>
          
            <div class="form-group has-success col-md-2">
              <button class="btn btn-danger" name="btn_search" value="submint" type="submit">Submit</button><br/><br/>
            </div>
        </form> -->

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
                  <!-- <th class="numeric">Image</th> -->
                  <th class="numeric">Text</th>
                  <th class="numeric">Name</th>
                  <th class="numeric">Address</th>
                  <th class="numeric">Remark</th>
                  <th class="numeric">Mobile</th>
                  <th class="numeric">Pin code</th>
                  <th class="numeric">WhatsApp</th>
                  <th class="numeric">Info</th>
                  <th class="numeric">Total Price</th>
                  <th class="numeric">Quantity</th>
                  <th class="numeric">OrderStatus</th>
                  <th class="numeric">Barcode</th>
                  <th class="numeric">date</th>
                  <th class="numeric">Update At</th>
                  <th class="numeric">Status</th>
                  <th class="numeric">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php

               /* if($_GET['btn_search']!=''){

                    $where = array();

                    if($_GET['order_type']!=''){

                      if($_GET['order_type']=='OnlinePayment'){
                          array_push($where, "order_type='".$_GET['order_type']."' and txnid!=''");
                      }else{
                        array_push($where, "order_type='".$_GET['order_type']."'");
                      }
                      

                    }if($_GET['status']!=''){

                      array_push($where, "status='".$_GET['status']."'");

                    }if($_GET['date']!=''){

                      $newDate = date("Y-m-d", strtotime($_GET['date']));
                      array_push($where, "date(order_date)='".$newDate."'");

                    }

                   $where_condition= implode(' and ', $where);
                    
                   
                    $query="select * from `customorder` where $where_condition ORDER BY customorder_id DESC";
                   

                }else{*/

                   /* $cur_date=date('Y/m/d h:i:s');
                    $old_date=date('Y/m/d h:i:s', strtotime("-7 days"));

                     */
              //  }
                  $query="select * from `customorder` ORDER BY customorder_id DESC";
                  $sql_con = mysqli_query($con,$query);
                  while($row_con = mysqli_fetch_array($sql_con)){

                      

                    

                      $ProductName='';
                      $info='';
                      $ProductQty='';
                      $cat_id=$row_con['cat_id'];

                          $p_idCity="select * from `customProductImage` WHERE `cat_id`='".$cat_id."'";
                          $p_idCity = mysqli_query($con,$p_idCity);
                          $resultp_idCity = mysqli_fetch_array($p_idCity);
                          $title=$resultp_idCity['customProductImage_title'];
                          if($cat_id==4){

                              $info=$row_con['brand'].'('.$row_con['brand_Model'].')';

                          }
                          if($cat_id==5){

                              $info=$row_con['size'];

                          }
                      


                        ?>
                <tr id='trrow' >
                  <td class="center" class="numeric"><?php echo $row_con['customorder_id'];?></td>
                  <td class="center" class="numeric"><?php echo $title;?></td>
                 <!--  <td class="center" class="numeric"> <img width="50px" src="../<?php echo $row_con['customPic'];?>"></td> -->

                  <td class="center" class="numeric"><?php echo $row_con['text'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['address'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['remark'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['mobile'];?></td>
                   <td class="center" class="numeric"><?php echo $row_con['pincode'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['whatsapp_mobile'];?></td>
                  <td class="center" class="numeric"><?php echo $info;?></td>
                  <td class="center" class="numeric"><?php echo $row_con['total_price'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['qty'];?></td>
                  <td class="center" class="numeric">
                    <select class="form-control" name="status" onChange="changeStatus(this.value,<?php echo $row_con['customorder_id'];?>);">
                      <option <?php if($row_con['status']=='0'){ echo "selected"; } ?> value="0"><?php echo 'Pending';?></option>
                      <option <?php if($row_con['status']=='1'){ echo "selected"; } ?> value="1"><?php echo 'Confirm';?></option>
                      <option <?php if($row_con['status']=='8'){ echo "selected"; } ?> value="8">Return</option>
                      <option <?php if($row_con['status']=='20'){ echo "selected"; } ?> value="20"><?php echo 'In process';?></option>
                      <option <?php if($row_con['status']=='21'){ echo "selected"; } ?> value="21"><?php echo'Dispached';?></option>

                      <option <?php if($row_con['status']=='3'){ echo "selected"; } ?> value="3"><?php echo 'Delivered';?></option>

                      <option <?php if($row_con['status']=='4'){ echo "selected"; } ?> value="4"><?php echo 'Cancel';?></option>
                      <option <?php if($row_con['status']=='22'){ echo "selected"; } ?> value="22"><?php echo 'Out of stock';?></option>

                     

                    </select>
                  </td>
                  <td class="center" class="numeric"><?php echo $row_con['barcode'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['order_date'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['update_at'];?></td>
                  <td class="center" class="numeric"><?php echo $row_con['order_type'];?></td>
                  <td class="center" class="numeric">
                    <a class='btn btn-info' title='edit' target="_blank" href="edit_custom_order.php?order_id=<?php echo $row_con['customorder_id'];  ?>"><i class='mdi-content-create'  >Edit</i></a>
                    <button class='btn btn-success' title='edit' target="_blank" 
                   onclick="sendmessage(<?php echo $row_con['customorder_id'];?>);"><i class='mdi-content-create'  >Message</i></button>
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
          data: "status="+status+"&oid="+oid+"&method=CustomOrder",
          success: function(response){
             console.log(response);
            if (response==1) {
              // console.log('done');
           // location.reload();
            } /*else{
              alert('Status not update');
            }*/
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
<script type="text/javascript">
  function sendmessage(oid){
    /*alert('hi');
    alert(oid);*/
      $.ajax({
      type:'GET',
      url: "sendmessage.php",
      data:"oid="+oid+"&method=CustomOrder",
      success: function(response){
        console.log(response);
        if (response==1) {
              alert('Your barcode is empty!');
              // console.log('done');
           // location.reload();
            } else if(response==0){
              alert('Your Order status not Dispached!');
            }
            else if(response==2){
              alert('Send message on mobile!');
            }
      }
    });
  }
</script>

