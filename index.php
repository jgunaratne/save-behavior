<?php
  error_reporting(0);
  
  $mtwid = $_GET["mtwid"];
  $_SESSION['mtwid']=$mtwid;
  
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
    <form action="simulator.php" id="form">
      <input type="hidden" name="mtwid" value="<?php echo $mtwid ?>" id="mtwid">
      <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="study-copy">
            <h1>Retirement investment study</h1>
            <p>Thank you for participating in this retirement saving study conducted by researchers at New York University. This study simulates retirement investing over a 34 year period. This study will take about 20-30 minutes of your time. You will be shown 34 screens where you will be presented with investment choices.</p>
            
            <h2>Pre-study questions</h2>
            <p>How old are you? <input type="text" name="age" id="inputAge"><br><br></p>
            <p>Gender:
              <br><input type="radio" name="gender" value="male"><label>Male</label>
              <br><input type="radio" name="gender" value="female"><label>Female</label><br><br>
            </p>
            <p>What is your level of investing experience?
              
              <br><input type="radio" name="experience" value="1"><label>None/No experience</label>
              <br><input type="radio" name="experience" value="2"><label>Novice</label>
              <br><input type="radio" name="experience" value="3"><label>Intermediate</label>
              <br><input type="radio" name="experience" value="4"><label>Expert</label>
              <br><input type="radio" name="experience" value="0"><label>Not sure</label><br><br>
            </p>
            <p>Do you have a retirement savings plan such as a 401k?
              <br><input type="radio" name="hasretire" value="1"><label>Yes</label>
              <br><input type="radio" name="hasretire" value="0"><label>No</label><br><br>
            </p>

            <div class="marg">
                <div id="questionMsg" class="red">Please complete all questions to continue.</div>
              </div>

            <hr>
            <h2>Study description</h2>
            <p>For each year simulated in the study you have $10,000 to invest. You have three choices of investments (also known as asset types): stocks, bonds and cash. You can choose to allocate your investments in any way you see fit.</p>
            <p>Making investment decisions requires understanding tradeoffs. Assets such as stocks have higher returns and earn more money in the long run, however, stocks also have high volatility, meaning they fluctuate more and you can lose money. Stocks are generally a good long term investment. Bonds have lower returns than stocks, but they also don't fluctuate as much. Finally, cash does does not generate returns, but it is impossible to lose money. Cash is a poor long term investment.</p>
            <p>Good retirement portfolios have a mix of stocks, bonds and cash. However, the percentage a person sets aside for each type of asset is a personal choice and depends on his or her adversity to risk.</p>

            <p>You can learn more about stocks, bonds and cash on <a href="http://www.schwabmoneywise.com/public/moneywise/money_basics/investing/stocks_bonds_cash.html" target="_blank">Charles Schwab's MoneyWise page</a>.
            <h2>Investment characteristics</h2>
            <p>For the purpose of this study stocks, bonds and cash have the following characteristics:</p>
            <table>
              <tr>
                <td>Asset type</td>
                <td>Average return each year</td>
                <td>Fluctuation potential (<a href="http://www.investopedia.com/terms/v/volatility.asp" target="_blank">Volatility</a>) <div class="info" title=" Volatility refers to the amount of uncertainty or risk about the size of changes in a security's value. A higher volatility means that a security's value can potentially be spread out over a larger range of values. This means that the price of the security can change dramatically over a short time period in either direction. A lower volatility means that a security's value does not fluctuate dramatically, but changes in value at a steady pace over a period of time."  rel="tooltip" data-toggle="tooltip" data-placement="bottom"></div></td>
              </tr>
              <tr>
                <td>
                  Stocks 
                  <div class="info" title="Stocks tend to provide the highest returns on your investment, but they can fluctuate dramatically. There is potential to lose money when investing in stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
                </td>
                <td>7.8%</td>
                <td>15%</td>
              </tr>
              <tr>
                <td>
                  Bonds 
                  <div class="info" title="Bonds provide lower returns than stocks, but fluctuate less. There is less potential to lose money with stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
                </td>
                <td>6.5%</td>
                <td>4%</td>
              </tr>
              <tr>
                <td>
                  Cash 
                  <div class="info" title="Cash provides no returns, but does not fluctuate and you cannot lose money." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
                </td>
                <td>0%</td>
                <td>0%</td>
              </tr>
            </table>
            <hr>
            <h2>Estimating investment performance</h2>
            <p>Change percents using the calculator below to calculate an estimate of your investment performance. By adjusting the percentage weights of stocks, bonds and cash, you can get an idea of how much money your investments will generate over time.</p>
            <div class="weights">
              <p>Adjust stock, bond and cash percentages to change risk and reward to see how different percentage allocations affect overall performance.</p>
              <label>Percent stock</label><input type="text" value="0" name="pstock" class="asset" id="inputPStock">%
              <div class="clear"></div>
              <label>Percent bond</label><input type="text" value="0" name="pbond" class="asset" id="inputPBond">%
              <div class="clear"></div>
              <label>Percent cash</label><input type="text" value="0" name="pcash" class="asset" id="inputPCash">%
              <div class="clear"></div>
              <label>Years until retirement</label><input type="text" value="34" name="years" class="asset" id="inputYears">
              <div class="clear"></div>
              <label>Yearly amount saved ($)</label><input type="text" value="10000" name="amount" class="asset" id="inputAmount">
              <div class="clear"></div>
              <div class="marg">
                <div id="calcMsg" class="red">Percentages must add up to 100%.</div>
              </div>
              <div class="clear"></div>
              <div class="goal amount">
                <label>Worst case estimate</label>
                <div id="estimateLow" class="save red">$0</div>
              </div>
              <div class="goal amount">
                <label>Likely case estimate</label>
                <div id="estimate" class="save">$0</div>
              </div>
              <div class="goal amount">
                <label>Best case estimate</label>
                <div id="estimateHigh" class="save green">$0</div>
              </div>
              <div class="clear"></div>
              <hr>
              <h1>Earning your Mechnical Turk reward</h1>
              <p>At the end of the 34 year simulation you will be shown the final amount of your investment.</p>
              <p>Stock and bond performance in this retirement simulation is randomly generated, but has the same return and volatility attributes you saw in the investment characteristics table above.</p>
              <h2>Mechanical Turk sample bonus amounts</h2>
              <p>For the purpose of this study we have given you a goal of saving $1,500,000 in 34 years. Stick to this goal. Your bonus is based on how close your final amount is to your goal. <strong>You are not rewarded for outperforming your goal.</strong> The closer your estimate is to the final amount the greater your Mechanical Turk bonus. Bonus amounts decrease substantially the further you deviate from your goal. Being above your goal is as bad as being below your goal. Aim for your goal, no more, no less.</p> <p>Below are some sample bonus amounts you may receive from Mechanical Turk for completing this study. These bonus amounts are in addition to the $1 you will receive for completing the study.</p>
              <table>
                <tr>
                  <td>Total savings</td>
                  <td>Goal</td>
                  <td>Bonus</td>
                </tr>
                <tr>
                  <td>$1,000,000</td>
                  <td>$1,500,000</td>
                  <td>$0.00</td>
                </tr>
                <tr>
                  <td>$1,250,000</td>
                  <td>$1,500,000</td>
                  <td>$1.33</td>
                </tr>
                <tr>
                  <td>$1,400,000</td>
                  <td>$1,500,000</td>
                  <td>$2.93</td>
                </tr>
                <tr>
                  <td><strong>$1,500,000</strong></td>
                  <td><strong>$1,500,000</strong></td>
                  <td><strong>$4.00</strong></td>
                </tr>
                <tr>
                  <td>$1,600,000</td>
                  <td>$1,500,000</td>
                  <td>$2.93</td>
                </tr>
                <tr>
                  <td>$1,750,000</td>
                  <td>$1,500,000</td>
                  <td>$1.33</td>
                </tr>
                <tr>
                  <td>$2,000,000</td>
                  <td>$1,500,000</td>
                  <td>$0.00</td>
                </tr>
              </table>
              <hr>
              <h1>Your retirement goal</h1>
              <p>Your goal is to save $1,500,000 for your retirement by allocating appropriate amounts to stock, bonds and cash. This number is based on retirement calculation data from Kiplinger.com for someone who saves $10,000 per year over a 34 year period.</p>
              <h2>Retirement savings goal: $1,500,000</h2><input type="hidden" value="1500000" name="goal" class="final-goal" id="inputGoal">
              <p>You should aim to have around $1,500,000 at the end of this study to earn the maximum Mechanical Turk bonus of $4.00. Your Mechanical Turk reward will be less than $4.00 if your final amount is more than $1,500,000 or less than $1,500,000.</p>
              <p><strong>WARNING: Do not press the back button in your web browser or attempt to restart the study after pressing the Continue button below. Pressing the back button or restarting the study will invalidate all of your answers and you will not be eligible for your Amazon Mechanical Turk reward. Be sure you read the instructions above before beginning the study.</strong></p>
            </div>
            <div class="marg">
              <input type="submit" class="btn btn-lg btn-primary" role="button" value="Continue" id="continueBtn">
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </form>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/intro.js"></script>
  </body>