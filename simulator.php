<?php
session_start();
$usercode = $_GET['usercode'];
?>
<html !doctype>
   <head>
      <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/fonts.css">
      <link rel="stylesheet" type="text/css" href="css/simulator.css">
      <script src="bower_components/jquery/dist/jquery.min.js"></script>
      <script src="bower_components/d3/d3.min.js"></script>
      <title>Retirement investment simulator</title>
   </head>
   <body>
      <?php if ($usercode != null) { ?>
      <div class="container" id="pageMsg">
         <h1>Please return tomorrow to complete the next part of this study.</h1>
      </div>
      <div class="container" id="completeMsg">
         <h1>Thank you for completing this study.</h1>
         <p>Your final amount is: $<span id="finalAmount"></span>. Your goal was: $<span id="goalAmount"></span>.</p>
         <p>Your Mechanical Turk reward is: $<span id="reward"></span></p>
         <h2>Your user code is: <?php echo $usercode; ?></h2>
      </div>
      <form id="yearForm">
         <input type="hidden" name="goal" value="<?php echo $goal;?>" id="inputGoal">
         <input type="hidden" name="usercode" value="<?php echo $usercode; ?>" id="inputUsercode">
         <input type="hidden" value="01" name="month">
         <input type="hidden" value="1980" name="year" id="inputYear">
         <div class="container">
            <div class="row page-data">
               <div class="col-md-12">
                  <h1>Retirement portfolio</h1>
                  <h2>This year: <span id="year">2014</span>; Retiring in 2048</h2>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 weights">
                  <div id="balanceChart"></div>
                  <div class="page-data">
                  <p>Adjust your stock, bond and cash percentages to change risk and reward.</p>
                  <label>Percent stock <div class="info" title="Stocks tend to provide the highest returns on your investment, but they can fluctuate dramatically. There is potential to lose money when investing in stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div></label><input type="text" value="0" name="pstock" class="asset" id="inputPStock">%
                  <div class="clear"></div>
                  <label>Percent bond <div class="info" title="Bonds provide lower returns than stocks, but fluctuate less. There is less potential to lose money with stocks." rel="tooltip" data-toggle="tooltip" data-placement="right"></div></label><input type="text" value="0" name="pbond" class="asset" id="inputPBond">%
                  <div class="clear"></div>
                  <label>Percent cash <div class="info" title="Cash provides no returns, but does not fluctuate and you cannot lose money." rel="tooltip" data-toggle="tooltip" data-placement="right"></div></label><input type="text" value="0" name="pcash" class="asset" id="inputPCash">%
                  <div class="clear"></div>
                  <label>Yearly amount saved</label><input type="text" value="10000" name="amount2" class="asset" disabled>
                  <input type="hidden" value="10000" name="amount" class="asset" id="inputAmount">
                  <div class="marg">
                     <div id="calcMsg" class="red">Percentages must add up to 100%.</div>
                 </div>
                  </div>
               </div>
               <div class="col-md-6 goals">
                  <div id="histChart"></div>
                  <div class="page-data">
                  <h2>Your progress in savings<br> towards retirement in 2048</h2>
                  <div class="savings amount">
                     <label>Amount saved to date</label>
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
            </div>
            <div class="page-data">
            <div class="row loss-aversion">
               <div class="col-md-12">
                  <hr>
               </div>
            </div>
            <div class="row loss-aversion">
               <div class="col-md-2">
               </div>
               <div class="col-md-8">
                  <div>
                     <div class="outcome primary">
                        <div class="future-val" id="savedToday">$500</div>
                        <div class="desc">Saved today</div>
                     </div>
                     <div class="clear"></div>
                     <div class="outcome">
                        <div class="future-val red" id="worstCase">$120</div>
                        <div class="desc">Worst case</div>
                     </div>
                     <div class="outcome">
                        <div class="future-val" id="likelyCase">$540</div>
                        <div class="desc">Likely case</div>
                     </div>
                     <div class="outcome">
                        <div class="future-val green" id="bestCase">$640</div>
                        <div class="desc">Best case</div>
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
                     Original goal
                     <div class="endowment-value" id="originalValue">$0</div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="num-group">
                     Gain or loss (based on your asset allocations)
                     <div class="endowment-value" id="gainLossValue">$0</div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="num-group">
                     Final estimated amount
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
                  <p>Continue when you have completed setting your asset allocations.
                     <input type="submit" id="submitBtn" value="Continue"  class="btn btn-lg btn-primary right">
                  </div>
               </div>
            </div>
         </div>
         </div>
      </form>
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