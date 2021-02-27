<?php 
session_start();

$username = $_SESSION['username'];

session_unset();

$_SESSION['username'] = $username;

// If statement that tell the user what was wrong with what they were trying to do
if (isset($_GET['error']) and $_GET['error'] == "Ports Unavailable") {
	echo '<script language="javascript">';
	echo 'alert("Choose Ports That Are Available on Travel Date")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "No Return Travel Date") {
	echo '<script language="javascript">';
	echo 'alert("Choose a Travel Date for the Return Trip")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "Ports Unavailable on Return Date") {
	echo '<script language="javascript">';
	echo 'alert("Choose Ports That Are Available on Return Date")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "Return Date Should Be Later than Travel Date") {
	echo '<script language="javascript">';
	echo 'alert("Choose Return Date that Comes After Travel Date")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "Ports must be different") {
	echo '<script language="javascript">';
	echo 'alert("Destination and Origin must be Different")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "Ports Unavailable on Travel Date") {
	echo '<script language="javascript">';
	echo 'alert("Choose Ports That Are Available on Travel Date")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "No Seats Available") {
	echo '<script language="javascript">';
	echo 'alert("No Seats are available on the travel date")';
	echo '</script>';
} else if (isset($_GET['error']) and $_GET['error'] == "No Seats Available Return") {
	echo '<script language="javascript">';
	echo 'alert("No Seats are available on the return travel date")';
	echo '</script>';
}
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/cruisesTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Explore</title>
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
				<h2>Search for Travel Days</h2>
			</section>
			<section class="child" id="paragraph">
				<p>Monday - Morar, Eigg and Muck<br>Tuesday - Morar, Eigg and Rum<br>Wednesday - Morar, Eigg and Muck<br>Thursday - Morar, Rum<br>Friday - Morar, Eigg and Muck<br>Saturday - Morar, Eigg and Rum<br>Sunday - Morar, Eigg and Muck</p>
				<form action="../private/exploreBookingHandle.php" method="post" onSubmit="return checkForm(this)">
					Type of Ticket:<br>
					<input type="radio" id="single" name="ticketType" value="single" required><label for="single">Single</label>
					<input type="radio" id="return" name="ticketType" value="return"><label for="return">Return</label><br><br>
					Date of Travel: <br><input type="date" name="travelDate" min="<?php echo date("Y-m-d"); ?>" required><br><br>
					Date of Return: <br><input type="date" name="travelDateReturn" min="<?php echo date("Y-m-d"); ?>"><br><br>
					<label for="from">From: </label>
					<select name="from" id="from" required>
						<option value="Morar">Morar</option>
						<option value="Eigg">Eigg</option>
						<option value="Muck">Muck</option>
						<option value="Rum">Rum</option>
					</select>
					<label for="to">To: </label>
					<select name="to" id="to" required>
						<option value="Morar">Morar</option>
						<option value="Eigg">Eigg</option>
						<option value="Muck">Muck</option>
						<option value="Rum">Rum</option>
					</select><br>
					<br><input type="submit" value="Confirm" name="submit" id="button"><br>
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
