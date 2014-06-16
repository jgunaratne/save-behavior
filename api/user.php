<?php
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$usercode = $_GET['usercode'];

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "SELECT * FROM user WHERE usercode = '$usercode'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

while($row = mysql_fetch_array($result)) {
	$mtwid = $row[0];
	$groupid = $row[1];
	$completed = $row[4];
	$goal = $row[5];
}

echo "$mtwid,$groupid,$completed,$goal";
?>