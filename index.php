<?php
session_start();
$mturkworkerid = $_GET["mtwid"];
if ($mturkworkerid == null) {
	$mturkworkerid = "AZ3456EXAMPLE";
}
$_SESSION['mturkworkerid']=$mturkworkerid;
//echo $_SESSION['mturkworkerid'];
header( 'Location: endowment.php' );
?>