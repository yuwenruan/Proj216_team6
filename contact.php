<?php
/* Team 6 TravelExperts Workshop 1: Proposal, OOSD Fall 2013 */
/*   Paul Millilgan SAIT-ID:000146584, 17 Nov 2013           */

/****** contact.php: display contact info & optionally send email */

  session_start();

    /* remember whether this page was reloaded due to form submission */
  $formSubmitted = isset($_POST['sendButton']); 

    /* if form was submitted then remember what was entered else empty string */
  $fromEmailAddr = isset($_POST['fromEmailAddr']) ? $_POST['fromEmailAddr'] : "";
  $emailSubject  = isset($_POST['emailSubject'])  ? $_POST['emailSubject']  : "";
  $emailMessage  = isset($_POST['emailMessage'])  ? $_POST['emailMessage']  : "";

  $sendAttempted = false;  /* will be true if all values are acceptable  */
  $sendSuccessful = false; /* will be set if a an email send is attempted */
  if(   ($fromEmailAddr != "")
     && ($emailSubject  != "")
     && ($emailMessage  != "") ){
	$sendAttempted = true; /* all form values were entered */

    $toEmailAddr = "info@TravelExperts.com";
	//mail($toEmailAddr, $emailSubject, $emailMessage, "From:".$fromEmailAddr);
	$sendSuccessful = false; /* email server not yet configured */
  }
?>
<!DOCTYPE html>

<html>
<head>
	<title>Contact Travel Experts</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
      <?php	include_once("header.php"); ?>

<div id="content">

<?php

	/******* formatPhoneNumber: return phone number formated (aaa)ppp-nnnn */
	function formatPhoneNumber($n){
		if( $n[0] != "(" ){ /* assume 'aaapppnnnn' and build '(aaa)ppp-nnnn' */
			$fn = "(" . substr($n, 0, 3) . ")";
			$fn .= substr($n, 3, 3) . "-" . substr($n, 6, 4);
			return $fn;
		}else if( $n[5] == " " ){ /* assume '(aaa) ppp-nnnn' so remove space */
		$fn = substr($n, 0, 5) . substr($n, 6, 8);
		return $fn;
		}
	}


	//connect to database
	$conn=mysql_connect("localhost","root","");
	$db=mysql_select_db('travelexperts') or die("Could not connect");

	$sql_agency="SELECT * FROM agencies;";
	$result=mysql_query($sql_agency) or die(mysql_error());
	
	print("<h1>Contact Us!</h1>");
	print("<h3>For assistance contact one of our qualified agents:</h3>");

	while ($row=mysql_fetch_assoc($result)) {
		$agencyid=$row['AgencyId'];
		$sql_agent="SELECT * from agents where AgencyId='".$agencyid."';";
		$sql_result=mysql_query($sql_agent) or die(mysql_error());
		if (mysql_num_rows($sql_result) > 0) {					
			echo "<table align='center'>";
			//echo "<tr><td>Name</td><td>Phone</td><td></td><td>Email</td></tr>";
			while($row_agent=mysql_fetch_assoc($sql_result)) {
				echo "<tr>";
				echo "  <td>".$row_agent['AgtFirstName']." ".$row_agent['AgtLastName']."</td>";
				$phone = formatPhoneNumber($row_agent['AgtBusPhone']);
				echo "  <td>".$phone."</td><td></td>";
				echo "  <td>".$row_agent['AgtEmail']."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<p align='center'>";
			echo "<b>Located in our office at:</b><br>";
			echo $row['AgncyAddress'].", ";
			echo $row['AgncyCity'].", ";
			echo $row['AgncyProv']." ".$row['AgncyPostal']."<br>";
			$phone = formatPhoneNumber($row['AgncyPhone']);
			$fax   = formatPhoneNumber($row['AgncyFax']);
			echo "Phone: ".$phone."<br> Fax:  ".$fax."<br><br>";
			echo "</p>";
			}
		}
	mysql_close($conn);

	print("<h2>Or send an email:</h2>");
?>

    <form method="post" name="emailForm">
        <table>
          <tr>
            <td align="right">To:</td>
      	    <td>info@TravelExperts.com</td>
          </tr>
          <tr>
            <td align="right">Your Email Address:</td>
      	    <td>
			  <input type="text" name="fromEmailAddr" size="40" maxlength="40"
      	                    value=<?= $fromEmailAddr ?>>
      	      <?php if($formSubmitted){
                      if($fromEmailAddr=="") print(" Missing");
                    }
              ?>
      	    </td>
          </tr>
          <tr>
            <td align="right">Subject:</td>
      	    <td>
			  <input type="text" name="emailSubject" size="40" maxlength="40"
      	                    value=<?= $emailSubject ?>>
      	      <?php if($formSubmitted){
                      if($emailSubject=="") print(" Missing");
                    }
              ?>
      	    </td>
          </tr>
          <tr>
            <td align="right">Message:</td>
      	    <td>
			  <textarea name="emailMessage" rows="15" cols="31" maxlength="1000">
			  <?php print("$emailMessage"); ?>
			  </textarea>
      	      <?php if($formSubmitted){
                      if($emailMessage=="") print(" Missing");
                    }
              ?>
      	    </td>
          </tr>
        </table>
        <input type="submit" name="sendButton" value="Send">

        <?php
          if($formSubmitted){ /* if form was submitted then give feedback */
            if($sendAttempted){
              if($sendSuccessful){
                print("Email sent<br>");
              }else{
                print("Email server not yet configured<br>");
              }
	        }else{ /* missing one or more values */
              print(" Must enter your email address, subject & message.<br>");
	        }
          }
        ?>
    </form>
</div>

<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>
