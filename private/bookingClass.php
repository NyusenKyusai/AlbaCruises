<?php

class Bookings {
	//Constant
	
	private $travelOrigin;
	private $travelDestination;
	
	private $travelTransfer;
	
	private $legs;
	
	public function __construct($travelOrigin, $travelDestination) {
		$this->travelOrigin = $travelOrigin;
		$this->travelDestination = $travelDestination;
		
		$this->transfer_guesser();
		
		$this->legs_creator();
	}
	
	/**
	 * Magic __get.
	 * @param string $name	* @return mixed
	 */
	
	public function __get($name) {
		return $this->$name;
	}
	
	public function __toString() {
		return $this->display();
	}
	
	private function transfer_guesser() {
		if (($this->travelOrigin == 'Morar' and $this->travelDestination == 'Rum') or ($this->travelOrigin == 'Rum' and $this->travelDestination == 'Morar')) {
			$this->travelTransfer = array('Eigg');
		} else if (($this->travelOrigin == 'Morar' and $this->travelDestination == 'Muck') or ($this->travelOrigin == 'Muck' and $this->travelDestination == 'Morar')) {
			$this->travelTransfer = array('Eigg');
		} else {
			$this->travelTransfer = [];
		}
		
		//echo count($this->travelTransfer);
	}
	
	private function legs_creator() {
		
		$current = $this->travelOrigin;
		$this->legs = [];
		$leg = 1;
		
		for ($i = 0; $i < count($this->travelTransfer); $i++) {
			array_push($this->legs, array("Leg $leg", $current, $this->travelTransfer[$i]));
			$leg += 1;
			$current = $this->travelTransfer[$i];
		}
		
		array_push($this->legs, array("Leg $leg", $current, $this->travelDestination));
		
		
		
		//var_dump($this->travelTransfer);
		
		
		//var_dump($this->legs);
		
		/*
		if ($this->travelTransfer == 'NULL') {
			$this->legs = array(
				array("Leg 1", $this->travelOrigin, $this->travelDestination)
			);
		} else {
			$this->legs = array(
				array("Leg 1", $this->travelOrigin, $this->travelTransfer),
				array("Leg 2", $this->travelTransfer, $this->travelDestination)
			);
		}
		*/
	}
	
	/**
	 * Display a trip in HTML
	 * @return string
	 */
	
	private function display() {
		$output = '';
		// Travel Origin
		$output .= $this->travelOrigin;
		$output .= '<br>';
		// Travel Destination
		$output .= $this->travelDestination;
		$output .= '<br><br>';
		// Leg 1 of Booking
		$output .= $this->legs[0][0] . ' From: ' . $this->legs[0][1] . ' To: ' . $this->legs[0][2];
		$output .= '<br>';
		if ($this->travelTransfer != NULL){
			// Leg 2 of Booking
			$output .= $this->legs[1][0] . ' From: ' . $this->legs[1][1] . ' To: ' . $this->legs[1][2];
			$output .= '<br>';
		}
		
		return $output;
		
	}
}

?>