<?php
  session_start();
  $mturkworkerid = $_GET["mtwid"];
  if ($mturkworkerid == null) {
      $mturkworkerid = "AZ3456EXAMPLE";
  }
  $_SESSION['mturkworkerid']=$mturkworkerid;

  $conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
  mysql_select_db("retire") or die(mysql_error());

  $query = "SELECT max(uid) FROM activity";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());

  $uid = 0;
  while($row = mysql_fetch_array($result)) {
    $uid = $row[0];
  }

  $uid = $uid + 1;
  ?>
<html>
  <head>
    <title>Retirement study</title>
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/simulator.css">
    <style>
      table {
      border-collapse: collapse;
      margin-bottom: 20px;
      }
      table td {
      border: 1px solid #ccc;
      padding: 5px 10px;
      font-size: 14px;
      }
    </style>
  </head>
  <body>
    <form action="simulator.php">
      <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="study-copy">
            <h1>Retirement investment study</h1>
            <p>Thank you for participating in this retirement saving study conducted by researchers at New York University. This study simulates retirement investing over a 34 year period. This study will take about 20-30 minutes of your time. You will be shown 34 screens where you will be presented with investment choices.</p>
            <p>For each year simulated in the study you have $7500 to invest. You have three choices of investments (also known as asset types): stocks, bonds and cash. You can choose to allocate your investments in any way you see fit.</p>
            <p>Making investment decisions requires understanding tradeoffs. Assets such as stocks have higher returns and earn more money in the long run, however, stocks also have high volatility, meaning they fluctuate more and you can lose money. Stocks are generally a good long term investment. Bonds have lower returns than stocks, but they also don't fluctuate as much. Finally, cash does does not generate returns, but it is impossible to lose money. Cash is a poor long term investment.</p>
            <p>Good retirement portfolios have a mix of stocks, bonds and cash. However, the percentage a person sets aside for eacy type of asset is a personal choice and depends on their adversity to risk.</p>
            <h2>Investment characteristics</h2>
            <table>
              <tr>
                <td>Asset type</td>
                <td>Return each year</td>
                <td>Volatility (fluctuation potential)</td>
              </tr>
              <tr>
                <td>Stocks</td>
                <td>7.8%</td>
                <td>15%</td>
              </tr>
              <tr>
                <td>Bonds</td>
                <td>6.5%</td>
                <td>4%</td>
              </tr>
              <tr>
                <td>Cash</td>
                <td>0%</td>
                <td>0%</td>
              </tr>
            </table>
            <hr>
            <h2>Estimating investment performance</h2>
            <p>Use the calculator below to calculate an estimate of your investment performance.</p>
            <div class="weights">
              <p>Adjust your stock, bond and cash percentages to change risk and reward.</p>
              <label>Percent stock</label><input type="text" value="40" name="pstock" class="asset">%
              <div class="clear"></div>
              <label>Percent bond</label><input type="text" value="40" name="pbond" class="asset">%
              <div class="clear"></div>
              <label>Percent cash</label><input type="text" value="20" name="pcash" class="asset">%
              <div class="clear"></div>
              <label>Years</label><input type="text" value="34" name="years" class="asset">
              <div class="clear"></div>
              <label>Yearly amount saved ($)</label><input type="text" value="7500" name="amount" class="asset">
              <div class="clear"></div>
              <div class="marg">
                <div id="calcMsg" class="red">Percentages must add up to 100%.</div>
              </div>
              <div class="clear"></div>
              <div class="goal amount">
                <label>Likely case estimate</label>
                <div id="estimate" class="save">$0</div>
              </div>
              <div class="goal amount">
                <label>Worst case estimate</label>
                <div id="estimateLow" class="save red">$0</div>
              </div>
              <div class="goal amount">
                <label>Best case estimate</label>
                <div id="estimateHigh" class="save green">$0</div>
              </div>
              <div class="clear"></div>

<hr>
<h1>Your retirement goal</h1>
          <p>Enter your retirement savings goal for this retirement simulation. Please think about this amount carefully as this dollar amount will be used as your target goal during the simulation:</p>
          $<input type="text" value="0" name="goal" class="final-goal">

              <div class="marg">
                <a class="btn btn-lg btn-primary" href="#" role="button" id="showTurkCopyBtn">Continue</a>
              </div>
            </div>
          </div>

          <div class="mturk-copy">
            <h1>Earning your Mechnical Turk reward</h1>
            <p>At the end of the 30 year simulation you will be shown the final amount of your investment.</p>
            <p>Stock and bond performance in this retirement simulation is randomly generated, but has the same return and volatility attributes you saw in the investment characteristics table.</p>
            <p>The closer your estimate is to the final amount the greater your Mechanical Turk reward. These are the rewards you may receive from Mechanical Turk for completing this study:</p>
            <h2>Mechanical Turk reward amounts</h2>
            <table>
              <tr>
                <td>Estimate within 5% of final amount</td>
                <td>$1.00</td>
              </tr>
              <tr>
                <td>Estimate within 15% of final amount</td>
                <td>$0.50</td>
              </tr>
              <tr>
                <td>Estimate within 25% of final amount</td>
                <td>$0.25</td>
              </tr>
              <tr>
                <td>Estimate within 50% of final amount</td>
                <td>$0.10</td>
              </tr>
              <tr>
                <td>Estimate within 75% of final amount</td>
                <td>$0.05</td>
              </tr>
              <tr>
                <td>Estimate very far off</td>
                <td>no reward</td>
              </tr>
            </table>
            <input type="submit" class="btn btn-lg btn-primary" role="button" value="Continue">
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
      <input type="hidden" name="uid" value="<?php echo $uid; ?>">
      <input type="hidden" name="mturkworkerid" value="<?php echo $mturkworkerid; ?>">
    </form>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/intro.js"></script>
  </body>