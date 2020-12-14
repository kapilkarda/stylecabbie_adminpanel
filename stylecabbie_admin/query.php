<?php 
include'db.php';
$method =  mysqli_real_escape_string($con,$_REQUEST['method']);
if($method=="1"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM product WHERE product_id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}
	if($method=="2"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM area WHERE area_id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="3"){
			echo "string";exit();
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);
		$myquery=mysqli_query($con,"SELECT * FROM category WHERE cat_id='$id'");
		if($rowProduct = mysqli_fetch_array($myquery)){
            $type = $rowProduct['type'];
		}
		if($type=='Normal'){
			$myquery=mysqli_query($con,"SELECT * FROM product WHERE cat_id='$id'");
			$row1=mysqli_num_rows($myquery);
			if ($row1>0) {
				 echo "<script>alert('login successfull');</script>";
				 echo "<script>window.location='category1.php';</script>";
			}else{
				$sql = mysqli_query($con,"DELETE FROM category WHERE cat_id='$id'"); 
			}
		}else if($type=='Custom'){
			$myquery=mysqli_query($con,"SELECT * FROM customProductImage WHERE cat_id='$id'");
			$row1=mysqli_num_rows($myquery);
			if ($row1>0) {
				 echo'  <script type="text/javascript"> alert("Product available in category!");</script>';
				 echo "<script>window.location='category.php';</script>";
			}else{
				$sql = mysqli_query($con,"DELETE FROM category WHERE cat_id='$id'"); 
			}
		}else if($type=='Daily-Dhamka'){
			$myquery=mysqli_query($con,"SELECT * FROM daily_dhamaka WHERE cat_id='$id'");
			$row1=mysqli_num_rows($myquery);
			if ($row1>0) {
				 echo'  <script type="text/javascript"> alert("Product available in category!");</script>';
				 echo "<script>window.location='category.php';</script>";
			}else{
				$sql = mysqli_query($con,"DELETE FROM category WHERE cat_id='$id'"); 
			}
		}

		

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="4"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM notification WHERE n_id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="5"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM colour WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="6"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM size WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="7"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM customProductImage WHERE customProductImage_id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="8"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM custom_image_product WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="9"){
		
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);
		$product_id =  mysqli_real_escape_string($con,$_REQUEST['product_id']);

		$sub_record1 = mysqli_query($con, "SELECT * FROM `product` WHERE product_id='$product_id'");
        $fetch_record1 = mysqli_fetch_array($sub_record1);
        $images=$fetch_record1['images'].'<br>';
        $id=','.$id;
        $result=str_replace($id, "",$images);

        $sql1 ="UPDATE `product` SET  images='$result' where product_id='$product_id'";
        $query = mysqli_query($con, $sql1); 

		$sql = mysqli_query($con,"DELETE FROM product_image WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="10"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM daily_dhamaka WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="11"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM daily_dhamaka_image WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="12"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM slider WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="13"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM mobileprint WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if(isset($_POST['brand'])){
	$brand=$_POST['brand'];

	$model_query = mysqli_query($con, "SELECT * FROM cover_sub_category WHERE `cat_id`='$brand' ");
	echo '<option value="">Select Model</option>';
	while($row_model = mysqli_fetch_array($model_query)){

	echo '<option value="'. $row_model['name'].'">'.$row_model['name'].'</option>';
	}
	}

	if($method=="updateMobileStatus"){
		$status =  $_GET['status'];
		$id     =  $_GET['id'];
		$sql = mysqli_query($con,"UPDATE `cover_sub_category` SET `status`='$status' WHERE `id`='$id'");

		if($sql)
		{

		echo '<script>window.location.href="mobilecover.php";</script>';

		}else
		{

		echo '<script>window.location.href="mobilecover.php";</script>';

		}
	}
	if($method=="reEditImage"){
		$order_id     =  $_GET['id'];
		$result=mysqli_query($con,"DELETE from `mobileprint` WHERE `order_id`='".$order_id."'");
             $mobileResult=mysqli_query($con,"UPDATE customorder SET status='23' WHERE customorder_id='".$order_id."'");

		if($mobileResult)
		{

		echo '<script>window.location.href="printed_mobile_cover_images.php";</script>';

		}else
		{

		echo '<script>window.location.href="printed_mobile_cover_images.php";</script>';

		}
	}

	if($method=="14"){
		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM sleeves WHERE id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}

	if($method=="15"){

		$id =  mysqli_real_escape_string($con,$_REQUEST['id']);

		$sql = mysqli_query($con,"DELETE FROM inventory_product WHERE product_id='$id'"); 

		if($sql)
		{

		echo "Successfully Delete.";

		}else
		{

		echo "Please Try Later.";

		}
	}
?>