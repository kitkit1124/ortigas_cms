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
			division_department_id: $('#division_department_id').val(),
			division_department_id_original: $('#division_department_id_original').val(),
			division_name: $('#division_name').val(),
			division_name_original: $('#division_name_original').val(),
			division_status: $('#division_status').val(),
			division_image: $('#division_image').val(),
			division_alt_image: $('#division_alt_image').val(),
			division_content: tinyMCE.get('division_content').getContent(),
			division_seo_content: tinyMCE.get('division_seo_content').getContent(),

			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// reset the button
				// shows the error message
				alertify.error(o.message);

				// displays individual error messages
				if (o.errors) {
					for (var form_name in o.errors) {
						$('#error-' + form_name).html(o.errors[form_name]);
					}
				}
			} else {
				if (o.action == 'add') {
					window.location.replace(site_url + 'careers/divisions/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 
					setTimeout(function(){ location.reload(); }, 1000);					
				} 
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

	tinymce.init({
		selector: "#division_content, #division_seo_content",
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