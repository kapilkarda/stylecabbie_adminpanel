
<?php
//database config file
include_once 'db.php'; 
if(isset($_POST['state_id']))
{
 
 //get state list
$sql = mysqli_query($con, "SELECT * FROM `cities` WHERE `state_id`='".$_POST['state_id']."'");
 
//check for rows
if(mysqli_num_rows($sql)>0)
{
	while($city=mysqli_fetch_array($sql))
	{ ?>
	<option  value ='<?php echo $city['city_id']; ?> '><?php echo $city['city_name']; ?> </option>
    <?php 
    }
       
} 
else
{
 echo '<option value="">Cities not available</option>';
}
}
 
 //when state id in post
if(isset($_POST['mobile']) && !empty($_POST['mobile'])){
    //get all user data acc to mobile
	$sql = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  `order` WHERE `mobile`='".$_POST['mobile']."' LIMIT  1"));
	$sql1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  `states` WHERE `state_id`='".$sql['state_id']."' "));
	$sql2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  `cities` WHERE `city_id`='".$sql['city_id']."' "));
	// print_r($sql);
	if ($sql) {
		$data= array('name' =>$sql['name'] ,'email' =>$sql['email'] ,'address' =>$sql['address'] ,'pincode' =>$sql['pin_code'],'state' =>$sql1['state_id'] ,'city' =>$sql2['city_id'],'city_name' =>$sql2['city_name'] ,'status' =>'true'  );
	}else{
		$data = array('status' => 'false');
	}
	echo json_encode($data);
}

?>
