<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$adult = $_SESSION['adult'];
$teen = $_SESSION['teen'];
$child = $_SESSION['child'];
$under3 = $_SESSION['under3'];

$adultArray = [];
$teenArray = [];
$childArray = [];
$under3Array = [];


for ($i = 1; $i <= $adult; $i++) {
	$adultArrayNames = [$_POST["adultForename$i"], $_POST["adultSurname$i"]];
	array_push($adultArray, $adultArrayNames);
}

for ($i = 1; $i <= $teen; $i++) {
	$teenArrayNames = [$_POST["teenForename$i"], $_POST["teenSurname$i"]];
	array_push($teenArray, $teenArrayNames);
}

for ($i = 1; $i <= $child; $i++) {
	$childArrayNames = [$_POST["childForename$i"], $_POST["childSurname$i"]];
	array_push($childArray, $childArrayNames);
}

for ($i = 1; $i <= $under3; $i++) {
	$under3ArrayNames = [$_POST["under3Forename$i"], $_POST["under3Surname$i"]];
	array_push($under3Array, $under3ArrayNames);
}

$_SESSION['adultArray'] = $adultArray;
$_SESSION['teenArray'] = $teenArray;
$_SESSION['childArray'] = $childArray;
$_SESSION['under3Array'] = $under3Array;

header('Location: ' . '../php/purchaseConfirmation');

?>