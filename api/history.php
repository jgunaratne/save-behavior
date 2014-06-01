<?php
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header('Content-type: text/plain');
$uid = $_GET["uid"];
$mturkworkerid = $_GET["mturkworkerid"];
$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "select * from activity where mturkworkerid = '$mturkworkerid';";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
echo "date,close\r";
while($row = mysql_fetch_array($result)) {
	$year = $row["year"];
	$month = $row["month"];
	$total = $row["totalvalue"];
	echo "$year-01-01,$total\r";
}
?>