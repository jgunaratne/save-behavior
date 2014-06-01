var stockRet = .078;
var bondRet = .065;
var cashRet = 0;

var stockVol = 0.15;
var bondVol = 0.04;
var cashVol = 0;

var portRet = 0;
var portVol = 0;

var currYear = 1980;
var currMonth = 1;

var goal = $('input[name=goal').val()*1;
var futureYearNum = 39;

var App = function() {

};

App.prototype.getSum = function() {
	var t = this;
	$.ajax({
		type: "GET",
		url: "api/sum.php",
		data: { 
			uid: $('input[name=uid]').val(),
			mturkworkerid: $('input[name=mturkworkerid]').val()
		},
		success: function(data) {
			var sum = Math.round(data*1);
			$('#sum').text(sum);
			$('#displaySum').text('$'+t.numberWithCommas(sum));

			

			var year = eval($('input[name=year]').val());
			var futureYear = year + 0;
			$('#year').text(futureYear);

			year++;
			$('input[name=year]').val(year);

			//$('input[name=year]').val(currYear);
			var simYear = year + futureYearNum;
	  		$('#year').text(simYear);
			
			t.renderHistChart();
			t.renderBalanceChart();
			t.updateEstimate();

			$('#submitBtn').attr('disabled', null);

		}
	});
};


App.prototype.renderHistChart = function(callback) {
	$("#histChart").html('');
	var margin = {top: 50, right: 50, bottom: 50, left: 50},
    width = 480 - margin.left - margin.right,
    height = 320 - margin.top - margin.bottom;

	var parseDate = d3.time.format("%Y-%m-%d").parse;

	var x = d3.time.scale()
	    .range([0, width]);

	var y = d3.scale.linear()
	    .range([height, 0]);

	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom");

	var yAxis = d3.svg.axis()
	    .scale(y)
	    .orient("left");

	var line = d3.svg.line()
	    .x(function(d) { 
	    	return x(d.date); 
	    })
	    .y(function(d) { return y(d.close); });

	var svg = d3.select("#histChart").append("svg")
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	var mturkworkerid = $('input[name=mturkworkerid]').val();
	d3.csv("api/history.php?mturkworkerid=" + mturkworkerid, function(error, data) {

	  if (data.length > 0) {

	  data.forEach(function(d) {
	    d.date = parseDate(d.date);
	    d.close = +d.close;

	    var dYear = d.date.getFullYear();
	    if (dYear > currYear) {
	    	currYear = dYear;
		}
	  });

	  if (callback) {
		callback();
	  }

	  x.domain(d3.extent(data, function(d) { 
	  	var nDate = d.date;
	  	var nYear = nDate.getFullYear() + futureYearNum;
	  	nDate.setYear(nYear);
	  	return nDate; 
	  }));
	  y.domain(d3.extent(data, function(d) { return d.close; }));

	  svg.append("g")
	      .attr("class", "x axis")
	      .attr("transform", "translate(0," + height + ")")
	      .call(xAxis);

	  svg.append("g")
	      .attr("class", "y axis")
	      .call(yAxis)
	    .append("text")
	      .attr("transform", "rotate(-90)")
	      .attr("y", 6)
	      .attr("dy", ".71em")
	      .style("text-anchor", "end")
	      .text("Amount ($)");

	  svg.append("path")
	      .datum(data)
	      .attr("class", "line")
	      .attr("d", line);

	  }
	      
	});	

	
};

