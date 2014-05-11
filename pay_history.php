<?php
	session_start();
  include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
		$userId = "".$_SESSION['userId']."";
	}

	$query = "SELECT * from bill WHERE userId ='".$_SESSION['userId']."';";
	$bills=mysqli_query($con,$query) or die(mysqli_error());

	mysqli_close($con);
?>

<!DOCTYPE html>	
<html>
    <head>
		<script src="jQuery.js"></script>
		<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>	
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
				<a href="make_payment.php" class="list-group-item">Make Payment</a>
				<a href="#" class="list-group-item active">Payment History</a>
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
			<div class="page-header">
				<h1><?php echo $userName;?> <small>Billing Management</small></h1>	
			</div>
			<table class="table table-striped">  
				<thead>  
				  <tr>  
				    <th>Card</th>  
				    <th>Name</th>  
				    <th>Pay Date</th>    
				  </tr>  
				</thead>  
				<tbody>
				  <?php
					while($row = mysqli_fetch_assoc($bills)){
						echo "<tr><td>".$row['cardNum']."</td><td>".$row['cardName']."</td><td>".$row['payTime']."</td></tr>";
					}
					?>
				</tbody>  
			</table>
		</div>
		
	</body>

</html>
