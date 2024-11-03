<?php
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

function connect_database() {
	$fetchType = "array";
	$dbHost    = "localhost";
	$dbLogin   = "onoinvest_paytm";
	$dbPwd     = "onoinvest_paytm";
	$dbName    = "onoinvest_paytm";
	$con       = mysqli_connect($dbHost, $dbLogin, $dbPwd, $dbName);
	if (!$con) {
		die("Database Connection failes" . mysqli_connect_errno());
	}
	return ($con);
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'onoinvest_paytm');
define('DB_PASSWORD', 'onoinvest_paytm');
define('DB_NAME', 'onoinvest_paytm');
?>