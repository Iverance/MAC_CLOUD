<?php
	session_start();
    include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
	}

	$month = date("m")+0;
	$query = "SELECT * from statements where billingDate >= '2014-0".$month."-01' and billingDate <= '2014-0".$month."-30';";
	$result=mysqli_query($con,$query) or die(mysqli_error());
	while($row = mysqli_fetch_assoc($result)){
		$curMonth = $row['amount'] + $curMonth;
	}
	
	//$query = "SELECT * from statements WHERE userId ='".$_SESSION['userId']."';";
	$query = "SELECT * FROM statements LEFT OUTER JOIN bill ON statements.payId = bill.stmtId WHERE bill.stmtId IS null AND statements.userId ='".$_SESSION['userId']."';";
	$stmts=mysqli_query($con,$query) or die(mysqli_error());

	mysqli_close($con);
?>

<!DOCTYPE html>	
<html>
    <head>
		<script src="js/jQuery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://digitalbush.com/files/jquery/watermarkinput/beta1/jquery.watermarkinput.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<title>MAS Cloud</title>
	</head>
	<body class="mainBGcolor">
	
	<!-- NAVIGATION BAR -->
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php" >MAS Cloud</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<dl class="nav navbar-nav pull-right">
						<li><a href="logout.php">Logout 
							<?php 
								if(isset($_SESSION['username'])) {
									echo $userName;
								}
							?></a>
						</li>
					</dl>
				</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container -->
		</nav>
		
		<ul class="nav nav-tabs">
			<li><a href="homepage.php">Home</a></li>
			<li><a href="user_management.php">User</a></li>
			<li class="active"><a href="#">Bill & Usage</a></li>
			<script>
				$('#myTab a').click(function (e) {
					e.preventDefault()
					$(this).tab('show')
				})
			</script>
		</ul>
		<br><br>
		<div class="col-md-2" >
			<!--the category section-->
			<div class="list-group center-block" style="margin:10px">
				<a href="bill_management.php" data-toggle="modal" class="list-group-item">Balance Review</a>
				<a href="#" class="active list-group-item">Make Payment</a>
				<a href="pay_history.php" class="list-group-item">Payment History</a>
				<script>
				$('.list-group-item').on('click',function(e){
				var previous = $(this).closest(".list-group").children(".active");
				previous.removeClass('active'); // previous list-item
				$(e.target).addClass('active'); // activated list-item
				});
				</script>
			</div>
		</div>
	
		<div class="col-md-6" >
			<!--main section-->
			<div>
				<font color="red">
				<center>
					<?php $reasons = array("wrongOldPwErr" => "Wrong Old Password! Try it again.", "DBErr" => "Unexpected inner error, try it again.");
					    if (isset($_GET['makePayFailed'])) {
							echo $_GET['Err'];
						}
					?>
				</center>
			</font>
			</div>
			<div class="page-header">
				<h1><?php echo $userName;?> <small>Billing Management</small></h1>	
			</div>
			<table class="table table-striped">  
				<thead>  
				  <tr>  
				    <th>Amount</th>  
				    <th>Bill Day</th>  
				    <th>Pay Due</th>    
				  </tr>  
				</thead>  
				<tbody>
					<?php
					while($row = mysqli_fetch_assoc($stmts)){
						echo "<tr><td>".$row['amount']."</td><td>".$row['billingDate']."</td><td>".$row['dueDate']."</td><td><input type='radio'  name='stmnt' id='stmnt' value=".$row['payId']." onclick='smth()' ></td></tr>";
					}
					?>
				</tbody>
			</table>
			<a href="#make_pay" data-toggle="modal" class="btn btn-primary pull-right">Pay it!</a>
		</div>

		<script>
			var stmntID;
			function smth(){
				stmntID = $('input[id=stmnt]:checked').val();
				var elem = document.getElementById("stmtId");
				elem.value = stmntID;
			}
		</script>

		<form action="pay.php"  name="make_pay" method="post">
			<div class = "modal fade" id = "make_pay" role ="dialog">
				<div class ="modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<h4>Make the Payment</h4>
						</div>
						<div class ="modal-body">
							<input type="hidden" name="stmtId" id="stmtId" value=""/>
							<b>Name: </b>
							<input type="text" name="card_name" id="cardName"/>
							</br>
							</br>
							<b>Card Type: </b>
							<input type="radio" name="card_type" value="Visa" >Visa
							<input type="radio" name="card_type" value="Master" >Master
							<input type="radio" name="card_type" value="America_Express" >Express
							<input type="radio" name="card_type" value="Discover" >Discover
							</br></br>
							<b>Card Number: </b>
							<input type="text" name="card_num" id="cardNum" />
							</br>
							</br>
							<b>Expire Day: </b>

							<select name="years" id="years">
								<option value=''>--Year--</option>
								<option value='2014'>2014</option>
								<option value='2015'>2015</option>
								<option value='2016>2016</option>
								<option value='2017'>2017</option>
								<option value='2018'>2018</option>
								<option value='2019'>2019</option>
								<option value='2020'>2020</option>
								<option value='2021'>2021</option>
								<option value='2022'>2022</option>
								<option value='2023'>2023</option>
								<option value='2024'>2024</option>
								<option value='2025'>2025</option>
							</select> 
							<select name="months" id="months">
								<option value=''>--Month--</option>
								<option value='1'>Janaury</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>
							</select> 

						</div>
						<div class="modal-footer">
							<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
							<input data-dismiss = "modal" class = "btn btn-primary" type="submit" value="Confirm" onclick="submitPay()"/>
						</div>
					</div>
				</div>
			</div>
			<script>	
 				$("#cardName").Watermark("card owner name");
				$("#cardNum").Watermark("credit card number");
				function submitPay() {
					/*new_pw = document.getElementById("new_pw").value;
					new_pw_con = document.getElementById("new_pw_con").value;
					if(new_pw!=new_pw_con) {
						alert("Your new password confirmation is incorrect!");
						return false;
					}else {*/
					document.make_pay.submit();
					//}
			}
			</script>
			</script>
		</form>
	
		
	</body>

</html>
