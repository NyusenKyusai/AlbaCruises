<?php
require_once("dbValues.php");

class Database {
	private $_connection; // Stores the connection
	private static $_instance; // Store the single instance.
	
	public static function getInstance() {
		// If statement that creates a new version of the instance if there isn't one that exists
		if (!self::$_instance) {
			self::$_instance = new self();
		}
		// Returns the instance to where the function was called
		return self::$_instance;
	}
	
	public function __construct() {
		// Sets the connection variable with the necessary information for connecting to the database
		$this->_connection = new MySQLi(dbhost, dbuser, dbpass, dbname);
		// Error Handling.
		if (mysqli_connect_error()) {
			trigger_error('Failed to connect to MySQL: ' . mysqli_connect_errno(), E_USER_ERROR);
		}
	}
	
	private function __clone() {}
	
	// Gets the connection for the user
	public function getConnection() {
		return $this->_connection;
	}
	
	// Function for disconnecting from the database
	public function dbDisconnect($_connection) {
		if (isset($_connection)) {
			mysqli_close();
		}
	}
	
	// Escapes difficult values from user input before it goes into the database
	
	public function dbEscape($_connection, $string) {
		return mysqli_real_escape_string($_connection, $string);
	}
	
	public function assocUsername($conn, $username) {
		$escapeUsername = $this->dbEscape($conn, $username);
		
		$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$escapeUsername';" );
		$result = mysqli_fetch_assoc($query);
		
		return $result;
	}
	
	public function usernameID($conn, $username) {
		$escapeUsername = $this->dbEscape($conn, $username);
		
		$query = mysqli_query($conn, "SELECT userID FROM users WHERE username = '$escapeUsername';" );
		$result = mysqli_fetch_assoc($query);
		
		return $result;
	}
	
	public function rowsUsername($conn, $username) {
		$escapeUsername = $this->dbEscape($conn, $username);
		
		$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$escapeUsername';" );
		$result = mysqli_num_rows($query);
		
		return $result;
	}
	
