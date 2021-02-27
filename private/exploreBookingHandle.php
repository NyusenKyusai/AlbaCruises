<?php
// Display errors to help with fixing errors
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

session_start();

// Linking the page to the database page
require_once('databaseClass.php');

// Calling function from database page
$db = new Database();
$conn  = $db->getConnection();


if(isset($_POST['submit'])) {
	
	$travelDate = $_POST['travelDate'];
	$travelDateReturn = $_POST['travelDateReturn'];
	$travelOrigin = $_POST['from'];
	$travelDestination = $_POST['to'];
	$ticketType = $_POST['ticketType'];
	
	
	
	if ($ticketType == "return" and $travelDateReturn == "") {
		// Creating Error Code
		$error_code = 'No Return Travel Date';
		//Redirecting back to the exploreBooking page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
		exit;
	}

	$dayOfWeek = date('l', strtotime($travelDate));
	$dayOfWeekReturn = date('l', strtotime($travelDateReturn));
	
	$possibleLocation = $db->portsByDay($conn, $dayOfWeek);
	$possibleLocationReturn = $db->portsByDay($conn, $dayOfWeekReturn);
	
	$possibleOrigins = in_array($travelOrigin, $possibleLocation);
	$possibleDestinations = in_array($travelDestination, $possibleLocation);
	$possibleOriginsReturn = in_array($travelOrigin, $possibleLocationReturn);
	$possibleDestinationsReturn = in_array($travelDestination, $possibleLocationReturn);
	
	if ($possibleOrigins == 0 or $possibleDestinations == 0) {
		// Creating Error Code
		$error_code = 'Ports Unavailable on Travel Date';
		//Redirecting back to the exploreBooking page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
		exit;
	} else if (($possibleOriginsReturn == 0 or $possibleDestinationsReturn == 0) and $ticketType == 'return') {
		// Creating Error Code
		$error_code = 'Ports Unavailable on Return Date';
		//Redirecting back to the exploreBooking page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
	} else if (($travelDate > $travelDateReturn) and $travelDateReturn != "") {
		// Creating Error Code
		$error_code = 'Return Date Should Be Later than Travel Date';
		//Redirecting back to the exploreBooking page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
	} else if ($travelOrigin == $travelDestination) {
		// Creating Error Code
		$error_code = "Ports must be different";
		//Redirecting back to the exploreBooking page
		header('Location: ' . '../php/exploreBooking.php' . '?error=' . urlencode($error_code));
	} else {
		// Creating the session and adding the values submitted to it
		$_SESSION['travelDate'] = $travelDate;
		$_SESSION['travelDateReturn'] = $travelDateReturn;
		$_SESSION['travelOrigin'] = $travelOrigin;
		$_SESSION['travelDestination'] = $travelDestination;
		$_SESSION['ticketType'] = $ticketType;
		
		header('Location: ' . '../php/travelDates.php');
	}

	
} else {
	// Redirecting to login page
	header("Location: " . "../php/exploreBooking.php");
}

?>