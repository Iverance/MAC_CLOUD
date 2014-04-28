<?php
	session_start();
    include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
	}else {
		header("location: login.php");
	}
	
	/* free result set */
			//$result->close();
	mysqli_close($con);
?>

<!DOCTYPE html>
<html>
    <head>
		<script src="js/jQuery.js"></script>
		<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
			<a href="#launch_ins" data-toggle="modal">
				<button type="button" class="btn btn-default">Launch new instance</button>
			</a>
		</div>

		<!--launch form-->
		<form action="command_py.php" name="launch_ins" method="post">
			<div class = "modal fade" id = "launch_ins" role ="dialog">
				<div class ="modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<h4>Launch An Instance</h4>
						</div>
						<div class ="modal-body">						
							<b>Instance Type Settings: </b>
							<select name="settings">
								<option value="AND">Android</option>
								<option value="IOS">IOS</option>
								<option value="WP">Windows Phone</option>
							</select>					
						</div>
						<div class = "modal-footer">
							<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
							<a class = "btn btn-primary" data-dismiss = "modal" onclick="submitIntstanceType();">Create</a>
						</div>
					</div>
				</div>
			</div>

		<!--launch form-->
			<div class = "modal fade" id = "launch_not_supported" role ="dialog">
				<div class ="modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<h4>Unsupported Device</h4>
						</div>
						<div class ="modal-body">						
							<b>Instance Not Supported Yet!</b>					
						</div>
						<div class = "modal-footer">
							<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
						</div>
					</div>
				</div>
			</div>

			<script type="text/javascript">
			function submitIntstanceType() {				
				if( document.launch_ins.settings.value == "AND" ){
					document.launch_ins.submit();
				}
				else {
					$('#launch_not_supported').modal('show');
				}
			}
			</script>
		</form>	
	</body>

</html>
