<!--
Author: Parker Smith
Date: Nov 18 2013
Travel Experts Project

This page displays the packages available to the customer AFTER the current date.
customer must be logged in to place an order, login button displayed in included header.
-->
<?php
/*This function gets the packages from the db
	and displays them on the html page.
	Only packages past the current date are displayed.
	Function checks if user is logged in before sending them to payment page
	through orderButton.php.
*/

session_start();
	
function displayPackage(){ 

	$dbh = mysql_connect("localhost", "root", "");
	mysql_select_db("travelexperts") or die ("db connection failed");
	
	$packageid = ("SELECT PackageId FROM packages");
	$packageName = ("SELECT PkgName FROM packages");
	$packageStart = ("SELECT DATE(PkgStartDate) AS PkgStartDate FROM packages");
	$packageEnd = ("SELECT DATE(PkgEndDate) AS PkgEndDate FROM packages");
	$packageDesc = ("SELECT PkgDesc FROM packages");
	$packagePrice = ("SELECT PkgBasePrice FROM packages");
	
	$packageid = mysql_query($packageid);
	$packageName = mysql_query($packageName);
	$packageStart = mysql_query($packageStart);
	$packageEnd = mysql_query($packageEnd);
	$packageDesc = mysql_query($packageDesc);
	$packagePrice = mysql_query($packagePrice);
	
	$date = date("Y-m-d");
		
	$rows = mysql_num_rows($packageid);
		
	$i=0;
	
	while($i < $rows){
			$idResult = mysql_result($packageid, $i);
			$nameResult = mysql_result($packageName, $i);
			$startResult = mysql_result($packageStart, $i);
			$endResult = mysql_result($packageEnd, $i);
			$descResult = mysql_result($packageDesc, $i);
			$priceResult = mysql_result($packagePrice, $i);
			
			if($endResult > $date)
			{
				print("<table>");
				print("<tr>
						<td class=\"titleRow\">Package Name</td>
						<td class=\"titleRow\">Number</td>
						<td class=\"titleRow\">Description</td>
						<td class=\"titleRow\">Departure Date</td>
						<td class=\"titleRow\">Return Date</td>
						<td class=\"titleRow\">Price</td>
						<td class=\"titleRow\">
							<form action=\"orderButton.php\" method=\"POST\">
								<input type=\"image\" src=\"./images/orderPic.png\" id=\"order\" value=\"".$idResult."\" name=\"order\">
							</form>
						</td>
					</tr>");
					if($endResult > $date && $startResult < $date)
						{
							print("<tr>
							<td>".$nameResult."</td>
							<td>".$idResult."</td>
							<td>".$descResult."</td>
							<td style=\"color:red;\">".$startResult."</td>
							<td>".$endResult."</td>
							<td>".$priceResult."</td>
							</tr>");
							print("</table>");
						}	
						
					else
						{
							print("<tr>
							<td>".$nameResult."</td>
							<td>".$idResult."</td>
							<td>".$descResult."</td>
							<td>".$startResult."</td>
							<td>".$endResult."</td>
							<td>".$priceResult."</td>
							</tr>");
							print("</table>");
						}
			}
			
			$i++;
	}
}
	
?>
<!--Start html page-->
<!DOCTYPE html>
<html>
<head>
	<title>Online Travel Booking and Management System</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
	<link href="./css/tableStylesPackages.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	//Include header and nav menu
	include_once("header.php");
	
?>
<div id="content"> 

	<!--Start content by calling displayPackage function-->
	<?php displayPackage(); ?>

</div>
<?php
	//Include footer content
	include_once("footer.php");
?>
		</div>
	</body>
</html>