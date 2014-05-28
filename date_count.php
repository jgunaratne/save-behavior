<?php

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

$today = date("Y-m-d");
$query_sum = "SELECT modified FROM `activity` WHERE modified > '$today';";
$result_sum = mysql_query($query_sum) or die('Query failed: ' . mysql_error());

$count = 0;
while($row_sum = mysql_fetch_array($result_sum)) {
	$count++;
}

echo $count;

?>