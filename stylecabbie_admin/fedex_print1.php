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
              $totalqty=0;
              for ($i=0; $i <count($p_idArray); $i++) { 

                  $p_idCity="select * from `cart` WHERE `cart_id`='".$p_idArray[$i]."'";
                  $p_idCity = mysqli_query($con,$p_idCity);
                  $resultp_idCity = mysqli_fetch_array($p_idCity);

                  $product_id=$resultp_idCity['product_id'];
                  $product_idQuery="select * from `product` WHERE `product_id`='".$product_id."'";
                  $productRes = mysqli_query($con,$product_idQuery);
                  $productResult = mysqli_fetch_array($productRes);
                  if($i==0){
                          
                          $product_id_fainal=$resultp_idCity['product_id'];
                          $ProductSize=$resultp_idCity['size'];
                          $ProductQty=$resultp_idCity['qty'];
                          $totalqty=$totalqty+$resultp_idCity['qty'];
                  }else{
                      $product_id_fainal.=','.$resultp_idCity['product_id'];
                      $ProductSize.=','.$resultp_idCity['size'];
                      $ProductQty.=','.$resultp_idCity['qty'];
                      $totalqty=$totalqty+$resultp_idCity['qty'];
                  }
              }




  				 ?>
		<div class="container" style="width: 100%; height:349px; border: 1px solid;border-bottom: dotted;">
		    <div class="row">
		    	<div class="col-md-12" style="text-align: center;"><img style="width: 200px;margin-top: 7px;" src="img/mahakaal logo.png"></div>
				<div class="col-md-12" >
					<div style="float: left;width:100%;height: 210px;">
						<strong><font size=4>To,</font></strong>
						<p><strong><font size=4>Name: </strong><?php echo $printData['name'];?></font></p>
						    <p><strong><font size=4>Address: </strong><?php echo $printData['address'];?></font></p>
						    <p style="float: left;margin-right: 21px;"><strong><font size=4>City: </strong><?php echo $resultCity['city_name'];?>
						    <p style="float: left;margin-right: 21px;"><strong><font size=4>State: </strong><?php echo $statename;?></font></p>
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
					<div style="width: 30%;float:left;font-size: 14px;">
						<strong>From,</strong><br>
						<strong>www.mahakaalstore.com</strong> Mobile:8085305205
					</div>
					   

					<table style="width: 70%;text-align: center;float:right">
						
						<tbody>

							<tr>
								<td style="border-left: solid 1px;">Qty</td>
								<td style="border-left: solid 1px;">OrderID</td>
								<td style="border-left: solid 1px;">Product</td>
								<td style="border-left: solid 1px;">Size</td>
								
							</tr>
							<tr>
									<td style="border-left: solid 1px;border-bottom: solid 1px;"><?php echo $ProductQty;?></td>	
									
									<td style="border-left: solid 1px;border-bottom: solid 1px;"><?php echo $printData['order_id'];?></td>
									<td style="border-left: solid 1px;border-bottom: solid 1px;"><?php echo $product_id_fainal;?></td>
									<td style="border-left: solid 1px;border-bottom: solid 1px;"><?php echo $ProductSize;?></td>
									
							</tr>
							<tr style="border-left: solid 1px;">
								<td></td>
								<td></td>
								<td ><strong>Total amount:</strong></td>
								<td > ₹<?php echo ($printData['total_price']); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		          
		<?php 
		   }
		 }
		?>
		
			
	</body>
</html>