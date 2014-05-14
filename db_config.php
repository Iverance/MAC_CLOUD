<?php
	
	$resourceNode = "http://192.168.0.176:8000/";
		// Create connection
	$db_host = "freesql.ctijsbuenarr.us-west-2.rds.amazonaws.com";
	$db_username = "admin";
	$db_pass = "adminpasswd";
	$db_name = "mac_web";
	$con=mysqli_connect("$db_host","$db_username","$db_pass","$db_name");

			// Check connection
			if (mysqli_connect_errno($con)) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  exit();
			}

?>
