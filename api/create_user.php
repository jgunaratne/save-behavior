<?php

$mtwid = $_GET["mtwid"];
$goal = $_GET["goal"];

function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
  $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
  $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
     $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
  $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

$groupid = 1;
$usercode = uniqid(true);
$ip = get_client_ip();
$year = 1980;
$reward = null;
$totalvalue = 0;

if ($mtwid == null) {
	$mtwid = "NONE";
}

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire") or die(mysql_error());

$query1 = "select groupid from user;";
$result1 = mysql_query($query1) or die('Query failed: ' . mysql_error());
while($row = mysql_fetch_array($result1)) {
	$groupid = $row[0] + 1;
}
if ($groupid > 3) {
	$groupid = 1;
}

$query2 = "INSERT INTO user VALUES ('$mtwid', '$groupid', '$usercode', '$ip', null, $goal, $year, now(), null, $totalvalue);";
$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());

echo $usercode;

?>