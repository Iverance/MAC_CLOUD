<?php
	include 'db_config.php';
	session_start();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		if(isset($_SESSION['username'])) {
			$month = date("m")+0;
			$query = "SELECT * from statements where billingDate >= '2014-0".$month."-01' and billingDate <= '2014-0".$month."-30';";
			$result=mysqli_query($con,$query) or die(mysqli_error());
			while($row = mysqli_fetch_assoc($result)){
				$curMonth = $row['amount'] + $curMonth;
			}
			
			$userId = "".$_SESSION['userId']."";
			$stmtId = "".$_POST['stmtId']."";
			$cardType = "".$_POST['card_type']."";
			$cardNum = "".$_POST['card_num']."";
			$year = "".$_POST['years']."";
			$month = "".$_POST['months']."";
			$expireDate = $year."\.".$month;
			$cardName = "".$_POST['card_name']."";
			$payDate = date("Y-m-d H:i:s");
			$q = "INSERT INTO bill (userId,cardType,cardNum,expireDate,cardName,balance,stmtId,payTime) VALUE  ('$userId','$cardType','$cardNum','$expireDate','$cardName','$curMonth','$stmtId','$payDate')";
			//echo $q;
		
			if (!$con->query($q))
			{
				die(header( 'Location: make_payment.php?makePayFailed=true&Err='.$q ));
			}
			else 
			{
				header( 'Location: make_payment.php' );
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
