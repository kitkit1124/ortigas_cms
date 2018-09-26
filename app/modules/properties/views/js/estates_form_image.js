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
		
			$('#estate_image').val(response.image);
			$('#estate_active_photo').attr('src', site_url + response.image);

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
