<?php
	session_start();
  include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
	}else {
		header("location: login.php");
	}
	$q = "SELECT * FROM regi_machines WHERE userId = '".$_SESSION['userId']."';";
	$result=mysqli_query($con,$q) or die(mysqli_error());
	/* free result set */
			//$result->close();

	mysqli_close($con);
?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="js/jQuery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<title>MAS Cloud</title>
		<script language=javascript>
        function addTDclass() {
            document.getElementById("stat").value = "green";
        }
    </script>
	</head>
	<body class="mainBGcolor" onload="addTDclass();">
	
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
			<table class="table table-striped"  id="machineTb">  
				<thead>  
				  <tr>  
				    <th>Instance ID</th>  
				    <th>Type</th>  
				    <th>Status</th>
						<th></th>
						<th></th>
				  </tr>  
				</thead>  
				<tbody>
					<?php
					while($row = mysqli_fetch_assoc($result)){
						if($row['type'] == 'and') {
							$type = 'Android';
						}elseif($row['type'] == ''){
						}else{
						}
		
						if($row['status'] == 'launching') {
							$class = 'class="label label-warning"';
							$stat='Launching...';
						}elseif($row['status'] == 'launched'){
							$class = 'class="label label-success"';
							$stat='Available';
						}else{
							$class = 'class="label label-danger"';
							$stat='Stop';
						}
						echo "<tr><td><span id='mId'>".$row['machineId']."</td><td id='type'>".$type."</td><td><span id='stat' $class '>".$stat."</span></td><td><a href='launch.php?send=false'>Delete</a></td><td><a href='launch.php?app=".$row['machineId']."'>Run App</a></td></tr>";
					}
					?>
				</tbody>  
			</table>
			<br>
			<a href="launch.php?send=true" data-toggle="modal">
				<button type="button" class="btn btn-default">Launch new instance</button>
			</a>
			<p class="red"><?php if (isset($_GET['Err'])) {echo $_GET['Err'];} ?></p>
		</div>
		

		<script>
			var instanceId;
			function getInstanceId(){
				stmntID = $('input[id=mId]:checked').val();
				var elem = document.getElementById("stmtId");
				elem.value = stmntID;
			}
				
			var $_GET = {};

			document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
					function decode(s) {
						  return decodeURIComponent(s.split("+").join(" "));
					}

					$_GET[decode(arguments[1])] = decode(arguments[2]);
			});

			if($_GET['success'].length > 1) {
				if($_GET['success']=="app")	alert('Run new app!');
				else if($_GET['success']=="ins") alert('Increase an instance!');
			}
			
		</script>

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