	public function insertIntoUsers($conn, $username, $hash, $dateBirth, $email){
		// Creating the query to insert into the User table
		$sql = "INSERT INTO users ";
		$sql .= "(username, password, dateBirth, email, adminStatus) ";
		$sql .= "VALUES (";
		$sql .= "'" . $this->dbEscape($conn, $username) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $hash) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $dateBirth) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $email) . "', ";
		$sql .= "'client'";
		$sql .= ");";
		
		//echo $sql;
		
		// Querying database to save the data
		$result = mysqli_query($conn, $sql);
		
		return $result;
	}
	
	public function findAccountDetailsByUsername($conn, $username) {
		// Creating SQL query statement
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username = '" . $this->dbEscape($conn, $username) . "';";
		// Querying database and fetching the results
		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		
		return $user;
		
	}
	
	public function findIDbyUsername($conn, $username) {
		// Creating SQL query statement
		$sql = "SELECT userID FROM users ";
		$sql .= "WHERE username = '" . $this->dbEscape($conn, $username) . "';";
		
		$result = mysqli_query($conn, $sql);
		$userID = mysqli_fetch_assoc($result);
		
		return $userID['userID'];
	}
	
	public function updateUser($conn, $user) {
		$oldUsernameID = $this->dbEscape($conn, $user['oldUsername']);
		// Creating SQL query statement
		$sql = "UPDATE users SET ";
		$sql .= "username='" . $this->dbEscape($conn, $user['newUsername']) . "', ";
		$sql .= "password='" . $this->dbEscape($conn, $user['password']) . "', ";
		$sql .= "dateBirth='" . $this->dbEscape($conn, $user['dateBirth']) . "', ";
		$sql .= "email='" . $this->dbEscape($conn, $user['email']) . "' ";
		$sql .= "WHERE userID = " .  $this->findIDbyUsername($conn, $oldUsernameID) . " ";
		$sql .= "LIMIT 1;";
		
		//echo $sql;
		
		// Querying database to save the new details
		$result = mysqli_query($conn, $sql);
	}
	
	public function portsByDay($conn, $travelDate) {
		// Creating SQL query statement
		$sql = "SELECT portOfDepart FROM travelSchedule ";
		$sql .= "WHERE departDay = '" . $this->dbEscape($conn, $travelDate) . "';";
		// Querying database and fetching the results
		$result = mysqli_query($conn, $sql);
		$possiblePortsRows = mysqli_num_rows($result);
		
		while ($possiblePorts = mysqli_fetch_assoc($result)) {
			$resultArray[] = $possiblePorts['portOfDepart'];
		}
		
		//echo $sql;
		return $resultArray;
	}
	
	public function findSeatsByShip($conn, $legOrigin, $legDestination, $travelDate) {
		// Creating SQL query statement
		$sql = "SELECT passTotal FROM bookingsInfo, bookingPorts ";
		$sql .= "WHERE bookingPorts.bookingID = bookingsInfo.bookingID ";
		$sql .= "and (dateOfTravel = '$travelDate')";
		$sql .= "and (legOrigin = '$legOrigin')";
		$sql .= "and (legDestination = '$legDestination');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		$possiblePassengersRows = mysqli_num_rows($result);
		
		while ($passengers = mysqli_fetch_assoc($result)) {
			$resultArray[] = $passengers['passTotal'];
		}
		
		if ($possiblePassengersRows > 0) {
			return $resultArray;
		}
	}
	
	public function findWheelchairByShip($conn, $legOrigin, $legDestination, $travelDate) {
		// Creating SQL query statement
		$sql = "SELECT disability FROM bookingsInfo, bookingPorts ";
		$sql .= "WHERE bookingPorts.bookingID = bookingsInfo.bookingID ";
		$sql .= "and (dateOfTravel = '$travelDate')";
		$sql .= "and (legOrigin = '$legOrigin')";
		$sql .= "and (legDestination = '$legDestination');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		$possiblePassengersRows = mysqli_num_rows($result);
		
		while ($passengers = mysqli_fetch_assoc($result)) {
			$resultArray[] = $passengers['disability'];
		}
		
		if ($possiblePassengersRows > 0) {
			return $resultArray;
		}
	}
	
	public function insertIntoBookingsInfo($conn, $bookingInfoArray) {
		// Creating SQL query statement
		$sql = "INSERT INTO bookingsInfo ";
		$sql .= "(userID, bookingForename, bookingSurname, address1, address2, contact, postcode, trueOrigin, trueDestination, dateOfTravel, ticketType) ";
		$sql .= "VALUES (";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[0]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[1]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[2]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[3]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[4]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[5]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[6]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[7]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[8]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[9]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingInfoArray[10]) . "' ";
		$sql .= ");";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$sql = "SELECT LAST_INSERT_ID();";
		
		$result = mysqli_query($conn, $sql);
		$return = mysqli_fetch_assoc($result);
		
		return $return;
	}
	
	public function insertIntoBookingPorts($conn, $bookingPortsArray) {
		// Creating SQL query statement
		$sql = "INSERT INTO bookingPorts ";
		$sql .= "(bookingID, legOfJourney, passTotal, legOrigin, legDestination, disability) ";
		$sql .= "VALUES (";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[0]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[1]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[2]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[3]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[4]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $bookingPortsArray[5]) . "'";
		$sql .= ");";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function insertPassNames($conn, $bookingID, $passNumber, $passArray, $passType) {
		// Creating SQL query statement
		$sql = "INSERT INTO bookingPassengers ";
		$sql .= "(bookingID, passNumber, passForename, passSurname, passType) ";
		$sql .= "VALUES (";
		$sql .= "'" . $this->dbEscape($conn, $bookingID) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $passNumber) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $passArray[0]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $passArray[1]) . "', ";
		$sql .= "'" . $this->dbEscape($conn, $passType) . "'";
		$sql .= ");";
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function findBoardingPassByUsername($conn, $username) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "SELECT bookingsInfo.bookingID, legOrigin, legDestination, dateOfTravel ";
		$sql .= "FROM bookingsInfo, bookingPorts ";
		$sql .= "WHERE bookingPorts.bookingID = bookingsInfo.bookingID ";
		$sql .= "and (userID = '$userID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$possibleBookingsRows = mysqli_num_rows($result);
		
		while ($bookings = mysqli_fetch_assoc($result)) {
			$resultArray[] = [$bookings['bookingID'], $bookings['legOrigin'], $bookings['legDestination'], $bookings['dateOfTravel']];
		}
		
		if ($possibleBookingsRows > 0) {
			return $resultArray;
		}
	}
	
	public function findBookingInfoByUsername($conn, $username) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "SELECT bookingID, trueOrigin, trueDestination, dateOfTravel ";
		$sql .= "FROM bookingsInfo ";
		$sql .= "WHERE (userID = '$userID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$possibleBookingsRows = mysqli_num_rows($result);
		
		while ($bookings = mysqli_fetch_assoc($result)) {
			$resultArray[] = [$bookings['bookingID'], $bookings['trueOrigin'], $bookings['trueDestination'], $bookings['dateOfTravel']];
		}
		
		if ($possibleBookingsRows > 0) {
			return $resultArray;
		}
	}
	
	public function findBoardingPassInfo($conn, $bookingID) {
		// Creating SQL query statement
		$sql = "SELECT passForename, passSurname ";
		$sql .= "FROM bookingPassengers ";
		$sql .= "WHERE (bookingID = '$bookingID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$passNameRows = mysqli_num_rows($result);
		
		while ($passNames = mysqli_fetch_assoc($result)) {
			$resultArray[] = [$passNames['passForename'], $passNames['passSurname']];
		}
		
		if ($passNameRows > 0) {
			return $resultArray;
		}
	}
	
	public function findAllBookingInfoByUsername($conn, $username, $bookingID) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "SELECT * ";
		$sql .= "FROM bookingsInfo ";
		$sql .= "WHERE (userID = '$userID') ";
		$sql .= "AND (bookingID = '$bookingID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$array1 = mysqli_fetch_assoc($result);
		
		$sql = "SELECT passTotal, disability ";
		$sql .= "FROM bookingPorts ";
		$sql .= "WHERE (bookingID = '$bookingID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$array2 = mysqli_fetch_assoc($result);
		
		$resultArray = [$array1, $array2];
		
		return $resultArray;
	}
	
	public function deleteBooking($conn, $bookingID, $username) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "DELETE FROM bookingPassengers ";
		$sql .= "WHERE (bookingID = '$bookingID');";
		
		echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$sql = "DELETE FROM bookingPorts ";
		$sql .= "WHERE (bookingID = '$bookingID');";
		
		$result = mysqli_query($conn, $sql);
		
		$sql = "DELETE FROM bookingsInfo ";
		$sql .= "WHERE (userID = '$userID') ";
		$sql .= "AND (bookingID = '$bookingID');";
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function findPassNumByBookingID($conn, $bookingID) {
		// Creating SQL query statement
		$sql = "SELECT passNumber, passForename, passSurname FROM bookingPassengers ";
		$sql .= "WHERE bookingID = '$bookingID';";
		
		$result = mysqli_query($conn, $sql);
		
		$passNameRows = mysqli_num_rows($result);
		
		while ($passNames = mysqli_fetch_assoc($result)) {
			$resultArray[] = [$passNames['passNumber'], $passNames['passForename'], $passNames['passSurname']];
		}
		
		return $resultArray;
	}
	
	public function updatePassName($conn, $bookingID, $array) {
		// Creating SQL query statement
		$sql = "UPDATE bookingPassengers SET ";
		$sql .= "passForename='" . $this->dbEscape($conn, $array[1]) . "', ";
		$sql .= "passSurname='" . $this->dbEscape($conn, $array[2]) . "' ";
		$sql .= "WHERE (bookingID = '$bookingID') ";
		$sql .= "AND (passNumber = '$array[0]');";
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function getBookingInfo($conn, $bookingID, $username) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "SELECT bookingForename, bookingSurname, address1, address2, contact, postcode FROM bookingsInfo ";
		$sql .= "WHERE bookingID = '$bookingID' ";
		$sql .= "AND userID = '$userID';";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		$resultArray = mysqli_fetch_assoc($result);
		
		return $resultArray;
	}
	
	public function updateBookingInfo($conn, $bookingID, $username, $array) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "UPDATE bookingsInfo SET ";
		$sql .= "bookingForename='" . $this->dbEscape($conn, $array[0]) . "', ";
		$sql .= "bookingSurname='" . $this->dbEscape($conn, $array[1]) . "', ";
		$sql .= "address1='" . $this->dbEscape($conn, $array[2]) . "', ";
		$sql .= "address2='" . $this->dbEscape($conn, $array[3]) . "', ";
		$sql .= "contact='" . $this->dbEscape($conn, $array[4]) . "', ";
		$sql .= "postcode='" . $this->dbEscape($conn, $array[5]) . "' ";
		$sql .= "WHERE (bookingID = '" . $this->dbEscape($conn, $bookingID) . "') ";
		$sql .= "AND (userID = '$userID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function getTravelDate($conn, $bookingID) {
		// Creating SQL query statement
		$sql = "SELECT dateOfTravel FROM bookingsInfo ";
		$sql .= "WHERE bookingID = '" . $this->dbEscape($conn, $bookingID) . "';";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		$array = mysqli_fetch_assoc($result);
		
		return $array;
	}
	
	public function findPortsByBookingID($conn, $bookingID) {
		// Creating SQL query statement
		$sql = "SELECT trueOrigin, trueDestination ";
		$sql .= "FROM bookingsInfo ";
		$sql .= "WHERE (bookingID = '" . $this->dbEscape($conn, $bookingID) . "');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$bookings = mysqli_fetch_assoc($result);
		
		return $bookings;
	}
	
	public function updateTravelDate($conn, $bookingID, $newTravelDate, $username) {
		$userID = $this->findIDbyUsername($conn, $username);
		// Creating SQL query statement
		$sql = "UPDATE bookingsInfo SET ";
		$sql .= "dateOfTravel='" . $this->dbEscape($conn, $newTravelDate) . "' ";
		$sql .= "WHERE (bookingID = '" . $this->dbEscape($conn, $bookingID) . "') ";
		$sql .= "AND (userID = '$userID');";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
	}
	
	public function findPassNamesForReport($conn, $legOrigin, $legDestination, $travelDate) {
		// Creating SQL query statement
		$sql = "SELECT passForename, passSurname ";
		$sql .= "FROM bookingsInfo, bookingPassengers, bookingPorts ";
		$sql .= "WHERE bookingsInfo.bookingID = bookingPassengers.bookingID ";
		$sql .= "AND bookingPassengers.bookingID = bookingPorts.bookingID ";
		$sql .= "AND legOrigin = '" . $this->dbEscape($conn, $legOrigin) . "' ";
		$sql .= "AND legDestination = '" . $this->dbEscape($conn, $legDestination) . "' ";
		$sql .= "AND dateOfTravel = '" . $this->dbEscape($conn, $travelDate) . "';";
		
		//echo $sql;
		
		$result = mysqli_query($conn, $sql);
		
		$passNameRows = mysqli_num_rows($result);
		
		while ($passNames = mysqli_fetch_assoc($result)) {
			$resultArray[] = [$passNames['passForename'], $passNames['passSurname']];
		}
		
		return $resultArray;
	}
}
?>