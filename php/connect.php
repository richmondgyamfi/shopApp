<?php 
	$dbcon = mysqli_connect('localhost','root','','shopappdb');

	if (mysqli_connect_errno()) {
		# code...
		echo "Database connection failed with this error: " .mysqli_connect_error();
		die();
	}

	// define('BASEURL', '/shopApp/'); //for localhost
	//define('BASEURL', (__FILE__)); For hosted app

	require_once $_SERVER['DOCUMENT_ROOT'].'/shopApp/config.php';
	require_once BASEURL.'helpers/helpers.php';
 ?>