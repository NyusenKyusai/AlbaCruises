<?php 

session_start(); 

$travelDate = $_POST['travelDate'];

// Linking the page to the database page
require_once('../private/databaseClass.php');
require('../private/usableFunctions.php');

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

$journeyArray = $_SESSION['journeyArray'];

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
} 

for ($i = 0; $i < count($journeyArray); $i++) {
	$passNames = $db->findPassNamesForReport($conn, $journeyArray[$i][1], $journeyArray[$i][2], $travelDate);
	
	$resultArray[] = [$passNames];
}

//var_dump($resultArray);

//var_dump($resultArray);
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Under Occupancy Passenger Names</title>
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
		<h3>Sailing Under Occupancy Info</h3>
		<?php
		for ($i = 0; $i < count($resultArray); $i++) {
			echo "Leg " . ($i + 1) . " Passenger Names<br><br>";
			for ($t = 0; $t < count($resultArray[$i][0]); $t++) {
				echo "Forename: " . $resultArray[$i][0][$t][0] . " Surname: " . $resultArray[$i][0][$t][1] . "<br>";
			}
			echo "<br>";
		}
		?>
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
