<?php

$usercode = $_GET["usercode"];

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

$q = "UPDATE user SET completed = now() WHERE usercode = '$usercode';";
$res = mysql_query($q) or die('Query failed: ' . mysql_error());

$q2 = "SELECT * FROM user WHERE usercode = '$usercode'";
$res2 = mysql_query($q2) or die('Query failed: ' . mysql_error());

$reward = 0;
$goal = 0;
$totalvalue = 0;
while($row = mysql_fetch_array($res2)) {
	$goal = round(sprintf('%f', $row['goal']));
	$totalvalue = round(sprintf('%f', $row['totalvalue']));
	$diff = abs($goal - $totalvalue);
	$percent = 1-abs(($totalvalue-$goal)/$goal)*6;
	$reward = round($percent * 400) / 100;
	if ($reward < 0) {
		$reward = 0;
	}
	//$reward += 1;
}

$q3 = "UPDATE user SET reward = $reward WHERE usercode = '$usercode';";
$res3 = mysql_query($q3) or die('Query failed: ' . mysql_error());

echo "$reward,$goal,$totalvalue";

?>