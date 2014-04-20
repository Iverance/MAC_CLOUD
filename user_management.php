<?php
	session_start();
    include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
	}
	
	/* free result set */
			//$result->close();
	mysqli_close($con);
?>

<!DOCTYPE html>
<html>
    <head>
		<script src="jQuery.js"></script>
		<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<title>MAC Cloud</title>
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
					<a class="navbar-brand" href="index.php" >MAC Cloud</a>
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
			<li class="active"><a href="#">User</a></li>
			<li><a href="bill_management">Bill & Usage</a></li>
			<script>
				$('#myTab a').click(function (e) {
					e.preventDefault()
					$(this).tab('show')
				})
			</script>
		</ul>
		<br><br><br>
		<div class="col-md-2" >
			<!--the category section-->
			<div class="list-group center-block" style="margin:10px">
				<a href="#" data-toggle="modal" class="list-group-item">Edit Profile</a>
				<a href="#" class="list-group-item">Reset Password</a>
				<script>
				$('.list-group-item').on('click',function(e){
				var previous = $(this).closest(".list-group").children(".active");
				previous.removeClass('active'); // previous list-item
				$(e.target).addClass('active'); // activated list-item
				});
				</script>
			</div>
		</div>
		
	</body>

</html>
