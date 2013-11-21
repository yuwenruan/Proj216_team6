<?php
  session_start();
  if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
  }else{
    $message = "message not set";
  }

  $keys = array('login','order','customerId','message');
  foreach($keys as $key){
    if(isset($_SESSION[$key])){
	  $val = $_SESSION[$key];
      print("<h2>$key set to: '$val'</h2>");
    }else{
	  print("<h2>$key not set</h2>");
	}
  }

  session_destroy();
  print("<h1>Abort message:</h1><h2>$message (session destroyed)</h2>");
  print("<a href='./testpayment.php'>TestPayment</a>");
?>
