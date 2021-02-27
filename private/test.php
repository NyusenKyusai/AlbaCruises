<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('bookingClass.php');
require_once('databaseClass.php');

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

$travelOrigin1 = 'Morar';
$travelDestination1 = 'Rum';

$booking1 = new Bookings($travelOrigin1, $travelDestination1);

$legs = 'legs';

//Calling function from the booking class
$journeyArray = $booking1->__get($legs);

$seatDetails = [];

for ($i = 0;$i < count($journeyArray); $i++) {
	$passTotal = $db->findSeatsByShip($conn, $journeyArray[$i][1], $journeyArray[$i][2], '2021-01-01');
	array_push($seatDetails, $passTotal);
}

var_dump($seatDetails);

?>