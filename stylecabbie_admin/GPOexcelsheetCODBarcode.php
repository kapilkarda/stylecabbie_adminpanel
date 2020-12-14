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
  ?>     
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
<div>  <!-- Start : Inner Page Content -->
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

      <table border="1" style="text-align: center;margin-left: 3%;">
          <tr>
              <td>SN</td>
              <td>Barcode</td>
              <td>Name</td>
              <td>City</td>
              <td>Pincode</td>
              <td>Tariff Category</td>
              <td>weight</td>
              <td>Cod value</td>
          </tr>
           <?php

                if (isset($_POST['btn_add'])){
                $print=explode(",", $_POST['print']);
                 $j=1;
                foreach ($print as $value) {

                $sql_con = mysqli_query($con,"SELECT * FROM `order`  where order_id='$value'");
               
                $row_con = mysqli_fetch_array($sql_con); 

                $p_id=$row_con['p_id'];
                $p_idArray=explode(',', $p_id);
                $totalqty=0;
                for ($i=0; $i <count($p_idArray); $i++) { 

                    $p_idCity="select * from `cart` WHERE `cart_id`='".$p_idArray[$i]."'";
                    $p_idCity = mysqli_query($con,$p_idCity);
                    $resultp_idCity = mysqli_fetch_array($p_idCity);

                    $product_id=$resultp_idCity['product_id'];
                    $product_idQuery="select * from `product` WHERE `product_id`='".$product_id."'";
                    $productRes = mysqli_query($con,$product_idQuery);
                    $productResult = mysqli_fetch_array($productRes);
                    if($i==0){
                            
                            
                            $totalqty=$totalqty+$resultp_idCity['qty'];
                    }else{
                        
                        $totalqty=$totalqty+$resultp_idCity['qty'];
                    }
                }

                $pin_code=$row_con['pin_code'];
                $pincod=mysqli_query($con,"SELECT * FROM `pincodes` where pincode='$pin_code' limit 1");
                $pincodres=mysqli_fetch_array($pincod);
                $districtname=$pincodres['districtname'];


                ?>
                <tr>
                  <td><?php echo$j; ?></td>
                  <td><img id="barcodeimage<?php echo$row_con['order_id']; ?>" src="" style="width:300px;height: 65px">
                            <script type="text/javascript">
                              try{
                                var image=textToBase64Barcode('<?php echo$row_con['barcode']; ?>');
                            }catch(e){
                              console.log(e);
                            }
                              document.getElementById("barcodeimage<?php echo$row_con['order_id']; ?>").src =image;

                            </script>
                   </td>
                  <td><?php echo$row_con['name']; ?></td>
                  <td><?php echo$districtname; ?></td>
                  <td><?php echo$row_con['pin_code']; ?></td>
                  <td><?php if($row_con['state_id']=='10' || $row_con['city_id']=='4759' || $row_con['city_id']=='5022' || $row_con['city_id']=='1119' || $row_con['city_id']=='4776')
                            { 
                              echo'N-N';
                              }else if($row_con['state_id']=='33' || $row_con['state_id']=='7' || $row_con['state_id']=='12' || $row_con['state_id']=='22' || $row_con['state_id']=='38'){
                                echo'N-S';
                              }else if($row_con['state_id']=='21'){
                                  echo'W-S';
                              }else{
                                echo'O-S';
                              } ?>

                    </td>
                    <td><?php echo (245*$totalqty);?> G</td>
                    <td><?php echo ($row_con['total_price']); ?></td>
                </tr>  


               <?php 
                $j++; 
              }
            }?>
      </table>
      
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

