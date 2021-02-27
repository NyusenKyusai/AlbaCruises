<?php 
session_start();

require('../private/usableFunctions.php');

// Linking the page to the database page
require_once('../private/databaseClass.php');

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

//Starting a instance of database class
$db = new Database();
$conn  = $db->getConnection();

$username = $_SESSION['username'];

$bookingIDArray = $_SESSION['bookingInfo'];

$bookingPassArrayKey = $_POST['bookingPassArrayKey'];

//echo $bookingPassArrayKey;

$bookingID = $bookingIDArray[$bookingPassArrayKey][0];

$bookingInfo = $db->findAllBookingInfoByUsername($conn, $username, $bookingID);

//var_dump($bookingInfo);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Purchase Confirmation</title>
<!--
Linking the CSS pages to the template
-->
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<main>
		<div class="container" id="Container">
			<section class="child" id="title">
				<h2>Confirmation</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="../private/purchaseConfirmationHandle" method="post">
					<?php
					echo "Forename: " . $bookingInfo[0]['bookingForename'] . "<br>";
					echo "Surname: " . $bookingInfo[0]['bookingSurname'] . "<br>";
					echo "Address 1: " . $bookingInfo[0]['address1'] . "<br>";
					echo "Address 2: " . $bookingInfo[0]['address2'] . "<br>";
					echo "Postcode: " . $bookingInfo[0]['postcode'] . "<br>";
					echo "Contact: " . $bookingInfo[0]['contact'] . "<br><br>";
					echo "Total Passengers: " . $bookingInfo[1]['passTotal'] . " <br>";
					echo "Travel Date = " . $bookingInfo[0]['dateOfTravel'] . "<br>";
					echo "Itenerary: <br>";
					echo $bookingInfo[0]['trueOrigin'] . " To " . $bookingInfo[0]['trueDestination'] . "<br><br>";
					echo "Wheelchair Access Needed: " . $bookingInfo[1]['disability'] . "<br><br>";
					?>
				</form>
			</section>
		</div>
	</main>
</body>
</html>
