<?php
	include 'db_config.php';
	session_start();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		if(isset($_SESSION['username'])) {
			$userName = "".$_SESSION['username']."";
			$result_user=$con->query("SELECT * FROM user WHERE userName='$userName'");

			if (!$result_user) 
			{
				echo 'Could not run query?: ' . mysql_error();
				exit;
			}
			else 
			{
				$user_info=mysqli_fetch_array($result_user);
				$userId = $user_info['userId'];
				//input in form
				if(isset($_POST["old_pw"])) {
					$old_pw =($_POST["old_pw"]);
				}
				if(isset($_POST["new_pw"])) {
					$new_pw =($_POST["new_pw"]);
				}
				$acc_server_get="http://localhost:8000/account/pwReset?userName=".$userName."&pwOld=".$old_pw."&pwNew=".$new_pw;
				$response = file_get_contents($acc_server_get);
				print_r($response."\n");
				if ($response == 'SUCCESS')
				{
					echo 'SUCCESS';
					header( 'Location: user_management.php' ) ;
				}
				else
				{
					die(header( 'Location: user_management.php?restPwFailed=true&reason='.response )) ;
				}
			}
		}
		/*if (!mysqli_query($con,$sql)) 
		{
			die('Error: ' . mysqli_error($con));
		}
		else 
		{
			echo 'its good.';
			//header( 'Location: homepage.php' ) ;	
		}*/
	}
?>
