<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
header('Content-type: text/plain');

$uid = $_GET["uid"];
$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "select sum(stock), sum(bond), sum(cash) from activity where uid = $uid;";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$query2 = "select year, stockprice, bondprice from activity where uid = $uid order by year desc limit 1;";
$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());

$stocksum = 0;
$bondsum = 0;
$cashsum = 0;
while($row = mysql_fetch_array($result)) {
	$stocksum = $row[0];
	$bondsum = $row[1];
	$cashsum += $row[2];
}

$stockprice = 0;
$bondprice = 0;
while($row2 = mysql_fetch_array($result2)) {
	$stockprice = $row2[1];
	$bondprice = $row2[2];
}

?>

[
	{
		'label' : 'Stocks',
		'value' : <?php echo $stocksum*$stockprice; ?>
	},
	{
		'label' : 'Bonds',
		'value' : <?php echo $bondsum*$bondprice; ?>
	},
	{
		'label' : 'Cash',
		'value' : <?php echo $cashsum; ?>
	}
]