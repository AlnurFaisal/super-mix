
<?php
session_start();

$username = htmlentities($_POST['username']);
$password = crypt($_POST['password'], CRYPT_BLOWFISH);

$db_host = getenv('DB_HOSTNAME');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

$dbh = new PDO('mysql:host=localhost;dbname=myCommerce', 'root', '');
$stmt = $dbh->prepare("SELECT * FROM `users` where `username` = ?");
$stmt->execute([$username]);

if($stmt->rowCount()) {
	// Username already taken
	echo 'Username ' . $username . ' is taken.';
} else {
	// Username not taken
	// So we INSERT into database
	$stmt2 = $dbh->prepare("INSERT INTO `users` (username, password)
    	VALUES (?, ?)");
	$stmt2->execute([$username, $password]);
	echo 'User registered successfully!';
}
