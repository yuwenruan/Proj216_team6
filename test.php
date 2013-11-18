<?php
//connect to database
$conn=mysql_connect("localhost","root","");
$db=mysql_select_db('travelexperts') or die("Could not connect");
/*
$sql="SELECT AgentId, AgtFirstName FROM AGENTS";

$result=mysql_query($sql);

while ($row=mysql_fetch_assoc($result)) {
	$str="INSERT INTO USERS ( user, password,role,roleId) VALUES ";
	$str.="('".strtolower($row['AgtFirstName'])."', '". md5(strtolower($row['AgtFirstName']))."','agent','". $row['AgentId']."');";
	
	echo $str."<br>";
}
*/

$sql="SELECT CustomerId, CustFirstName,CustLastName FROM CUSTOMERS";
$result=mysql_query($sql);

while ($row=mysql_fetch_assoc($result)) {
	$str="INSERT INTO USERS ( user, password,role,roleId) VALUES ";
	$str.="('".strtolower($row['CustFirstName']).".".strtolower($row['CustLastName'])."', '". md5(strtolower($row['CustFirstName']))."','customer','". $row['CustomerId']."');";
	
	echo $str."<br>";
}
?>
