<?PHP
    include('db_config.php');
    if(isset($_POST['submit'])){
        //require_once("./include/membersite_config.php");
        $userName=$_POST['username'];
        $email=$_POST['email'];
        $userPassword=$_POST['password'];      
        //check if username and email are in DB
        $sql="SELECT * FROM user WHERE userName='$name' OR mail='$email'";
        $result=mysqli_query($con,$sql);
        $count=mysqli_num_rows($result);
        //insert into DB if username and email are unique
        if($count != 0){
            //echo "Please try again. Non-unique password or email.";
					echo 'Could not run query: ' . mysql_error();
        	die(header("location:register.php?registrationFailed=true&reason=userNameOrEmailNonUnique"));
        } else {
			$sql = "INSERT INTO user (userName, mail, pw) VALUES('{$userName}', '{$email}', '{$userPassword}')";
			if (!mysqli_query($con,$sql)) 
			{
				die('Error: ' . mysqli_error($con));
			}
            header("location: index.php?remarks=success");
            echo "Register success!";
            mysql_close($con);
        }
    }
?>
<!DOCTYPE html>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
  <head>
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="msvalidate.01" content="36A28D9109C077BA3E623651FC1656F4" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:admins" content="19908503" />
    <meta property="fb:app_id" content="112989545392380" /> 

    <meta property="og:title" content="HTML Snippets for Twitter Boostrap framework : Bootsnipp.com" />
    <meta property="og:type" content="website" />
          <meta property="og:url" content="http://bootsnipp.com" />
        <meta property="og:image" content="http://bootsnipp.com/img/logo.jpg" />
    <meta property="og:site_name" content="Bootsnipp.com" />
          <meta property="og:description" content="Bootsnipp is an element gallery for web designers and web developers, anybody who is using Bootstrap will find this website essential in their craft." />
        <meta name="description" content="Bootsnipp is an element gallery for web designers and web developers, anybody who is using Bootstrap will find this website essential in their craft.">
    <meta name="author" content="Maks Surguy, @msurguy">
    <title>Register for an account | Bootsnipp.com</title>
    <font color="red"><center>
    ?></center>
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-144x144-precomposed.png">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://bootsnipp.com/css/bootsnipp.css?ver=2">
    <style type="text/css">

	body{
		background-image: url('./img/blur.jpg');
	}
	
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	.form-signin .middle {
	  margin-bottom: -1px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	.form-signin .bottom {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	.form-signin .form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	}
	.colorgraph {
	  height: 5px;
	  border-top:0;
	  background: #c4e17f;
	  border-radius: 5px;
	  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	}
</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>
    <![endif]-->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-34731274-1']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <script type="text/javascript">
    var fb_param = {};
    fb_param.pixel_id = '6007046190250';
    fb_param.value = '0.00';
    (function(){
      var fpw = document.createElement('script');
      fpw.async = true;
      fpw.src = '//connect.facebook.net/en_US/fp.js';
      var ref = document.getElementsByTagName('script')[0];
      ref.parentNode.insertBefore(fpw, ref);
    })();
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6007046190250&amp;value=0" /></noscript>
    <script src="gen_validatorv4.js" type="text/javascript"></script>
  </head>

  <body>
    <div id="wrap">
        <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0;">
  <div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-bootsnipp-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

  <!-- Collect the nav links, forms, and other content for toggling -->
      <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container" >
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" >Mas Cloud.</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <!--<li><a href="#about"></a></li>
            <li><a href="#services">Learn More</a></li> -->
            <li><a href="register.php">Register</a></li>
            <li><a href="Contact/contact.php">Contact</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>

    </div><!-- /full-width-image-1 -->
        
    <!-------- START FORM ----->  
        <div class="container">
	<div class="row" style="margin-top:40px;">
		<div class="col-md-4 col-md-offset-4">	
			<font color = "black"><h3>Register for an account:</h3></font>
      	<font color="red">
        <center><?php $reasons = array("userNameOrEmailNonUnique" => "Non-unique Email or Username! Please try another username or email.");
        	if (isset($_GET["registrationFailed"]))
          	echo $reasons[$_GET["reason"]];
        	?>
        </center></font>
			<hr class="colorgraph">
                        <font color="red">* required fields</font>
			<form method="POST" id='myform' action="" accept-charset="UTF-8" role="form" class="form-signin">
                        <input name="submit" type="hidden" value="submit">
                        <fieldset>
					<input class="form-control" placeholder="Username*" name="username" type="text">
          <input class="form-control middle" placeholder="E-mail*" name="email" type="text">
          <input class="form-control middle" placeholder="Password*" name="password" type="password">
          <input class="form-control bottom" placeholder="Confirm Password*" name="password_confirmation" type="password" >
          <input class="btn btn-lg btn-primary btn-block" type="submit" value="Register">
            <p class="text-center" style="margin-top:10px;"><font color = "black">OR</font></p>
				  	<p class="text-center"><a href="index.php">Already have an account?</a></p>
			  	</fieldset>
		  	</form>
                </div>
  	</div>
</div>
    </div>
  
  <!-- FOOTER -->
  <footer class="bs-footer" role="contentinfo">
  <div class="container">
    <div class="bs-social">
      <ul class="bs-social-buttons">
            <li class="facebook-button">
          <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fbootsnipp.com&amp;width=130&amp;height=20&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;send=true&amp;appId=112989545392380" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:20px;" class="facebook-btn" allowTransparency="true"></iframe>
        </li>
        <li class="follow-btn">
          <iframe allowtransparency="true" frameborder="0" scrolling="no"
            src="//platform.twitter.com/widgets/follow_button.html?screen_name=bootsnipp"
            style="width:136px; height:20px;" class="twitter-follow-button twitter-follow-button"></iframe>
        </li>
        <li class="tweet-btn">
          <iframe allowtransparency="true" frameborder="0" scrolling="no"
                 src="https://platform.twitter.com/widgets/tweet_button.html?lang=en&via=bootsnipp&url=http%3A%2F%2Fbootsnipp.com&text=RT%20Design%20elements%20and%20code%20snippets%20for%20%23twbootstrap%20HTML%2FCSS%2FJS%20framework"
                 style="width:136; height:20px;" class="twitter-share-button twitter-count-horizontal"></iframe>
        </li>
      </ul>
    </div>
    <p align="center">MasCloud.com was crafted by Scales Inc. DB Hosted on <a href="http://aws.amazon.com/rds/" target="_blank" title="Amazon RDS Cloud Hosting"><img src="http://www.cloudreviews.com/blog/wp-content/uploads/2013/06/rds_logo1_300x100.png" alt = "AWS RDS" height="42" width="120"></a></p>
  </div>
</footer>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="http://bootsnipp.com/js/vendor/placeholder.min.js"></script>
    <script src="ddmmyyyy-validation.js"></script>
    <script type="text/javascript">
            
            //validators for registration form
            var frmvalidator  = new Validator("myform");
        
            frmvalidator.addValidation("username","req","Please enter a Username.");
            frmvalidator.addValidation("username","alphabetic","Username must be letters and numbers.");
            frmvalidator.addValidation("username","minlength=6","Min length for username must be 6.");


            frmvalidator.addValidation("firstname","req","Please enter your First Name");
            frmvalidator.addValidation("firstname","alphabetic","No special characters or numbers allowed in First Name.");
            frmvalidator.addValidation("firstname","maxlength=20","Max length for first name must be < 20");
 
            frmvalidator.addValidation("lastname","req","Please enter your Last Name");
            frmvalidator.addValidation("lastname","alphabetic","No special characters or numbers allowed in Last Name.");
            frmvalidator.addValidation("lastname","maxlength=20","Max length for last name must be < 20");
            
            frmvalidator.setAddnlValidationFunction(validatedate);       
                        
            frmvalidator.addValidation("secretQues","maxlen=50", "Secret Question  must be less than 50 characters");
            frmvalidator.addValidation("secretQues","alphanumeric_space", "Secret Question  must be letters and numbers.");
			
			frmvalidator.addValidation("secretAns","maxlen=50", "Secret Question  must be less than 50 characters");
            frmvalidator.addValidation("secretAns","alphanumeric_space", "Secret Question  must be letters and numbers.");
			
			frmvalidator.addValidation("email","maxlen=50", "Email must be less than 50 characters");
            frmvalidator.addValidation("email","req");
            frmvalidator.addValidation("email","email");
            
            frmvalidator.addValidation("password","req");
            frmvalidator.addValidation("password","alphabetic","Passwords must be letters and numbers.");
            
            frmvalidator.setAddnlValidationFunction(DoCustomValidation);
            
            
            //special validation for date
            function validatedate(){ 
                
               var dateformat = "^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$";  
               
               // Match the date format through regular expression  
               if(bday.value.match(dateformat))  
               {  
                document.form1.text1.focus();  
                //Test which seperator is used '/' or '-'  
                var opera1 = bday.value.split('/');  
                var opera2 = bday.value.split('-');  
                lopera1 = opera1.length;  
                lopera2 = opera2.length;  
               
                    // Extract the string into month, date and year  
                    if (lopera1>1)  
                    {  
                        var pdate = bday.value.split('/');  
                    }  
                    else if (lopera2>1)  
                    {  
                        var pdate = bday.value.split('-');  
                    }  
                    
                    var dd = parseInt(pdate[0]);  
                    var mm  = parseInt(pdate[1]);  
                    var yy = parseInt(pdate[2]);  
                    
                    // Create list of days of a month [assume there is no leap year by default]  
                    var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];  
                    
                    if (mm==1 || mm>2)  
                    {  
                        if (dd>ListofDays[mm-1])  
                        {  
                            alert('Invalid date format!');  
                            return false;  
                        }  
                    }  
                    
                    if (mm==2)  
                    {  
                        var lyear = false;  
                        if ( (!(yy % 4) && yy % 100) || !(yy % 400))   
                        {  
                            lyear = true;  
                        }  
                        if ((lyear==false) && (dd>=29))  
                        {  
                            alert('Invalid date format!');  
                            return false;  
                        }  
                        if ((lyear==true) && (dd>29))  
                        {  
                            alert('Invalid date format!');  
                            return false;  
                        }  
                    }  
                }  
                else  
                {  
                    alert("Invalid date format!");  
                    document.form1.text1.focus();  
                    return false;  
                }
                return true;
            }  // Group 2 use validation for date from http://www.w3resource.com/javascript/form/javascript-date-validation.php#sthash.uUwfI9iJ.dpuf
                              
                 
            //special validation for password
            function DoCustomValidation()
            {
              var frm = document.forms["myform"];
              if(frm.password.value != frm.password_confirmation.value)
              {
                sfm_show_error_msg('The Password and verified password does not match!',frm.pwd1);
                return false;
              }
              else
              {
                return true;
              }
            }
 
    $(function() {
      $('.tip').tooltip();
      $('input, textarea').placeholder(); 
      $( ".search-btn").mouseover(function(e) {
        var $marginLefty = $('.form-input-slide');
        $marginLefty.animate({  marginLeft: 0});
      });
      $( "#search-form" ).mouseleave(function(e) {
        var $marginLefty = $('.form-input-slide');
        $marginLefty.animate({  marginLeft: -$marginLefty.outerWidth()});
      });
    });
    </script>
    <script type="text/javascript" src="http://cdn.buysellads.com/ac/audience.js"></script>   
  </body>
</html>
