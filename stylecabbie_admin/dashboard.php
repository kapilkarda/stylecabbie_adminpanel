<?php 
  error_reporting(E_ALL); ini_set('display_errors', 1);
  date_default_timezone_set('Asia/Calcutta'); 
  if(!isset($_SESSION)){ 
    session_start(); 
  }
  if(!(isset($_SESSION['id']))){
      header("location:index.php");
  }
  include('db.php'); 
?>
<style type="text/css">
  @media only screen and (max-width: 800px) {
    #unseen table td:nth-child(2), 
    #unseen table th:nth-child(2) {display: none;}
  }
  td {
      word-wrap:break-word!important;
  }
</style>
<?php include('header.php');
  include('sidebar.php'); ?>            
  <div id="content">  <!-- Start : Inner Page Content -->
    <div class="container"> <!-- Start : Inner Page container -->
      <div class="crumbs">    <!-- Start : Breadcrumbs -->
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="current">Stylecabbie</li>
        </ul>
      </div>  
      <div class="row">
        <div class="col-sm-12">
          <div class="page-header">
            
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="order.php?order_type=&status=&date=&btn_search=">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $query=mysqli_query($con,"SELECT * FROM `order`");
                        $cunt=mysqli_num_rows($query);?>
                        <?php echo  $cunt;?>
                      </div>
                      <div class="desc">               
                      Total Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="product.php">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $date=date('Y/m/d');
                        $querytoday=mysqli_query($con,"SELECT * FROM `order` WHERE date(`order_date`)='$date' "); 
                        $querytodaycunt=mysqli_num_rows($querytoday);?>
                        <?php echo  $querytodaycunt;?>
                      </div>
                      <div class="desc">               
                        Today order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="product.php">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php

                        $date=date("Y/m/d", strtotime( '-1 days' ) );
                        $querytoday=mysqli_query($con,"SELECT * FROM `order` WHERE date(`created_at`)='$date'"); 
                        $querytodaycunt=mysqli_num_rows($querytoday);?>
                        <?php echo  $querytodaycunt;?>
                      </div>
                      <div class="desc">               
                        Yesterday order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=0">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Pendingquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='0'");
                        $Pendingcunt=mysqli_num_rows($Pendingquery);?>
                        <?php echo  $Pendingcunt;?>
                      </div>
                      <div class="desc">               
                      Pending Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
        <!--     <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=1">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Confirmquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='1'");
                        $Confirmcunt=mysqli_num_rows($Confirmquery);?>
                        <?php echo  $Confirmcunt;?>
                      </div>
                      <div class="desc">               
                      COD Confirm Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=9">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $SPConfirmquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='9'");
                        $SPConfirmcunt=mysqli_num_rows($SPConfirmquery);?>
                        <?php echo  $SPConfirmcunt;?>
                      </div>
                      <div class="desc">               
                      SP Confirm Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=10">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $NAConfirmquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='10'");
                        $NAConfirmcunt=mysqli_num_rows($NAConfirmquery);?>
                        <?php echo  $NAConfirmcunt;?>
                      </div>
                      <div class="desc">               
                      NA Confirm Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=11">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $INDConfirmquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='11'");
                        $INDConfirmcunt=mysqli_num_rows($INDConfirmquery);?>
                        <?php echo  $INDConfirmcunt;?>
                      </div>
                      <div class="desc">               
                      IND Confirm Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=7">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Confirmquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='7'");
                        $Confirmcunt=mysqli_num_rows($Confirmquery);?>
                        <?php echo  $Confirmcunt;?>
                      </div>
                      <div class="desc">               
                      Not connected
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=3">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat yellow">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Inprocessquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='3'");
                        $Inprocesscunt=mysqli_num_rows($Inprocessquery);?>
                        <?php echo  $Inprocesscunt;?>
                      </div>
                      <div class="desc">               
                      SP Delivered Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=12">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat yellow">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Inprocessquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='12'");
                        $Inprocesscunt=mysqli_num_rows($Inprocessquery);?>
                        <?php echo  $Inprocesscunt;?>
                      </div>
                      <div class="desc">               
                      DTDC Delivered Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=2">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Deliveredquery1=mysqli_query($con,"select * from `order` WHERE `status`='2'"); 
                        $Deliveredcunt1=mysqli_num_rows($Deliveredquery1);?>
                        <?php echo  $Deliveredcunt1;?>
                      </div>
                      <div class="desc">               
                       COD Delivered Order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=4">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                    <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Cancelquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='4'");
                        $Cancelcunt=mysqli_num_rows($Cancelquery);?>
                        <?php echo  $Cancelcunt;?>
                      </div>
                      <div class="desc">               
                      Cancel order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=5">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Returnquery1=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='5'"); 
                        $Returncunt1=mysqli_num_rows($Returnquery1);?>
                        <?php echo  $Returncunt1;?>
                      </div>
                      <div class="desc">               
                       COD Return order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=8">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat yellow">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Returnquery11=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='8'"); 
                        $Returncunt11=mysqli_num_rows($Returnquery11);?>
                        <?php echo  $Returncunt11;?>
                      </div>
                      <div class="desc">               
                       SP Return order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderfailed.php">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $OnlineCancelquery=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='0' and order_type='OnlinePayment' and `txnid`='' "); 
                        $OnlineCancelquerycunt=mysqli_num_rows($OnlineCancelquery);?>
                        <?php echo  $OnlineCancelquerycunt;?>
                      </div>
                      <div class="desc">               
                        Online Failed
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="orderstatus.php?status=6">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $Paymentquery1=mysqli_query($con,"SELECT * FROM `order` WHERE `status`='6'"); 
                        $Paymentcunt1=mysqli_num_rows($Paymentquery1);?>
                        <?php echo  $Paymentcunt1;?>
                      </div>
                      <div class="desc">               
                        COD Payment order
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div> -->
            
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="product.php">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat red">
                    <div class="visual">
                      <i class="fs-user-2"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $query1=mysqli_query($con,"select * from product"); 
                        $cunt1=mysqli_num_rows($query1);?>
                        <?php echo  $cunt1;?>
                      </div>
                      <div class="desc">               
                        Product
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4" style="margin-top: 20px;">
              <a class="more" href="userlist.php">
                <div class="col-md-6 col-md-12">
                  <div class="dashboard-stat blue">
                    <div class="visual">
                      <i class="fs-user-4"></i>
                    </div>
                    <div class="details">
                      <div class="number">
                        <?php
                        $userquery1=mysqli_query($con,"SELECT * FROM `user`"); 
                        $usercunt1=mysqli_num_rows($userquery1);?>
                        <?php echo  $usercunt1;?>
                      </div>
                      <div class="desc">               
                        Users
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <a href="javascript:void(0);" class="scrollup">Scroll</a>
      </div>
    </div>
  </div>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
