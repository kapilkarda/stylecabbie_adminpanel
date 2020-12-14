<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php 
			error_reporting(E_ALL); ini_set('display_errors', 1);
			if(!isset($_SESSION)) { 
			        session_start(); 
			}
  			include('db.php');
		   if(!(isset($_SESSION['id']))){
		      header("location:index.php");
		   }
		   if (isset($_POST['btn_add'])){
		    $print=explode(",", $_POST['print']);
		    foreach ($print as $value) {
		      $sql=mysqli_query($con,"SELECT * FROM `order` o,`states` s,`cities` c  where order_id='$value' and o.state_id=s.state_id and o.city_id=c.city_id");
		    $printData=mysqli_fetch_array($sql);date_default_timezone_set('Asia/Calcutta');
  				$date=date('Y-m-d'); ?>
		<div class="container" style="width: 100%; height:349px; border: 1px solid;">
		    <div class="row">
		    	<div class="col-md-12" style="text-align: center;"><img style="width: 200px;margin-top: 7px;" src="img/mahakaal logo.png"></div>
				<div class="col-md-12" >
					<div style="float: left;width:100%;height: 230px;">
						<strong><font size=4>To,</font></strong>
						<p><strong><font size=4>Name: </strong><?php echo $printData['name'];?></font></p>
						    <p><strong><font size=4>Address: </strong><?php echo $printData['address'];?></font></p>
						    <p style="float: left;margin-right: 21px;"><strong><font size=4>City: </strong><?php echo $printData['city_name'];?>
						    <p style="float: left;margin-right: 21px;"><strong><font size=4>State: </strong><?php echo $printData['state_name'];?></font></p>
						    <p><strong><font size=4>Pin code: </strong><?php echo $printData['pin_code'];?></font></p>
						    <p><strong><font size=4>Customer Mobile No.: </strong> <?php echo $printData['mobile'];?></font></p>
					</div>
					<!-- <span style="position: absolute;top: 20px;right: 50px;"><img src="img/mahakaal logo.png" style="width: 100px;"> -->
					</span>
				</div>
				<!-- <div class="col-md-3">
					
				</div> -->
			</div>
			<div class="row" style="border-top: solid;">
				<div class="col-md-12" >
					<div>
						<strong><font size=4>From,</font></strong>
					</div>
					    <p style="float:left;margin-left: 60px;"><strong>MAHAKAAL STORE (www.mahakaalstore.com) </strong></font></p>
						<p><strong> Mobile No.: </strong> 8085305205</p>
				</div>
			</div>
		</div>
		          
		<?php 
		   }
		 }
		?>
		
			
	</body>
</html>