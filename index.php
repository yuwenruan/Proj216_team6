<!--
Author: Parker Smith
Date: Nov 18 2013
Travel Experts Project

This is the main index page, it displays a slideshow in the main content,
orders can be placed through the slideshow.
-->
<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Travel Booking and Management System</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
	<link href="./css/indexStyles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/slideshow.js"></script>
</head>
<body onLoad="initialize();"><!--Body on load calls initialize function to start javascript, found in slideshow.js-->
	<div id="wrap">
<?php
	//Include header and nav menu
	include_once("header.php");	
?>
<div id="content"> 

	<!--Start Slideshow content-->
	<div id="imageBox">
		<img id="imageS"></img>
			<div id="linkBox">
				<div class="functionClass">
					<img src="#" onClick="imageView(0); stopSlide();" id="desc0" class="linkP"></img>
					<img src="#" onClick="imageView(1); stopSlide();" id="desc1" class="linkP"></img>
					<img src="#" onClick="imageView(2); stopSlide();" id="desc2" class="linkP"></img>
					<img src="#" onClick="imageView(3); stopSlide();" id="desc3" class="linkP"></img>
					<img id="slideStopper" class="linkP" onClick="setTimer();" src="images/playSlide.png"></img>
				</div>
				<div class="functionClass">
					<form action="orderButton.php" method="POST" onClick="buttonValue();">
						<input type="image" src="./images/orderPic.png" id="order" value="" name="order">
					</form>
				</div>
			</div>
	</div>

</div>
<?php
	//Include footer content
	include_once("footer.php");
?>
		</div>
	</body>
</html>