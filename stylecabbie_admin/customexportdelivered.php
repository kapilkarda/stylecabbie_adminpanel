<?php 
  error_reporting(0); ini_set('display_errors', 1);
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  include('db.php');
   if(!(isset($_SESSION['id'])))
   {
      header("location:index.php");
   }

 //export.php  
if (isset($_POST['id'])) {
$output = ' 
<div class="portlet box blue">
  <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-table"></i>Despatched Detail
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
      <tr>
        <th>S.no</th>    
        <th>Order id</th>  
        <th>Name</th>  
        <th>Status</th>  
      </tr>  
  ';
  $val = json_decode($_POST['id']);
  $output2 = '</table>';  
  for($i=0;$i<count($val);$i++){
    $order_id = $val[$i]->order_id;
    $qry = mysqli_query($con,"SELECT * FROM `customorder` WHERE `customorder_id`='".$order_id."'");
    $sqll1 = mysqli_fetch_assoc($qry); 
    $sqll = mysqli_num_rows($qry);
    $date=date('Y-m-d h:i:s');
    if ($sqll>0) {
      if ($sqll1['status']=='21') {
        $query = "UPDATE `customorder` SET `status`='3' WHERE `customorder_id`='".$order_id."'";  
          mysqli_query($con, $query);
      }
      $qry1 = mysqli_query($con,"SELECT * FROM `customorder` WHERE `customorder_id`='".$order_id."'");
      $fetch = mysqli_fetch_assoc($qry1); 
      $name=$sqll1['name'];
      $status=$fetch['status'];
      if ($status=='21') {
        $order_status="Dispatched";
      }else if ($status=='0') {
        $order_status="Pending";
      }else if ($status=='1') {
        $order_status="Confirm";
      }else if ($status=='8') {
        $order_status="Return";
      }else if ($status=='20') {
        $order_status="In process";
      }else if ($status=='3') {
        $order_status="Delivered";
      }else if ($status=='2') {
        $order_status="COD Delivered";
      }else if ($status=='4') {
        $order_status="Cancel";
      }else if ($status=='22') {
        $order_status="Out of Stock";
      }
      $output1 .= '  
      <tr>  
        <td>'.$i.'</td>  
        <td>'.$order_id.'</td>  
        <td>'.$name.'</td>  
        <td>'.$order_status.'</td>  
      </tr>  
      ';
      } 
  }
  echo $output.$output1.$output2;  
}
              
              
          
 ?>