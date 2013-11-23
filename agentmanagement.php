<!--
	Author: Yu Wen Ruan
	Date: Nov 17, 2013
    Course: PROJ216 Team 6
    Assignment: Threaded Workshop - Phase I
                Travel Experts Web Site
	
	agentmanagement.php
	We arrive this page after clicking agent-management menu button
    If agent is not logged in then go to login.php
	
	-list employees in limit records per page
	-each employee record has edit link to modify
	-each employee record can be deleted if there is no customers under his/her name
		otherwise, show message this agent cannot be deleted
	-the bottom of the page has link to add new employee
-->
<!DOCTYPE html>
<?php
	session_start();
?>

<html>
<head>
	<title>Employees management-Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
?>
<div id="content"> 
<?php
	$agentErr="";
	//if agent is login, show records of employees, each page show limited records
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
			//show all agents information in the table
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
		
		//print the split page links, previous or next
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
		
		//display message indicating success or failure of delete operation, only delete if agent has no customers
		if (isset($_GET['agentid'])) {
			if ($_GET['agentid']=='0')	{
				$agentErr="This agent is deleted";
				echo "<p style='color:red; font-weight=bold;'>".$agentErr."</p>";
			}
			else 	{	
				$agentErr="This agent cannot be deleted, there are number of customers being assigned to this agent!";
				echo "<p style='color:red; font-weight=bold;'>".$agentErr."</p>";
			}
		}		
		
		mysql_close($conn);
	}
	else 	{
		header("Location: login.php");
	}

?>	
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>
