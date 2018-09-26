/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randynivales@gmail.com>
 * @copyright 	Copyright (c) 2014-2015, Randy Nivales
 * @link		randynivales@gmail.com
 */
$(function() {

	// groups
	// var opts=$("#select-groups").html(), opts2="<option></option>"+opts;
	// $("select.populate-groups").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
   	$("#groups").select2();
    // $('#groups').data().select2.updateSelection(default_groups);


	// handles the submit action
	$('#submit').click(function(e){
		var $this = $(this);
		var loadingText = '<i class="fa fa-spinner fa-spin"></i> Loading...';
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}
		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(ajax_url, {
			first_name: $('#first_name').val(),
			last_name: $('#last_name').val(),
			company: $('#company').val(),
			phone: $('#phone').val(),
			email: $('#email').val(),
			// username: $('#username').val(),
			password: $('#password').val(),
			password_confirm: $('#password_confirm').val(),
			groups: $('#groups').val(),
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// reset the button
				$this.html($this.data('original-text'));
				
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
			$this.html($this.data('original-text'));
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