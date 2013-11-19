<!--
Author: Parker Smith
Date: Nov 18 2013
Page header file to be included

This file sets up the header of every page to be displayed.
It sets up the login buttons based on session variables.
-->

		<header> 
			<div id="logo" ><img src="./images/banner.png" height="180px"></div>
			<div id="buttons" style="float:right;">
				<a href="login.php" id="loginButton"><img src="./images/login.png"></a>
				<a href="register.php" id="signupButton"><img src="./images/signup.png"></a>
				<a href="logout.php" id="logoutButton"><img src="./images/logout.png"></a>
			</div>
			<div id="banner">
				<h1 id="welcome">Welcome to Travel Experts</h1>
			</div>
		</header>
		<?php
			include_once("menu.php");
		?>
		
<?php

	if(isset($_SESSION['login']))
	{
		print("<script>
			document.getElementById(\"loginButton\").style.display=\"none\";
			document.getElementById(\"signupButton\").style.display=\"none\";
			document.getElementById(\"logoutButton\").style.display=\"inline\";
		</script>");
	}
	else
	{
		print("<script>
			document.getElementById(\"loginButton\").style.display=\"inline\";
			document.getElementById(\"signupButton\").style.display=\"inline\";
			document.getElementById(\"logoutButton\").style.display=\"none\";
		</script>");
	}

?>	