<?php
	session_start();
    include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
		$userId = "".$_SESSION['userId']."";
	}
	$month = date("m")+0;
	$month = $month-1;
	$query = "SELECT * from statements where billingDate >= '2014-0".$month."-01' and billingDate <= '2014-0".$month."-30';";
	$result=mysqli_query($con,$query) or die(mysql_error());
	while($row = mysqli_fetch_assoc($result)){
		$lastMonth = $row['amount'] + $lastMonth;
	  }
	$month = $month+1;
	$query = "SELECT * from statements where billingDate >= '2014-0".$month."-01' and billingDate <= '2014-0".$month."-30';";
	$result=mysqli_query($con,$query) or die(mysql_error());
	while($row = mysqli_fetch_assoc($result)){
		$curMonth = $row['amount'] + $curMonth;
	}

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
				<a href="#" data-toggle="modal" class="active list-group-item">Balance Review</a>
				<a href="make_payment.php" class="list-group-item">Make Payment</a>
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
			<div class="page-header">
				<h1><?php echo $userName;?> <small>Billing Management</small></h1>	
			</div>
			<div id="container" style="width:100%; height:400px;">
				<script>
					$(function () { 
							$('#container').highcharts({
									chart: {
										  type: 'bar'
									},
									title: {
										  text: ''
									},
									xAxis: {
										  categories: ["<?php echo date('M',mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));?>", "<?php echo date('M');?>"]
									},
									yAxis: {
										  title: {
										      text: 'Bill Amount ($)'
										  }
									},
									series: [{
										  name: "This month",
										  data: [0, "<?php echo $curMonth;?>"]
									},	{
										  name: "Last month",
										  data: [parseInt("<?php echo $lastMonth; ?>"),0]
									}]
							});
					});
				</script>
			</div>
		</div>
		
	</body>

</html>
