<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$ticketType = $_SESSION['ticketType'];
$legSeatsArray = $_SESSION['legSeatsArray'];

if (isset($_SESSION['legSeatsArrayReturn'])) {
	$legSeatsArrayReturn = $_SESSION['legSeatsArrayReturn'];
}

$_SESSION['adult'] = $_POST['adult'];
$_SESSION['teen'] = $_POST['teen'];
$_SESSION['child'] = $_POST['child'];
$_SESSION['under3'] = $_POST['under3'];

$passTotal = $_POST['adult'] + $_POST['teen'] + $_POST['child'] + $_POST['under3'];

for ($i = 0; $i < count($legSeatsArray); $i++) {
	if ($passTotal > $legSeatsArray[$i]) {
		// Creating Error Code
		$error_code = 'Too Many Passengers';
		//Redirecting back to the setBookingInfo page
		header('Location: ' . '../php/setBookingInfo.php' . '?error=' . urlencode($error_code));
		exit;
	}
}

if (isset($_SESSION['legSeatsArrayReturn'])) {
	for ($i = 0; $i < count($legSeatsArrayReturn); $i++) {
		if ($passTotal > $legSeatsArrayReturn[$i]) {
			// Creating Error Code
			$error_code = 'Too Many Passengers';
			//Redirecting back to the setBookingInfo page
			header('Location: ' . '../php/setBookingInfo.php' . '?error=' . urlencode($error_code));
			exit;
		}
	}
}

$_SESSION['forename'] = $_POST['forename'];
$_SESSION['surname'] = $_POST['surname'];
$_SESSION['address1'] = $_POST['address1'];
$_SESSION['address2'] = $_POST['address2'];
$_SESSION['contact'] = $_POST['contact'];
$_SESSION['postcode'] = $_POST['postcode'];
$_SESSION['passTotal'] = $passTotal;
$_SESSION['wheelchair'] = $_POST['wheelchair'];

if ($ticketType == 'return') {
	$wheelChairReturn = $_POST['wheelchairReturn'];
	$_SESSION['wheelchairReturn'] = $wheelChairReturn;
}

//var_dump($legSeatsArray);

header('Location: ' . '../php/passengerDetails.php');
?>