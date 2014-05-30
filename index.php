<?php
session_start();
$mturkworkerid = $_GET["mtwid"];
$_SESSION['mturkworkerid']=$mturkworkerid;
//echo $_SESSION['mturkworkerid'];
header( 'Location: endowment.php' );
?>