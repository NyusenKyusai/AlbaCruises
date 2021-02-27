<!doctype html>
<html>
<head>
<title>Print Boarding Passes</title>
<!--
Linking the CSS pages to the template
-->
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
</body>
</html>

<?php
session_start(); 

// Linking the page to the database page
require_once('../private/databaseClass.php');

// Getting the username from the session
$username = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

// Getting array from session
$array = $_SESSION['boardingPassesArray'];

// Getting the array from POST
$boardingPassArrayKey = $_POST['boardingPassArrayKey'];

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

$boardingPassArray = $array[$boardingPassArrayKey];



// Calling a function from database class to get the details from the database
$boardingPassInfo = $db->findBoardingPassInfo($conn, $boardingPassArray[0]);

//var_dump($boardingPassInfo);

for ($i = 0; $i < count($boardingPassInfo); $i++) {
echo "
<div class='boardingPass'>
	<img src='../images/cruisesLogo.fw.png' alt=''><h3>Boarding Pass</h3>
	<p>Passenger Name: " . $boardingPassInfo[$i][0] . " " . $boardingPassInfo[$i][1] . "</p>
	<p>Sailing: " . $array[$boardingPassArrayKey][1] . " to " . $array[$boardingPassArrayKey][2] . "</p>
	<p>Sailing Date: " . $array[$boardingPassArrayKey][3] . "</p>	
</div>
<br>
";
}

