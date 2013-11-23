<!--
	Author: Yu Wen Ruan
	Date: Nov 18, 2013
    Course: PROJ216 Team 6
    Assignment: Threaded Workshop - Phase I
                Travel Experts Web Site
	
	agentdelete.php
	We arrive this file from agentmanagement.php when a delete link is clicked.
	If agent is not logged in, go to login.php
	If this agent does not have any customer under his/her name, 
		this agent is deleted. 
		And, return to agentmanagement.php. 
	Otherwise, a message pass back to agentmanagement.php saying agent cannot be delete
-->
<!DOCTYPE html>
<?php
	
	session_start();
	
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts') or die("Could not connect");
		
		//agent id is in the URL, the record needs to be located and delete
		if (isset($_GET["id"])){
			$id= $_GET["id"];
			$sql="SELECT * FROM CUSTOMERS WHERE AgentId='".$id."';";
			$result=mysql_query($sql);
			if (mysql_num_rows($result) == 0 ){	
			
				//delete from agents table
				$sql_agent="DELETE FROM AGENTS WHERE AgentId='".$id."';";
				$result=mysql_query($sql_agent);
				
				//delete from users table
				$sql_user="DELETE FROM USERS WHERE roleId='".$id."' and role='agent';";
				$result=mysql_query($sql_user);
				
				//after delete redirect the page to agentmanagement.php
				header("Location: agentmanagement.php?agentid=0");
			}
			else	{
				$url="agentmanagement.php?agentid=".$id;
				header("Location: $url");
			}
			
			
		}
		else header("Location: agentmanagement.php");
	}else{
	  header("Location: login.php");
	}
	
?>