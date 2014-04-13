$('#yearForm').submit(function(e) {
	var serialized = $('#yearForm').serialize();
	$.get('save_month.php?' + serialized).done(function() {
		getSum();
	});
	
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
		$('#sum').html(data);

		var year = eval($('input[name=year]').val());
		year++;
		$('input[name=year]').val(year);
		
	}
})
}