<!--
	menu.php
	Author: Yu Wen Ruan
	Course: CPRG216
	Date: Nov 14, 2013
-->
<div id="menu"> 
	<a class="links" href="index.php" >Home</a>
	<a class="links" href="packages.php" >Packages</a>
	<a class="links" href="contact.php" >Contact Us</a>
</div>
<?php
	if (isset($_SESSION['login']) && $_SESSION['login']=='agent') {
?>
<div id="submenu"> 
	<a class="links" href="contact.php" >Agent Management Module</a>
	<a class="links" href="contact.php" >Customer Management Module</a>
	<a class="links" href="contact.php" >Supplier Management Module</a>
	<a class="links" href="contact.php" >Report Generation</a>
</div>	
<?php
	}
?>