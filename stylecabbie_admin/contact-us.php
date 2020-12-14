<?php
	require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us | Mahakaal Store</title>
	<meta name="author" content="Afterfeed Shop">
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
	<link rel="shortcut icon" href="favicon.ico">

	<?php
		require_once('headlink.php');
	?>
</head>

<body class="boxed">
	<!-- Loader -->
	<div id="loader-wrapper">
		<div class="cube-wrapper">
			<div class="cube-folding">
				<span class="leaf1"></span>
				<span class="leaf2"></span>
				<span class="leaf3"></span>
				<span class="leaf4"></span>
			</div>
		</div>
	</div>

	<div id="wrapper">

		<!-- Page -->
		<div class="page-wrapper">
			<!-- Header -->
			<!-- Header -->
			<?php
				$variant = 2;
				require_once('header.php');
			?>
			<!-- /Sidebar -->
			<!-- Page Content -->
			<main class="page-main">
				<div class="block">
					<div class="container">
						<ul class="breadcrumbs">
							<li><a href="index.html"><i class="icon icon-home"></i></a></li>
							<li>/<span>Contact Us</span></li>
						</ul>
					</div>
				</div>
				<div class="block">
					<div class="container">
						<div class="row">
							<div class="col-sm-5">
								<div class="text-wrapper">
									<h2>Address Details</h2>
									<div class="address-block">
										<h3>ADDRESS 1</h3>
										<ul class="simple-list">
											<li><i class="icon icon-location-pin"></i>Adress: EK 489 Scheme No. 54 Near Anand Mohan Mathur Sabhagruh,Indore, Madhya Pradesh 452010
											</li>
											<li><i class="icon icon-phone"></i>Phone: 0731-4981691 (10am to 7pm Monday to friday)</li>
										<!-- 	<li><i class="icon icon-phone"></i>Fax: 123456789xxxx</li> -->
											<li><i class="icon icon-close-envelope"></i>Email: <a href="mailto:info.mahakaalstore@gmail.com">info.mahakaalstore@gmail.com</a></li>
										</ul>
									</div>
									<!-- <div class="address-block last">
										<h3>ADDRESS 2</h3>
										<ul class="simple-list">
											<li><i class="icon icon-location-pin"></i>Adress: 5487 Capers Road, Glasgow D43 66 GR, Boston</li>
											<li><i class="icon icon-phone"></i>Phone: 9823xxx</li>
											<li><i class="icon icon-phone"></i>Fax: 123456789xxxx</li>
											<li><i class="icon icon-close-envelope"></i>Email: <a href="mailto:support@seiko.com">Seico@example.com</a></li>
										</ul>
									</div> -->
								</div>
							</div>
							<div class="col-sm-7">
								<div class="text-wrapper">
									<h2>Contact Information</h2>
									<p id="contactFormSuccess">Your email was send successfully!</p>
									<p id="contactFormError">Error, try to submit this form again.</p>
									<form id="contactform" class="contact-form white" name="contactform" method="post">
										<label>Full Name<span class="required">*</span></label>
										<input type="text" class="form-control input-lg" name="name" style=" text-transform: capitalize;">
										<label>Mobile no<span class="required">*</span></label>
										<input type="text" class="form-control input-lg" name="mobile">
										<label>E-mail<span class="required">*</span></label>
										<input type="text" class="form-control input-lg" name="email">
										<label>Comment<span class="required">*</span></label>
										<textarea class="form-control input-lg" name="message"></textarea>
										<div>
											<button class="btn btn-lg" id="submit">Submit</button>
										</div>
										<div class="required-text">* Required Fields</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="block fullwidth">
					<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSK_nLPUyr7NGihR1MkH5z1COHYFI9SKs"></script>
					<script type="text/javascript">
						// When the window has finished loading create our google map below
						google.maps.event.addDomListener(window, 'load', init);

						function init() {
							// Basic options for a simple Google Map
							// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
							var mapOptions = {
								zoom: 14,
								scrollwheel: false,
								center: new google.maps.LatLng(22.752559,75.865535, 13.75), // Seiko

								// How you would like to style the map. 
								// This is where you would paste any style found on Snazzy Maps.
								styles: [{
									"featureType": "administrative",
									"elementType": "labels.text.fill",
									"stylers": [{
										"color": "#444444"
									}]
								}, {
									"featureType": "landscape",
									"elementType": "all",
									"stylers": [{
										"color": "#f2f2f2"
									}]
								}, {
									"featureType": "poi",
									"elementType": "all",
									"stylers": [{
										"visibility": "off"
									}]
								}, {
									"featureType": "road",
									"elementType": "all",
									"stylers": [{
										"saturation": -100
									}, {
										"lightness": 45
									}]
								}, {
									"featureType": "road.highway",
									"elementType": "all",
									"stylers": [{
										"visibility": "simplified"
									}]
								}, {
									"featureType": "road.highway",
									"elementType": "geometry.fill",
									"stylers": [{
										"color": "#ffffff"
									}]
								}, {
									"featureType": "road.arterial",
									"elementType": "labels.icon",
									"stylers": [{
										"visibility": "off"
									}]
								}, {
									"featureType": "transit",
									"elementType": "all",
									"stylers": [{
										"visibility": "off"
									}]
								}, {
									"featureType": "water",
									"elementType": "all",
									"stylers": [{
										"color": "#dde6e8"
									}, {
										"visibility": "on"
									}]
								}]
							};

							// Get the HTML DOM element that will contain your map 
							// We are using a div with id="map" seen below in the <body>
							var mapElement = document.getElementById('googleMap');

							// Create the Google Map using our element and options defined above
							var map = new google.maps.Map(mapElement, mapOptions);

							// Let's also add a marker while we're at it
							var marker = new google.maps.Marker({
								position: new google.maps.LatLng(22.752559,75.865535),
								map: map,
								title: 'Mahakaal Store'
							});
						}
					</script>
					<!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->
					<div id="googleMap" class="google-map"></div>
				</div>
			</main>
			<!-- /Page Content -->
			<!-- Footer -->
			<?php
				require_once('footer.php');
			?>
			<!-- /Footer -->


		</div>
		<!-- /Page -->
	</div>
	<?php
		require_once('extra.php');
		require_once('footerscript.php');
	?>
	<!-- jQuery form validation -->
	<script src="js/vendor/form/jquery.form.js"></script>
	<script src="js/vendor/form/jquery.validate.min.js"></script>
	<script>
		// Contact page form
		$(function () {
			$('#contactform').validate({
				rules: {
					name: {
						required: true,
						minlength: 3
					},
					mobile: {
						required: true,
                        maxlength:10,
						minlength: 10,
						number:true

					},

					message: {
						required: true,
						minlength: 15,

					},
					email: {
						required: true,
						email: true
					}

				},
				messages: {
					name: {
						required: "Please enter your name",
						minlength: "Your name must consist of at least 3 characters"
					},
				   mobile: {
						required: "Please enter your mobile no",
					    maxlength:"Your Mobile Number must be 10 digit!",
						minlength:  "Your Mobile Number must be 10 digit!",
                        number: "Enter the valid Mobile Number!"
					},
					message: {
						required: "Please enter your message",
						minlength: "Your message must consist of at least 15 characters"
					},
					email: {
						required: "Please enter your email"
					}
				},
				submitHandler: function (form) {
					$(form).ajaxSubmit({
						type: "POST",
						data: $(form).serialize(),
						url: "contact.php",
						success: function () {
							$('#contactFormSuccess').fadeIn();
							$('#contactFormError').fadeOut();
							$('#contactform').trigger('reset');
						},
						error: function () {
							$('#contactFormSuccess').fadeOut();
							$('#contactFormError').fadeIn();
						}
					});
				}
			});
		});
	</script>
	</div>
</body>
</html>