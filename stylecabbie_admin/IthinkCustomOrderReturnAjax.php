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

   /*function send_sms_for_order($order_id,$mobile,$barcode){
            $msg="Hope you enjoyed your shopping at mahakaal store ! Click these link and track your order https://www.delhivery.com/track/package/".$barcode."" ;

            $msg = urlencode($msg);
            $curl = curl_init();
            $url="http://msg.smscluster.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=baed1c78daff684bf259af57d3ed78a9&message=$msg&senderId=MAHAKL&routeId=1&mobileNos=$mobile&smsContentType=english";
              //echo $url;
            curl_setopt_array($curl, array(
              CURLOPT_URL =>$url ,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET"
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            /*if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }*/
    //} 

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
        <th>Order id</th>  
        <th>S.no</th>  
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
        $query = "UPDATE `customorder` SET `status`='8',`update_at`='$date' WHERE `customorder_id`='".$order_id."'";  
          mysqli_query($con, $query);
          //$mobile = $sqll1['mobile'];
        
          //send_sms_for_order($order_id,$mobile,$barcode);
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
      }else if ($status=='8') {
        $order_status="Return";
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