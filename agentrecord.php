<!--
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 17, 2013
	
	agentrecord.php
	main page to edit,delete add agent 
-->
<!DOCTYPE html>
<?php
	session_start(); //start session
	
	function validation($infor) {
		$error="";
		foreach ($infor as $key=>$value) {
			if ($value=="" && $key!="AgtMiddleInitial") {
				$error .="Please fill ".$key. ", it can not be blank <br>";
				return $error;
			}
		}
		return $error;
	}
	//function to generate update SQL statement
	function genSQLUpdate($infor) {
		$str="";
		foreach ($infor as $key=>$value) {
			if ($value!="") 
				$str .= $key."='".$value."',";
		}
		$str=substr($str,0,-1);
		return $str;
	}
	
	//function to generate the insert SQL statement
	function genSQLInsert($infor,$tablename) {
		
		$insertStr="INSERT INTO ".$tablename." (";
		$valueStr=" VALUES (";
		
		//get value from associate array
		while (list($key, $value) = each($infor)) {
			$insertStr.=$key.',';
			if ($key=="password")	
				$valueStr .='"'.md5($value) . '",';
			else
				$valueStr .='"'.$value . '",';
		}
		
		$insertStr = substr($insertStr,0,-1);  //get rid of last ','
		$insertStr .=')';
		
		$valueStr = substr($valueStr,0,-1); 
		$valueStr .= ');';
		
		//generate the full insert SQL statement 
		$query_str=$insertStr . $valueStr ;
		return $query_str;
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
					//set array to get all agent information from form
					$agentRec=array();					
					$agentRec["AgtFirstName"]=isset($_POST["fname"])? $_POST["fname"]:"";
					$agentRec["AgtMiddleInitial"]=isset($_POST["mname"]) ? $_POST["mname"] :"";
					$agentRec["AgtLastName"]=isset($_POST["lname"]) ? $_POST["lname"]:"";
					$agentRec["AgtBusPhone"]=isset($_POST["phone"]) ? $_POST["phone"]:"";
					$agentRec["AgtEmail"]=isset($_POST["email"]) ? $_POST["email"]:"";
					$agentRec["AgtPosition"]=isset($_POST["position"]) ? $_POST["position"]:"";
					$agentRec["AgencyId"]=isset($_POST["agencyid"]) ? $_POST["agencyid"]:"";
					
					//set array to get login information from form
					$userRec=array();
					$userRec['user']=isset($_POST['user'])? $_POST['user']:"";
					$userRec['password']=isset($_POST['password'])? $_POST['password']:"";					
					 
					$show_str="";
					
					$b_add=false;
					
					//if login is agent
					if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
						//connect to database
						$conn=mysql_connect("localhost","root","");
						$db=mysql_select_db('travelexperts') or die("Could not connect");
						
						//id is in the URL, the record needs to be edited
						if (isset($_GET["id"])){
							$id= $_GET["id"];
							// the form is submitted, process the form and update the record
							if (isset($_POST["submit"])) {
								if (is_numeric($_GET['id'])) {
									$show_str=validation($agentRec);
									if ($show_str==""){
										$sql_str1=genSQLUpdate($agentRec);
										$sql_str="UPDATE AGENTS SET ". $sql_str1." WHERE AgentId='".$id."';";
										//print $sql_str;
										$result=mysql_query($sql_str) or die(mysql_error());;
										if ($result) {
											$show_str="Update the information successfully";
											header("Location: agentmanagement.php");
										}
										else $show_str="Update the information is not successful";
									}
								}
								else {
									$show_str="The ID is not valid";
									header("Location: agentmanagement.php");
								}
							}
							else {
								//not submitted, need modify the record
								 if (is_numeric($_GET['id']) && $_GET['id'] > 0)	{
									// get 'id' from URL
									$id = $_GET['id'];
									
									// get the recode from the database
									//set the information back to form
									$sql_str="SELECT * FROM AGENTS WHERE AgentId='".$id."';";
									$result=mysql_query($sql_str) or die(mysql_error());;
									if (mysql_num_rows($result)==1 && $result) {
										$row=mysql_fetch_assoc($result);
										$agentRec["AgtFirstName"]=$row['AgtFirstName'];
										$agentRec["AgtLastName"]=$row['AgtLastName'];
										$agentRec["AgtMiddleInitial"]=$row["AgtMiddleInitial"];
										$agentRec["AgtBusPhone"]=$row["AgtBusPhone"];
										$agentRec["AgtEmail"]=$row["AgtEmail"];
										$agentRec["AgtPosition"]=$row["AgtPosition"];
										$agentRec["AgencyId"]=$row["AgencyId"];																		
									}							
								
								}
							}
						}
						else {
							//add new record
							$b_add=true;
							//if submit button is pressed, insert new record to agents table and users table
							if (isset($_POST["submit"])) {	
								//check validation for every field of form
								$show_str=validation($agentRec); 
								if ($show_str==""){
									//generate insert SQL statement for insert new record to agents table
									$sql_str=genSQLInsert($agentRec,"AGENTS"); 
									//echo $sql_str;									
									$result=mysql_query($sql_str) or die(mysql_error());
									if ($result) {
										//insert record to agents table
										$show_str="New record is added to agents table";
										//get the max agentid for the last record that just added in
										$sql="SELECT max(AgentId) FROM AGENTS";
										$result1=mysql_query($sql) or die(mysql_error());
										if ($result1) {
											$row=mysql_fetch_row($result1);
											//print_r ($row);
											//set agentid to users table associated with agent's login user name and password
											
											$userRec['roleId']=$row[0];
											$userRec['role']='agent';
											$show_str=validation($userRec);
											
											$sql=genSQLInsert($userRec,"USERS");
											$result2=mysql_query($sql) or die(mysql_error());
											if ($result2) {
												$show_str.="<br>New record is added to users table";
												header("Location: agentmanagement.php");
											}
											
										}
									}
									else $show_str="Add new record is not successful";
									
									

								}
								$b_add=false;								
								
							}
						}
						
						
				?>
				<form method="POST">
					<p><?=$show_str?></p>
					<div style="margin:auto">
						<strong>First Name: *</strong><input type="text" name="fname" value="<?php echo $agentRec["AgtFirstName"]?>"/><br>
						<strong>Middle Initial: </strong><input type="text" name="mname" value="<?php echo $agentRec["AgtMiddleInitial"]?>"/><br>
						<strong>Last Name: *</strong><input type="text" name="lname" value="<?php echo $agentRec["AgtLastName"]?>"/><br>
						<strong>Business Phone: *</strong><input type="text" name="phone" value="<?php echo $agentRec["AgtBusPhone"]?>"/><br>
						<strong>Email: *</strong><input type="text" name="email" value="<?php echo $agentRec["AgtEmail"]?>"/><br>
						<strong>Position: *</strong><input type="text" name="position" value="<?php echo $agentRec["AgtPosition"]?>"/><br>
						<strong>Agency ID: *</strong>
						<select name="agencyid" value="<?php echo $agentRec["AgencyId"]?>">
							<?php
								//set value for select element
								$sql="SELECT AgencyId FROM AGENCIES";
								$result=mysql_query($sql);
								while ($row=mysql_fetch_row($result)) {
									if ($row[0]==$agentRec["AgencyId"])
										echo "<option selected>".$row[0]."</option>";
									else
										echo "<option >".$row[0]."</option>";
								}
							?>
						</select>
						<br>
						<?php 
							//if it is add new record, agent has to have login information
							if ($b_add) { 
						?>
						<strong>User: *</strong><input type="text" name="user" value="<?php echo $userRec["user"]?>"/><br>
						<strong>Password: *</strong><input type="password" name="password" value="<?php echo $userRec["password"]?>"/><br>
						<?php 
							}
						?>
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