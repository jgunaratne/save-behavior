<?php
  session_start();
  $usercode = $_GET['usercode'];
  ?>
<html !doctype>
  <head>
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/simulator.css">
    <title>Retirement investment simulator</title>
  </head>
  <body>
    <?php if ($usercode != null) { ?>
    <div class="container" id="completeMsg">
      <h1>Thank you for completing this study.</h1>
      <p>Your final amount is: $<span id="finalAmount"></span>. Your goal was: $<span id="goalAmount"></span>.</p>
      <p>Your Mechanical Turk bonus is: $<span id="reward"></span></p>
      <h2>Your user code is: <?php echo $usercode; ?></h2>
    </div>
    <div class="container" id="returnMsg">
      <h1>Please return tomorrow</h1>
      <p>This is a 5 days study. Please return tomorrow to continue this study.</p>
      <h2>Your user code is: <?php echo $usercode; ?></h2>
    </div>
    <form id="yearForm">
      <input type="hidden" name="goal" value="<?php echo $goal;?>" id="inputGoal">
      <input type="hidden" name="usercode" value="<?php echo $usercode; ?>" id="inputUsercode">
      <input type="hidden" value="01" name="month">
      <input type="hidden" value="1980" name="year" id="inputYear">
      <div class="container">
        <div class="row page-data">
          <div class="col-md-6">
            <h1>Retirement portfolio</h1>
          </div>
          <div class="col-md-6">
            <h2>This year: <span id="year">2014</span>; Retiring in 2048</h2>
          </div>
        </div>
        <div class="row page-data">
          <div class="col-md-6 weights">
            <div id="balanceChart"></div>
            <p>The pie chart above shows your overall portfolio allocations for your entire retirement savings since you began saving in 2014.</p>
            <hr>
            <h2>This year's retirement saving allocations</h2>
            <p>Use the input fields below to adjust this year's retirement saving. Adjusting percentages changes your stock, bond and cash weights, affecting your risk and reward.</p>
            <label>
              Percent stock 
              <div class="info" title="Stocks tend to provide the highest returns on your investment, but they can fluctuate dramatically. There is potential to lose money when investing in stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
            </label>
            <input type="text" value="0" name="pstock" class="asset" id="inputPStock">% <span class="previous-percent" id="prevPStock">(Previous year: <span class="prev-amount">0</span>%)</span>
            <div class="clear"></div>
            <label>
              Percent bond 
              <div class="info" title="Bonds provide lower returns than stocks, but fluctuate less. There is less potential to lose money with stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
            </label>
            <input type="text" value="0" name="pbond" class="asset" id="inputPBond">% <span class="previous-percent" id="prevPBond">(Previous year: <span class="prev-amount">0</span>%)</span>
            <div class="clear"></div>
            <label>
              Percent cash 
              <div class="info" title="Cash provides no returns, but does not fluctuate and you cannot lose money." rel="tooltip" data-toggle="tooltip" data-placement="right"></div>
            </label>
            <input type="text" value="0" name="pcash" class="asset" id="inputPCash">% <span class="previous-percent" id="prevPCash">(Previous year: <span class="prev-amount">0</span>%)</span>
            <div class="clear"></div>
            <label>Yearly amount saved</label><input type="text" value="10000" name="amount2" class="asset" disabled>
            <input type="hidden" value="10000" name="amount" class="asset" id="inputAmount">
            <div class="marg">
              <div id="calcMsg" class="red">Percentages must add up to 100%.</div>
            </div>
          </div>
          <div class="col-md-6 goals">
            <div id="histChart"></div>
            <p>The chart above shows the overall total value of your retirement portfolio over time.</p>
            <h2>Your progress in savings<br> towards retirement in 2048</h2>
            <div class="savings amount no-width">
              <label class="no-width">Amount saved to date (Your actual present savings)</label>
              <div id="sum" class="save hide">0</div>
              <div id="displaySum" class="save"></div>
            </div>
            <div class="goal amount hide">
              <label>Savings goal</label>
              <div id="goal" class="save">$0</div>
            </div>
            <div class="goal amount hide">
              <label>Estimated outcome</label>
              <div id="estimate" class="save">0</div>
            </div>
          </div>
        </div>
        <div class="page-data">
          <div class="row loss-aversion">
            <div class="col-md-6">
              <p>Below are likely outcomes for what a $10,000 investment today will be worth in the future. The likely case is the most probable</p>
              <div>
                <div class="outcome primary">
                  <div class="future-val" id="savedToday">$0</div>
                  <div class="desc">
                    Saved today 
                    <div class="info" title="If you saved this amount today, the resulting outcomes are shown below." rel="tooltip" data-toggle="tooltip" data-placement="bottom"></div>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="outcome">
                  <div class="future-val red" id="worstCase">$0</div>
                  <div class="desc">
                    Worst case 
                    <div class="info" title="Your investment could decrease to this amount in a worst case situation." rel="tooltip" data-toggle="tooltip" data-placement="bottom"></div>
                  </div>
                </div>
                <div class="outcome">
                  <div class="future-val" id="likelyCase">$0</div>
                  <div class="desc">
                    Likely case 
                    <div class="info" title="Your investment today is likely to be valued at this amount when you retire." rel="tooltip" data-toggle="tooltip" data-placement="bottom"></div>
                  </div>
                </div>
                <div class="outcome">
                  <div class="future-val green" id="bestCase">$0</div>
                  <div class="desc">
                    Best case 
                    <div class="info" title="If the stock market only goes up, this is the best possible value of your investment in the future." rel="tooltip" data-toggle="tooltip" data-placement="bottom"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row endowment-effect">
            <div class="col-md-12">
              <hr>
            </div>
          </div>
          <div class="row endowment-effect">
            <div class="col-md-4">
              <div class="num-group">
                Goal 
                <div class="info" title="This goal is the amount your investments should be worth by the time you retire." rel="tooltip" data-toggle="tooltip" data-placement="top"></div>
                <div class="endowment-value" id="originalValue">$0</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="num-group">
                Difference from your goal
                <div class="info" title="This the estimated gain or loss based on your asset allocations. In other words, this is the amount estimated of how far you are away from your goal. You can change your stock, bond and cash allocations to attempt to move closer to your goal." rel="tooltip" data-toggle="tooltip" data-placement="top"></div>
                <div class="endowment-value" id="gainLossValue">$0</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="num-group">
                Estimated final savings 
                <div class="info" title="This the estimated final amount based on your asset allocations." rel="tooltip" data-toggle="tooltip" data-placement="top"></div>
                <div class="endowment-value" id="currentValue">$0</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="marg">
                <input type="submit" id="submitBtn" value="Continue"  class="btn btn-lg btn-primary right"> <p class="right">When you're finished changing your savings allocation, press Continue to move to the next year.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/d3/d3.min.js"></script>
    <script src="js/simulator.js"></script>
    <?php } else { ?>
    <div class="container">
      <form>
        <h2>Please enter your user code:</h2>
        <input type="text" name="usercode" width="32" class="std-fld">
        <input type="submit">
      </form>
    </div>
    <?php } ?>
  </body>
</html>