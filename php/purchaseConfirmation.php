<?php 
session_start();

require('../private/usableFunctions.php');

if (!isset($_SESSION['username'])) {
	// Creating Error Code
	$error_code = 'Log In Before Booking';
	//Redirecting back to the exploreBooking page
	header('Location: ' . '../php/loginUser.php' . '?error=' . urlencode($error_code));
	exit;
}

$travelDate = $_SESSION['travelDate'];
$ticketType = ucfirst($_SESSION['ticketType']);
$username = $_SESSION['username'];
$travelOrigin = $_SESSION['travelOrigin'];
$travelDestination = $_SESSION['travelDestination'];

$forename = $_SESSION['forename'];
$surname = $_SESSION['surname'];
$address1 = $_SESSION['address1'];
$address2 = $_SESSION['address2'];
$contact = $_SESSION['contact'];
$postcode = $_SESSION['postcode'];
$passTotal = $_SESSION['passTotal'];

if (isset($_SESSION['wheelchair'])){
	$wheelchair = ucfirst($_SESSION['wheelchair']);
} else {
	$wheelchair = 'No';
}

//echo $wheelchair;


$adult = $_SESSION['adult'];
$teen = $_SESSION['teen'];
$child = $_SESSION['child'];
$under3 = $_SESSION['under3'];

$journeyArray = $_SESSION['journeyArray'];

if ($ticketType == 'Return'){
	$travelDateReturn = $_SESSION['travelDateReturn'];
	$journeyArrayReturn = $_SESSION['journeyArrayReturn'];
	
	if (isset($_SESSION['wheelchairReturn'])){
		$wheelchairReturn = ucfirst($_SESSION['wheelchairReturn']);
	} else {
		$wheelchairReturn = 'No';
	}
}

$under3Price = 0;
$childPrice = 10;
$teenPrice = 13;

$adultPrice = journeyPriceFunction($travelOrigin, $travelDestination);

$priceTotal = ($adult * $adultPrice) + ($teen * $teenPrice) + ($child * $childPrice) + ($under3 * $under3Price);

if ($ticketType == 'single') {
	$priceTotal = $priceTotal / 2;
}

?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Purchase Confirmation</title>
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
				<h2>Confirmation</h2>
			</section>
			<section class="child" id="paragraph">
				<form action="../private/purchaseConfirmationHandle" method="post">
					<?php
					echo "Forename: $forename<br>";
					echo "Surname: $surname<br>";
					echo "Address 1: $address1<br>";
					echo "Address 2: $address2<br>";
					echo "Contact: $contact<br><br>";
					echo "Postcode: $postcode<br>";
					echo "Adult Passengers: $adult ";
					echo "Teen Passengers: $teen<br>";
					echo "Child Passengers: $child ";
					echo "Under 3 Passengers: $under3<br><br>";
					echo "Ticket Type = $ticketType<br>";
					echo "Travel Date = $travelDate<br>";
					echo "Itenerary: <br>";
					for ($i = 0;$i < count($journeyArray); $i++) {
						echo ($journeyArray[$i][0] . ": " . $journeyArray[$i][1] . " To "  . $journeyArray[$i][2] . "<br>");
					}
					echo "Wheelchair Access Needed: $wheelchair<br><br>";
					if ($ticketType == 'Return') {
						echo "Return Travel Date = $travelDateReturn<br>";
						echo "Itenerary: <br>";
						for ($i = 0;$i < count($journeyArrayReturn); $i++) {
							echo ($journeyArrayReturn[$i][0] . ": " . $journeyArrayReturn[$i][1] . " To "  . $journeyArrayReturn[$i][2] . "<br>");
						}
						echo "Wheelchair Access Needed: $wheelchairReturn<br><br>";
					}
					echo "Total Price: £" . $priceTotal . "<br><br>";
					?>
					<br><input type="button" value="Back" id="button" onClick="history.back()">
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
