<?php 
/* 
Author		:	George Chacko
Date		:	21 November 2013
Project		: 	Phase I - workshop prototype
-- Functions file  ----- functions used in web site 
Reusable functions in this file
--------------------------------
1. insertData		:	Inserts data into data base. 
						Parameters - data array and table name. Data associative array hold
						column names (keys) and values
2. insertData_Id	:	Inserts data into data base same as insertData. But at the same time 
						returns id of newly inserted row
3. checkColumns_UsersTable	:	Checks whether all desired columns exists in users table.
								If so returns true otherwise false
*/
// Adding Data to DB-------------------
function insertData($dataArray,$table)
{
	// variable to hold sql statement
	$insertStmt = "INSERT INTO $table (";
	
	// Initializing variables to hold column names and values
	$cols = "";  //columns
	$vals = "";  // fields
	
	// getting keys from array passed as parameter
	$keys = array_keys($dataArray);
	// --- looping through array
	foreach ($keys as $key)
	{
		$cols .= $key . ",";
		$vals .= "'" . $dataArray[$key] . "'," ;
	}
	
	// -- removing extra comma 
	$cols = rtrim($cols, ",");
	$vals = rtrim($vals, ",");
	
	$insertStmt .= $cols . ") VALUES (" . $vals . ")";
	
	// Data base connection
	$con=mysql_connect("localhost","root","");
	
	//providing which data base to be used
	mysql_select_db('TravelExperts') or die('Could not connect');
	
	// executes DB operation
	$results = mysql_query($insertStmt);
	
	if($results)
	{
		mysql_close();
		return true;
	}
	else
	{
		mysql_close();
		return false;
	}
}
//--------------------------------------
function insertData_Id($dataArray,$table)
{
	// variable to hold sql statement
	$insertStmt = "INSERT INTO $table (";
	
	// Initializing variables to hold column names and values
	$cols = "";  //columns
	$vals = "";  // fields
	
	// getting keys from array passed as parameter
	$keys = array_keys($dataArray);
	// --- looping through array
	foreach ($keys as $key)
	{
		$cols .= $key . ",";
		$vals .= "'" . $dataArray[$key] . "'," ;
	}
	
	// -- removing extra comma 
	$cols = rtrim($cols, ",");
	$vals = rtrim($vals, ",");
	
	$insertStmt .= $cols . ") VALUES (" . $vals . ")";
	
	// Data base connection
	$con=mysql_connect("localhost","root","");
	
	//providing which data base to be used
	mysql_select_db('TravelExperts') or die('Could not connect');
	
	// executes DB operation
	$results = mysql_query($insertStmt);
	
	if($results)
	{
		return mysql_insert_id();
	}
	else
	{
		mysql_close();
		return 0;
	}
}
//--------------------------------
function checkColumns_UsersTable()
{
	//-----------------------------------------
	/* Open a connection */
	$mysqli = new mysqli("localhost", "root", "", "TravelExperts");

	/* check Data base connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	//-----------------------------
	// boolean variables for checking each column
	$passwordColumn = false;
	$roleColumn 	= false;
	$roleIdColumn 	= false;
	$userColumn 	= false;
	$userIdColumn 	= false;
	//-----------------------------
	$query = "SELECT COLUMN_NAME
			FROM INFORMATION_SCHEMA.COLUMNS 
			WHERE TABLE_SCHEMA = 'travelexperts' 
			AND TABLE_NAME = 'users' 
			ORDER BY COLUMN_NAME";
	
	//-----------------------------
	
	if($result = $mysqli->query($query)) 
	{
		while($row = mysqli_fetch_array($result))
		{
			switch ($row[0])
			{
				case 'password':
					$passwordColumn = true;
					break;
				case 'role':
					$roleColumn 	= true;
					break;
				case 'roleId':
					$roleIdColumn 	= true;
					break;
				case 'user':
					$userColumn 	= true;
					break;
				case 'userId':
					$userIdColumn	 = true;
					break;
			} 
		}
		//-----------------------
		/* free result set */
		$result->close();
	}
	//---------------------------------
	if($passwordColumn && $roleColumn 
		&& $roleIdColumn && $userColumn && $userIdColumn)
	{
		return true;
	}	
	else
	{
		return false;
	}
	//---------------------------------
}
//--------------------------------
?>