 <!--- CONNECT AND CONFIGURE OUR DATABASE --->
<?php
    
$db_host = "macdb.ctijsbuenarr.us-west-2.rds.amazonaws.com";
$db_username = "mac";
$db_pass = "mac4thewin";
$db_name = "mac_web";

@mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to MySQL");
@mysql_selectdb("$db_name") or die ("No database");

?>
