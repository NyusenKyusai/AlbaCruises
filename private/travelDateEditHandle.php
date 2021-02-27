<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 

// Linking the page to the database page
require_once('../private/databaseClass.php');
require('../private/bookingClass.php');
require('../private/usableFunctions.php');

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

$bookingID = $_SESSION['bookingID']; 
$oldTravelDate = $_SESSION['oldTravelDate'];
$newTravelDate = $_POST['newTravelDate']; 

//echo $oldTravelDate;

//echo $newTravelDate;

$portsArray = $db->findPortsByBookingID($conn, $bookingID);

$dayOfWeek = date('l', strtotime($newTravelDate));
$possibleLocation = $db->portsByDay($conn, $dayOfWeek);

$possibleOrigins = in_array($portsArray['trueOrigin'], $possibleLocation);
$possibleDestinations = in_array($portsArray['trueDestination'], $possibleLocation);
//var_dump($portsArray);


if ($possibleOrigins == 0 or $possibleDestinations == 0) {
	// Creating Error Code
	$error_code = 'Ports Unavailable on Travel Date';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/bookingInfo.php' . '?error=' . urlencode($error_code));
	exit;
}

// Starting a instance of the booking class
$booking = new Bookings($portsArray['trueOrigin'], $portsArray['trueDestination']);

$legs = 'legs';

//Calling function from the booking class
$journeyArray = $booking->__get($legs);

// Calling a function from database class to get the details from the database
list($oldSeatDetails, $oldWheelchairDetails) = processJourney($journeyArray, $db, $conn, $oldTravelDate);
list($newSeatDetails, $newWheelchairDetails) = processJourney($journeyArray, $db, $conn, $newTravelDate);

$oldSeatsNeeded = availableSeats($oldSeatDetails);
$newSeatsNeeded = availableSeats($newSeatDetails);


for ($i = 0; $i < count($oldSeatDetails); $i++) {
	if ($newSeatsNeeded[$i] == NULL){
		$newSeatsNeeded[$i] = 0;
	}
	
	if ($oldSeatsNeeded[$i] > (30 - $newSeatsNeeded[$i])) {
		// Creating Error Code
		$error_code = 'No Seats Available';
		//Redirecting back to the setBookingInfo page
		header('Location: ' . '../php/bookingInfo.php' . '?error=' . urlencode($error_code));
		exit;
	}
}

for ($i = 0; $i < count($oldWheelchairDetails); $i++) {
	if ($newWheelchairDetails[$i][0] == NULL){
		$newWheelchairDetails[$i][0] = 0;
	}
	
	if ($newWheelchairDetails[$i][0] == 1 and $oldWheelchairDetails[$i][0] == 1) {
		// Creating Error Code
		$error_code = 'No Wheelchair Access Available';
		//Redirecting back to the setBookingInfo page
		header('Location: ' . '../php/bookingInfo.php' . '?error=' . urlencode($error_code));
		exit;
	}
}

//var_dump($oldWheelchairDetails);
//var_dump($newWheelchairDetails);

$db->updateTravelDate($conn, $bookingID, $newTravelDate, $username);

header('Location: ' . '../php/bookingInfo.php');

?>