

<!DOCTYPE html>
<html>
    <head>
		<script src="js/jQuery.js"></script>
		<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<title>MyTacks.com</title>
	</head>
	<body class="mainBGcolor">
	
	<!-- NAVIGATION BAR -->
		<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
		  <div class="container" >
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php" >MyTacks Inc.</a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
			  
				<div class="col-sm-8 col-md-8 pull-center">
					<form class="navbar-form" role="search" id="srch_bar" action="search_result.php" method="post">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" name="srch_term" id="srch_term">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit" onclick="searchSubmit()"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
						<script type="text/javascript">
							function searchSubmit()
							{
								document.getElementById('srch_bar').submit();
							}
						</script>
					</form>
				</div>

				<div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
				  <dl class="nav navbar-nav">
					<li><a href="Contact/contact.php">Contact</a></li>
					<li><a href="logout.php">Logout 
						<?php 
							if(isset($_SESSION['username'])) {
								echo $userName;
							}
						?></a></li>
				  </dl>
				  
				  
				</div><!-- /.navbar-collapse -->
			</div>
			
		  </div><!-- /.container -->
		</nav>
		<br><br><br><br>

		
		
		
		  <div class="col-md-2" >
			<!--the button set section-->
			<!--<div class="btn-group-vertical center-block" style="margin:10px">
			  <a href = "#createboard" data-toggle="modal">
				<button type="button" class="btn btn-default" >Create Board</button>
			  </a>
			</div>-->
			
			
			<!--the category section-->
			<div class="list-group center-block" style="margin:10px">
			  <h2>Category</h2>
			  <a href="#createboard" data-toggle="modal" class="list-group-item">Create Board</a>
			  <a href="all_board.php" class="list-group-item">My Board</a>
			  <a href="user_tack.php" class="list-group-item">My Tacks</a>
			  <a href="friend_list.php" class="list-group-item">Search Friends</a>
			  <script>
				$('.list-group-item').on('click',function(e){
					var previous = $(this).closest(".list-group").children(".active");
					previous.removeClass('active'); // previous list-item
					$(e.target).addClass('active'); // activated list-item
				});
			  </script>
			</div>
		  </div>
		  
		  
		  <div class="col-md-8">

		  <!--The add tack object-->
		  <div class="col-sm-6 col-md-4">
				<div class="thumbnail">
				<a href = "#createtack" data-toggle="modal">
					<img src="img/plus.jpg" style="height:207px;width:200px;display: block; margin: 0.5cm">
				</a>
					
				  <div class="caption">
					<h4>Create New Tack</h4>
					<p>Click to create a new tack.<p>
				  </div>
				</div>

		  </div>
		  
		  
		  <?php
			$tack_num=mysqli_num_rows($result);
			//echo mysqli_num_rows($result);
			 
				while($row = mysqli_fetch_array($result)) {
					
					echo "
					<div class=\"col-sm-6 col-md-4\">
					<div class=\"thumbnail\">
					<script>
						var thumbnail = 'http://images.websnapr.com/?url=".$row['url']."&key=bTmGswCsoBm9&hash=' + encodeURIComponent(websnapr_hash);
						document.write('<a target=\"_blank\" style=\"display: block; margin: 0.5cm\" href=\"".$row['url']."\"><img class=\"img-thumbnail\" src=\"'+thumbnail+'\"></a>');
					</script>
					<div class=\"caption\">
					<h4>".$row['tackName']."</h4>
					<p class=\"tackDes\">".$row['tackDescription']."</p>
					<p align=\"right\"><a class=\"btn btn-primary\" role=\"button\"><span class=\"glyphicon glyphicon-pushpin\"></span>	</a>
					</p>
					</div>
					</div>
					</div>";
				}
		  ?>
		  
		  
			<!--Tack Object-->
			  <!--<div class="col-sm-6 col-md-4">
				<div class="thumbnail">

				  <script>
					function img_preview(url) {
						var apiKey = 'bTmGswCsoBm9',
							thumbail;
						thumbnail = 'http://images.websnapr.com/?url=' + url + '&key=bTmGswCsoBm9&hash=' + encodeURIComponent(websnapr_hash);
						document.write('<a target="_blank" style="display: block; margin: 0.5cm" href="'+url+'"><img class="img-thumbnail" src="'+thumbnail+'"></a>');
					};
					img_preview("http://www.yahoo.com/");
				  </script>

				  <div class="caption">
					<h4>Title</h4>
					<p class="tackDes">YAHOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO<p>
					<hr style="border-color:#000000">
					<ul class="media-list" >
					  <li class="media">
						<a class="pull-left" href="#">
						  <img class="media-object" src="img/head.jpg" alt="...">
						</a>
						<div class="media-body">
						  <h5 class="media-heading">Comment</h5>
						  
						</div>
					  </li>
					</ul>
					<p align="right">
					<a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-search"></span>	</a>
					</p>
				  </div>
				</div>
			  </div>-->
			  
			  
		</div>
		
		
		
		<!--CreateTack form-->
		<form action="inserttack.php" name="createtack" method="post">
		<div class = "modal fade" id = "createtack" role ="dialog">
			<div class ="modal-dialog">
				<div class = "modal-content">
					<div class = "modal-header">
						<h4>Create a Tack</h4>
					</div>
					<div class ="modal-body">
					<b>Enter Tack Name: </b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="tackname" id="tackname"  maxlength="12"/><br><br>							
						<b>Tack Description: </b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="tackdesc" id="tackdesc" maxlength="12"/><br><br>
						<b>Enter Tack URL: </b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="tackURL" id="tackURL"  maxlength="100"/><br><br>							
						<b>Privacy Settings: </b>
						    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="settings">
							<option value="private" >Private</option>
							<option value="public">Public</option>
						</select><br></br>						
					</div>
					<div class = "modal-footer">
						<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
						<a class = "btn btn-primary" data-dismiss = "modal" onclick="submitForm();">Create</a>
					</div>
				</div>
			</div>
			</div>

			<script type="text/javascript">

			 function submitForm()
			 {
				   document.createtack.submit();
			 }
			</script>
		</form>	
		
		<!--CreateBoard form-->
		<form action="insertboard.php" name="createboard" method="post">
			<div class = "modal fade" id = "createboard" role ="dialog">
			<div class ="modal-dialog">
				<div class = "modal-content">
					<div class = "modal-header">
						<h4>Create a Board</h4>
					</div>
					<div class ="modal-body">
						<fieldset>
					<legend><i>Enter Board Details:</i></legend>
					<center>
					
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>Enter Board Name: </b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="boardname" id="boardname"  maxlength="20"/><br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>Enter Description: </b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="boarddesc" id="boarddesc" maxlength="100"/><br><br>
						<b>Select the Privacy Settings: </b>
						<select name="setting">
							<option value="private">Private</option>
							<option value="public">Public</option>
						</select>
					
					</center>
				</fieldset>	
					</div>
					<div class = "modal-footer">
						<a class = "btn btn-default" data-dismiss = "modal">Cancel</a>
						<a class = "btn btn-primary" data-dismiss = "modal" onclick="submitForm1();">Create</a>
						
					
				</div>
				</div>
			</div>
			</div>

			<script type="text/javascript">
			 function submitForm1()
			 {
				   document.createboard.submit();
			 }
			</script>
		</form>	
		
		
	</body>

</html>
