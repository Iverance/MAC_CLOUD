<?php
		// Create connection
	$db_host = "macdb.ctijsbuenarr.us-west-2.rds.amazonaws.com";
	$db_username = "mac";
	$db_pass = "mac4thewin";
	$db_name = "mac_web";
	$con=mysqli_connect("$db_host","$db_username","$db_pass","$db_name");

			// Check connection
			if (mysqli_connect_errno($con)) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  exit();
			}
?>
