<?php
   session_start();
   $usercode = $_SESSION['usercode'];
   $goal = $_POST['goal'];
   if ($goal != null) {
      $conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
      mysql_select_db("retire") or die(mysql_error());
      $query = "UPDATE user SET goal = $goal WHERE usercode = '$usercode';";
      $result = mysql_query($query) or die('Query failed: ' . mysql_error());
   }
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
      <form id="yearForm">
         <input type="hidden" name="goal" value="<?php echo $goal;?>" id="inputGoal">
         <input type="hidden" name="usercode" value="<?php echo $usercode; ?>" id="inputUsercode">
         <div class="container" id="pageData">
            <div class="row">
               <div class="col-md-12">
                  <h1>Retirement portfolio: <span id="year">2020</span></h1>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 weights">
                  <div id="balanceChart"></div>
                  <div class="hidden">
                     <label>Month</label><input type="text" value="01" name="month">
                     <label>Year</label><input type="text" value="1980" name="year" id="inputYear">
                     <br>
                  </div>
                  <p>Adjust your stock, bond and cash percentages to change risk and reward.</p>
                  <label>Percent stock</label><input type="text" value="40" name="pstock" class="asset" id="inputPStock">%
                  <div class="clear"></div>
                  <label>Percent bond</label><input type="text" value="40" name="pbond" class="asset" id="inputPBond">%
                  <div class="clear"></div>
                  <label>Percent cash</label><input type="text" value="20" name="pcash" class="asset" id="inputPCash">%
                  <div class="clear"></div>
                  <label>Yearly amount saved</label><input type="text" value="7500" name="amount2" class="asset" disabled>
                  <input type="hidden" value="7500" name="amount" class="asset" id="inputAmount">
                  <div class="marg">
                     <div id="calcMsg" class="red">Percentages must add up to 100%.</div>
                 </div>
               </div>
               <div class="col-md-6 goals">
                  <div id="histChart"></div>
                  <h2>Your progress in savings<br> towards retirement in 2054</h2>
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
                     Original amount
                     <div class="endowment-value" id="originalValue">$1,100,000</div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="num-group">
                     Gain or loss (based on your asset allocations)
                     <div class="endowment-value" id="gainLossValue">$1,100,000</div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="num-group">
                     Final amount
                     <div class="endowment-value" id="currentValue">$1,100,000</div>
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
      </form>
      <div class="container" id="pageMsg">
         <h1>Please return tomorrow to complete the next part of this study.</h1>
      </div>
      <div class="container" id="completeMsg">
         <h1>Thank you for completing this study.</h1>
         <h2>Your code is: <?php echo $usercode; ?></h2>
      </div>
      <script src="js/simulator.js"></script>
      <?php } ?>
   </body>
</html>