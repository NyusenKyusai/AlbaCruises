<?php
function journeyPriceFunction($travelOrigin, $travelDestination) {
	
	if (($travelOrigin == 'Morar' and $travelDestination == 'Eigg') or ($travelOrigin = 'Eigg' and $travelDestination = 'Morar')) {
		$adultPrice = 18;
		
		return $adultPrice;
	} else if (($travelOrigin == 'Morar' and $travelDestination == 'Muck') or ($travelOrigin = 'Muck' and $travelDestination = 'Morar')) {
		$adultPrice = 19;
		
		return $adultPrice;
	} else if (($travelOrigin == 'Morar' and $travelDestination == 'Rum') or ($travelOrigin = 'Rum' and $travelDestination = 'Morar')) {
		$adultPrice = 24;
		
		return $adultPrice;
	} else if (($travelOrigin == 'Eigg' and $travelDestination == 'Muck') or ($travelOrigin = 'Muck' and $travelDestination = 'Eigg')) {
		$adultPrice = 10;
		
		return $adultPrice;
	} else if (($travelOrigin == 'Eigg' and $travelDestination == 'Rum') or ($travelOrigin = 'Rum' and $travelDestination = 'Eigg')) {
		$adultPrice = 16;
		
		return $adultPrice;
	}
}

function availableSeats($seatDetails) {
	$availableSeats = [];
	$passTotal = 0;
	
	for ($t = 0; $t < count($seatDetails); $t++) {
		for ($i = 0; $i < count($seatDetails[$t]); $i++) {
			$passTotal = $passTotal + $seatDetails[$t][$i];
		}
		array_push($availableSeats, $passTotal);
		$passTotal = 0;
	}
	
	//var_dump($availableSeats);
	
	return $availableSeats;
}

//Function to process journey seating and disability
function processJourney($journeyArray, $db, $conn, $travelDate) {
	$seatDetails = [];
	$wheelchairDetails = [];
	for ($i = 0; $i < count($journeyArray); $i++) {
		$legOrigin = $journeyArray[$i][1];
		$legDestination = $journeyArray[$i][2];
		
		$passengerArray = $db->findSeatsByShip($conn, $legOrigin, $legDestination, $travelDate);
		array_push($seatDetails, $passengerArray);
		
		$wheelchairArray = $db->findWheelchairByShip($conn, $legOrigin, $legDestination, $travelDate);
		array_push($wheelchairDetails, $wheelchairArray);

		//var_dump($passengerArray);
	}
	return array($seatDetails, $wheelchairDetails);
}
?>