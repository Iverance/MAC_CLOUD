<?php

ob_start();
session_start();
include ("config.php");

// username and password sent from form 
$username=$_POST['username']; 
$password=$_POST['password']; 

// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$sql="SELECT * FROM user WHERE name='$username' AND pw='$password'";
$result=mysql_query($sql);


// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	
    // Register $username, $password and redirect to file "homepage.php"
    /*following functions are deprecated in PHP 5.4+
	session_register("username");
    session_register("password");*/
	$_SESSION['username']=$username; 
	$_SESSION['password']=$password; 
    header("location: homepage.php");

	
} else {
    die(header("location:index.php?loginFailed=true&reason=passwordErr"));   
	
}

ob_end_flush();

?>
