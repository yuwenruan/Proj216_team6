<!--
	Author: Yu Wen Ruan
	Course: PROJ216
	Date: Nov 21, 2013
	
	payment.php
	booking page for customer to book the travel packages
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
			<?php
				$bookings=array();
				$bookings['BookingDate']=isset($_POST["bdate"])? $_POST["bdate"]:date(Y-m-d);
				$bookings['BookingNo']=isset($_POST["bnumber"])? $_POST["bnumber"]:"";
				$bookings['TravelerCount']=isset($_POST["travels"])? $_POST["travels"]:"";
				$bookings['TripTypeId']=isset($_POST["ttype"])? $_POST["ttype"]:"";
				$bookings['PackageId']=isset($_POST["package"])? $_POST["package"]:"";
				
				//connect to database
				$conn=mysql_connect("localhost","root","");
				$db=mysql_select_db('travelexperts') or die("Could not connect");
				
				//if login is customer
				if (isset($_SESSION['login']) && $_SESSION['login']=='customer') {
					//if customer id is get
					if (isset($_SESSION['customerId'])) { 
						$customerId=$_SESSION['customerId'];
						
						if (isset($_SESSION['order'])) {
							$packageId=$_SESSION['order'];
						}
					}
				}
				else if (isset($_SESSION['login']) && $_SESSION['login']=='agent'){
					
				}
				else {
					mysql_close($conn);	
					header("Location: index.php");
				}
				
			?>
				<form method="POST">
					<table>
					<tr>
						<td>Date:</td>
						<td><input type="text" name="bdate" value="<?echo $bookings['BookingDate'];?>"/></td>						
					</tr>
					<tr>
						<td>Booking Number:	</td>	
						<td><input type="text" name="bnumber" value="<?echo $bookings['BookingNo'];?>"/></td>						
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
								$result=mysql_query($sql);
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
						</td>
					</tr>
					<tr>
						<td> Package:</td>
						<td>
							
							<?php
								//set value for select element
								if ($packageId=="") {
									echo "<select name='package' value='".$bookings['PackageId'] ."' >" ;
									$sql="SELECT PkgName FROM packages;";
									$result=mysql_query($sql);
									$i=1;
									if ($result) {
										while ($row=mysql_fetch_row($result)) {
											if ($i==1) {
												echo "<option value='".$row[0]."' selected>".$row[1]."</option>";
												$i+=1;
											}
											else
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
										}
									}
								}
								else {
									$sql="SELECT PkgName FROM packages where PackageId='".$packageId."';";
									$result=mysql_query($sql);
									if ($result) {
										$row=mysql_fetch_row($result);
										$bookings['PackageId']=$row[0];									
									}
									echo "<input name='package' value='".$bookings['PackageId'] ."' >" ;
								}
							?>
						</td>
					</tr>
					
					<tr><td col="2"><input type="submit" name="submit" value="Booking" /></tr>
					</table>
					
				
				</form>
			</div>
			<?php
				mysql_close($conn);	
				include_once("footer.php");
			?>
		</div>
	</body>	
</html>
