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
  include('sidebar.php');


      if (isset($_POST['upload'])) {
             $customorder_id=$_POST['id'];
             $brand=$_POST['brand'];
             $brand_Model=$_POST['brand_Model'];
             $brand_Model = ltrim($brand_Model);
             $image=$_FILES['picture']['name'];
             $date=date('Ymdhis');

                  $path1 = "vendoreditCropImages/".$date.$_FILES["picture"]["name"];
                  if(move_uploaded_file($_FILES["picture"]["tmp_name"], $path1)){

                    $select="SELECT * FROM `cover_sub_category` WHERE `cat_id`='$brand' and `name`='$brand_Model'";
                    $sqlselect = mysqli_query($con, $select);
                    $row_select = mysqli_fetch_array($sqlselect);
                    $innerwidth=$row_select['innerwidth'];
                    $innerheight=$row_select['innerheight'];
                    $main_date=date('Y-m-d h:i:s');

                   $query="INSERT INTO `vendormobileprint` (`order_id`,`image`,`brand`,`model`,`innerwidth`,`innerheight`,`outerwidth`,`outerheight`,`date`) VALUES ('$customorder_id','$path1','$brand','$brand_Model','$innerwidth','$innerheight','$outerwidth','$outerheight','$main_date')";
                   $sql = mysqli_query($con, $query);
                    if ($sql) {
                    // echo "<script>window.location.href='customMobilePrint.php';</script>";
                    } else {
                    echo"try latter";
                    }
                 
                  }else{
                     echo'not';exit;
                  }
        }


   ?> 
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
            <li class="current">Custom Mobile Image Edit</li>
        </ul>
    </div>  <!-- End : Breadcrumbs -->
    <div class="page-header">   <!-- Start : Page Header -->
        <div class="page-title">
            <h3>Custom Mobile Image</h3>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="portlet box blue">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-table"></i>Custom Mobile Image
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
            
              <table class="table table-bordered table-hover table-responsive DynamicTable">
                <thead>
                  <tr>
                    <th class="numeric">Sno.</th>
                    <th class="numeric">Image</th>
                    <th class="numeric">Order Id</th>
                    <th class="numeric">Brand</th>
                    <th class="numeric">model</th>
                    <th class="numeric">width</th>
                    <th class="numeric">height</th>
                    <th class="numeric">Sensor</th>
                    <th class="numeric">Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                      $query1="select * from `customordervendor`  WHERE `status`='2' and `product_name`='CustomMobileCover'";
                            $sql_con1 = mysqli_query($con,$query1);
                            $i=0;
                            while($row_con1 = mysqli_fetch_array($sql_con1)){

                                    $brand=$row_con1['brand'];
                                    $brand_Model=$row_con1['modal'];
                                    $brand_Model = ltrim($brand_Model);
                                    $info=$row_con1['brand'].'('.$row_con1['modal'].')';


                                    $selectcat="SELECT * FROM `cover_sub_category` WHERE `cat_id`='$brand' and `name`='$brand_Model'";
                                    $sqlselectcat = mysqli_query($con, $selectcat);
                                    $row_selectcat = mysqli_fetch_array($sqlselectcat);

                                    $order_id=$row_con1['id'];
                                    $selectm="SELECT * FROM `vendormobileprint` WHERE `order_id`='$order_id'";
                                    $sqlselectm = mysqli_query($con, $selectm);
                                    if(!$row_selectm = mysqli_fetch_array($sqlselectm)){
                                      $i++;

                                      if($i<=5){

                                      
                                ?>

                                <tr id='trrow' >

                                    <td class="center" class="numeric"><?php echo $i; ?></td>
                                    <td><img width="100px" src="../vendor/<?php echo $row_con1['customPic'];?>">
                                    <td class="center" class="numeric"><?php echo $row_con1['id'];?></td>
                                    <td class="center" class="numeric"><?php echo $row_con1['brand'];?></td>
                                    <td class="center" class="numeric"><?php echo $row_con1['modal'];?></td>
                                    <td class="center" class="numeric"><?php echo $row_selectcat['innerwidth'];?></td> 
                                    <td class="center" class="numeric"><?php echo $row_selectcat['innerheight'];?></td> 
                                    <td class="center" class="numeric"><?php echo $row_selectcat['sensor'];?></td> 
                                    <td class="center" class="numeric">
                                      <form action="" method="POST" enctype="multipart/form-data">
                                        <input required type="file" name="picture" class="form-control" style="width: 36%;">
                                          <input type="hidden" name="id" class="form-control" value="<?php echo $row_con1['id'];?>">
                                          <input type="hidden" name="brand" class="form-control" value="<?php echo $row_con1['brand'];?>">
                                          <input type="hidden"  name="brand_Model" class="form-control" value="<?php echo $row_con1['modal'];?>">
                                          <button type="submit" class="btn btn-info" name="upload" style="">Upload Image</button> 
                                        </form>  
                                    </td>  
                                </tr>


                              <?php } }  }?>
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

