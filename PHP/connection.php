<?php
	$servername = "mysql";
	$username = "root";
	$password = "root";
	$dbname = "php";

	// Create connection
	$con = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	echo "connected";


	$query = "SELECT * FROM Employee";
	$result = mysqli_query($conn, $query);
	print_r("<pre>");
	print_r($result);
	$res = mysqli_num_rows($result);
	print_r("<pre>");
	print_r($res);
	$resultArray = mysqli_fetch_array($result, MYSQLI_ASSOC);
	print_r("<pre>");
	print_r($resultArray);


	
?>