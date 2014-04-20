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
			<li class="active"><a href="#">Home</a></li>
			<li><a href="user_management.php">User</a></li>
			<li><a href="bill_management">Bill & Usage</a></li>
			<script>
				$('#myTab a').click(function (e) {
					e.preventDefault()
					$(this).tab('show')
				})
			</script>
		</ul>
		
		<div class="col-md-9">
			<h1>Instances status</h1>		
			<table class="table table-striped">  
				<thead>  
				  <tr>  
				    <th>Instance ID</th>  
				    <th>Type</th>  
				    <th>Status</th>    
				  </tr>  
				</thead>  
				<tbody>  
				  <tr>  
				    <td>001</td>  
				    <td>Android </td>  
				    <td><span class="label label-success">Available</span></td>    
				  </tr>  
				  <tr>  
				    <td>002</td>  
				    <td>IOS</td>  
				    <td><span class="label label-warning">Launching...</span></td>   
				  </tr>  
				  <tr>  
				    <td>003</td>  
				    <td>Windows Phone</td>  
				    <td><span class="label label-danger">Stop</span></td>   
				  </tr>  
				</tbody>  
			</table>
			<br>
			<button type="button" class="btn btn-default" >Launch new instance</button>
		</div>

	</body>

</html>
