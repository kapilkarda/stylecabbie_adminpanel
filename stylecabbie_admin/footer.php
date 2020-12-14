
<footer class="page-footer variant4 fullboxed">
	
	<div class="footer-middle">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-lg-3">
					<div class="footer-block collapsed-mobile">
						<div class="title">
							<h4>INFORMATION</h4>
							<div class="toggle-arrow"></div>
						</div>
						<div class="collapsed-content">
							<ul class="marker-list">
								<li><a href="about.php">About Us</a></li>
								<li><a href="refund.php">Terms Conditions</a></li>
								<!-- <li><a href="TermsCondition.php">Terms Conditions</a></li> -->
							<!-- 	<li><a href="#">Privacy Policy</a></li> -->
					            <!-- <li><a href="#">Our Blog</a></li> -->
								<!-- <li><a href="search.php">Search Terms</a></li> -->
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="footer-block collapsed-mobile">
						<div class="title">
							<h4>Categories</h4>
							<div class="toggle-arrow"></div>
						</div>
						<div class="collapsed-content">
							<ul class="marker-list">
								<?php
								$sqlCategory = mysqli_query($con, "SELECT * from category");
								while($qurCat = mysqli_fetch_array($sqlCategory)){
									$cat_id=$qurCat['cat_id'];
									if($qurCat['type']=='Normal'){	
									$sqlCategory1 = mysqli_query($con, "SELECT * from subcategory where cat_id='$cat_id'");
                          			$row1=mysqli_num_rows($sqlCategory1);
	                          		if($row1==0){ ?>
										<li><a href="category.php?id=<?php echo $qurCat['cat_id'];?>"><?php echo $qurCat['cat_name'];?></a>
										</li>
									<?php }else{ ?>
									<li><a href="subcategory.php?id=<?php echo $qurCat['cat_id'];?>"><?php echo $qurCat['cat_name'];?></a>
									</li>
								 <?php } }else if($qurCat['type']=='Custom'){ 
								$sqlCategory1 = mysqli_query($con, "SELECT * from customProductImage where cat_id='$cat_id'");
								$row1=mysqli_num_rows($sqlCategory1);
														if($row1==0){ ?>
								<li><a href="#" onclick="Available();"><?php echo $qurCat['cat_name'];?></a>
									</li>
										<?php } else{ 
								while($row1 = mysqli_fetch_array($sqlCategory1)){ 
								?> 
									<li><a href="customProduct.php?id=<?php echo $row1['cat_id'];?>"><?php echo $qurCat['cat_name'];?></a>
									</li>
								<?php  }}}else if($qurCat['type']=='Daily-Dhamaka'){?>
									<li><a href="dhamaka_category.php?id=<?php echo $qurCat['cat_id'];?>"><?php echo $qurCat['cat_name'];?></a>
									</li>
								<?php }} ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="footer-block collapsed-mobile">
						<div class="title">
							<h4>CUSTOMER CARE</h4>
							<div class="toggle-arrow"></div>
						</div>
						<div class="collapsed-content">
							<ul class="marker-list">
				<!-- 				<li><a href="http://www.afterfeed.com">Our Blog</a></li> -->
								<li><a href="contact-us.php">Contact Us</a></li>
								<li><a href="privacy.php">Privacy Policy</a></li>
							    <li><a href="refund.php">Refund and Cancellation Policy</a></li> 
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="footer-block collapsed-mobile">
						<div class="title">
							<h4>CONTACT US</h4>
							<div class="toggle-arrow"></div>
						</div>
						<div class="collapsed-content">
							<ul class="simple-list">
								<li><i class="icon icon-phone"></i>0731-4981691 (10am to 7pm Monday to friday)</li>
								<li><i class="icon icon-close-envelope"></i><a href="mailto:info.mahakaalstore@gmail.com">info.mahakaalstore@gmail.com</a></li>
							</ul>
							<div class="footer-social">
								<a href="https://www.facebook.com/mahakaalstoreIND/" target="_blank"><i class="icon icon-facebook-logo icon-circled"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bot">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-8">
					<!-- <div class="image-banner text-center">
						<a href="#"> <img src="images/banners/footer-banner.jpg" alt="Footer Banner" class="img-responsive"> </a>
					</div> -->
				</div>
				<div class=" col-md-6 col-lg-4">
					<div class="footer-copyright text-center"> © <?php echo date('Y'); ?> Mahakaal Store. All Rights Reserved. </div>
				<!-- 	<div class="footer-payment-link text-center">
						<a href="#"><img src="images/payment-logo/icon-pay-1.png" alt=""></a>
						<a href="#"><img src="images/payment-logo/icon-pay-2.png" alt=""></a>
						<a href="#"><img src="images/payment-logo/icon-pay-3.png" alt=""></a>
						<a href="#"><img src="images/payment-logo/icon-pay-4.png" alt=""></a>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- /Footer -->
<a class="back-to-top back-to-top-mobile" href="#">
	<i class="icon icon-angle-up"></i> To Top
</a>
<script type="text/javascript">
	function Available(){
		alert('No Product Available');
	}
</script>