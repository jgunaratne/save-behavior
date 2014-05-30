<?php
session_start();
$mturkworkerid = $_GET["mtwid"];
if ($mturkworkerid == null) {
	$mturkworkerid = "AZ3456EXAMPLE";
}
$_SESSION['mturkworkerid']=$mturkworkerid;
//echo $_SESSION['mturkworkerid'];
//header( 'Location: endowment.php' );
?>
<html>
<head>
	<title>Retirement study</title>
	<style>
		@import url(bower_components/bootstrap/dist/css/bootstrap.min.css);
		table {
			border-collapse: collapse;
			margin-bottom: 20px;
		}
		table td {
			border: 1px solid #ccc;
			padding: 5px 10px;
		}
	</style>
</head>
<body>


 <!-- Fixed navbar -->
    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Retirement study</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Exit</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      

    	<h1>Retirement investment study</h1>
	<p>Thank you for participating in this retirement saving study conducted by researchers at New York University. This study simulates retirement investing over a 30 year period.</p>

	<p>For each year simulated in the study you are given a fictitous $5000 to invest. You have three choices of investments (also known as asset types): stocks, bonds and cash. You can choose to allocate your investments in any way you see fit.</p>

	<p>Here are the characteristics of the investments:</p>

	<table>
		<tr>
			<td>Asset type</td><td>Return</td><td>Volatility</td>
		</tr>
		<tr>
			<td>Stocks</td><td>8%</td><td>15%</td>
		</tr>
		<tr>
			<td>Bonds</td><td>5%</td><td>5%</td>
		</tr>
		<tr>
			<td>Cash</td><td>0%</td><td>0%</td>
		</tr>
	</table>

	<table>
		<tr>
			<td>Asset type</td><td>Worse case</td><td>Likely case</td><td>Best case</td>
		</tr>
		<tr>
			<td>Stocks</td><td></td><td></td><td></td>
		</tr>
		<tr>
			<td>Bonds</td><td></td><td></td><td></td>
		</tr>
		<tr> 
			<td>Cash</td><td></td><td></td><td></td>
		</tr>
	</table>

	<p>Please estimate the amount of money you will have at the end of the simulation:</p>
	<input type="text">

	<p>At the end of the 30 year simulation you will be shown the actual final amount of your investment.</p>

	<p>The closer your estimate is to the actual final amount the greater your Mechanical Turk reward. These are the rewards you may receive from Mechanical Turk for completing this study:</p>

<table>
	<tr><td>Estimate within 5% of final amount</td><td>$1.00</td></tr>
	<tr><td>Estimate within 15% of final amount</td><td>$0.50</td></tr>
	<tr><td>Estimate within 25% of final amount</td><td>$0.25</td></tr>
	<tr><td>Estimate within 50% of final amount</td><td>$0.10</td></tr>
	<tr><td>Estimate within 75% of final amount</td><td>$0.05</td></tr>
	<tr><td>Estimate very far off</td><td>no reward</td></tr>
</table>

<a class="btn btn-lg btn-primary" href="simulator.php" role="button">Continue</a>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>