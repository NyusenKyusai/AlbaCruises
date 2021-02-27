<?php 
session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Linking the page to the database page and the bookingClass page
require_once('../private/databaseClass.php');
require('../private/bookingClass.php');
require('../private/usableFunctions.php');

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

// Getting info sent through session
$travelDate = $_SESSION['travelDate'];
$travelDateReturn = $_SESSION['travelDateReturn'];
$travelOrigin = $_SESSION['travelOrigin'];
$travelDestination = $_SESSION['travelDestination'];
$ticketType = $_SESSION['ticketType'];

// Starting a instance of the booking class
$booking = new Bookings($travelOrigin, $travelDestination);

$legs = 'legs';

//Calling function from the booking class
$journeyArray = $booking->__get($legs);

$_SESSION['journeyArray'] = $journeyArray;

// Calling a function from database class to get the details from the database
list($seatDetails, $wheelchairDetails) = processJourney($journeyArray, $db, $conn, $travelDate);

$availableSeats = availableSeats($seatDetails);

if ($ticketType == 'return') {
	// Starting a instance of the booking class
	$bookingReturn = new Bookings($travelDestination, $travelOrigin);

	//Calling function from the booking class
	$journeyArrayReturn = $bookingReturn->__get($legs);
	
	$_SESSION['journeyArrayReturn'] = $journeyArrayReturn;

	// Calling a function from database class to get the details from the database
	list($seatDetailsReturn, $wheelchairDetailsReturn) = processJourney($journeyArrayReturn, $db, $conn, $travelDateReturn);
	
	$availableSeatsReturn = availableSeats($seatDetailsReturn);
}

//var_dump($wheelchairDetails);

//var_dump($seatDetails);

//echo count($seatDetails[0]);

?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Travel Dates</title>
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
				<h2>Potential Dates</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="setBookingInfo.php" method="post">
					Date of Travel: <br><input type="date" name="travelDate" value="<?php echo $travelDate; ?>" readonly><br><br>
					Number of seats available: <br>
					<?php
					$legSeatsArray = [];
					$legSeatsArrayReturn = [];
					
					for ($i = 0; $i < count($journeyArray); $i++) {
						$legOrigin = $journeyArray[$i][1];
						$legDestination = $journeyArray[$i][2];
						
						if ($seatDetails == NULL) {
							$legSeats = 30;
						} else {
							$legSeats = 30 - $availableSeats[$i];
						}
						
						array_push($legSeatsArray, $legSeats);
						
						if ($wheelchairDetails[$i] == NULL or in_array('1', $wheelchairDetails)) {
							$legWheelchairSeats = 1;
							$_SESSION['legWheelchairSeats'] = 'true';
						} else {
							$legWheelchairSeats = 0;
							$_SESSION['legWheelchairSeats'] = 'false';
						}
						
						echo "$legOrigin to $legDestination: <input type='text' name='leg" . $i . "' value='$legSeats' readonly><br>";
						echo "Wheelchair Seats Available: <input type='text' name='wheelchairLeg" . $i . "' value='$legWheelchairSeats' readonly><br>";
						//echo $legDestination;
					}
					
					$_SESSION['legSeatsArray'] = $legSeatsArray;
					
					if ($ticketType == 'return') {
					?>
					Date of Return: <br><input type="date" name="travelDateReturn" value="<?php echo $travelDateReturn; ?>" readonly><br><br>
					Number of seats available: <br>
					<?php
						for ($i = 0; $i < count($journeyArrayReturn); $i++) {
							$legOriginReturn = $journeyArrayReturn[$i][1];
							$legDestinationReturn = $journeyArrayReturn[$i][2];
						
							if ($seatDetailsReturn == NULL) {
								$legSeatsReturn = 30;
							} else {
								$legSeatsReturn = 30 - $availableSeatsReturn[$i];
							}
							
							array_push($legSeatsArrayReturn, $legSeatsReturn);
						
							if ($wheelchairDetailsReturn[$i] == NULL or in_array('1', $wheelchairDetailsReturn)) {
								$legWheelchairSeatsReturn = 1;
								$_SESSION['legWheelchairSeatsReturn'] = 'true';
							} else {
								$legWheelchairSeatsReturn = 0;
								$_SESSION['legWheelchairSeatsReturn'] = 'false';
							}
						
							echo "$legOriginReturn to $legDestinationReturn: <input type='text' name='leg" . $i . "Return' value='$legSeatsReturn' readonly><br>";
							echo "Wheelchair Seats Available: <input type='text' name='wheelchairLeg" . $i . "Return' value='$legWheelchairSeatsReturn' readonly><br>";
							//echo $legDestination;
						}
						
						$_SESSION['legSeatsArrayReturn'] = $legSeatsArrayReturn;
					}
					?>
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
