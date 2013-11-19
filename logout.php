<?php

	session_start();
	
	if(isset($_SESSION['login']))
	{
		session_destroy();
	}
	else
	{
		header("Location: index.php");
	}
	
?>