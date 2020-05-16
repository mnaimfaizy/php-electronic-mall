// JavaScript Document
// Find states/provinces according to the selected country
$('#country').on('change', function() {
	$.get('ajax/load_states.php?country_code=' +$(this).val(), function(data) { 
			$("#state").html(data);
			$("#state").prepend('<option value="" disabled="disabled" selected="selected"> -- Select State -- </option>');
		});
});
var output = '<option value="" selected="selected" disabled>-- Select Country First --</option>';
	$("#state").html(output);