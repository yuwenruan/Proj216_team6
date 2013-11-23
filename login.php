<!--	
	Author: Yu Wen Ruan
	Date: Nov 14, 2013
    Course: PROJ216 Team 6
    Assignment: Threaded Workshop - Phase I
                Travel Experts Web Site
	
	login.php
	login page for customer or agent to login in
	
-->
<?php

	session_start();
	//get the directory of url, and generate the redirect page url
	$url  = $_SERVER['HTTP_HOST'];
	$url .= $_SERVER['SCRIPT_NAME'];
	
	//if order button was pressed then after login go to booking.php
	//otherwise, go to index.php
	if (isset($_SESSION['order'])) {	
		$packageId=$_SESSION['order'];
		$theurl="http://".dirname($url)."/booking.php";
	}
	else {	
		$packageId="";
		$theurl="http://".dirname($url)."/index.php";
	}
	
	//connect to database
	$conn=mysql_connect("localhost","root","");
	$db=mysql_select_db('travelexperts') or die("Could not connect");

	//set the associative array for user and password based on user's input
	$users=array();
	$users['user']=isset($_POST['user'])? $_POST['user']: "";
	$users['password']=isset($_POST['password'])? $_POST['password']: "";

	//check the validation of user and password field, empty or null is not allowed
	function validation($array) {
		$resultStr="";
		if ($array['user']=="") {
			$resultStr="Please enter your login name";
		}
		
		if ($array['password']=="") {
			$resultStr="Please enter your password to login";
		}
		return $resultStr;
	}

	$showInfo="";

	// submit button is pressed
	//check the validation of two fields, if not show the message on the top
	//otherwise check password match the encrypted value in database or not
	//if yes, go to the agententry.php, if no, stay in this page, re-enter the password. 
	if (isset($_POST['submit'])) {
		$showInfo=validation($users);
		if (strlen($showInfo)==0) {
			$sql_str='SELECT * FROM USERS WHERE USER="'.$users['user'].'";';
			
			$result=mysql_query($sql_str) or die(mysql_error());
			
			if (mysql_num_rows($result) > 0) {
				while ($row=mysql_fetch_assoc($result)){
					$pwd=$row['password'];
					
					if (md5(trim($users['password']))==$pwd) {
						$_SESSION['login']=$row['role'];
						if ($row['role']=='customer') $_SESSION['customerId']=$row['roleId'];
						header("Location: $theurl");
					}
					else
						$showInfo="Password does not match, try again.";
				}
			}
			else {
				$showInfo="This user does not exist, please register first";
			}
			
		}
		
	}
	if (isset($_POST['register'])) {
		$theurl ="http://".dirname($url)."/register.php";
		header("Location: $theurl");
	}
	
?>

<html>
<head>
	<title>Login-Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
?>
<div id="content"> 

	<h2>Welcome, Please Login</h2>
	<h4><?=$showInfo?></h4>
	<form method="POST">
		<table border="0">
					<tr>
						<td class="label">User ID:</td><td><input type="text" name="user" value="<?php echo $users['user'];?>"></td>
					</tr>
					<tr>
						<td class="label">Password</td><td><input type="password" name="password" value=""></td>
					</tr>
					<tr>
						<td colspan=2>
							<input type="submit" name="submit" value="Submit">
							<input type="submit" name="register" value="Register">
						</td>
					</tr>
		</table>
				
	</form>
	
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>
