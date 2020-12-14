<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
   if(!(isset($_SESSION['id'])))
   {
      header("location:index.php");
   }
   
include('db.php'); 

   ?>
 <style type="text/css">@media only screen and (max-width: 800px) {
  #unseen table td:nth-child(2), 
  #unseen table th:nth-child(2) {display: none;}
}
@media only screen and (max-width: 640px) {
  #unseen table td:nth-child(4),
  #unseen table th:nth-child(4),
  #unseen table td:nth-child(7),
  #unseen table th:nth-child(7),
  #unseen table td:nth-child(8),
  #unseen table th:nth-child(8){display: none;}
}
td {
    word-wrap:break-word!important;
}
.dataTables_filter{
  text-align: right;
}
    </style>
         <?php include('header.php');
               include('sidebar.php'); ?>            
       <!-- End : Side bar -->
        <div id="content">  <!-- Start : Inner Page Content -->
            <div class="container"> <!-- Start : Inner Page container -->
                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="current">Mobile Cover Detail</li>
                    </ul>
                </div>  <!-- End : Breadcrumbs -->
                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Mobile Cover Detail</h3>
                    </div>
                </div>  <!-- End : Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i>Mobile Cover Detail</div>                               
                                <div class="actions">
                                    <div class="btn-group">
                                      <a class="btn mini green" href="add_mobileCover.php" >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Mobile Cover Size
                                        </a>    
                                       </div>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover DynamicTable">
                                    <thead>
                                        <tr>
                                            <th class="numeric">Id</th>
                                            <th class="numeric">Brand</th>
                                            <th class="numeric">Model</th>
                                            
                                            <th class="numeric">Status</th>
                                            <th class="numeric">width</th>
                                            <th class="numeric">height</th>
                                            <th class="numeric">Sensor</th>
                                            <th class="numeric">Active Status</th>
                                            <th class="numeric">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php  $sql_con = mysqli_query($con,"SELECT * FROM cover_sub_category ORDER BY id ASC ");
                                      $i=0;
                                      while($row_con = mysqli_fetch_array($sql_con)) {
                                      $i++; 
                                      ?>
                               <tr id='trrow".$row_con['id']."' >
                                 <td class="center" class="numeric"><?php echo $i;?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['cat_id'];?></td>
                                 <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['status'];?>
                                  <td class="center" class="numeric"><?php echo $row_con['innerwidth'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['innerheight'];?>
                                  <td class="center" class="numeric"><?php echo $row_con['sensor'];?></td>
                                  <td> <center>  <?php if($row_con['status']=='1'){?>
                                     <a href="query.php?status=0&id=<?php echo $row_con['id'];?>&method=updateMobileStatus"><button class='btn btn-danger'  value="0">In Active</button>
                                   </a>
                                  <?php }elseif($row_con['status']=='0'){?>
                                      <a href="query.php?status=1&id=<?php echo $row_con['id'];?>&method=updateMobileStatus"><button class='btn btn-success' id="change_sed<?php echo $row_con['id'];?>" value="1">Active</button></a></center>
                                  <?php }?></td>
                                  <td >

                                    <a class='btn btn-info' title='student' href="edit_mobileCover.php?id=<?php echo $row_con['id'];  ?>"><i class='mdi-content-create'>Edit</i></a>
                                    <a class='btn btn-info' title='student' href="editMobileCoverStock.php?id=<?php echo $row_con['id'];  ?>"><i class='mdi-content-create'>Edit Stock</i></a>
                                    
                                 
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
    </div>  <!-- End : container -->
    <!-- =====modal box===== -->
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
      function changeStatusCus(status,id){
        alert(status);
        alert(id);
        var result= confirm("Are you really want change status?");
        if(result==true){
          $.ajax({
            type:'GET',
            url: "query.php",
            data: "status="+status+"&id="+id+"&method=updateMobileStatus",
            success: function(response){
               console.log(response);
              if (response=='1') {
                 document.getElementById('change_s'+id).style.visibility = 'hidden';
                document.getElementById('change_sed'+id).style.visibility = 'visible';
                // console.log('done');
             // location.reload();
              } else{
                alert('Status not update');
              }
            }
          });
        }
      }
    </script>
        </body>  

</html>