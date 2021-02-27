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

$db->deleteBooking($conn, $bookingID, $username);

header('Location: ' . '../php/bookingInfo.php');

?>