App.prototype.renderBalanceChart = function() {
	var t = this;
	$("#balanceChart").html('');
	var svg = d3.select("#balanceChart")
	.append("svg")
	.append("g")

svg.append("g")
	.attr("class", "slices");
svg.append("g")
	.attr("class", "labels");
svg.append("g")
	.attr("class", "lines");

var width = 480,
    height = 320,
	radius = Math.min(width, height) / 2;

var pie = d3.layout.pie()
	.sort(null)
	.value(function(d) {
		return d.value;
	});

var arc = d3.svg.arc()
	.outerRadius(radius * 0.8)
	.innerRadius(radius * 0.4);

var outerArc = d3.svg.arc()
	.innerRadius(radius * 0.9)
	.outerRadius(radius * 0.9);

svg.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var key = function(d){ return d.data.label; };

var color = d3.scale.ordinal()
	.domain(["Stocks", "Bonds", "Cash"])
	.range(["#98abc5", "#6b486b", "#d0743c", "#ff8c00"]);

$.ajax({
		type: "GET",
		url: "api/balance.php",
		data: { 
			uid: $('input[name=uid]').val(),
			mturkworkerid: $('input[name=mturkworkerid]').val()
		},
		success: function(data) {
			var data = eval(data);

			t.renderPie(data);
		}
	});


App.prototype.renderPie = function(data) {


	var totalValue = 0;
	for (var i = 0; i < data.length; i++) {
		totalValue += data[i].value;
	}


	if (totalValue > 0) {
		$('#balanceChart, #histChart').show();

	/* ------- PIE SLICES -------*/
	var slice = svg.select(".slices").selectAll("path.slice")
		.data(pie(data), key);

	slice.enter()
		.insert("path")
		.style("fill", function(d) { return color(d.data.label); })
		.attr("class", "slice");

	slice		
		.transition().duration(1000)
		.attrTween("d", function(d) {
			this._current = this._current || d;
			var interpolate = d3.interpolate(this._current, d);
			this._current = interpolate(0);
			return function(t) {
				return arc(interpolate(t));
			};
		})

	slice.exit()
		.remove();

	/* ------- TEXT LABELS -------*/

	var text = svg.select(".labels").selectAll("text")
		.data(pie(data), key);

	text.enter()
		.append("text")
		.attr("dy", ".35em")
		.text(function(d) {
			return d.data.label;
		});
	
	function midAngle(d){
		return d.startAngle + (d.endAngle - d.startAngle)/2;
	}

	text.transition().duration(1000)
		.attrTween("transform", function(d) {
			this._current = this._current || d;
			var interpolate = d3.interpolate(this._current, d);
			this._current = interpolate(0);
			return function(t) {
				var d2 = interpolate(t);
				var pos = outerArc.centroid(d2);
				pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
				return "translate("+ pos +")";
			};
		})
		.styleTween("text-anchor", function(d){
			this._current = this._current || d;
			var interpolate = d3.interpolate(this._current, d);
			this._current = interpolate(0);
			return function(t) {
				var d2 = interpolate(t);
				return midAngle(d2) < Math.PI ? "start":"end";
			};
		});

	text.exit()
		.remove();

	/* ------- SLICE TO TEXT POLYLINES -------*/

	var polyline = svg.select(".lines").selectAll("polyline")
		.data(pie(data), key);
	
	polyline.enter()
		.append("polyline");

	polyline.transition().duration(1000)
		.attrTween("points", function(d){
			this._current = this._current || d;
			var interpolate = d3.interpolate(this._current, d);
			this._current = interpolate(0);
			return function(t) {
				var d2 = interpolate(t);
				var pos = outerArc.centroid(d2);
				pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
				return [arc.centroid(d2), outerArc.centroid(d2), pos];
			};			
		});
	
	polyline.exit()
		.remove();

	}



};
};

App.prototype.calcReturns = function(yearlySavings, percentRet, years) {
	var val = 0;
	for (var i = 0; i < years; i++) {
		val += yearlySavings;
		val = val * (1 + percentRet);
	}
	return Math.round(val);
};

App.prototype.updateEstimate = function() {
	var t = this;
	var year = eval($('input[name=year]').val());
	var pstock = $('input[name=pstock]').val()/100;
	var pbond = $('input[name=pbond]').val()/100;
	var pcash = $('input[name=pcash]').val()/100;
	var amount = $('input[name=amount]').val()*1;

	var totalPercent =  pstock + pbond + pcash;
	portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;

	var remainingYears = 2015 - year;
	var estimate = t.calcReturns(amount,portRet,remainingYears);
	var sum = ($('#sum').text() * 1)

	var actualEst = estimate + sum;
	$('#estimate').text('$'+t.numberWithCommas(actualEst));

	var gainLossVal = actualEst - goal;
	t.calcEndowmentVals(goal,actualEst,gainLossVal);
	t.updateCases();

};

