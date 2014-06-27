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

	var pstock = $('#inputPStock').val()/100;
	var pbond = $('#inputPBond').val()/100;
	var pcash = $('#inputPCash').val()/100;
	var amount = $('#inputAmount').val()*1;

	var remainingYears = $('#inputYears').val()*1;;
	var actualEst = estimate;
	var totalPercent =  pstock + pbond + pcash;
	totalPercent = Math.round(totalPercent*100)/100;
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

		//$('#inputGoal').val(estLikely);
	}

	
};

App.prototype.addEvents = function() {
	var t = this;
	$('.asset').change(function() {
		t.calcEstOutcome();
	});

	$('#inputAge').change(function() {
		var val = $(this).val() ;
		if (isNaN(+val)) {
			alert('Please enter a number for your age.');
			$(this).val('');
		}

	});

	$('#calcBtn').click(function(e) {
		t.calcEstOutcome();
		e.preventDefault();
		return false;
	});

	$('#inputGoal').blur(function() {
		var nval = $('#inputGoal').val().replace(/\D/g,'');
		$('#inputGoal').val(nval);
	});

	$('#continueBtn').click(function(e) {

		if ($('#inputAge').val() == '' || 
			$('form')[0].gender.value == '' ||
			$('form')[0].experience.value == '' ||
			$('form')[0].hasretire.value == '') {
			$('#questionMsg').show();
			window.scrollTo(0, 0);
		} else {
			var age = $('#inputAge').val().replace(/\D/g,'');
			$('#inputAge').val(age);
			t.createUser();
		}
		return false;
	});

	$('.info').tooltip();

};

App.prototype.calcTurkReward  = function() {

};

App.prototype.createUser = function() {
	$('#continueBtn').attr('disabled', 'disabled');
	$.ajax({
		type: "GET",
		url: "api/create_user.php",
		data: { 
			mtwid: $('#mtwid').val(),
			goal: $('#inputGoal').val(),
			age: $('#inputAge').val(),
			gender: document.querySelector('input[name="gender"]:checked').value,
			experience: document.querySelector('input[name="experience"]:checked').value,
			hasretire: document.querySelector('input[name="hasretire"]:checked').value,
		},
		success: function(data) {
			document.location = 'simulator.php?usercode='+data;
		}
	});
};

App.prototype.init = function() {
	var t = this;
	t.addEvents();
	t.calcEstOutcome();
	$('#questionMsg').hide();
};

var app = new App();
app.init();