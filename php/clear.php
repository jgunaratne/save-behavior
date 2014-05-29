<?php
$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "DELETE FROM activity";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>