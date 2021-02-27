<?php 

session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

$adult = $_SESSION['adult'];
$teen = $_SESSION['teen'];
$child = $_SESSION['child'];
$under3 = $_SESSION['under3'];

?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Passenger Details</title>
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
				<h2>Passenger Details</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="../private/passengerDetailsHandle.php" method="post" onSubmit="return checkForm(this)">
					<?php
					for ($i = 1; $i <= $adult; $i++) {
						echo "Adult $i Forename: <input type='text' name='adultForename$i' required><br>";
						echo "Adult $i Surname: <input type='text' name='adultSurname$i' required><br><br>";
					}
					echo "<br>";
					for ($i = 1; $i <= $teen; $i++) {
						echo "Teen $i Forename: <input type='text' name='teenForename$i' required><br>";
						echo "Teen $i Surname: <input type='text' name='teenSurname$i' required><br><br>";
					}
					echo "<br>";
					for ($i = 1; $i <= $child; $i++) {
						echo "Child $i Forename: <input type='text' name='childForename$i' required><br>";
						echo "Child $i Surname: <input type='text' name='childSurname$i' required><br><br>";
					}
					echo "<br>";
					for ($i = 1; $i <= $under3; $i++) {
						echo "Under 3's $i Forename: <input type='text' name='under3Forename$i' required><br>";
						echo "Under 3's $i Surname: <input type='text' name='under3Surname$i' required><br><br>";
					}
					echo "<br>";
					?>
					
					<br><input type="button" value="Back" id="button" onClick="history.back()">
					<input type="submit" value="Confirm" id="button"><br>
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
