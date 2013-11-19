<!--
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 18, 2013
	
	agentdelete.php
	From agentmanagement.php agent list to delete one agent record
-->
<!DOCTYPE html>
<?php
	
	session_start();
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		
		//id is in the URL, the record needs to be located and delete
		if (isset($_GET["id"])){
			$id= $_GET["id"];
			//delete from agents table
			$sql_agent="DELETE FROM AGENTS WHERE AgentId='".$id."';";
			$result=mysql_query($sql_agent);
			//echo "delete agent:" .$sql_agent."<br>";
			
			//delete from users table
			$sql_user="DELETE FROM USERS WHERE roleid='".$id."' and role='agent';";
			$result=mysql_query($sql_user);
			//echo "delete user:" .$sql_user."<br>";
			//after delete redirect the page to agentmanagement.php
			header("Location: agentmanagement.php");
			
		}
		else header("Location: agentmanagement.php");
	}
?>