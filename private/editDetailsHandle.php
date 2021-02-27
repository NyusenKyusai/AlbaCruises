<?php
// Display errors to help with fixing errors
ini_set('dispay_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

// Linking the page to the database page and starting the session for loggin in	
require_once('databaseClass.php');
session_start();

// Calling the database class and getting the connection
$db = new Database();
$conn  = $db->getConnection();

// Checking to see if the new username is taken
$newUsername = $_POST['username'];
$rows = $db->rowsUsername($conn, $newUsername);

// Creating Error Code
$error_code = 'Username Taken';

//If statement that decides whether to redirect or continue
if ($rows > 0) {
	//Redirecting back to the account details page
	header('Location: ' . '../php/editDetails.php' . '?error=' . urlencode($error_code));
	exit;
}

// Getting the username from the session
$username = $_SESSION['username'];

// Creating an array containing the elements of the form
$user = [];
$user['oldUsername'] = $username;
$user['newUsername'] = $_POST['username'];
$tempPass = $_POST['password']; 
$user['password'] = password_hash($tempPass, PASSWORD_DEFAULT);
$user['dateBirth'] = $_POST['dateBirth'];
$user['email'] = $_POST['email'];

// Calling function to update User table
$result = $db->updateUser($conn, $user);

// Updating the session username
$_SESSION['username'] = $user['newUsername'];

//Redirecting back to the account details page
header('Location: ' . '../php/editDetails.php');
?>