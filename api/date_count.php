<?php
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

date_default_timezone_set("America/New_York");

$today = date("Y-m-d");
$query_sum = "SELECT modified FROM `activity` WHERE modified > '$today';";
$result_sum = mysql_query($query_sum) or die('Query failed: ' . mysql_error());

$count = 0;
while($row_sum = mysql_fetch_array($result_sum)) {
	$count++;
}

echo $count;

?>