<?php
header('Content-type: text/plain');
$uid = $_GET["uid"];
$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "select * from activity where uid = $uid;";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
echo "date,close\r";
while($row = mysql_fetch_array($result)) {
	$year = $row["year"];
	$month = $row["month"];
	$total = $row["totalvalue"];
	echo "$year-01-01,$total\r";
}
?>