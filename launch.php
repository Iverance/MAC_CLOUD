<?php
	include ("db_config.php");
	session_start();
	if(isset($_GET["send"])) {
		if($_GET["send"]=="true") {
			$queryUpdate="UPDATE user SET requests=requests + 1 WHERE userId = '".$_SESSION['userId']."';";
			echo $queryUpdate;
			//mysqli_query($con,$queryUpdate) or echo mysqli_error($db);
			if (!$con->query($queryUpdate)) {
				printf("Errormessage: %s\n", $con->error);
				header( 'Location: homepage.php?Err='.$con->error ) ;
			}else{
				header( 'Location: homepage.php?success=ins' ) ;
			}
		}else if($_GET["send"]=="false") {
			$queryUpdate="UPDATE user SET requests=requests - 1 WHERE userId = '".$_SESSION['userId']."';";
			echo $queryUpdate;
			//mysqli_query($con,$queryUpdate) or echo mysqli_error($db);
			if (!$con->query($queryUpdate)) {
				printf("Errormessage: %s\n", $con->error);
				header( 'Location: homepage.php?Err='.$con->error ) ;
			}else{
				header( 'Location: homepage.php?success=des' ) ;
			}
		}
	}

	if(isset($_GET["app"])) {
		$queryUpdate="SELECT deviceIp from regi_machines WHERE machineId = '".$_GET["app"]."';";
		$result = mysqli_query($con,$queryUpdate);
		if (!$result) {
			printf("Errormessage: %s\n", $con->error);
			header( 'Location: homepage.php?Err='.$con->error ) ;
		}else{
			$row = mysqli_fetch_array($result);
			$ip = $row['deviceIp'];
			$getHTTP = $resourceNode."resource/launchApp?deviceIp=".$ip;
			$response = file_get_contents($getHTTP);
			//echo $response;
			header( 'Location: homepage.php?success=app' ) ;
		}
		/*if($_GET["send"]=="true") {
			$queryUpdate="UPDATE user SET requests=requests + 1 WHERE userId = '".$_SESSION['userId']."';";
			echo $queryUpdate;
			//mysqli_query($con,$queryUpdate) or echo mysqli_error($db);
			if (!$con->query($queryUpdate)) {
				printf("Errormessage: %s\n", $con->error);
				header( 'Location: homepage.php?Err='.$con->error ) ;
			}else{
				header( 'Location: homepage.php' ) ;
			}
		}else if($_GET["send"]=="false") {
			$queryUpdate="UPDATE user SET requests=requests - 1 WHERE userId = '".$_SESSION['userId']."';";
			echo $queryUpdate;
			//mysqli_query($con,$queryUpdate) or echo mysqli_error($db);
			if (!$con->query($queryUpdate)) {
				printf("Errormessage: %s\n", $con->error);
				header( 'Location: homepage.php?Err='.$con->error ) ;
			}else{
				header( 'Location: homepage.php' ) ;
			}
		}*/
	}

	mysqli_close($con);
?>
