<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

$travelDate = $_POST['travelDate'];
$travelOrigin = $_POST['from'];
$travelDestination = $_POST['to'];

// Linking the page to the database page
require_once('../private/databaseClass.php');
require('../private/bookingClass.php');
require('../private/usableFunctions.php');

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

// Starting a instance of the booking class
$booking = new Bookings($travelOrigin, $travelDestination);

$legs = 'legs';

//Calling function from the booking class
$journeyArray = $booking->__get($legs);

$_SESSION['journeyArray'] = $journeyArray;

// Calling a function from database class to get the details from the database
list($seatDetails, $wheelchairDetails) = processJourney($journeyArray, $db, $conn, $travelDate);

//var_dump($seatDetails);

//echo $travelDate;
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Under Occupancy Info</title>
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
		for ($i = 0; $i < count($seatDetails); $i++) {
			if ($seatDetails[$i][0] == NULL) {
				$seatDetails[$i][0] = 0;
			}
			
			if ($wheelchairDetails[$i][0] == NULL) {
				$wheelchairDetails[$i][0] = 0;
			}
			
			echo "" . $journeyArray[$i][0] . ": " . $journeyArray[$i][1] . " to " . $journeyArray[$i][2] . "<br>";
			echo "Number of Passengers: " . $seatDetails[$i][0] . "<br>";
			echo "Wheelchair Access Seat Taken: " . $wheelchairDetails[$i][0] . "<br><br>";
		}
		?>
		<div class='card'>
			&nbsp;&nbsp;Passenger Names
			<form action='underOccupancyPassNames.php' class='formButtons' method='post'>
				<input type="hidden" name="travelDate" value="<?php echo $travelDate; ?>">
				<input type='submit' name='submit' value='View'>
			</form>
		</div><br>
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
