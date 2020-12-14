<?php 
include'db.php';
$id=$_GET['id'];

		
		$myquery=mysqli_query($con,"SELECT * FROM subcategory WHERE sub_id='$id'");
		if($rowProduct = mysqli_fetch_array($myquery)){
            $cat_name = $rowProduct['name'];
		}
		
			$myquery=mysqli_query($con,"SELECT * FROM product WHERE Sub_cat_id='$id'");
			$row1=mysqli_num_rows($myquery);
			if ($row1>0) {
				  echo' <script type="text/javascript"> alert("Product available in '.$cat_name.' Sub Category!");</script>';
				 echo "<script>window.location='subcategory.php';</script>";
			}else{
				$sql = mysqli_query($con,"DELETE FROM subcategory WHERE sub_id='$id'"); 
			}
		

		

		if($sql)
		{
			echo'  <script type="text/javascript"> alert("Sub Category delete Successfully!");</script>';
			echo "<script>window.location='subcategory.php';</script>";

		}else
		{

		    echo'  <script type="text/javascript"> alert("Sorry not delete category!");</script>';
			echo "<script>window.location='category.php';</script>";

		}

		



	?>