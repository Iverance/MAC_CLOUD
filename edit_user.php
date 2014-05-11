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
				if(isset($_POST["email"])) {
					$mail =($_POST["email"]);
				}
				$acc_server_get="http://localhost:8000/account/editProfile?userName=".$userName."&email=".$mail;
				echo $acc_server_get;

      	$response = file_get_contents($acc_server_get);
				print_r($response."\n");
				if ($response == 'SUCCESS') 
				{
					echo 'SUCCESS';
					//header( 'Location: user_management.php' ) ;
				}
				else
				{
					echo $response;
					//header( 'Location: user_management.php' ) ;
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
