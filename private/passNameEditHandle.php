<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$passTotal = $_POST['passTotal'];

//echo $bookingID;
//echo $passTotal;

for ($i = 0; $i < $passTotal; $i++) {
	$passArray[] = [$i + 1, $_POST['passForename' . $i], $_POST['passSurname' . $i]];
}

//var_dump($passArray);

//echo $passArray[8][0];

for ($i = 0; $i < $passTotal; $i++) {
	$db->updatePassName($conn, $bookingID, $passArray[$i]);
}

header('Location: ' . '../php/bookingInfo.php');
?>