<?php
include'db.php';
if(isset($_POST['value'])){
			$cat_id=$_POST['value'];
			 $sql = "SELECT * FROM subcategory WHERE `cat_id`='".$cat_id."'";
                  $query1=mysqli_query($con, $sql);
                 $row1=mysqli_num_rows($query1);
                 if ($row1) {
					echo'<div class="form-group has-success col-md-8" >
					<label class="control-label" for="inputSuccess1">Select Sub category<span style="color:red;">*</span></label>
					<select class="form-control" id="type123" name="subcategory" required >
					<option value="">Select category</option>';
                      $sql = "SELECT * FROM subcategory WHERE `cat_id`='".$cat_id."'";
                      $result = mysqli_query($con,$sql);
                      while($row = mysqli_fetch_assoc($result)) {
                     
	                  echo '<option value="'. $row['sub_id'].'">'.$row['name'].'</option>';
	                     } 
	                 echo '</select>
	                 </div>';
		         }else{
		         	echo " ";
		         }

}

?>