<?php
session_start();

$username = htmlentities($_POST['username']);
$password = crypt($_POST['password'], CRYPT_BLOWFISH);

$dbh = new PDO('mysql:host=localhost;dbname=myCommerce', 'root', '');
$stmt = $dbh->prepare("SELECT * FROM `users` where `username` = ? AND
	`password` = ?");
$stmt->execute([$username, $password]);

if($stmt->rowCount()) {
	// Correct login credentials
	$_SESSION['user'] = $username;
	echo 'Logged in as ' . $username;
} else {
	// only users not logged in will do this
	echo 'Username ' . $username . ' is incorrect