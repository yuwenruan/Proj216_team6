<?php 
/******************************************************************************************
Author		:	George Chacko
Date		:	21 November 2013
Project		: 	Phase I - workshop prototype
Customer registration Page 
--------------------------- 
1. Basic customer information like first name, last name etc. inserted into
   customers table.
2. user id, password, customer id and 'customer' as role into users table
3. password is encrypted using md5 before storing
4. Mandatory columns (form text elements) validation implemented
5. session variables 'login' and 'customer' initialized.
6. On successful registration, if session variable 'order' is set, redirected to booking page
   otherwise to home (index) page
/******************************************************************************************
*/
session_start();
?>
<!DOCTYPE html>

<html>
<head>
	<title>Customer Registration - Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");	
	//---------------------------
	include_once("functions.php");	
	//**********************************************************
	// --- code for checking user table validity START ---------
	/*if(!checkColumns_UsersTable())
	{
		print "USERS Table is NOT CORRECT";
	}
	else
	{
		print "USERS Table is CORRECT";
	}*/
	// --- code for checking user table validity END ---------
	//********************************************************
	//---------------------------
	// Initializing customer array
	$customerInfo = array(	"CustFirstName"	=> "",
							"CustLastName" 	=> "",
							"CustAddress" 	=> "",
							"CustCity" 		=> "",
							"CustProv" 		=> "",
							"CustPostal" 	=> "",
							"CustCountry" 	=> "",
							"CustHomePhone" => "",
							"CustBusPhone" 	=> "",
							"CustEmail" 	=> "",
							"CustUid"		=> "",
							"CustPwd"		=> "",
							"CustConfmPwd"	=> ""
				);
	//---------------------------
	$isValidForm = true; // to determine if form is valid to insert into Data base
	//---------------------------
	$error = array(	"CustFirstName"	=> "",
					"CustLastName" 	=> "",
					"CustAddress" 	=> "",
					"CustCity" 		=> "",
					"CustProv" 		=> "",
					"CustPostal"	=> "",
					"CustCountry" 	=> "",
					"CustHomePhone" => "",
					"CustBusPhone" 	=> "",
					"CustEmail" 	=> "",
					"CustUid" 		=> "",
					"CustPwd" 		=> "",
					"CustConfmPwd" 	=> ""
					);
	//----------------------
	if (isset($_POST["submit"]))
	{
		// looping form collection for each customer information field
		foreach (array_keys($_POST) as $name)
		{
			// populating associative array
			$customerInfo[$name] = $_POST[$name]; 
		} // for loop end
		//---------------------------
		//--- Page validation 
		
		if(empty($customerInfo['CustFirstName']))
		{
			$error['CustFirstName'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustLastName']))
		{
			$error['CustLastName'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustAddress']))
		{
			$error['CustAddress'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustCity']))
		{
			$error['CustCity'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustProv']))
		{
			$error['CustProv'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustPostal']))
		{
			$error['CustPostal'] = "*Missing*";
			$isValidForm = false;
		}
		else // checking postal code format
		{
			if(filter_var($customerInfo['CustPostal'], FILTER_VALIDATE_REGEXP, 
					array("options"=>array("regexp"=>"/^[a-z][0-9][a-z]( )?[0-9][a-z][0-9]$/i"))) === false)
			{
				$error['CustPostal'] = "Postal Code not in correct format";
				$isValidForm = false;
			}
		}
		if(empty($customerInfo['CustCountry']))
		{
			$error['CustCountry'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustHomePhone']))
		{
			$error['CustHomePhone'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustBusPhone']))
		{
			$error['CustBusPhone'] = "*Missing*";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustEmail']))
		{
			$error['CustEmail'] = "*Missing*";
			$isValidForm = false;
		}
		else  // Checking email format
		{
			if(!filter_var($customerInfo['CustEmail'], FILTER_VALIDATE_EMAIL))
			{
				$isValidForm = false;
				$error['CustEmail'] = "Email is Invalid";
			}
		}
		if(empty($customerInfo['CustUid']))
		{
			$error['CustUid'] = "*Missing*";
			$isValidForm = false;
		}
		// checking both password and re enter password text fields filled
		if(empty($customerInfo['CustPwd']))
		{
			$error['CustPwd'] = "*Missing*";
			$isValidForm = false;
		}
		elseif(empty($customerInfo['CustConfmPwd']))
		{
			$error['CustConfmPwd'] = "*Missing*";
			$isValidForm = false;
		}
		else  // checking both password and re enter password are same
		{
			if($customerInfo['CustPwd'] != $customerInfo['CustConfmPwd'])
			{
				$error['CustPwd'] = "Mismatch - Re Enter Password";
				$customerInfo['CustPwd'] = "";
				$isValidForm = false;
			}
		}
		//-------- Page validation ends -----------
		//---------------------------
		// If customer data is valid insert into data base
		if($isValidForm)
		{
			// populate user id and password from array into variables
			// to insert into another table (users)
			$userId = $customerInfo['CustUid'];
			$pwd	= $customerInfo['CustPwd'];
			
			// removing data not related to customer from array
			unset($customerInfo['submit']);
			unset($customerInfo['CustUid']);
			unset($customerInfo['CustPwd']);
			unset($customerInfo['CustConfmPwd']);
			
			// Insert customer data
			// Customer data inserted and customer id captured into a variable
			$customerId = insertData_Id($customerInfo,'customers');
			
			if($customerId != 0)
			{
				// Initializing user info array
				$userInfo = array(	"user"		=> "",
									"password" 	=> "",
									"role" 		=> "",
									"roleId"	=> ""
								 );
				$userInfo['user'] 		= $userId;
				$userInfo['password'] 	= md5($pwd); // password is encrypted
				$userInfo['role'] 		= "customer";
				$userInfo['roleId'] 	= $customerId;
				//--------------------
				// Inserting user id and password into users table
				if(insertData($userInfo,'users'))
				{
					// initializing session variables - login & customerId
					$_SESSION["login"] 		= "customer";
					$_SESSION["customerId"] = $customerId;
					
					// On successful customer registration - 
					// check if order is placed if so redirect to booking page otherwise to home page
					if(isset($_SESSION["order"]))
					{
						header("Location:booking.php");
					}
					else
					{
						header("Location:index.php");
					}
				}
				else
				{
					print "<b>User information could not be added!!!</b>";
				}
				//--------------------
			}
			else
			{
				print "<b>Customer information could not be added!!!</b>";
			}	
		}
		//---------------------------
	}
?>
<div id="content">
	<form id="frm" method="post" >
		<table align="center">
			<tr><td align="center"><h2>Customer Registration</h2></td></tr>
			<tr>
				<td>
					<table>
						<tr>
							<td align="right">First Name:</td>
							<td><input type="text" name="CustFirstName" size="20" maxlength="25" 
									value="<?php echo $customerInfo['CustFirstName'];?>">
								<small><font color="red"><?php echo $error["CustFirstName"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">Last Name:</td>
							<td><input type="text" name="CustLastName" size="20" maxlength="25" 
									value="<?php echo $customerInfo['CustLastName'];?>">
								<small><font color="red"><?php echo $error["CustLastName"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">Address:</td>
							<td><input type="text" name="CustAddress" size="30" maxlength="75" 
									value="<?php echo $customerInfo['CustAddress'];?>">
								<small><font color="red"><?php echo $error["CustAddress"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">City:</td>
							<td><input type="text" name="CustCity" size="30" maxlength="50" 
									value="<?php echo $customerInfo['CustCity'];?>">
								<small><font color="red"><?php echo $error["CustCity"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">Province:</td>
							<td><input type="text" name="CustProv" size="2" maxlength="2" 
									value="<?php echo $customerInfo['CustProv'];?>">
								<small><font color="red"><?php echo $error["CustProv"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">Postal Code:</td>
							<td><input type="text" name="CustPostal" size="7" maxlength="7" 
									value="<?php echo $customerInfo['CustPostal'];?>">
								<small><font color="red"><?php echo $error["CustPostal"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">Country:</td>
							<td><input type="text" name="CustCountry" size="25" maxlength="25" 
									value="<?php echo $customerInfo['CustCountry'];?>">
								<small><font color="red"><?php echo $error["CustCountry"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">Home Phone:</td>
							<td><input type="text" name="CustHomePhone" size="20" maxlength="20" 
									value="<?php echo $customerInfo['CustHomePhone'];?>">
								<small><font color="red"><?php echo $error["CustHomePhone"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">Business Phone:</td>
							<td><input type="text" name="CustBusPhone" size="20" maxlength="20" 
									value="<?php echo $customerInfo['CustBusPhone'];?>">
								<small><font color="red"><?php echo $error["CustBusPhone"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">Email:</td>
							<td><input type="text" name="CustEmail" size="20" maxlength="50" 
									value="<?php echo $customerInfo['CustEmail'];?>">
								<small><font color="red"><?php echo $error["CustEmail"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">User Name:</td>
							<td><input type="text" name="CustUid" size="12" maxlength="12" 
									value="<?php echo $customerInfo['CustUid'];?>">
								<small><font color="red"><?php echo $error["CustUid"]; ?></font></small>	
							</td>
						</tr>
						<tr>
							<td align="right">Password:</td>
							<td><input type="password" name="CustPwd" size="20" maxlength="128" 
									value="<?php echo $customerInfo['CustPwd'];?>">
								<small><font color="red"><?php echo $error["CustPwd"]; ?></font></small>
							</td>
						</tr>
						<tr>
							<td align="right">Re-enter Password:</td>
							<td><input type="password" name="CustConfmPwd" size="20" maxlength="128">
								<small><font color="red"><?php echo $error["CustConfmPwd"]; ?></font></small>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="submit" value="REGISTER"  name="submit" ></input>
					<input type="reset" value="CLEAR" ></input>
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