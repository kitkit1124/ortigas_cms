$(function() {

	// handles the submit action
	$('#post').click(function(e){
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
		$.post(post_url, {
			category_name_original: $('#category_name_original').val(),
			category_name: $('#category_name').val(),
			category_description: tinyMCE.get('category_description').getContent(),
			category_snippet_quote: tinyMCE.get('category_snippet_quote').getContent(),
			category_bottom_description: tinyMCE.get('category_bottom_description').getContent(),
			category_image: $('#category_image').val(),
			category_alt_image: $('#category_alt_image').val(),
			category_status: $('#category_status').val(),

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
						$('#error-asterisk-' + form_name).html('<span style="color:red">*</span>');
					}
				}
			} else {
				if (o.action == 'add') {
					window.location.replace(site_url + 'properties/properties/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 
				} 
			}

			$this.html($this.data('original-text'));
			
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

	tinymce.init({
		selector: "#category_description, #category_bottom_description, #category_snippet_quote", 
		theme: "modern",
		statusbar: true,
		menubar: true,
		relative_urls: false,
		remove_script_host : false,
		convert_urls : true,
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern'
		],
		toolbar1: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link mybutton documents videos',
		image_advtab: true,
	});
});