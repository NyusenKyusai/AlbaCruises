<?php 

session_start(); 

// Linking the page to the database page
require_once('../private/databaseClass.php');

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

// Getting the username from the session
$username = $_SESSION['username'];
//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

$bookingID = $_POST['bookingID'];

//echo $username;

$bookingInfo = $db->getBookingInfo($conn, $bookingID, $username);

//var_dump($bookingInfo);
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Edit Booking Info</title>
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
	<div class="sidenav">
		<h3>Customers</h3>
		<a href="editDetails.php">Edit Account Details</a>
		<a href="boardingPasses.php">My Boarding Passes</a>
		<a href="bookingInfo.php">My Bookings</a>
		<?php
		if ($_SESSION['adminStatus'] == 'admin') {
		?>
		<h3 class="admin">Admin</h3>
		<a href="adminStatistics.php">Statistics</a>
		<?php
		}
		?>
	</div>
	<div class="main">
		<h3>Edit Booking Info</h3>
		<form action="../private/updateBookingInfoHandle.php" method="post" onSubmit="return checkForm(this)">
			Forename: <br><input type="text" name="forename" value="<?php echo $bookingInfo['bookingForename']; ?>" required><br>
			Surname: <br><input type="text" name="surname" value="<?php echo $bookingInfo['bookingSurname']; ?>" required><br>
			Address 1: <br><input type="text" name="address1" value="<?php echo $bookingInfo['address1']; ?>" required><br>
			Address 2: <br><input type="text" name="address2" value="<?php echo $bookingInfo['address2']; ?>" required><br>
			Phone: <br><input type="tel" name="contact" value="<?php echo $bookingInfo['contact']; ?>" required><br>
			Postcode: <br><input type="text" name="postcode" value="<?php echo $bookingInfo['postcode']; ?>" required><br>
			<input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">
			<br><input type="button" value="Back" id="button" onClick="history.back()">
			<input type="submit" value="Confirm" id="button"><br>
		</form>
	</div>
	<!-- InstanceEndEditable -->
	<footer>
		<!--
		Footer
		-->
		<p>18018535 &copy; 2020</p>
	</footer>
</body>
<!-- InstanceEnd --></html>
