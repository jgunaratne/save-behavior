var stockRet = .078;
var bondRet = .065;
var cashRet = 0;

var stockVol = 0.15;
var bondVol = 0.04;
var cashVol = 0;

var portRet = 0;
var portVol = 0;

var App = function() {

};

App.prototype.calcFV = function(save, percentRet, years) {
	var val = save;
	for (var i = 0; i < years; i++) {
		val += val * percentRet;
	}
	return Math.round(val);
};

App.prototype.calcReturns = function(yearlySavings, percentRet, years) {
	var val = 0;
	for (var i = 0; i < years; i++) {
		val += yearlySavings;
		val = val * (1 + percentRet);
	}
	return Math.round(val);
};

App.prototype.numberWithCommas = function(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
};

App.prototype.calcEstOutcome = function() {
	var t = this;
	var year = eval($('input[name=year]').val());
	var pstock = $('input[name=pstock]').val()/100;
	var pbond = $('input[name=pbond]').val()/100;
	var pcash = $('input[name=pcash]').val()/100;
	var amount = $('input[name=amount]').val()*1;

	var remainingYears = $('input[name=years]').val()*1;;
	var actualEst = estimate;
	var totalPercent =  pstock + pbond + pcash;
	portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;
	portVol = (stockVol*pstock + bondVol*pbond + cashVol*pcash);
	portVol = portVol/(1/portVol);

	if (totalPercent != 1) {
		$('#calcMsg').show();
		$('#estimate, #estimateLow, #estimateHigh').text('');
	} else {
		$('#calcMsg').hide();
		

		var estLow = Math.round(t.calcReturns(amount,portRet-portVol, remainingYears));
		var estLikely = t.calcReturns(amount,portRet,remainingYears);
		var estHigh = Math.round(t.calcReturns(amount,portRet+portRet, remainingYears));

		$('#estimateLow').text('$'+t.numberWithCommas(estLow));
		$('#estimate').text('$'+t.numberWithCommas(estLikely));
		$('#estimateHigh').text('$'+t.numberWithCommas(estHigh));

		$('input[name=goal').val(estLikely);
	}

	
};

App.prototype.addEvents = function() {
	var t = this;
	$('.asset').change(function() {
		t.calcEstOutcome();
	});

	$('#calcBtn').click(function(e) {
		t.calcEstOutcome();
		e.preventDefault();
		return false;
	});

	$('#showTurkCopyBtn').click(function() {
		$('.study-copy').hide();
		$('.mturk-copy').show();
	});
};

App.prototype.calcTurkReward  = function() {

};

App.prototype.init = function() {
	var t = this;
	t.addEvents();
	t.calcEstOutcome();
	$('.mturk-copy').hide();
};

var app = new App();
app.init();