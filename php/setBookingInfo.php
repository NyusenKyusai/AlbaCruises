<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 

// Getting info sent through session
$travelDate = $_SESSION['travelDate'];
$travelDateReturn = $_SESSION['travelDateReturn'];
$legSeatsArray = $_SESSION['legSeatsArray'];
$legWheelChairSeats = $_SESSION['legWheelchairSeats'];

if (isset($_SESSION['legSeatsArrayReturn'])) {
	$legSeatsArrayReturn = $_SESSION['legSeatsArrayReturn'];
}

if (isset($_SESSION['legWheelchairSeatsReturn'])) {
	$legWheelChairSeatsReturn = $_SESSION['legWheelchairSeatsReturn'];
} else {
	$legWheelChairSeatsReturn = 'false';
}


$ticketType = $_SESSION['ticketType'];

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

for ($i = 0; $i < count($legSeatsArray); $i++) {
	if ($legSeatsArray[$i] == 0) {
		// Creating Error Code
		$error_code = 'No Seats Available';
		//Redirecting back to the setBookingInfo page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
		exit;
	}
}

if (isset($_SESSION['legSeatsArrayReturn'])) {
	for ($i = 0; $i < count($legSeatsArrayReturn); $i++) {
		if ($legSeatsArrayReturn[$i] == 0) {
			// Creating Error Code
			$error_code = 'No Seats Available Return';
			//Redirecting back to the setBookingInfo page
			header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
			exit;
		}
	}
}

if (isset($_GET['error']) and $_GET['error'] == "Too Many Passengers") {
	echo '<script language="javascript">';
	echo 'alert("Not enough seats available for the amount of passengers selected")';
	echo '</script>';
}
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Booking Information</title>
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
				<h2>Booking Information</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="../private/setBookingInfoHandle.php" method="post" onSubmit="return checkForm(this)">
					Forename: <br><input type="text" name="forename" required><br>
					Surname: <br><input type="text" name="surname" required><br>
					Address 1: <br><input type="text" name="address1" required><br>
					Address 2: <br><input type="text" name="address2" required><br>
					Phone: <br><input type="tel" name="contact" required><br>
					Postcode: <br><input type="text" name="postcode" required><br>
					Date of Travel: <br><input type="date" name="travelDate" value="<?php echo $travelDate ?>" readonly required><br><br>
					<?php
					if ($ticketType == 'return') {
						echo "Date of Return: <br><input type='date' name='travelDateReturn' value='$travelDateReturn' readonly required><br><br>";
					}
					?>
					Passengers: <br>
					<label for="adult">Adult: </label>
					<select class="1-30" name="adult" id="adult">
						<?php
						for ($i = 1; $i <= $legSeatsArray[0]; $i++) {
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select>
					<label for="teen">Teen (11-16): </label>
					<select class="1-29" name="teen" id="teen">
						<?php
						for ($i = 0; $i <= $legSeatsArray[0] - 1; $i++) {
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select><br>
					<label for="child">Child (3-10): </label>
					<select class="1-29" name="child" id="child">
						<?php
						for ($i = 0; $i <= $legSeatsArray[0] - 1; $i++) {
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select>
					<label for="under3">Under 3: </label>
					<select class="1-29" name="under3" id="under3">
						<?php
						for ($i = 0; $i <= $legSeatsArray[0] - 1; $i++) {
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select><br><br>
					<?php
					if ($legWheelChairSeats == 'true') {
					echo '
						Wheel Chair Access:<br>
						<input type="radio" id="yes" name="wheelchair" value="yes" required><label for="yes">Yes</label>
						<input type="radio" id="no" name="wheelchair" value="no"><label for="no">No</label><br><br>';
						
					}
					if ($legWheelChairSeatsReturn == 'true' and $ticketType == 'return') {
					echo '
						Wheel Chair Access Return:<br>
						<input type="radio" id="yes" name="wheelchairReturn" value="yes" required><label for="yes">Yes</label>
						<input type="radio" id="no" name="wheelchairReturn" value="no"><label for="no">No</label><br><br>';
						
					}
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
