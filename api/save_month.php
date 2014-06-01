<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$uid = $_GET["uid"];
$mturkworkerid = $_GET["mturkworkerid"];
$month = $_GET["month"];
$year = $_GET["year"];
$amount = $_GET["amount"];
$pbond = $_GET["pbond"]/100;
$pstock = $_GET["pstock"]/100;
$pcash = $_GET["pcash"]/100;
$goal = $_GET["goal"];
$usercode = $_GET["usercode"];


function readCSV($csvFile, $type){
	$line_hash = array();
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle) ) {
		$line_array = fgetcsv($file_handle, 1024);
		$line_key = substr($line_array[0],0,-3);
		if ($type == 'stock') {
			// Add more volatility to stock performance
			$line_array[4] = $line_array[4] * (1 + (rand(-10,10)/100));
		}
		$line_hash[$line_key] = $line_array;
	}
	fclose($file_handle);
	return $line_hash;
}

$csvfile_djia = '../data/djia.csv';
$csvfile_fbndx = '../data/fbndx.csv';

$djia_hash = readCSV($csvfile_djia, 'stock');
$fbndx_hash = readCSV($csvfile_fbndx, 'bond');

$date_str = "$year-$month";
$djia_price = $djia_hash[$date_str][4];
$fbndx_price = $fbndx_hash[$date_str][6];

$stock_share_price = $djia_price/100;
$bond_share_price = $fbndx_price*10;

$stock_shares_bought = ($amount*$pstock)/$stock_share_price;
$bond_shares_bought = ($amount*$pbond)/$bond_share_price;
$cash_saved = $amount*$pcash;
$totalvalue = ($stock_shares_bought*$stock_share_price) + ($bond_shares_bought*$bond_share_price) + $cash_saved;

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

$query_sum = "select sum(stock), sum(bond), sum(cash) from activity where mturkworkerid = '$mturkworkerid';";
$result_sum = mysql_query($query_sum) or die('Query failed: ' . mysql_error());

while($row_sum = mysql_fetch_array($result_sum)) {
	$stocksum = $row_sum[0];
	$bondsum = $row_sum[1];
	$cashsum = $row_sum[2];
}
$total_sum = ($stocksum*$stock_share_price) + ($bondsum*$bond_share_price) + $cashsum;

$totalvalue = $totalvalue + $total_sum;

echo "$uid, $month, $year, $stock_shares_bought, $bond_shares_bought";
echo "<br>";
echo "$stock_share_price, $bond_share_price, $stock_shares_bought, $bond_shares_bought";
echo "<br>";
echo "$uid,$month,$year,$pstock,$pbond,$djia_price,$fbndx_price,$amount,$mturkworkerid";
echo "<br>";
echo "$stock_share_price,$bond_share_price";

$query = "INSERT INTO activity VALUES ($uid, $month, $year, $stock_shares_bought, $bond_shares_bought, $cash_saved, $stock_share_price, $bond_share_price, $totalvalue, now(), '$mturkworkerid', $pstock, $pbond, $pcash, $goal, '$usercode');";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$stocksum = 0;
$bondsum = 0;
$cashsum = 0;

?>