<!--
Author: Parker Smith
Date: Nov 18 2013
Course: PROJ216 Team 6
Assignment: Threaded Workshop - Phase I
            Travel Experts Web Site


Page header file to be included

This file sets up the header of every page to be displayed.
It sets up the login buttons based on session variables.
It also includes the menu bar which has more selections if an agent is logged on
It also notifies the user if they have not imported the correct database
-->

		<header> 
			<div id="logo" ><img src="./images/banner.png"></div>
			<div id="buttons" style="float:right;">
				<a href="login.php" id="loginButton"><img src="./images/login.png"></a>
				<a href="register.php" id="signupButton"><img src="./images/signup.png"></a>
				<a href="logout.php" id="logoutButton"><img src="./images/logout.png"></a>
			</div>
			<div id="banner">
				<h1 id="welcome">Come travel with us</h1>
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
	//----- Code for checking users table columns - START
	// Added by George
	// Notify the user if they have not imported our datebase
	include_once("functions.php");	
	
	if(!checkColumns_UsersTable())
	{
?>
		<script language="JavaScript"> 
			alert('Please Import Database file named "TravelExperts-v2.sql"');
		</script>	
<?php		
	}
	//----- Code for checking users table columns - END
	//---------------------------------------------------
?>	