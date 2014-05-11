 <!--- CONNECT AND CONFIGURE OUR DATABASE --->
<?php
    
$db_host = "freesql.ctijsbuenarr.us-west-2.rds.amazonaws.com";
$db_username = "admin";
$db_pass = "adminpasswd";
$db_name = "mac_web";

@mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to MySQL");
@mysql_selectdb("$db_name") or die ("No database");

?>
