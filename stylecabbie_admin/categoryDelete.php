<?php 
include'db.php';
$id=$_GET['id'];

		
		$myquery=mysqli_query($con,"SELECT * FROM category WHERE cat_id='$id'");
		if($rowProduct = mysqli_fetch_array($myquery)){
            $type = $rowProduct['type'];
            $cat_name = $rowProduct['cat_name'];
		}
		if($type=='Normal'){
			$myquery=mysqli_query($con,"SELECT * FROM product WHERE cat_id='$id'");
			$row1=mysqli_num_rows($myquery);
			if ($row1>0) {
				  echo' <script type="text/javascript"> alert("Product available in '.$cat_name.' Category!");</script>';
				 echo "<script>window.location='category.php';</script>";
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
			echo'  <script type="text/javascript"> alert("Category delete Successfully!");</script>';
			echo "<script>window.location='category.php';</script>";

		}else
		{

		    echo'  <script type="text/javascript"> alert("Sorry not delete category!");</script>';
			echo "<script>window.location='category.php';</script>";

		}


	?>