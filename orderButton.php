<?php
/*
Author: Parker Smith
Date: Nov 18 2013
Course: PROJ216 Team 6
Assignment: Threaded workshop pahse I 
			Travel Experts Web Site

This page enables the order button by starting a session, checking if user is logged in.
If they are it sends them to the booking page, if not it sends them to the login page.
*/

	session_start();
	/*checks for login*/
	if(isset($_SESSION['login']))
	{
		/*set order session variable to post of order button, then redirect to booking.php*/
		$_SESSION['order'] = $_POST['order'];
		header("Location: booking.php");
	}
	else
	{
		/*sets order session variable to hold customers order, but redirects to login.php*/
		$_SESSION['order'] = $_POST['order'];
		header("Location: login.php");
	}

?>