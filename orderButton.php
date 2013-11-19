<?php
/*
Author: Parker Smith
Date: Nov 18 2013
Travel Experts Project

This page enables the order button by starting a session, checking if user is logged in.
If they are it sends them to the payment page, if not it sends them to the login page.
*/

	session_start();
	if(isset($_SESSION['login']))
	{
		$_SESSION['order'] = $_POST['order'];
		header("Location: payment.php");
	}
	else
	{
		header("Location: login.php");
	}

?>