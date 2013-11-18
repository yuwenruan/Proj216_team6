<!--
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 17, 2013
	
	customermanagement.php
	main page to manage customers
-->
<!DOCTYPE html>
<?php
	session_start();
?>

<html>
<head>
	<title>Online Travel Booking and Management System-customers management</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
?>
<div id="content"> 
<?php
	//when agent login, show records of customers, each page show limited records
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
		
		$perpage = 6; 
		$start = (isset($_GET['id'])) ? $_GET['id'] : 0;
		
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		//total records of agents table
		$TotalRec = mysql_result(mysql_query("SELECT COUNT(*) FROM customers"), 0);
		
		$sql_str="SELECT * FROM customers LIMIT $start, $perpage;";
		
		$result=mysql_query($sql_str) or die(mysql_error());
		if (mysql_num_rows($result) > 0) {
?>
	<table border='1'>
	<tr>
		<th>Customer ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Address</th>
		<th>City</th>
		<th>Province</th>
		<th>Postal Code</th>
		<th>Country</th>
		<th>Home Phone</th>
		<th>Business Phone</th>
		<th>Email</th>
		<th>Agent ID</th>
	</tr>
	
<?php
			while ($row=mysql_fetch_assoc($result)){
				echo "<tr>";
				foreach ($row as $key=>$value)
				{					
					echo "<td>";
					echo $value;
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
			
		if($start == 0) {
		  echo "Previous Screen";
		}
		else	{
		  echo "<a style='color:red;' href='customermanagement.php?id=".($start - $perpage)."'>Previous Screen</a> "; 
		}
		
		if(($start + $perpage) >= $TotalRec)	{
		  echo "Next Screen";
		}
		else	{
		  echo "<a style='color:red;' href='customermanagement.php?id=".($start + $perpage)."'>Next Screen</a> "; 
		}
		mysql_close($conn);
	}
?>	
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>