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
		     	 	$sql=mysqli_query($con,"SELECT * FROM `customorder` where customorder_id='$value'");

		    		$row_con=mysqli_fetch_array($sql);
		    		date_default_timezone_set('Asia/Calcutta');
  					$date=date('Y-m-d'); 

  					  $state_id=$row_con['state_id'];
                      $queryState="select * from `states` WHERE `state_id`='$state_id'";
                      $resState = mysqli_query($con,$queryState);
                      $resultState = mysqli_fetch_array($resState);

                      $city_id=$row_con['city_id'];
                      $queryCity="select * from `cities` WHERE `city_id`='$city_id'";
                      $resCity = mysqli_query($con,$queryCity);
                      $resultCity = mysqli_fetch_array($resCity);

  					  $ProductName='';
                      $ProductSize='';
                      $ProductQty='';
                      $pro_type_final='';
                     // $p_id=$row_con['p_id'];
                     // $p_idArray=explode(',', $p_id);
                    /*  for ($i=0; $i <count($p_idArray); $i++) { 

                          $p_idCity="select * from `cart` WHERE `cart_id`='".$p_idArray[$i]."'";
                          $p_idCity = mysqli_query($con,$p_idCity);
                          $resultp_idCity = mysqli_fetch_array($p_idCity);

                          $product_id=$resultp_idCity['product_id'];
                          $product_idQuery="select * from `product` WHERE `product_id`='".$product_id."'";
                          $productRes = mysqli_query($con,$product_idQuery);
                          $productResult = mysqli_fetch_array($productRes);
                          if($productResult['cat_id']==3){

                              $info=$resultp_idCity['brand'].'('.$resultp_idCity['model'].')';
                              $pro_type='M';

                          }else{
                            $info=$resultp_idCity['size'];
                             $pro_type='T';
                          }
                          
                          if($i==0){

                                  
                                  $ProductName=$productResult['name'];
                                  $ProductSize=$info;
                                  $ProductQty=$resultp_idCity['qty'];
                                  $pro_type_final=$pro_type;

                          }else{
                              $ProductName.=','.$productResult['name'];
                              $ProductSize.=','.$info;
                              $ProductQty.=','.$resultp_idCity['qty'];
                              $pro_type_final.=','.$pro_type;
                          }
                      }*/


  				?>
		<div class="container" style="width: 90%; height:523px; border: 1px solid;">
		    <div class="row">
		    	<div style="text-align: center;" class="col-md-12"><img style="width: 300px;padding: 24px;" src="img/mahakaal logo.png"></div>
				<div class="col-md-12" >
					<div style="float: left; width:70%;">
						<strong><font size=4>To,</font></strong>
						<p><strong><font size=4>Name: </strong><?php echo $row_con['name'];?></font></p>
						    <p><strong><font size=4>Address: </strong><?php echo $row_con['address'];?></font></p>
						    <p><strong><font size=4>City: </strong><?php echo $resultCity['city_name'];?>
						    <p><strong><font size=4>State: </strong><?php echo $resultState['state_name'];?></font></p>
						    <p><strong><font size=4>Pin code: </strong><?php echo $row_con['pincode'];?></font></p>
						    <p><strong><font size=4>Mobile No.: </strong> <?php echo $row_con['mobile'];?></font></p>
					</div>
					<div style="top: 20px;right: 50px;border: 1px solid black;padding: 12px;float: right; width:30%;">
						<p><strong>EMS Speed Post</strong></p>
						<p><strong>BNPL A/c No. 3-11346</strong></p>
						<p><strong>Indore GPO-452001</strong></p>
						<p><strong>Date : <?php echo $date; ?></strong></p>
					</div>
					<!-- <span style="position: absolute;top: 20px;right: 50px;"><img src="img/mahakaal logo.png" style="width: 100px;"> -->
					</span>
				</div>
				<!-- <div class="col-md-3">
					
				</div> -->
			</div>
			<div class="row col-md-12">
				
				<div class="col-md-6 " style="float:right;">
						<strong><font size=4>From,</font></strong>
						<p>Name:Mahakaal store</p>
						<p>Address:EK 489 Scheme no 54 pin 452010</p>
						<p>Mobile No.:8085305205</p>
				</div>
				<div class="col-md-12 " style="font-size: 10px;">
					
						Order Id:<?php echo $value." ".$row_con['brand']."(".$row_con['brand_Model'].")";?>
				</div>
			</div>
		</div>
		          
		<?php 
		   }
		 }
		?>
		
			
	</body>
</html>