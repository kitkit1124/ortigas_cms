$(function() {
	
	
	
	// handles the submit action
	$('#submit').click(function(e){
		// change the button to loading state
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
			customer_fname: $('#customer_fname').val(),
			customer_lname: $('#customer_lname').val(),
			customer_telno: $('#customer_telno').val(),
			customer_mobileno: $('#customer_mobileno').val(),
			customer_email: $('#customer_email').val(),
			customer_id_type: $('#customer_id_type').val(),
			customer_id_details: $('#customer_id_details').val(),
			customer_mailing_country: $('#customer_mailing_country').val(),
			customer_mailing_house_no: $('#customer_mailing_house_no').val(),
			customer_mailing_street: $('#customer_mailing_street').val(),
			customer_mailing_city: $('#customer_mailing_city').val(),
			customer_mailing_brgy: $('#customer_mailing_brgy').val(),
			customer_mailing_zip_code: $('#customer_mailing_zip_code').val(),
			customer_billing_country: $('#customer_billing_country').val(),
			customer_billing_house_no: $('#customer_billing_house_no').val(),
			customer_billing_street: $('#customer_billing_street').val(),
			customer_billing_city: $('#customer_billing_city').val(),
			customer_billing_brgy: $('#customer_billing_brgy').val(),
			customer_billing_zip_code: $('#customer_billing_zip_code').val(),

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