$(function(){
	$('#confirm').click(function(e){
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');

		e.preventDefault();
		
		$.post(ajax_url, {
			'confirm': 1,
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		}, function(data) {
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				btn.button('reset');
				alertify.error(o.message);
				$('#modal').modal('hide');
			}
			else {
				window.location.replace( site_url + "dashboard");
			}

		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			btn.button('reset');
		});

	});
});