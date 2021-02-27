<?php
session_start();

require_once('databaseClass.php');

$username = $_SESSION['username'];

$travelDate = $_SESSION['travelDate'];
$travelDateReturn = $_SESSION['travelDateReturn'];
$ticketType = $_SESSION['ticketType'];
$travelOrigin = $_SESSION['travelOrigin'];
$travelDestination = $_SESSION['travelDestination'];

$forename = $_SESSION['forename'];
$surname = $_SESSION['surname'];
$address1 = $_SESSION['address1'];
$address2 = $_SESSION['address2'];
$contact = $_SESSION['contact'];
$postcode = $_SESSION['postcode'];
$passTotal = $_SESSION['passTotal'];

$journeyArray = $_SESSION['journeyArray'];

$adultArray = $_SESSION['adultArray'];
$teenArray = $_SESSION['teenArray'];
$childArray = $_SESSION['childArray'];
$under3Array = $_SESSION['under3Array'];

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

if ($ticketType == 'return') {
	$journeyArrayReturn = $_SESSION['journeyArrayReturn'];
}

if ($_SESSION['wheelchair'] == 'yes') {
	$legWheelChairSeats = 1;
} else {
	$legWheelChairSeats = 0;
}

if ($_SESSION['wheelchairReturn'] == 'yes') {
	$legWheelChairSeatsReturn = 1;
} else {
	$legWheelChairSeatsReturn = 0;
}

$userID = $db->usernameID($conn, $username);

$bookingInfoArray = [$userID['userID'], $forename, $surname, $address1, $address2, $contact, $postcode, $travelOrigin, $travelDestination, $travelDate];

$bookingID = $db->insertIntoBookingsInfo($conn, $bookingInfoArray);

for ($i = 0;$i < count($journeyArray); $i++) {
	$bookingPortsArray = [$bookingID['LAST_INSERT_ID()'], $journeyArray[$i][0], $passTotal, $journeyArray[$i][1], $journeyArray[$i][2], $legWheelChairSeats] ;
	
	$db->insertIntoBookingPorts($conn, $bookingPortsArray);
}

$count = 1;

for ($i = 0; $i < count($adultArray); $i++) {
	$db->insertPassNames($conn, $bookingID['LAST_INSERT_ID()'], $count, $adultArray[$i], 'adult');
	
	$count++;
}

for ($i = 0; $i < count($teenArray); $i++) {
	$db->insertPassNames($conn, $bookingID['LAST_INSERT_ID()'], $count, $teenArray[$i], 'teen');
	
	$count++;
}

for ($i = 0; $i < count($childArray); $i++) {
	$db->insertPassNames($conn, $bookingID['LAST_INSERT_ID()'], $count, $childArray[$i], 'child');
	
	$count++;
}

for ($i = 0; $i < count($under3Array); $i++) {
	$db->insertPassNames($conn, $bookingID['LAST_INSERT_ID()'], $count, $under3Array[$i], 'under3');
	
	$count++;
}

if ($ticketType == 'return') {
	
	$bookingInfoArrayReturn = [$userID['userID'], $forename, $surname, $address1, $address2, $contact, $postcode, $travelDestination, $travelOrigin, $travelDateReturn, $ticketType];

	$bookingIDReturn = $db->insertIntoBookingsInfo($conn, $bookingInfoArrayReturn);

	for ($i = 0;$i < count($journeyArrayReturn); $i++) {
		$bookingPortsArrayReturn = [$bookingIDReturn['LAST_INSERT_ID()'], $journeyArrayReturn[$i][0], $passTotal, $journeyArrayReturn[$i][1], $journeyArrayReturn[$i][2], $legWheelChairSeatsReturn] ;
	
		$db->insertIntoBookingPorts($conn, $bookingPortsArrayReturn);
	}
	
	$count = 1;

	for ($i = 0; $i < count($adultArray); $i++) {
		$db->insertPassNames($conn, $bookingIDReturn['LAST_INSERT_ID()'], $count, $adultArray[$i], 'adult');
	
		$count++;
	}

	for ($i = 0; $i < count($teenArray); $i++) {
		$db->insertPassNames($conn, $bookingIDReturn['LAST_INSERT_ID()'], $count, $teenArray[$i], 'teen');
	
		$count++;
	}

	for ($i = 0; $i < count($childArray); $i++) {
		$db->insertPassNames($conn, $bookingIDReturn['LAST_INSERT_ID()'], $count, $childArray[$i], 'child');
	
		$count++;
	}

	for ($i = 0; $i < count($under3Array); $i++) {
		$db->insertPassNames($conn, $bookingIDReturn['LAST_INSERT_ID()'], $count, $under3Array[$i], 'under3');
	
		$count++;
	}

}

header('Location: ' . '../php/bookingMade.php');
?>