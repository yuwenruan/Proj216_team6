<!--
	
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 14, 2013
	
	menu.php
	Define the menu style when mouse hover
	
-->
<style type="text/css">
#menu a:hover {
	color: red;
	margin-top:-10px;
	font-weight:bold;
}

#submenu a:hover {
	color: red;
	margin-top:-10px;
	font-weight:bold;
}

</style>
<div id="menu"> 
	<a class="links" href="index.php" >Home</a>
	<a class="links" href="packages.php" >Packages</a>
	<a class="links" href="contact.php" >Contact Us</a>
</div>
<?php
	//when agent login, the extra menu will show the menu for management: employees, customers, suppliers, reports
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
?>
<div id="submenu"> 
	<a class="links" href="agentmanagement.php" >Agent Management</a>
	<a class="links" href="customermanagement.php" >Customer Management</a>
	<a class="links" href="contact.php" >Supplier Management</a>
	<a class="links" href="contact.php" >Report Generation</a>
</div>	
<?php
	}
?>