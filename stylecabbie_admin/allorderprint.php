<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src='https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js'></script>
	</head>
	<script type="text/javascript">
		
			//JsBarcode("#barcode", "YA778351560IN");
			function textToBase64Barcode(text){
			  var canvas = document.createElement("canvas");
			  JsBarcode(canvas, text, {format: "CODE39"});
			  return canvas.toDataURL("image/png");
			}
		</script>
	<body>
		<?php 
			error_reporting(E_ALL); ini_set('display_errors', 1);
			date_default_timezone_set('Asia/Calcutta'); 
			if(!isset($_SESSION)) { 
			        session_start(); 
			}
  			include('db.php');
		   if(!(isset($_SESSION['id']))){
		      header("location:index.php");
		   }
		
		    $from_order_id=$_GET['from'];
		    $to_order_id=$_GET['to'];

			$sql=mysqli_query($con,"SELECT * FROM `order` o,`states` s,`cities` c  where order_id BETWEEN $from_order_id AND $to_order_id and o.state_id=s.state_id and o.city_id=c.city_id and order_type='CashOnDelivery' and status='0' group by mobile ORDER BY order_id ASC");
		      while ($printData=mysqli_fetch_array($sql)) {

		       $bar=mysqli_query($con,"SELECT * FROM `barcode` where status='0' limit 1");
		       if($getbar=mysqli_fetch_array($bar)){
		       			 
		       			$barcode=$getbar['code'];
		       			$order_id=$printData['order_id'];
		       			$updatesql=mysqli_query($con,"UPDATE `order` SET `status`='2' where order_id='$order_id'");
		       			
		       			$updatebarcodeorder=mysqli_query($con,"UPDATE `order` SET `barcode`='$barcode' where order_id='$order_id'");
		       			$updatebarcode=mysqli_query($con,"UPDATE `barcode` SET `status`='1' where code='$barcode'");

		       		  $pin_code=$printData['pin_code'];
		       		  $pincod=mysqli_query($con,"SELECT * FROM `pincodes` where pincode='$pin_code' limit 1");
		       		  $pincodres=mysqli_fetch_array($pincod);
		       		  $taluk=$pincodres['taluk'];
		       		  $districtname=$pincodres['districtname'];
		       		  $statename=$pincodres['statename'];

		       			
		       }else{
		       	echo'bar code samapt ho gaye hai.';exit;
		       }


		       ?>
		<div class="container" style="width: 100%; height:523px; border: 1px solid;">
		    <div class="row">

		    	<div class="col-md-12" style="text-align: center;font-size: 24px; border-bottom: solid 1px;">
				<b><span align="center" style="
				    font-size: 34px;
				">Express COD Parcel of - ₹ <?php echo ($printData['qty']*299)+100; ?>/-</span></b><br>
				<span align="center">(<?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
											echo $f->format(($printData['qty']*299)+100); ?>)</span>
				<span align="center">EbillerID:8987</span>
				<br>
				<span style=" font-size: 18px;" align="center">पोस्टमॉस्टर जी कृपया कस्टमर को फ़ोन लगाए बगैर पार्सल वापस न करे 5 से 7 दिन रोक कर रखे </span>
				</div>

				<div class="col-md-12" >
					<div class="col-md-6" style="border-right: solid 1px;width: 50%;float: left;height: 310px;">

						<strong><font size=4>To,</font></strong>
						    <p><strong><font size=4>Name: </strong></font><?php echo $printData['name'];?></p>
						    <p><strong><font size=4>Address: </strong></font><?php echo $printData['address'];?></p>
						     <p><strong><font size=4>City: </strong></font><?php echo $printData['city_name']; ?></p>
						    <p><strong><font size=4>Taluk: </strong></font><?php echo $taluk; ?>, <strong><font size=4>District: </strong></font><?php echo $districtname; ?></p>
						    <p><strong><font size=4>State: </strong></font><?php echo $statename; ?></p>
						    <p><strong><font size=4>Pin code: </strong></font><?php echo $printData['pin_code'];?></p>
						    <p><strong><font size=4>Mobile No.: </strong> <?php echo $printData['mobile'];?></font></p>
						
					</div>
					<div class="col-md-6" style="float: right;width: 50%;height: 287px;">

						<strong><font style="float: left;" size=4>From,</font></strong>
						<img style="width: 110px;margin-left: 50px;padding: 15px;" src="img/mahakaal logo.png">
						<h3 style="text-align: center;font-weight: 700;margin-top: 0px;">MAHAKAAL T-SHIRT</h3>
						<p>Engineer Master Solutions Pvt. Ltd.</p>
						<p></strong> 210, 1st Floor, 19A Electronic</p>
						Complex, Pardeshipura Indore M.P. Pin: 452010</p>
						<p>Mobile No.:8085305205</p>
						
					</div>
				</div>
				<div class="col-md-12" style="float: left;border-top: solid 1px;width: 100%;" >
					<div style="float:left;width: 50%;">
						<img id="barcodeimage<?php echo$order_id; ?>" src="" style="width: 328px;">
					</div>
					<script type="text/javascript">
						try{
							var image=textToBase64Barcode('<?php echo$barcode; ?>');
					}catch(e){
						console.log(e);
					}
						document.getElementById("barcodeimage<?php echo$order_id; ?>").src =image;

					</script>
					<table style="width: 50%;text-align: center;float:right">
						<thead style="border-bottom: solid 1px;">
							
							<th style="text-align: center;padding-bottom: 10px;padding-top: 10px;border-left: solid 1px;width: 60px;">Weight</th>
							<th style="text-align: center;padding-bottom: 10px;padding-top: 10px;border-left: solid 1px;width: 60px;">OrderID</th>
							<th style="text-align: center;padding-bottom: 10px;padding-top: 10px;border-left: solid 1px;width: 60px;">Product</th>
							<th style="text-align: center;padding-bottom: 10px;padding-top: 10px;border-left: solid 1px;width: 60px;">Size</th>
							<th style="text-align: center;padding-bottom: 10px;padding-top: 10px;border-left: solid 1px;width: 60px;">Date</th>
						</thead>
						<tbody>
							<tr>
									
									<td style="border-left: solid 1px;"><?php echo (245*$printData['qty']);?> G</td>
									<td style="border-left: solid 1px;"><?php echo $printData['order_id'];?></td>
									<td style="border-left: solid 1px;"><?php echo $printData['p_id'];?></td>
									<td style="border-left: solid 1px;"><?php echo $printData['size'];?></td>
									<td style="border-left: solid 1px;"><?php echo date('d/m/Y');?></td>	
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		          
		<?php 
		   }
	
		?>
	

		
		
			
	</body>
</html>