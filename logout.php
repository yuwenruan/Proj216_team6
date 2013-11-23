<?php
/*
Author: Parker Smith
Date: Nov 18 2013
Course: PROJ216 Team 6
Assignment: Threaded Workshop - Phase I
            Travel Experts Web Site

user is logged out by destroying the session
*/
	session_start();
	
	if(isset($_SESSION['login']))
	{
		session_destroy();	
	}
	
	header("Location: index.php");
	
	
?>