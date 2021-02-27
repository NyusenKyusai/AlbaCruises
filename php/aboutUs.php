<?php session_start(); ?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>About Us</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!--
Linking the CSS pages to the template
-->
<link href="../css/style.css" rel="stylesheet" type="text/css">
<!--
Linking the Javascript pages to the template
-->
<script src="../js/javascriptFunctions.js"></script>
</head>

<body>
<!--
Linking the logo to the template
-->
	<nav>
		<ul id="logoBar">
			<li style="float: left"><img src="../images/cruisesLogo.fw.png" alt="" id="Logo"></li>
			<?php
			if (isset($_SESSION['username'])) {
				echo '<li><a href="../private/logoutUser.php">Log Out</a></li>';
				echo '<li><a href="../php/editDetails.php">Account</a></li>';
			} else {
				echo '<li><a href="../php/registerUser.php">Register</a></li>';
				echo '<li><a href="../php/loginUser.php">Login</a></li>';
			}
			?>
		</ul>
		<!--
		Creating the navigational menu for the template
		-->
		<ul id="navBar">
			<li><a href="aboutUs.php">About Us</a></li>
			<li><a href="exploreBooking.php">Explore</a></li>
			<li><a href="newsletter.php">News</a></li>
			<li style="float: right;"><a href="contactUs.php">Contact Us</a></li>
		</ul>
	</nav>
	<!-- InstanceBeginEditable name="MainRegion" -->
	<main>
		<div class="container" id="aboutUsContainer">
			<section class="child">
				<img src="../images/Image1.jpg" alt="">
				<h4>Book a Cruise with us to Eigg, Muck or Rum</h4>
				<form action="exploreBooking.php" method="get">
					<input type="submit" value="Explore" id="button">
				</form>
			</section>
			<section class="child">
				<img src="../images/Image2.jpg" alt="">
				<h4>Special Events for Frequent Customers</h4>
				<form action="specialEvents.php" method="get">
					<input type="submit" value="Ceilidh" id="button">
				</form>
			</section>
		</div>
	</main>
	<!-- InstanceEndEditable -->
	<footer>
		<!--
		Footer
		-->
		<p>18018535 &copy; 2020</p>
	</footer>
</body>
<!-- InstanceEnd --></html>
