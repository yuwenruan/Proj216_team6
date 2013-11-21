<?php
/* Team 6 TravelExperts Workshop 1: Proposal, OOSD Fall 2013 */
/*   Paul Millilgan SAIT-ID:000146584, 17 Nov 2013           */

/****** payment.php: accept a payment from the customer */
/*            requires session variables as follows */
/*                $_SESSION['login']  = 'customer' or 'agent' */
/*                $_SESSION['order']  = the desired package's ID */
/*                $_SESSION['custId'] = the customer's ID */

  session_start();
  $abort = "";
  if(!isset($_SESSION['login'])){
    $_SESSION['message'] = "payment.php: user is not logged in";
    $abort = "abort.php";
  }else{
    $userType = $_SESSION['login'];
    if( ($userType!='customer') && ($userType!='agent') ){
      $_SESSION['message'] = "payment.php: logged in user not customer or agent";
	  $abort = "abort.php";
    }else if( $userType=='customer' ){
      if(!isset($_SESSION['customerId'])){
        $_SESSION['message'] = "payment.php(customer): customer ID not set";
	    $abort = "abort.php";
      }else{
	    $customerId = $_SESSION['customerId'];
	  }
	  if(!isset($_SESSION['order'])){
        $_SESSION['message'] = "payment.php: order not set to package ID";
	    $abort = "abort.php";
      }else{
	    $packageId = $_SESSION['order'];
	  }
    }else if( $userType=='agent' ){
	  /* get customer ID and package ID from agent */
        /* display customer table and package table with IDs */
        /* form to get customer ID and package ID */
	  $customerId = 105;
	  $packageId = 1;
    }
  }


    /******* submitQuery: submit a query to the database and return the result */
	function submitQuery($sql){
		//connect to database
		$conn=mysql_connect("localhost","root","");
		$db=mysql_select_db('travelexperts')
			or die("Could not connect to travelexperts database");
		$result=mysql_query($sql);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $sql;
			die($message);
		}
		mysql_close($conn);
		return $result;
	}

    /****** displayPackage: */
    function displayPackage($row){
	
      print("<table border=1>");
      print("<tr>");
	  print("  <td>Name</td>");
	  print("  <td>Description</td>");
	  print("  <td>Price</td>");
	  print("  <td>Leaving</td>");
	  print("  <td>Returning</td>");
      print("</tr>");
      print("<tr>");
	  $name = $row['PkgName'];
      print("<td>$name</td>");
	  $description = $row['PkgDesc'];
      print("<td>$description</td>");
	  $price = $row['PkgBasePrice'] + $row['PkgAgencyCommission'];
      print("<td>$$price</td>");
      $leaving = date("j M Y",strtotime($row['PkgStartDate']));
      print("<td>$leaving</td>");
      $returning = date("j M Y",strtotime($row['PkgEndDate']));
      print("<td>$returning</td>");
      print("</tr>");
      print("</table>");
	  return($price);
    }

    /******* displayCustomer: */
    function displayCustomer($row){
      print("<table border=1>");
	  print("<tr>");
	  print("  <td>Name</td>");
	  print("  <td colspan=5>Address</td>");
	  //print("  <td>Home Phone</td>");
	  //print("  <td>Work Phone</td>");
	  //print("  <td>Email</td>");
	  print("</tr>");
      print("<tr>");
	  $name = $row['CustFirstName'] . " ";
	  $name .= $row['CustLastName'];
	  print("  <td>$name</td>");
	  $address = $row['CustAddress'];
	  print("  <td>$address</td>");
	  $city = $row['CustCity'];
	  print("  <td>$city</td>");
	  $prov = $row['CustProv'];
	  print("  <td>$prov</td>");
	  $postal = $row['CustPostal'];
	  print("  <td>$postal</td>");
	  $country = $row['CustCountry'];
	  print("  <td>$country</td>");
	  //$homePhone = formatPhoneNumber($row['CustHomePhone']);
	  //print("  <td>$homePhone</td>");
	  //$businessPhone = formatPhoneNumber($row['CustBusPhone']);
	  //print("  <td>$businessPhone</td>");
	  //$email = $row['CustEmail'];
	  //print("  <td>$email</td>");
      print("</tr>");
      print("</table>");
      return($name);
    }

    /******* displayCreditCard: */
    function displayCreditCard($row){
      print("<table border=1>");
	  print("<tr>");
	  print("  <td>Name</td>");
	  print("  <td>Number</td>");
	  print("  <td>Expiry</td>");
	  print("</tr>");
      print("<tr>");
	  $name = $row['CCName'];
	  print("  <td>$name</td>");
	  $number = $row['CCNumber'];
	  print("  <td>$number</td>");
      $expiry = date("j M Y",strtotime($row['CCExpiry']));
	  print("  <td>$expiry</td>");
      print("</tr>");
      print("</table>");
      return($name);
    }


  //Customer Registration:
  $sql = "SELECT * FROM customers WHERE customerId=" . $customerId;
  print("<h2>$sql</h2>");
  $result = submitQuery($sql);
  if ($row=mysql_fetch_assoc($result)) {
    displayCustomer($row);
	$custName = $row['CustFirstName'] . " ";
	$custName .= $row['CustLastName'];
  }else{
    $_SESSION['message'] = "payment.php: customerId not in database";
	$abort = "abort.php";
  }
  //Selected Package:
  $sql = "SELECT * FROM packages WHERE packageId=" . $packageId;
  print("<h2>$sql</h2>");
  $result = submitQuery($sql);
  if ($row=mysql_fetch_assoc($result)) {
    displayPackage($row);
	$pkgName = $row['PkgName'];
	$pkgPrice = $row['PkgBasePrice'] + $row['PkgAgencyCommission'];
  }else{
    $_SESSION['message'] = "payment.php: packagId not in database";
	$abort = "abort.php";
  }
  //OnFile Credit Card information:
  $sql = "SELECT * FROM creditcards WHERE customerId=" . $customerId;
  print("<h2>$sql</h2>");
  $result = submitQuery($sql);
  if ($row=mysql_fetch_assoc($result)) {
    displayCreditCard($row);
	$CCname = $row['CCName'];
	$CCnumber = $row['CCNumber'];
    $CCexpiry = date("j M Y",strtotime($row['CCExpiry']));
  }


if($abort!="") header("Location: abort.php");
else{
  $l = $_SESSION['login'];
  $o = $_SESSION['order'];
  $c = $_SESSION['customerId'];
  print("<h1>login=$l order=$o cid=$c</h1>");
  print("<h1>cid=$customerId pid=$packageId</h1>");
}

?>
<!DOCTYPE html>

<html>
<head>
	<title>Payment Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
      <?php	include_once("header.php"); ?>

<div id="content">

  <ul>
   <li>Customer: $custName</li>
   <li>Package: $pkgName</li>
   <li>Price: $$pkgPrice</li>
   <li>Credit Card Type: $CCname</li>
   <li>Credit Card Number: $CCnumber</li>
   <li>Credit Card Expiry: $CCexpiry</li>
  </ul>

</div>

<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>