<script type="text/javascript" src="assets/plugins/common/jquery.event.move.js"></script>
<script type="text/javascript" src="assets/plugins/common/lodash.compat.js"></script>
<script type="text/javascript" src="assets/plugins/common/respond.min.js"></script>
<script type="text/javascript" src="assets/plugins/common/excanvas.js"></script>
<script type="text/javascript" src="assets/plugins/common/breakpoints.js"></script>
<script type="text/javascript" src="assets/plugins/common/touch-punch.min.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script>
  $(document).ready(function(){
      App.init();
      DataTabels.init();
  });        
</script>
<script>
 function edit_user(id){
  jQuery.ajax({
    type:'POST',
    url:'query.php',
    data:'method=18&id='+id,
    success:function(res){
      $('#edit_user').modal("show");
      var jsonData = JSON.parse(res);
      console.log(jsonData);
      document.getElementById('id2').value =jsonData.edit_user.id1;
      document.getElementById('title2').value =jsonData.edit_user.title1;
      document.getElementById('description2').value =jsonData.edit_user.description1;
      document.getElementById('date2').value = jsonData.edit_user.date1;
      document.getElementById("imgid").src   = jsonData.edit_user.dateimg;
      document.getElementById('myfile').value= jsonData.edit_user.dateimg;
    }
    });
  }
  function delete_user(id){
    var result= confirm("Are you really want delete this sub category?");
    if(result==true){
      $.ajax({
          type:'POST',
          url:'query.php',
          data:'method=2&id='+id,
          success:function(res){
           location.reload(); 
          }
      });
    }
 }
</script>