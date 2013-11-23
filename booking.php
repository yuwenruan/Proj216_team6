<!--
	Author: Yu Wen Ruan & Paul Milligan
	Course: PROJ216
	Date: Nov 21, 2013
	
	payment.php
	This page is arrived at after one of the following:
      -a logged on agent or customer clicks an order button
	  -a new customer clicks an order button then successfully registers in register.php
    This page collects booking information then inserts a row into the bookings table of the database.
-->
<!DOCTYPE html>
<?php
	session_start(); //start session	
?>
<html>
	<head>
		<title>Booking-Travel Experts</title>
		<link href="./css/bk.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrap">
			<?php				
				include_once("header.php");	
			?>
			<div id="content"> 
			<form method="POST"> <!-- form that collects booking information -->
				<table> <!-- table that aligns booking information -->
			<?php
				/*
					This page is reloaded when its form is submitted.
					Initialize booking information to empty strings or the values submitted in the form.
				*/
				$today=date("Y-m-d"); // get today's date
			
				$bookings=array();
				$bookings['BookingDate']=isset($_POST["bdate"])? $_POST["bdate"]:$today;
				$bookings['BookingNo']=isset($_POST["bnumber"])? $_POST["bnumber"]:"";
				$bookings['TravelerCount']=isset($_POST["travels"])? $_POST["travels"]:"";
				$bookings['CustomerId']=isset($_POST["cname"])? $_POST["cname"]:"";
				$bookings['TripTypeId']=isset($_POST["ttype"])? $_POST["ttype"]:"";
				$bookings['PackageId']=isset($_POST["package"])? $_POST["package"]:"";
				
				$submitFeedback=""; // will be set if there is feedback
				
				//connect to database
				$conn=mysql_connect("localhost","root","");
				$db=mysql_select_db('travelexperts') or die("Could not connect");
				
				//if customer is logged in
				if (isset($_SESSION['login']) && $_SESSION['login']=='customer') {
					  // get customer ID from login or registration
					if (isset($_SESSION['customerId'])) {
						$bookings['CustomerId']=$_SESSION['customerId'];
						// get package ID from when order button was clicked
						if (isset($_SESSION['order'])) {
							$bookings['PackageId']=$_SESSION['order'];
						}
					}
				} // if agent is logged in
				else if (isset($_SESSION['login']) && $_SESSION['login']=='agent'){
					if (isset($_SESSION['order'])) {
						// get package ID from when order button was clicked
						$bookings['PackageId']=$_SESSION['order'];
					}
					// agent must select a customer, so show customer list
			?>
				<tr>
					<td><p>Customer Name:</p></td>
					<td>
						<select name="cname" value="<?php echo $bookings['CustomerId'];?>"> 
							<?php
								//Select SQL statement for listing the customers
								$sql="SELECT CustomerId, CustFirstName, CustLastName FROM customers;";
								$result=mysql_query($sql) or die(mysql_error());
								while ($row=mysql_fetch_assoc($result)) {							
									echo "<option value='".$row['CustomerId']."'>";
									echo $row['CustFirstName']." ".$row['CustLastName']."</option>";
								}
							?>
						</select>
					</td>
				</tr>
			<?php			
					
				} else { // if neither customer nor agent logged in then go to home page
					mysql_close($conn);	
					header("Location: index.php");
				}
				
				if (isset($_POST['submit'])) { // if page was reloaded after clicking submit
					// then insert the booking
					$insertStr="INSERT INTO bookings (";
					$valueStr=" VALUES (";
					while (list($key, $value) = each($bookings)) {
						$insertStr.=$key.',';
						$valueStr .='"'.$value . '",';
					}
					$insertStr = substr($insertStr,0,-1);  //get rid of last ','
					$insertStr .=')';
					
					$valueStr = substr($valueStr,0,-1); 
					$valueStr .= ');';
					
					//generate the full sql statement
					$query_str=$insertStr . $valueStr ;
					
					//insert sql statement 
					$result=mysql_query($query_str) or die(mysql_error());
					if ($result) // set message to report what happened
						$submitFeedback="Booking succeeded";
					else
						$submitFeedback="Booking failed";
				}
				
			?>
					
					<tr> <!-- rest of form for booking information -->
						<td>Date:</td>
						<td><?=$bookings['BookingDate'];?></td>						
					</tr>
					<tr>
						<td>Booking Number:	</td>	
						<td><input type="text" name="bnumber" value="<?php echo $bookings['BookingNo'];?>"/></td>						
					</tr>
					<tr>
						<td>Travellers:</td>
						<td>
							<select name="travels" value="<?php echo $bookings['TravelerCount']; ?>" > 
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</td>
					</tr>
					<tr>
						<td>Trip Type:</td>
						<td>
							<select name="ttype" value="<?php echo $bookings['TripTypeId']; ?>" > 
							<?php
								//set value for select element
								$sql="SELECT * FROM triptypes;";
								$result=mysql_query($sql) or die(mysql_error());
								$i=1;
								while ($row=mysql_fetch_row($result)) {
									if ($i==1) {
										echo "<option value='".$row[0]."' selected>".$row[1]."</option>";
										$i+=1;
									}
									else
										echo "<option value='".$row[0]."'>".$row[1]."</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td> Package:</td>
						<td>
							
							<?php // display the Package name but put package ID in the form
								$sql="SELECT PkgName FROM packages where PackageId='".$bookings['PackageId']."';";
								$result=mysql_query($sql) or die(mysql_error());
								if ($result) {
									$row=mysql_fetch_assoc($result);
									echo "<input type='hidden' name='package' value='".$bookings['PackageId'] ."' >".$row['PkgName'] ;
								}
							?>
						</td>
					</tr>
					
					<tr>
					  <td ><input type="submit" name="submit" value="Booking" /></td>
					  <td ><?=$submitFeedback;?></td>
					</tr>
				  </table>			
				</form>
			</div> <!--  end of content div -->

			<?php
				mysql_close($conn);	
				include_once("footer.php");
			?>
		</div>
	</body>	
</html>
