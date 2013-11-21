<!--
	Author: Yu Wen Ruan
	Course: PROJ216, Team 6
	Date: Nov 17, 2013
	
	customermanagement.php
	main page to manage customers
	show all customers in split pages
-->
<!DOCTYPE html>
<?php
	session_start();
?>

<html>
<head>
	<title>Customers management-Travel Experts</title>
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
		
		$perpage = 6;  //set 6 records for every page
		$start = (isset($_GET['id'])) ? $_GET['id'] : 0;
		
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		//total records of agents table
		$TotalRec = mysql_result(mysql_query("SELECT COUNT(*) FROM customers"), 0);
		//set limit record for every page
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
			//write every record to table
			//show all customer
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
		
		//print the link for previous page and next page	
		if($start == 0)	{
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
		mysql_close($conn); //close database
	}
?>	
</div>
<?php
	include_once("footer.php"); //include footer file 
?>
		</div>
	</body>
</html>