/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

$(function() {

	// handles the submit action
	$('#submit').click(function(e){

		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(ajax_url, {
			navigation_group_id: $('#navigation_group_id').val(),
			navigation_parent_id: $('#navigation_parent_id').val(),
			navigation_name: $('#navigation_name').val(),
			navigation_link: $('#navigation_link').val(),
			navigation_target: $('#navigation_target').val(),
			navigation_type: $('#navigation_type').val(),
			navigation_status: $('#navigation_status').val(),
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// shows the error message
				alertify.error(o.message);

				// displays individual error messages
				if (o.errors) {
					for (var form_name in o.errors) {
						$('#error-' + form_name).html(o.errors[form_name]);
					}
				}
			} else {
				// refreshes the datatables
				$('#datatables').dataTable().fnDraw();

				// closes the modal
				$('#modal').modal('hide'); 

				// restores the modal content to loading state
				restore_modal(); 

				// shows the success message
				alertify.success(o.message); 
			}
		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			btn.button('reset');
		});
	});

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});