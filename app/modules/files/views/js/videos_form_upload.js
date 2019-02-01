Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");
/*	 Dropzone.options.myDropzone = {
	    maxFilesize: 10000,
	    init: function() {
	      this.on("uploadprogress", function(file, progress) {
	        console.log("File progress", progress);
	      });
	    }
	  }*/
	 try{
			myDropzone.on("success", function(file, response) {
				
				var response = jQuery.parseJSON(response);

				if (response.status == 'failed') {
					alert(jQuery(response.error).text());

				} else {

					// closes the modal
					$('#modal').modal('hide'); 
				
					// $('#video_upload video').val(response.image);
					$('#video_upload video').attr('src', site_url + response.video_source);

					// restores the modal content to loading state
					restore_modal(); 

					// shows the success message
					alertify.success(response.message);
				}
				
				$('.dz-image, .dz-preview').remove();
				$('.dz-message').show();


			});
		}
		catch(e){
			console.log(e)
		}

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

});