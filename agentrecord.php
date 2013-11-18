<!--
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 17, 2013
	
	agentrecord.php
	-main page to edit and add agent
-->
<!DOCTYPE html>
<?php
	session_start();
	function validation($infor) {
		$error="";
		foreach ($infor as $key=>$value) {
			if ($value=="") {
				$error .="Please fill ".$key. ", it can not be blank <br>";
				return $error;
			}
		}
		return $error;
	}
	
	function genSQLUpdate($infor) {
		$str="";
		foreach ($infor as $key=>$value) {
			if ($value=="") $str .= $key."='".$value."',";
		}
		$str=substr($str,0,-1);
		
	}
?>
<html>
	<head>
		<title>Online Travel Booking and Management System-Agent's record</title>
		<link href="./css/bk.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrap">
			<?php
				include_once("header.php");	
			?>
			<div id="content"> 
				<?php
					$agentRec=array();
					
					$agentRec["agtFirstName"]=isset($_POST["fname"]) ? $_POST["fname"]|"";
					$agentRec["agtLastName"]=isset($_POST["lname"]) ? $_POST["lname"]|"";
					
					if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
						//connect to database
						$conn=mysql_connect("localhost","root","");
						$db=mysql_select_db('travelexperts') or die("Could not connect");
						
						//id is in the URL, the record needs to be edited
						if (isset($_GET["id"]){
							$id=isset($_GET["id"]) ? $_GET["id"]|"";
							// the form is submitted
							if (isset($_POST["submit"])) {
								if (is_numeric($_GET['id'])) {
									$show_str=validation($agentRec);
									if ($show_str==""){
										$sql_str=genSQLUpdate($agentRec);
										$sql_str="UPDATE AGENTS SET ". $sql_str." WHERE AgentId='".$id."';";
										
										$result=mysql_query($sql_str);
										if ($result) $show_str="Update the information successfully";
										else $show_str="Update the information is not successful";
									}
								}
							}
						}
						
						
				?>
				<form method="POST">
					<div>
						<strong>First Name: *</strong><input type="text" name="fname" value="<?php echo $agentRec["agtFirstName"]?>"/>
						<strong>Last Name: *</strong><input type="text" name="lname" value="<?php echo $agentRec["agtLastName"]?>"/>
						<p>* required</p>
                        <input type="submit" name="submit" value="Submit" />
					</div>					
				</form>
				
				<?php
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