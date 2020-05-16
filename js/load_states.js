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

/* ---------------------------------------------------------------------------------------------------------------- */

$('#bill_country').on('change', function() {
	$.get('ajax/load_states.php?country_code=' +$(this).val(), function(data) { 
			$("#bill_state").html(data);
			$("#bill_state").prepend('<option value="" disabled="disabled" selected="selected"> -- Select State -- </option>');
		});
});
var output = '<option value="" selected="selected" disabled>-- Select Country First --</option>';
	$("#bill_state").html(output);
	
/* ---------------------------------------------------------------------------------------------------------------- */

$('#shipping_country').on('change', function() {
	$.get('ajax/load_states.php?country_code=' +$(this).val(), function(data) { 
			$("#shipping_state").html(data);
			$("#shipping_state").prepend('<option value="" disabled="disabled" selected="selected"> -- Select State -- </option>');
		});
});
var output = '<option value="" selected="selected" disabled>-- Select Country First --</option>';
	$("#shipping_state").html(output);