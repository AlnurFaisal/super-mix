<?php
session_start();

$username = htmlentities($_POST['username']);
$password = crypt($_POST['password'], CRYPT_BLOWFISH);

$db_host = getenv('DB_HOSTNAME');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

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