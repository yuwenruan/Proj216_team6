<!--
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 17, 2013
	
	agentmanagement.php
	-main page to manage employees
	-list employees in limit record per page
	-each employee record has edit and delete link to modify
	-the bottom of the page has link to add new employee
-->
<!DOCTYPE html>
<?php
	session_start();
?>

<html>
<head>
	<title>Online Travel Booking and Management System-employees management</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
?>
<div id="content"> 
<?php
	//when agent login, show records of employees, each page show limited records
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
		
		$perpage = 6; 
		$start = (isset($_GET['idpage'])) ? $_GET['idpage'] : 0;
		
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		//total records of agents table
		$TotalRec = mysql_result(mysql_query("SELECT COUNT(*) FROM agents"), 0);
		
		$sql_str="SELECT * FROM agents LIMIT $start, $perpage;";
		
		$result=mysql_query($sql_str) or die(mysql_error());
		if (mysql_num_rows($result) > 0) {
?>
	<table border='1'>
	<tr>
		<th>ID</th>
		<th>First Name</th>
		<th>Middle Initial</th>
		<th>Last Name</th>
		<th>Business Phone</th>
		<th>Email</th>
		<th>Position</th>
		<th>Agency ID</th>
		<th></th>
		<th></th>
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
				echo "<td><a style='color:red;' href='agentrecord.php?id=" . $row['AgentId'] . "'>Edit</a></td>";
				echo "<td><a style='color:red;' href='agentdelete.php?id=" . $row['AgentId'] . "'>Delete</a></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		
		if($start == 0) {
		  echo "Previous Screen";
		}
		else	{
		  echo "<a style='color:red;' href='agentmanagement.php?idpage=".($start - $perpage)."'>Previous Screen</a> "; 
		}
		
		if(($start + $perpage) >= $TotalRec)	{
		  echo "Next Screen";
		}
		else	{
		  echo "<a style='color:red;' href='agentmanagement.php?idpage=".($start + $perpage)."'>Next Screen</a> "; 
		}
		echo "<br> <a style='color:blue;' href='agentrecord.php'>Add New Record</a>";

	}
	
	mysql_close($conn);
?>	
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>