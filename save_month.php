<?php
$uid = $_GET["uid"];
$month = $_GET["month"];
$year = $_GET["year"];
$amount = $_GET["amount"];
$pbond = $_GET["pbond"];
$pstock = $_GET["pstock"];

function readCSV($csvFile){
	$line_hash = array();
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle) ) {
		$line_array = fgetcsv($file_handle, 1024);
		$line_key = substr($line_array[0],0,-3);
		$line_hash[$line_key] = $line_array;
	}
	fclose($file_handle);
	return $line_hash;
}

$csvfile_djia = 'data/djia.csv';
$csvfile_fbndx = 'data/fbndx.csv';

$djia_hash = readCSV($csvfile_djia);
$fbndx_hash = readCSV($csvfile_fbndx);

$date_str = "$year-$month";
$djia_price = $djia_hash[$date_str][4];
$fbndx_price = $fbndx_hash[$date_str][6];

$stock_share_price = $djia_price/100;
$bond_share_price = $fbndx_price*10;

$stock_shares_bought = ($amount*$pstock)/$stock_share_price;
$bond_shares_bought = ($amount*$pbond)/$bond_share_price;

echo "$uid, $month, $year, $stock_shares_bought, $bond_shares_bought";
echo "<br>";
echo "$stock_share_price, $bond_share_price, $stock_shares_bought, $bond_shares_bought";
echo "<br>";
echo "$uid,$month,$year,$pstock,$pbond,$djia_price,$fbndx_price,$amount";

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());
$query = "INSERT INTO activity VALUES ($uid, $month, $year, $stock_shares_bought, $bond_shares_bought, $stock_share_price, $bond_share_price)";

//$query = 'INSERT INTO activity VALUES ($uid, $month, $year, $stock_shares_bought, $bond_shares_bought)';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

//http://localhost/retire/save_month.php?year=1999&month=01&pbond=.3&pstock=.7&uid=1&amount=1000

?>