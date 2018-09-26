$(function() {

	$('#submit').click(function(e) {
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');

		e.preventDefault();

		$.post(ajax_url, {
			// 'config_name': $('#config_name').val(),
			'config_value' : config_value(), 
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		}, function(data) {

			var response = jQuery.parseJSON(data);
			if(response.success === false) {
				// reset the button
				btn.button('reset');
				
				alertify.error(response.message);
				if(response.errors) {
					for (var form_name in response.errors) {
						console.log(form_name);
						$('#error-' + form_name).html(response.errors[form_name]);
					}
				}
			} else {
				$('#datatables').dataTable().fnDraw();
				$('#modal').modal('hide');
				restore_modal();
				alertify.success(response.message);
			}

			console.log(data);
		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			btn.button('reset');
		});
	});

	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	// Stringify array values
	function config_value()
	{
		var social_buttons  = new Array();

		if ($('.social-button-status').hasClass('social-button-status'))
		{
			$('.social-button-status').each(function(key, value){

				var elem    = $(value);
				var id      = elem.attr('id');          
				var name    = elem.attr('data-name');           
				var icon    = $('.social-button-icon').eq(key).val();
				var status  = (elem.is(":checked")?1:0);

				social_buttons.push({'id': id , 'name' : name , 'icon' : icon , 'status' : status});

			});

			return JSON.stringify(social_buttons);
		}
		else
		{
			return $('#config_value').val();
		}

	}

});
