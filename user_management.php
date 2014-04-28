<?php
	session_start();
    include ("db_config.php");
    

	
	if(isset($_SESSION['username'])) {
		$userName = "".$_SESSION['username']."";
	}else {
		header("location: login.php");
	}

	$query = "SELECT * FROM user WHERE userName='$userName'";
	$result_user=mysqli_query($con,$query);
	if (!$result_user) 
	{
		echo 'Could not run query?: ' . mysql_error();
	}
	else 
	{
		$user_info=mysqli_fetch_array($result_user, MYSQLI_BOTH);
		$userMail = $user_info['mail'];
	}
	
	/* free result set */
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
			<li><a href="homepage.php">Home</a></li>
			<li class="active"><a href="#">User</a></li>
			<li><a href="bill_management.php">Bill & Usage</a></li>
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
				<a href="/mac/user_management.php" data-toggle="modal" class="list-group-item active">Edit Profile</a>
				<a href="#reset_pw" data-toggle="modal" class="list-group-item">Reset Password</a>
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
			<!--the category section-->
			<div class="page-header">
				<h1><?php echo $userName;?> <small>Edit profile</small></h1>
				<form action="post_node.php" name="edit_pro" method="post">
					</br>
					<b>Name: </b>
					<input type="text" name="email" value="First Name" />
					<input type="text" name="email" value="Last Name" />
					</br>
					</br>
					<b>Email: </b>
					<input type="text" name="email" value="<?php echo htmlspecialchars($userMail); ?>" />
					</br>
					</br>
					<div class=pull-right>
						<a class = "btn btn-primary" data-dismiss = "modal" onclick="submitIntstanceType();">Confirm</a>
						<a href="user_management.php" class = "btn btn-default" data-dismiss = "modal">Cancel</a>
					</div>
					<script type="text/javascript">
						function submitIntstanceType() {
							document.edit_pro.submit();
						}
					</script>
				</form>	
			</div>

		</div>
		
		<form name="reset_pw" method="post">
			<div class = "modal fade" id = "reset_pw" role ="dialog">
				<div class ="modal-dialog">
					<div class = "modal-content">
						<div class = "modal-header">
							<h4>Reset the Password</h4>
						</div>
						<div class ="modal-body">						
							<b>Enter your old password</b>
							<input type="text" name="old_pw" id="old_pw"  maxlength="20"/><br><br>
							<b>Enter your new password</b>
							<input type="text" name="new_pw" id="new_pw"  maxlength="20"/><br><br>
							<b>Confirm your new password</b>										
							<input type="text" name="new_pw_con" id="new_pw_con"  maxlength="20"/><br><br>
						</div>
						<div class = "modal-footer">
							<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
							<a class = "btn btn-primary" data-dismiss = "modal" onclick="submitResetPw();">Confirm</a>
						</div>
					</div>
				</div>
			</div>

			<script type="text/javascript">
			function submitResetPw() {
				document.reset_pw.submit();
			}
			</script>
		</form>	



	</body>

</html>
