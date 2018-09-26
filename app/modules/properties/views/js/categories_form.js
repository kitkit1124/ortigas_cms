Dropzone.autoDiscover = false;

$(function() {
	
	var myDropzone = new Dropzone("#dropzone");
	
	myDropzone.on("success", function(file, response) {
		img = jQuery.parseJSON(response);

		if (img.status == 'failed') {
			$('.dz-image, .dz-preview').remove();
			$('.dz-message').show();
			alertify.error(img.error);
		} else {

			$('#category_image').val(img.image);
			$('#category_active_image').attr('src', site_url + img.image);
			$('.dz-image, .dz-preview').remove();
			$('.dz-message').show();
			
			$('p.note').fadeOut(500);
			$('#dropzone').hide();
			$('#image_container').show();
		}
	});

	
	$("#category_active_image").click(function(){
		$('#image_container').hide();
		$('#dropzone').fadeIn(500);
		$('p.note').fadeIn(500);

	});
	
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
			category_name_original: $('#category_name_original').val(),
			category_name: $('#category_name').val(),
			category_image: $('#category_image').val(),
			category_status: $('#category_status').val(),

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