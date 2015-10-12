<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$database = "zipcodesdb";
 
 
$conn = mysql_connect("$hostname","$username","$password") or die(mysql_error());
mysql_select_db("$database", $conn);
?>