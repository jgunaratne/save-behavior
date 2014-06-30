<?php

$usercode = $_GET["usercode"];
$comments = $_GET["comments"];

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

$q = "UPDATE user SET comments = '$comments' WHERE usercode = '$usercode';";
$res = mysql_query($q) or die('Query failed: ' . mysql_error());

echo "Comments added.";

?>