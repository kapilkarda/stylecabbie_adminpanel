
<?php include('db.php');
 include('header.php');
 if(isset($_POST['user']))
     {
        $company=$_POST['company'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $job_title=$_POST['job_title'];
        $email=$_POST['email'];
        $city=$_POST['city'];
        $state=$_POST['state'];
        $country=$_POST['country'];
        $zip=$_POST['zip'];
        $date12=$_POST['date'];
        $time=date("H:i:s");
        $date=$date12.$time;
        $badge=rand();
       
     
           $query = mysqli_query($con,"INSERT INTO `user`(`badgeId`, `company_name`, `fname`, `lname`, `job_title`, `email`, `city`, `state`, `zip`, `country`, `date_captured`) VALUES ('$badge','$company','$fname','$lname','$job_title','$email','$city','$state','$zip','$country','$date')");
             if($query)
                {
                   //header("location:user.php");
                }
                else{
                     echo "try latter";
                     }
       }

       if(isset($_POST['update']))
     {
        $id1=$_POST['id1'];
        $company1=$_POST['company1'];
        $fname1=$_POST['fname1'];
        $lname1=$_POST['lname1'];
        $job_title1=$_POST['job_title1'];
        $email1=$_POST['email1'];
        $city1=$_POST['city1'];
        $state1=$_POST['state1'];
        $country1=$_POST['country1'];
        $zip1=$_POST['zip1'];
        $date12=$_POST['date1'];
        $time1=date("H:i:s");
        $date1=$date12.$time1;
       
       
     
           $query = mysqli_query($con,"UPDATE `user` SET `company_name`='$company1',`fname`='$fname1',`lname`='$lname1',`job_title`='$job_title1',`email`='$email1',`city`='$city1',`state`='$state1',`zip`='$zip1',`country`='$country1',`date_captured`='$date1' WHERE id='$id1'");
             if($query)
                {
                   //header("location:user.php");
                }
                else{
                     echo "try latter";
                     }
       }
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
    </style>
       <!-- Start : Side bar -->
         <?php include('sidebar.php'); ?>            
       <!-- End : Side bar -->

        <div id="content">  <!-- Start : Inner Page Content -->

            <div class="container"> <!-- Start : Inner Page container -->

                <div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li class="current">Participants</li>
                    </ul>

                </div>  <!-- End : Breadcrumbs -->

                <div class="page-header">   <!-- Start : Page Header -->
                    <div class="page-title">
                        <h3>Participants</h3>
                    </div>
                </div>  <!-- End : Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption"><i class="fa fa-table"></i> Participants Details</div>
                                                                
                                <div class="actions">
                                    <div class="btn-group">
                                       <!--  <a class="btn mini green" href="#" data-toggle="modal" 
                               data-target="#basicModal" >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Participants 
                                        </a> -->
                                        <a class="btn mini green" href="add.php"  >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Participants 
                                        </a>
                                       
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            
                                        <th class="numeric">Badge ID Numbers</th>
                                            <th class="numeric">Company</th>
                                            <th class="numeric">First Name</th>
                                            <th class="numeric">Last Name</th>
                                            <th class="numeric">Job Title</th>
                                            <th class="numeric" style="word-wrap: break-word">Email</th>
                                            <th class="numeric">City</th>
                                            <th class="numeric">State</th>
                                             <th class="numeric"> Zip</th>
                                              <th class="numeric">Country</th>
                                            <th class="numeric">Date Captured</th>

                                           <th class="numeric">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php $sql_con = mysqli_query($con,"SELECT * FROM user order by id desc");
                             $count = 0;
                             while($row_con = mysqli_fetch_array($sql_con))
                             { 
                                $count=$count+1;
                                $cid=$row_con['id'];
                                // $date = date_create($row_con['date_captured']);
                                // $dobb=date_format($date, 'Y-m-d H:i:s');
                               ?>
                               <tr id='trrow".$row_con['id']."' >
                                
                                 <td class="center" class="numeric"><?php echo $row_con['badgeId'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['company_name'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['fname'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['lname'];?></td>
                                  <td class="center" class="numeric"><?php echo $row_con['job_title'];?></td>
                                  <td class="center"  width="10%"><div style="word-wrap: break-word!important;background-color: white;width: 90px;"><?php echo $row_con['email'];?></div></td>
                                      <td class="center" class="numeric"><?php echo $row_con['city'];?></td>
                                         <td class="center" class="numeric"><?php echo $row_con['state'];?></td>
                                            <td class="center" class="numeric"><?php echo $row_con['zip'];?></td>
                                               <td class="center" class="numeric"><?php echo $row_con['country'];?></td>
                                <td class="center" class="numeric"><div style="word-wrap: break-word!important;background-color: white;width: 90px;"><?php echo $row_con['date_captured'];?></div></td>
                                
                                <td class="numeric">
                                    <a class='btn btn-info' href='edit.php?id=<?php echo $row_con['id'];?>' style='width:100%;' title='Edit' ><i class='mdi-content-create' style='margin-left:-10px;' >Edit</i></a>

                                <a class='btn btn-danger' href='javascript:void(0);' title='Delete' style='width:100%;' onclick='delete_user(<?php echo $row_con['id'];?>);' ><i class='mdi-action-delete' style='margin-left:-10px;'>Delete</i></a>

                               
                                </td>
                               </tr>
                               <?php }?>
                            <!--  <a class='btn btn-info' onclick='edit_user(<?php echo $row_con['id'];?>);' style='width:100%;' title='Edit' ><i class='mdi-content-create' style='margin-left:-10px;' >Edit</i></a> -->
                                         <!--  <a class='btn btn-info' onclick='edit_user();' style='width:30%;' title='Edit' ><i class='mdi-content-create' style='margin-left:-10px;' >Edit</i></a> -->
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

      <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn pull-right" data-dismiss="modal">Close</button>
             <form class="form-horizontal row-border" id="validate-1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" validate="validate">
            <h4 class="modal-title" id="myModalLabel">Add User</h4>
            </div>
            <div class="modal-body">
              <label>Company</label>
                <input type="text" name="company" id="company" placeholder="enter Company" class="form-control" required >
            </div>
            
            <div class="modal-body">
              <label>First Name</label>
                <input type="text" name="fname" id="fname" placeholder="enter fname" class="form-control" required >
            </div>
             <div class="modal-body">
              <label>Last Name</label>
                <input type="text" name="lname" id="lname" placeholder="enter lname" class="form-control" required >
            </div>

             <div class="modal-body">
              <label>Job Title</label>
                <input type="text" name="job_title" id="job_title" placeholder="enter job_title" class="form-control" required >
            </div>

            <div class="modal-body">
              <label>Email</label>
                <input type="email" name="email" id="email" placeholder="enter Email" class="form-control" required >
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://iamrohit.in/lab/js/location.js"></script>
                                    
            <div class="modal-body">
              <label>Country</label>
                <select name="country" class="countries form-control" id="countryId">
                                        <option value="">Select Country</option>
                                            </select>
            </div>

             <div class="modal-body">
              <label>State</label>
               <select name="state" class="states form-control" id="stateId">
                                            <option value="">Select State</option>
                                            </select>
            </div>

             <div class="modal-body">
              <label>City</label>
               <select name="city" class="cities form-control" id="cityId">
                                            <option value="">Select City</option>
                                            </select>
            </div>
            
            <!-- <div class="modal-body">
              <label>Gender</label>
                Male<input type="checkbox" name="gender" id="gender" placeholder="Enter Gender" value="male" >
                 FeMale<input type="checkbox" name="gender" id="gender" placeholder="Enter Gender" value="female" >

            </div> -->

            <div class="modal-body">
              <label>ZipCode</label>
                <input type="text" name="zip" id="zip" placeholder="enter ZipCode" class="form-control" required >
            </div>
             <div class="modal-body">
              <label>Date Captured</label>
                <input type="date" name="date" id="date" placeholder="Enter Date Captured"  class="form-control" required>
                

            </div>
             
         <div class="modal-footer">
              
              
               <input type="submit" value="Submit" name="user" class="btn"/>
        </div>
   
    </form>

    </div>
  </div>
</div>
      <!-- =====modal box===== -->

      <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn pull-right" data-dismiss="modal">Close</button>
             <form class="form-horizontal row-border" id="validate-1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" validate="validate">
            <h4 class="modal-title" id="myModalLabel">UPDATE</h4>
            </div>
             <div class="modal-body">
           
                <input type="hidden" name="id1" id="id2" placeholder="enter id" class="form-control" >
            </div>
                       <div class="modal-body">
              <label>Company</label>
                <input type="text" name="company1" id="company2" placeholder="enter Company" class="form-control" required >
            </div>
            
            <div class="modal-body">
              <label>First Name</label>
                <input type="text" name="fname1" id="fname2" placeholder="enter fname" class="form-control" required >
            </div>
             <div class="modal-body">
              <label>Last Name</label>
                <input type="text" name="lname1" id="lname2" placeholder="enter lname" class="form-control" required >
            </div>

             <div class="modal-body">
              <label>Job Title</label>
                <input type="text" name="job_title1" id="job_title2" placeholder="enter job_title" class="form-control" required >
            </div>

            <div class="modal-body">
              <label>Email</label>
                <input type="email" name="email1" id="email2" placeholder="enter Email" class="form-control" required >
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://iamrohit.in/lab/js/location.js"></script>
                                    
            <div class="modal-body">
              <label>Country</label>
                <select name="country1" class="countries form-control" id="country2" onchange="edit_country(this.value);">
                                        <option value="">Select Country</option>
                                            </select>
            </div>

             <div class="modal-body">
              <label>State</label>
               <!-- <select name="state1" class="states form-control" id="state2">
                                            <option value="">Select State</option>
                                            </select> -->
              <input type="text" name="state1" class="states form-control" id="state2">

            </div>

             <div class="modal-body">
              <label>city</label>
               <!-- <select name="city1" class="cities form-control" id="city2">
                                            <option value="">Select City</option>
                                            </select> -->
                      <input type="text" name="city1" class="cities form-control" id="city2">
            </div>
            
            <!-- <div class="modal-body">
              <label>Gender</label>
                Male<input type="checkbox" name="gender" id="gender" placeholder="Enter Gender" value="male" >
                 FeMale<input type="checkbox" name="gender" id="gender" placeholder="Enter Gender" value="female" >

            </div> -->

            <div class="modal-body">
              <label>ZipCode</label>
                <input type="text" name="zip1" id="zip2" placeholder="enter ZipCode" class="form-control" required >
            </div>
             <div class="modal-body">
              <label>Date Captured</label>
                <input type="date" name="date1" id="date2" placeholder="Enter Date Captured"  class="form-control" required>
                

            </div>
             
           
            <div class="modal-footer">
      
               <input type="submit" value="Submit" name="update" class="btn"/>
        </div>
         </form>
    </div>
  </div>
</div>
      <!-- =====end modal box===== -->
        </body>  

</html>
<script>

     function edit_user(id){
            jQuery.ajax({
                  type:'POST',
                  url:'query.php',
                  data:'method=4&id='+id,
                  success:function(res){
                       $('#edit_user').modal("show");

                      var jsonData = JSON.parse(res);
                      console.log(jsonData);
                      document.getElementById('id2').value =jsonData.edit_user.id1;
                      document.getElementById('company2').value =jsonData.edit_user.company1;
                      document.getElementById('fname2').value =jsonData.edit_user.fname1;
                      document.getElementById('lname2').value = jsonData.edit_user.lname1;
                      document.getElementById('job_title2').value = jsonData.edit_user.job_title1;
                      document.getElementById('email2').value = jsonData.edit_user.email1;
                       
                       ;
                    document.getElementById('country2').value = jsonData.edit_user.country1;
                    document.getElementById('state2').value = jsonData.edit_user.state1;
                      //alert(jsonData.edit_user.state1);
                 
                    document.getElementById('city2').value = jsonData.edit_user.city1;
                      //alert(jsonData.edit_user.city1);
                    document.getElementById('zip2').value = jsonData.edit_user.zip1;
                      document.getElementById('date2').value = jsonData.edit_user.date1;

                    
                  }
              });
      }
// function edit_country(value)
// {
//   $.ajax{(

//     type:'POST',
//     url:'state.php',
//     data:'value='+value,
//     success:function(html)
//     {
//       $('.states').html(html);
//     }
//     )};
// }
    function delete_user(id){

            var result= confirm("Are you really want Delete This Participants?");

            if(result==true){

                $.ajax({

                    type:'POST',

                    url:'query.php',

                    data:'method=1&id='+id,

                    success:function(res){

                        alert(res);

                        location.reload(); 

                    }

                });

            }

        }

</script>
<?php include('footer.php');?>