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
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');

		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(post_url, {
			website_name: $('#website_name').val(),
			website_email: $('#website_email').val(),
			website_url: $('#website_url').val(),
			website_theme: $('#website_theme').val(),
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
				// closes the modal
				$('#modal').modal('hide'); 

				// restores the modal content to loading state
				restore_modal(); 

				// shows the success message
				alertify.success(o.message); 
			}
			// reset the button
			btn.button('reset');
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