App.prototype.calcFV = function(save, percentRet, years) {
	var val = save;
	for (var i = 0; i < years; i++) {
		val += val * percentRet;
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

App.prototype.updateCases = function() {
	var t = this;
	var pstock = $('input[name=pstock]').val()/100;
	var pbond = $('input[name=pbond]').val()/100;
	var pcash = $('input[name=pcash]').val()/100;
	var amount = $('input[name=amount]').val()*1;

	var totalPercent =  pstock + pbond + pcash;
	portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;
	portVol = stockVol*pstock + bondVol*pbond + cashVol*pcash;

	var year = $('input[name=year]').val();
	var remainingYears = 2015 - year;

	var estLow = Math.round(t.calcFV(amount,portRet-portVol, remainingYears));
	var estLikely = t.calcFV(amount,portRet,remainingYears);
	var estHigh = Math.round(t.calcFV(amount,portRet+portRet, remainingYears));

	$('#savedToday').text('$'+t.numberWithCommas(amount));
	$('#worstCase').text('$'+t.numberWithCommas(estLow));
	$('#likelyCase').text('$'+t.numberWithCommas(estLikely));
	$('#bestCase').text('$'+t.numberWithCommas(estHigh));
};

App.prototype.checkDateCount = function(callback) {
	$.ajax({
		type: "GET",
		url: "api/date_count.php",
		success: function(data) {
			var count = Math.round(data*1);
			if (count > 500) {
				$('#pageData').hide();
				$('#pageMsg').show();
			} else {
				$('#pageData').show();
				$('#pageMsg').hide();
			}
		}
	});
};

App.prototype.addEvents = function() {
	var t = this;
	$('.asset').change(function() {
		t.updateEstimate();
	});

	$('#yearForm').submit(function(e) {

		$('#submitBtn').attr('disabled', 'disabled');

		var year = $('input[name=year]').val();

		if (year < 2015) {
			var pstock = $('input[name=pstock]').val()/100;
			var pbond = $('input[name=pbond]').val()/100;
			var pcash = $('input[name=pcash]').val()/100;

			var totalPercent =  pstock + pbond + pcash;

			if (pstock + pbond + pcash != 1) {
				alert('Stock + bond + cash percents must add up to 100%.');
			} else {
				portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;
				var serialized = $('#yearForm').serialize();
				$.get('api/save_month.php?' + serialized).done(function() {
					t.getSum();
				});

			}
		} else {
			
			setTimeout(function() {
				$('#completeMsg').show();
				$('#pageData, #pageMsg').hide();
			}, 500);
			
		}
		window.scrollTo(0, 0);
		t.checkDateCount();
		e.preventDefault();
	});
};

App.prototype.clearDB = function() {
	var t = this;
	$.get('api/clear.php').done(function() {
		t.getSum();
		$('input[name=year]').val(1980);
	});
	$('#balanceChart, #histChart').hide();
	alert('DB cleared');
};

App.prototype.calcEndowmentVals = function(originalValue, currentValue, gainLossValue) {
	var t = this;
	$('#originalValue').html('$' + t.numberWithCommas(originalValue));
	$('#currentValue').html('$' + t.numberWithCommas(currentValue));
	$('#gainLossValue').html('$' + t.numberWithCommas(gainLossValue));

	$('#gainLossValue').removeClass('red').removeClass('green');

	if (gainLossValue < 0) {
		$('#gainLossValue').addClass('red');
	} else if (gainLossValue > 0) {
		$('#gainLossValue').addClass('green');
	}

};

App.prototype.init = function(completeMsg) {
	var t = this;
	t.addEvents();
	t.checkDateCount();
	t.renderBalanceChart();
	t.renderHistChart(function() {
		$('input[name=year]').val(currYear);
	});
	t.updateCases();
	t.getSum();

	$('#goal').text('$' + t.numberWithCommas(goal));

	$('#balanceChart, #histChart').hide();

};


var app = new App();
app.init();