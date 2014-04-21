<?php
	include 'db_config.php';
	session_start();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		if(isset($_SESSION['username'])) {
			$userName = "".$_SESSION['username']."";
			$result_user=$con->query("SELECT * FROM user WHERE name='$userName'");

			if (!$result_user) 
			{
				echo 'Could not run query?: ' . mysql_error();
				exit;
			}
			else 
			{
				$user_info=mysqli_fetch_array($result_user);
				$userId = $user_info['id'];
				echo $userId;
			}
		}
		//echo "inside post method";
		$setting =($_POST["settings"]);
		// echo $setting;
		if ($setting == 'AND') {

			echo 'start python';
			/*$command = escapeshellcmd('python /var/www/mac/st.py');
			shell_exec($command);*/

		}
		$sql= "INSERT INTO instance (owner, type, status) VALUES ('$userId' , '$setting', 'launching')";
		echo $sql;

		if (!mysqli_query($con,$sql)) 
		{
			die('Error: ' . mysqli_error($con));
		}
		else 
		{
			header( 'Location: homepage.php' ) ;	
		}
	}
?>
