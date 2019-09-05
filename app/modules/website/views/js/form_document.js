Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");

	myDropzone.on("success", function(file, response) {

		var ext = file.name.split('.').pop();
		var thumb = "";
		switch(ext){
		case "docx":
		case "doc":
			thumb = 'fa fa-file-word-o fa-5x color_doc';
			break;

		case "pdf":
			thumb = 'fa fa-file-pdf-o fa-5x color_pdf';
			break;
		}

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());
		} else {

			alertify.success('File Upload Successful.');

			$('#post_document').val(response.document_file);

			$('.upload_document_holder').append('<i class="'+ thumb +'"></i><br><span>'+ file.name +'</span>');
			$('.upload_document_holder').fadeIn();

			// closes the modal
			$('#modal').modal('hide');

			// restores the modal content to loading state
			restore_modal();

			// shows the success message

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