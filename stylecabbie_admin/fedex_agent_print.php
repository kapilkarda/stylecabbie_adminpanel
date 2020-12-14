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
				     
				        date_default_timezone_set('Asia/Calcutta');
		  				$date=date('Y-m-d');
						  $sql=mysqli_query($con,"SELECT * FROM `order`  where order_id='$value'");
					      $printData=mysqli_fetch_array($sql);

					      $order_id=$printData['order_id'];
						  $pin_code=$printData['pin_code'];

			       		  $pincod=mysqli_query($con,"SELECT * FROM `pincodes` where pincode='$pin_code' limit 1");
			       		  $pincodres=mysqli_fetch_array($pincod);
			       		  $taluk=$pincodres['taluk'];
			       		  $districtname=$pincodres['districtname'];
			       		  $statename=$pincodres['statename'];

			       		  $city_id=$printData['city_id'];
			              $queryCity="select * from `cities` WHERE `city_id`='$city_id'";
			              $resCity = mysqli_query($con,$queryCity);
			              $resultCity = mysqli_fetch_array($resCity);


		       		  $p_id=$printData['p_id'];
		              $p_idArray=explode(',', $p_id);
            ?>
		<div class="container" style="width: 100%;height:523px;border: 1px solid;border-bottom: dotted;">
		    <div class="row">
		    	<div class="col-md-12" style="text-align: center;margin: 1%;"><img style="width: 200px;margin-top: 7px;" src="img/mahakaal logo.png"></div>
				<div style="width: 48%;float: left;border: solid 1px;margin-right: 2%;">
					<span style="text-align: center;border-bottom: solid 1px;font-size: 16px;font-weight: bold;margin-left: 33%;">Customer Details</span>
					<div style="float: left;width:100%;padding-left: 5%;">
						<p><strong>Name:</strong> <?php echo $printData['name'];?> </p>
						<p><strong>Mobile No.:</strong> <?php echo $printData['mobile'];?></p>
					</div>
				</div>
				<div style="width: 50%;float: left;border: solid 1px;">
					<span style="text-align: center;border-bottom: solid 1px;font-size: 16px;font-weight: bold;margin-left: 33%;">Order Details</span>
					<div style="float: left;width:100%;padding-left: 5%;">
						<p><strong>Order ID:</strong> 000<?php echo $printData['order_id'];?></p>
						<p><strong>Order Date:</strong> <?php echo $printData['order_date'];?></p>
						   
					</div>
				</div>
				<div style="border: solid 1px;margin: 5px;width: 100%;float: left;margin-top: 11px;" >
					<span style="border-bottom: solid 1px;font-size: 16px;font-weight: bold;margin-left: 38%;">Shipping Address</span>
					<div style="float: left;width:100%;padding-left: 5%;">
						<p><strong>Address:</strong> <?php echo $printData['address'];?></p>
						    <p style="float: left;margin-right: 21px;"><strong>City:</strong> <?php echo $resultCity['city_name'];?>
						    <p style="float: left;margin-right: 21px;"><strong>State:</strong> <?php echo $statename;?></p>
						    <p><strong>Pin code:</strong> <?php echo $printData['pin_code'];?></p>
						   
					</div>
				</div>
			</div>
			<div style="width: 100%;height:130px;margin-top: 20px;border:solid 1px;border-bottom: none;">		
				<table style="width: 100%;border: solid 1px black;text-align: center;" border="1">
								<tr>
									<td style="font-weight: 700;">Name</td>
									<td style="font-weight: 700;">Price</td>
									<td style="font-weight: 700;">Qty</td>
									<td style="font-weight: 700;">total</td>
								</tr>
								<tbody>
									<?php 

									for($i = 0; $i <count($p_idArray); $i++) {

											$query3 = mysqli_query($con, "SELECT * FROM `cart` where cart_id='$p_idArray[$i]' ORDER BY cart_id asc" );
											    $sql3=mysqli_fetch_array($query3);
											    $produce_id=$sql3['product_id'];
												$qty=$sql3['qty'];
												$is_payment=$sql3['is_payment'];
												
												$query2 = mysqli_query($con, "SELECT * FROM `product` where product_id='$produce_id'");

												$sqll2=mysqli_fetch_array($query2);
												$photo='http://mahakaalstore.com/afterfeed_admin/'.$sqll2['photo'];
												$product_name=$sqll2['name'];
												$product_price=$sqll2['sale_price'];
										

									?>
									<tr>
										<td><?php echo$product_name; ?></td>
										<td>₹ <?php echo$product_price; ?></td>
										<td><?php echo$qty; ?></td>
										<td>₹ <?php echo$is_payment; ?></td>
									</tr>
								<?php } ?>
									
									
									

								</tbody>
				</table>
			</div>
		          
		<?php 
		   }
		}
		?>
		<div style="width: 25%;float: right;border-left: solid 1px;border-right: solid 1px;height: 100px;">
		<table style="float: right;position: relative;">
				<tbody>
					<tr style="border: none;">
									<td></td>
									<td></td>
									<td style="text-align: right;"><span style="font-size: 15px;font-weight: 700;">Sub Total:</span></td>
									<td>₹ <?php echo$printData['total_price']-$printData['delivery_charge']-$printData['cod_charge']; ?></td>
								</tr>
								<tr style="border: none;">
									<td></td>
									<td></td>
									<td style="text-align: right;"><span style="font-size: 15px;font-weight: 700;">Delivery Charges:</span></td>
									<td>₹ <?php echo$printData['delivery_charge']; ?></td>
								</tr>
								<tr style="border: none;">
									<td></td>
									<td></td>
									<td style="text-align: right;"><span style="font-size: 15px;font-weight: 700;">COD Charges:</span></td>
									<td>₹ <?php echo$printData['cod_charge']; ?></td>
								</tr>
								<tr style="border: none;">
									<td></td>
									<td></td>
									<td style="text-align: right;"><span style="font-size: 15px;font-weight: 700;">Grand Total:</span></td>
									<td>₹ <?php echo$printData['total_price']; ?></td>
								</tr>
				</tbody>
		</table>
	</div>
		<div style="width: 75%;border-top: solid 1px;border-right: solid 1px;height: 100px;">
			<table style="float: left;position: relative;">
					<tbody>
								<tr style="border: none;">
										<td></td>
										<td></td>
										<td style="text-align: left;"><span style="font-size: 15px;font-weight: 700;">From,</span></td>
										<td></td>
									</tr>
						          <tr style="border: none;">
										<td></td>
										<td></td>
										<td style="text-align: left;"><span style="font-size: 12px;">Mahakaal Store</span></td>
										<td></td>
									</tr>
									<tr style="border: none;">
										<td></td>
										<td></td>
										<td style="text-align: left;"><span style="font-size: 12px;">www.mahakaalstore.com</span></td>
										<td></td>
									</tr>
									<tr style="border: none;">
										<td></td>
										<td></td>
										<td style="text-align: left;"><span style="font-size: 12px;">info@mahakaalstore.com</span></td>
										<td></td>
									</tr>
									<tr style="border: none;">
										<td></td>
										<td></td>
										<td style="text-align: left;"><span style="font-size: 12px;">8085305205</span></td>
										<td></td>
									</tr>
					</tbody>
			</table>
		</div>
			
	</body>
</html>