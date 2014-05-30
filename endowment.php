<?php
session_start();
$mturkworkerid = $_SESSION['mturkworkerid'];
?>
<html !doctype>
<head>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<link rel="stylesheet" type="text/css" href="css/endowment.css">
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/d3/d3.min.js"></script>
</head>
<body>
	<div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          	<button id="clearDBBtn"  type="button">Clear DB</button>
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Retirement study</a>
        </div>
      </div>
    </div>
	<div class="container" id="pageData">
		<div class="row">
			<div class="col-md-6">
				<h2>Your retirement portfolio</h2>
				<h1><span id="month">Jan</span> <span id="year">1980</span></h1>
				
			</div>
			<div class="col-md-6">

			</div>
		</div>
		<div class="row">
			<div class="col-md-6 weights">
				<div id="balanceChart"></div>
				<form id="yearForm">
					<div class="hidden">
				<label>UID</label><input type="text" value="100" name="uid">
				<label>MTurkWorkerID</label><input type="text" value="<?php echo $mturkworkerid; ?>" name="mturkworkerid">
				<label>Month</label><input type="text" value="01" name="month">
				<label>Year</label><input type="text" value="1980" name="year">
				<br>
			</div>
				<label>Percent stock</label><input type="text" value="40" name="pstock" class="asset">%
				<div class="clear"></div>
				<label>Percent bond</label><input type="text" value="40" name="pbond" class="asset">%
				<div class="clear"></div>
				<label>Percent cash</label><input type="text" value="20" name="pcash" class="asset">%
				<div class="clear"></div>
				<label>Yearly amount saved</label><input type="text" value="7500" name="amount" class="asset">
				<input type="submit" id="submitBtn">
				</form>
			</div>
			<div class="col-md-6 goals">
				<div id="histChart"></div>
				<div class="savings amount"><label>Amount saved to date</label><div id="sum" class="save hide">0</div><div id="displaySum" class="save"></div></div>
				<div class="goal amount"><label>Savings goal</label><div id="goal" class="save">$1,100,000</div></div>
				<div class="goal amount"><label>Estimated outcome</label><div id="estimate" class="save">0</div></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><hr></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="desc">
				<p>Potential value of your $500 investment today with 10% volatility and 8% returns.</p>
				<p>Decreasing volatility will help prevent losses. Adding stocks to your portfolio increases returns.</p>
			</div>
			</div>
			<div class="col-md-6">
				<div>
					
				<div class="outcome primary">
					<div class="future-val" id="savedToday">$500</div>
					<div class="desc">Saved today</div>
				</div>
				<div class="clear"></div>
				<div class="outcome">
					<div class="outcome-line left"></div>
					<div class="future-val red" id="worstCase">$120</div>
					<div class="desc">Worst case</div>
				</div>
				<div class="outcome">
					<div class="outcome-line center"></div>
					<div class="future-val" id="likelyCase">$540</div>
					<div class="desc">Likely case</div>
				</div>
				<div class="outcome">
					<div class="outcome-line right"></div>
					<div class="future-val green" id="bestCase">$640</div>
					<div class="desc">Best case</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" id="pageMsg">
<p>Please return tomorrow to complete the next part of this study.</p>
</div>
	<script src="js/endowment.js"></script>
</body>
</html>