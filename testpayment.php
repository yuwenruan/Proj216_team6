<?php
  session_start();
  $_SESSION['login'] = 'customer';
  //$_SESSION['login'] = 'agent';
  $_SESSION['customerId'] = 105;
  $_SESSION['order'] = 1;
/*
/**/
  $_SESSION['message'] = "testpayment.php";
  header("Location: payment.php");

?>
