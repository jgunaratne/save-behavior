<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$uid = $_GET["uid"];
$mturkworkerid = $_GET["mturkworkerid"];
$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "select sum(stock), sum(bond), sum(cash) from activity where mturkworkerid = '$mturkworkerid';";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$query2 = "select year, stockprice, bondprice from activity where mturkworkerid = '$mturkworkerid' order by year desc limit 1;";
$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());

$stocksum = 0;
$bondsum = 0;
$cashsum = 0;
while($row = mysql_fetch_array($result)) {
	$stocksum = $row[0];
	$bondsum = $row[1];
	$cashsum = $row[2];
}

$stockprice = 0;
$bondprice = 0;
while($row2 = mysql_fetch_array($result2)) {
	$stockprice = $row2[1];
	$bondprice = $row2[2];
}

echo ($stocksum*$stockprice) + ($bondsum*$bondprice) + $cashsum;
?>