Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");

	myDropzone.on("success", function(file, response) {

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());

		} else {

			// closes the modal
			$('#modal').modal('hide'); 
		
			$('#property_image').val(response.image);
			$('#property_active_image').attr('src', site_url + response.image);

			$('.selected_image').val(response.image);
			$('.active_image_thumb').attr('src', site_url + response.image);

			// restores the modal content to loading state
			restore_modal(); 

			// shows the success message
			//alertify.success(response.message);
		}
		
		$('.dz-image, .dz-preview').remove();
		$('.dz-message').show();


	});

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

});
