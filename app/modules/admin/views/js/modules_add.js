/**
 * @package		Codifire
 * @version			1.0
 * @author 			Randy Nivales <randynivales@gmail.com>
 * @author 			Ghem Gatchalian <densetsu.ghem@gmail.com>
 * @copyright 		Copyright (c) 2014-2015, Randy Nivales
 * @link			randynivales@gmail.com; densetsu.ghem@gmail.com
 */
 
$(function() {
	
	if ($('#table_availability').val() == 'false') {
		$('#table_availability').trigger('change');
		$('#table_availability').removeAttr("checked");
	} else
	{
		$('#table_availability').attr("checked", true);
	}

	$('.icp-auto').iconpicker({
		 hideOnSelect: true
	});

	// $('#copyright_year, #module_order').mask('###0');

	// handles the submit action
	$('#submit').click(function(e){
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');
	});

	$(document).on('select keyup', '#module_name_singular', function() {
		var table_name = $(this).val().replace(/\s+/g, '_').toLowerCase() + '_';
		$('.table-name').text(table_name);
	});


	$('#clone').click(function(){
		$('#table_fields .table_row').last().clone(true).insertAfter($('#table_fields .table_row').last());

		$('#table_fields .table_row:last-child input').val('');
		$('#table_fields .table_row:last-child select').val('--');
		$('#table_fields .table_row:last-child select[name="form_type[]"] ').val('INPUT');
	});
});

$('.column_type').change(function() {
	var target = $(this).parent().siblings().children('.column_length');
		switch($(this).val()) {
			case 'CHAR': target.val(255); break;
			case 'VARCHAR': target.val(255); break;
			case 'BIGINT': target.val(20); break;
			case 'INT': target.val(10); break;
			case 'MEDIUMINT': target.val(8); break;
			case 'SMALLINT': target.val(5); break;
			case 'TINYINT': target.val(3); break;
			case 'DECIMAL': target.val('(10,2)'); break;
			case 'SET': target.val('("Active","Disabled")'); break;	
			default: target.val('--'); break;
		}	//end switch

	target = $(this).parent().siblings().children('.form_type');
		switch ($(this).val()) {
			case 'TEXT':
				target.val('TEXTAREA');
				break;
			case 'BOOLEAN':
				target.val('CHECKBOX');
				break;
			default:
				target.val('INPUT');
				break;
		}	//endswitch
});

$('#table_availability').on('change', function() {
	$('#table_columns').toggle();
	$('.help-block').toggle();
	$('.box-footer #clone').toggle();

	var chk = $('#table_availability').is(':checked');

		$('#table_availability').val(chk);
});

//on select (column_index[])
// 
var index;
	index = $('select[name="column_index[]')
				  .map(function() {
				    return this.value;
				  })
				 .get();

$('select[name="column_index[]').on('change', function (e) {
	e.preventDefault();

	var target = $('select[name="column_index[]');
	var submit = $('#submit');
		target.removeClass('primary_error');

	submit.removeClass('disabled');
	submit.attr('disabled', false);


	if (index.indexOf(this.value) >= 0 ) { //exists
		if (this.value == 'Primary') {
			$(this).addClass('primary_error');
			alertify.error("Only 1 Primary is allowed.");
			submit.addClass('disabled');
			submit.attr('disabled', true);
		} else { //index or --
			index = target
				  .map(function() {
				    return this.value;
				  })
				 .get();
		}
		//console.log(index);
	}  	
	else {
		index = $('select[name="column_index[]')
			  .map(function() {
			    return this.value;
			  })
			 .get();
	}
});