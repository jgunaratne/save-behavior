var App = function() {

};

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


$('#yearForm').submit(function(e) {

	$('#submitBtn').attr('disabled', 'disabled');

	var year = $('input[name=year]').val();

	if (year < 2015) {
		var pstock = $('input[name=pstock]').val()/100;
		var pbond = $('input[name=pbond]').val()/100;
		var pcash = $('input[name=pcash]').val()/100;

		console.log(pstock, pbond, pcash);

		var totalPercent =  pstock + pbond + pcash;
		console.log(totalPercent);

		if (pstock + pbond + pcash != 1) {
			alert('Stock + bond + cash percents must add up to 100%.');
		} else {

			portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;


			var serialized = $('#yearForm').serialize();
			$.get('save_month.php?' + serialized).done(function() {
				getSum();
			});

		}
	}
	
	e.preventDefault();
});



function getSum() {
	$.ajax({
		type: "GET",
		url: "sum.php",
		data: { 
			uid: $('input[name=uid]').val()
		},
		success: function(data) {
			var sum = Math.round(data*1);
			$('#sum').text(sum);
			$('#displaySum').text('$'+numberWithCommas(sum));

			var year = eval($('input[name=year]').val());
			var futureYear = year + 0;
			$('#year').text(futureYear);

			year++;
			$('input[name=year]').val(year);

			//$('input[name=year]').val(currYear);
	  		$('#year').text(year);
			
			renderHistChart();
			renderBalanceChart();

			
			updateEstimate();

			$('#submitBtn').attr('disabled', null);

		}
	});
}

//$('#submitBtn').attr('disabled', 'disabled');

$('#clearDBBtn').on('click', function() {
	$.get('clear.php').done(function() {
		getSum();
		$('input[name=year]').val(1980);
	});
	alert('DB cleared');
});

function renderHistChart() {
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
	    .x(function(d) { return x(d.date); })
	    .y(function(d) { return y(d.close); });

	var svg = d3.select("#histChart").append("svg")
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	  .append("g")
	    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.csv("history.php?uid=100", function(error, data) {

	  if (data.length > 0) {

	  data.forEach(function(d) {
	    d.date = parseDate(d.date);
	    d.close = +d.close;

	    var dYear = d.date.getFullYear();
	    if (dYear > currYear) {
	    	currYear = dYear;
		}
	  });

	  

	  x.domain(d3.extent(data, function(d) { return d.date; }));
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
}

function renderBalanceChart() {
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
		url: "balance.php",
		data: { 
			uid: $('input[name=uid]').val()
		},
		success: function(data) {

			var data = eval(data);
			//console.log(data);
			renderPie(data);
		}
	});


function renderPie(data) {

	var totalValue = 0;
	for (var i = 0; i < data.length; i++) {
		totalValue += data[i].value;
	}

	//console.log(totalValue);

	if (totalValue > 0) {
	

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
}

function calcReturns(yearlySavings, percentRet, years) {
	var val = 0;
	for (var i = 0; i < years; i++) {
		val += yearlySavings;
		val = val * (1 + percentRet);
	}
	return Math.round(val);
}

$('.asset').change(function() {
	updateEstimate();
});

function updateEstimate() {
	var year = eval($('input[name=year]').val());
	var pstock = $('input[name=pstock]').val()/100;
	var pbond = $('input[name=pbond]').val()/100;
	var pcash = $('input[name=pcash]').val()/100;
	var amount = $('input[name=amount]').val()*1;

	var totalPercent =  pstock + pbond + pcash;
	portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;

	var remainingYears = 2015 - year;
	var estimate = calcReturns(amount,portRet,remainingYears);
	var sum = ($('#sum').text() * 1)
	//console.log(sum);

	//console.log(estimate);

	var actualEst = estimate + sum;
	$('#estimate').text('$'+numberWithCommas(actualEst));

	updateCases();

}

function calcFV(save, percentRet, years) {
	var val = save;
	for (var i = 0; i < years; i++) {
		val += val * percentRet;
	}
	return Math.round(val);
}

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function updateCases() {
	var pstock = $('input[name=pstock]').val()/100;
	var pbond = $('input[name=pbond]').val()/100;
	var pcash = $('input[name=pcash]').val()/100;
	var amount = $('input[name=amount]').val()*1;

	var totalPercent =  pstock + pbond + pcash;
	portRet = stockRet*pstock + bondRet*pbond + cashRet*pcash;
	portVol = stockVol*pstock + bondVol*pbond + cashVol*pcash;

	var year = $('input[name=year]').val();
	var remainingYears = 2015 - year;

	var estLow = Math.round(calcFV(amount,portRet-portVol, remainingYears));
	var estLikely = calcFV(amount,portRet,remainingYears);
	var estHigh = Math.round(calcFV(amount,portRet+portRet, remainingYears));

	//console.log(portVol);


	$('#savedToday').text('$'+numberWithCommas(amount));
	$('#worstCase').text('$'+numberWithCommas(estLow));
	$('#likelyCase').text('$'+numberWithCommas(estLikely));
	$('#bestCase').text('$'+numberWithCommas(estHigh));
}

function checkDateCount() {
	$.ajax({
		type: "GET",
		url: "date_count.php",
		success: function(data) {
			var count = Math.round(data*1);
			if (count > 5) {
				$('#pageData').hide();
				$('#pageMsg').show();
			} else {
				$('#pageData').show();
				$('#pageMsg').hide();
			}
		}
	});
}

function init() {
	checkDateCount();
	renderBalanceChart();
	renderHistChart();
	updateCases();
	getSum();
}

init();
