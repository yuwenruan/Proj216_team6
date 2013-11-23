<!--
	Author: Yu Wen Ruan
	Date: Nov 19 2013
	Course: PROJ216 Team 6
	Assignment: Threaded workshop pahse I 
				Travel Experts Web Site
	
	report.php
	The page to generate report for agents
	list each agent and number of customers they have
	list each customer and number of bookings they have
-->
<!DOCTYPE html>
<?php
	//start a session
	session_start();
?>

<html>
<head>
	<title>Reports-Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
?>
<div id="content">
<h2>List number of customers that each agent has:</h2>
<?php
	//when agent login, show report: customers that each agent has
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		
		//SQL statement: list how many customers that each agent has
		$sql_str="select a.AgtFirstName, a.AgtLastName, count(c.customerId) as 'numbers'";
		$sql_str .=" from agents a, customers c where a.AgentId=c.AgentId ";
		$sql_str .="group by a.AgentId;";
		
		$result=mysql_query($sql_str) or die(mysql_error());
		
		if ($result) {
?>
	<table border="1">
		<tr>
			<th>Agent First Name</th>
			<th>Agent Last Name</th>
			<th>Number of Customers</th>
		</tr>
		<?php
			//print table to list number of customers
			while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
				foreach ($row as $key=>$value)
				{					
					echo "<td >";
					echo $value;
					echo "</td>";
				}
			echo "</tr>";
			}
		?>
	</table>
	<?php
		}
	?>
	<h2>List number of bookings that each customer has:</h2>
	<?php
		//SQL statement: list number of bookings that each customer has
		$sql_str="select c.custFirstName,c.custLastName,count(b.bookingId)  as 'numbers'";
		$sql_str .=" from customers c, bookings b where c.customerId=b.customerId  ";
		$sql_str .="group by c.customerId;";
		
		$result=mysql_query($sql_str) or die(mysql_error());
		
		if ($result) {
	?>
	<table border="1">
		<tr>
			<th>Customer First Name</th>
			<th>Customer Last Name</th>
			<th>Number of Bookings</th>
		</tr>
		<?php
			//print table to list number of booking of each customer
			while($row=mysql_fetch_assoc($result)){
			echo "<tr>";
				foreach ($row as $key=>$value)
				{					
					echo "<td>";
					echo $value;
					echo "</td>";
				}
			echo "</tr>";
			}
		?>
	</table>
<?php
		}
	}
	//close the database connection
	mysql_close($conn);
	
?>
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>