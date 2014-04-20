<?php

session_start();

session_destroy();

//echo "You have been logged out, <a href='http://localhost/MyTacksSystem/index.php'>click here</a> to return."

header("location: index.php");

?>
