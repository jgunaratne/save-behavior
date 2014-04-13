<?php

$m = $_GET["m"];
$y = $_GET["y"];

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

$date_str = "$y-$m";
$djia_price = $djia_hash[$date_str][4];
$fbndx_price = $fbndx_hash[$date_str][6];
echo "<pre>$djia_price, $fbndx_price</pre>";
?>
