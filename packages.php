<!--
Author: Parker Smith
Date: Nov 18 2013
Course: PROJ216 Team 6
Assignment: Threaded workshop pahse I 
			Travel Experts Web Site

This page displays the packages available to the customer AFTER the current date.
customer must be logged in to place an order, login button displayed in included header.
-->
<?php
session_start();

/*This function gets the packages from the db
	and displays them on the html page.
	Only packages past the current date are displayed.
	Function checks if user is logged in before sending them to booking page
	through orderButton.php.
*/	

function displayPackage(){ 
	
	/*Start db connection*/
	$dbh = mysql_connect("localhost", "root", "");
	mysql_select_db("travelexperts") or die ("db connection failed");
	
	/*create strings for mysql queries*/
	$packageid = ("SELECT PackageId FROM packages");
	$packageName = ("SELECT PkgName FROM packages");
	$packageStart = ("SELECT DATE(PkgStartDate) AS PkgStartDate FROM packages");
	$packageEnd = ("SELECT DATE(PkgEndDate) AS PkgEndDate FROM packages");
	$packageDesc = ("SELECT PkgDesc FROM packages");
	$packagePrice = ("SELECT PkgBasePrice FROM packages");
	
	/*make mysql queries*/
	$packageid = mysql_query($packageid);
	$packageName = mysql_query($packageName);
	$packageStart = mysql_query($packageStart);
	$packageEnd = mysql_query($packageEnd);
	$packageDesc = mysql_query($packageDesc);
	$packagePrice = mysql_query($packagePrice);
	
	/*get the current date-formatted yyyy-mm-dd*/
	$date = date("Y-m-d");
	
	/*get the number of packages in the packages table*/
	$rows = mysql_num_rows($packageid);
	
	//define iterator for loop
	$i=0;
	
	print("<table>");
	
	/*This loop gets the package info from a specific row and prints the info in a table*/
	while($i < $rows){
			$idResult = mysql_result($packageid, $i);
			$nameResult = mysql_result($packageName, $i);
			$startResult = mysql_result($packageStart, $i);
			$endResult = mysql_result($packageEnd, $i);
			$descResult = mysql_result($packageDesc, $i);
			$priceResult = mysql_result($packagePrice, $i);
			
			/*conditional to check if the package offer has finished*/
			if($endResult > $date)
			{
				
				print("<tr>
						<td class=\"titleRow\">Package Name</td>
						<td class=\"titleRow\">Description</td>
						<td class=\"titleRow\">Offer Start Date<br>yyyy/mm/dd</td>
						<td class=\"titleRow\">Offer End Date<br>yyyy/mm/dd</td>
						<td class=\"titleRow\">Price</td>
						<td class=\"titleRow\">
							<form action=\"orderButton.php\" method=\"POST\">
								<input type=\"hidden\" id=\"order\" value=\"".$idResult."\" name=\"order\">
								<input type=\"image\" src=\"./images/orderPic.png\" name=\"order\">
							</form>
						</td>
					</tr>");
					/*conditional to check if package offer has started if yes, print package with start date offer in red*/
					if($endResult > $date && $startResult < $date)
						{
							print("<tr>
							<td>".$nameResult."</td>
							<td>".$descResult."</td>
							<td style=\"color:red;\">".$startResult."</td>
							<td>".$endResult."</td>
							<td>".number_format($priceResult,2)."</td>
							</tr>");
							
						}	
						
					else
						{
							print("<tr>
							<td>".$nameResult."</td>
							<td>".$descResult."</td>
							<td>".$startResult."</td>
							<td>".$endResult."</td>
							<td>".number_format($priceResult,2)."</td>
							</tr>");
						}
			}
			$i++;
			
	}//end loop
	print("</table>");
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