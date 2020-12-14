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
                        <li class="current">Sub Category Detail</li>
                    </ul>
                </div>  <!-- End : Breadcrumbs -->
                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Sub Category Detail</h3>
                    </div>
                </div>  <!-- End : Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i>Sub Category Detail</div>                               
                                <div class="actions">
                                    <div class="btn-group">
                                      <a class="btn mini green" href="add_subcategory.php" >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Sub Category
                                        </a>    
                                       </div>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover DynamicTable">
                                    <thead>
                                        <tr>
                                            <th class="numeric">Id</th>
                                            <th class="numeric">Category</th>
                                            <th class="numeric">Name</th>
                                            <th class="numeric">Photo</th>
                                            <th class="numeric">Satus</th>
                                            <th class="numeric">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php  $sql_con = mysqli_query($con,"SELECT * FROM subcategory ORDER BY `sub_id` ASC ");
                                      while($row_con = mysqli_fetch_array($sql_con)) { 
                                      ?>
                                 
                               <tr id='trrow".$row_con['id']."' >
                                 <td class="center" class="numeric"><?php echo $row_con['sub_id'];?></td>
                                 <td class="center" class="numeric">

                                   <?php  $sql_con1 = mysqli_query($con,"SELECT * FROM category WHERE `cat_id`='".$row_con['cat_id']."'");
                                      while($row_con1 = mysqli_fetch_array($sql_con1)) { 
                                      ?>
                                  <?php if($row_con1['cat_id']==$row_con['cat_id']){echo $row_con1['cat_name'] ;}}?>
                                    
                                  </td>
                                 <td class="center" class="numeric"><?php echo $row_con['name'];?></td>
                                 <td class="center" class="numeric">
                                    <?php if(!empty($row_con['image'])){?>
                                    <center><img src="<?php echo $row_con['image'];?>"  style="height: 100px;width: 100px;"></center>
                                  <?php }else{echo '';}?>
                                  </td>
                                 <td class="center" class="numeric"><?php echo $row_con['status'];?></td>
                                  
                                <!--  <td class="center" class="numeric"><?php echo $row_con['url'];?></td> -->
                                 
                                  <td class="center" class="numeric">
                                    <a class='btn btn-info' title='student' href="edit_subcategory.php?id=<?php echo $row_con['sub_id'];  ?>"><i class='mdi-content-create'>Edit</i></a>
                                    <a class='btn btn-danger' href="subcategorydelete.php?id=<?php echo  $row_con['sub_id']?>"  title='Delete'><i class='mdi-content-create'>Delete</i></a>
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
     function delete_user(id){
            var result= confirm("Are you really want delete this Product?");
            if(result==true){
                $.ajax({
                    type:'POST',
                    url:'query.php',
                    data:'method=3&id='+id,
                    success:function(res){
                     location.reload(); 
                    }
                });
            }
     }
</script>
        </body>  

</html>