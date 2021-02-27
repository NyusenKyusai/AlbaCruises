<?php session_start(); ?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Register</title>
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
		<div class="container" id="Container">
			<section class="child" id="title">
				<h2>Create a New Account</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="../private/registerHandle.php" method="post" onSubmit="return checkForm(this)">
					Username: <br><input type="text" name="username" required><br>
					Password: <br><input type="text" name="password" required><br>
					Date of Birth: <br><input type="date" name="dateBirth" required><br>
					Email: <br><input type="email" name="email" required><br>
					Would you like to receive <br>a monthly newsletter?<br>
					<input type="radio" id="yes" name="newsletter" value="yes" required><label for="yes">Yes</label>
					<input type="radio" id="no" name="newsletter" value="no"><label for="no">No</label><br>
					<br><input type="submit" value="Register" name="submit" id="button"><br>
				</form>
				<a href="loginUser.php">Log in?</a>
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
