$(function() {

	$('#post_properties, #post_tags').select2();

	$('.clear_logo').on('click',function(){
		$('.upload_document_holder .fa-5x, .upload_document_holder span').remove();
		$('#post_document').attr('value','');
	});

	// handles the post action
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

		// get checked categories
		var checkedCategories = $('.post_categories:checked').map(function() {
			return this.value;
		}).get();

		var properties = 0;
		if($('#post_properties').val()) { var properties = $('#post_properties').val(); }

		var tags = 0;
		if($('#post_tags').val()) { var tags = $('#post_tags').val(); }

		// submits the data to the backend
		$.post(post_url, {
			post_title_orig: $('#post_title_orig').val(),
			post_title: $('#post_title').val(),
			post_content: tinyMCE.activeEditor.getContent(),
			post_categories: checkedCategories,
			post_properties: properties,
			post_tags: tags,
			post_image: $('#post_image').val(),
			post_posted_on: $('#post_posted_on').val(),
			post_layout: $('#post_layout').val(),
			post_status: $('.post_status:checked').val(),
			post_alt_image: $('#post_alt_image').val(),
			post_slug: $('#post_slug').val(),
			post_facebook: $('#post_facebook').val(),
			post_twitter: $('#post_twitter').val(),
			post_instagram: $('#post_instagram').val(),
			post_linkedin: $('#post_linkedin').val(),
			post_youtube: $('#post_youtube').val(),
			post_document:  $('#post_document').val(),
			// post_sidebar_id: $('#post_sidebar_id').val(),
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		},
		function(data, status) {
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
					window.location.replace(site_url + 'website/posts/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 
				}
			}
			// reset the button
			$this.html($this.data('original-text'));

		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			$this.html($this.data('original-text'));
		});
	});

	// initialize tinymce
	tinymce.init({
		selector: "#post_content",
		extended_valid_elements : "span[*],i[*]",
		theme: "modern",
		statusbar: true,
		menubar: true,
		relative_urls: false,
		remove_script_host : false,
		convert_urls : true,
		content_css: 'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
   		noneditable_noneditable_class: 'fa',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern fontawesome'
		],
		// toolbar1: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link images documents videos',
		toolbar1: 'undo redo | styleselect | bold italic | fontsizeselect  alignleft aligncenter alignright alignjustify | bullist numlist | link fontawesome',
		image_advtab: true,
	});

	$("#dtBox").DateTimePicker({
		dateTimeFormat: "yyyy-mm-dd HH:mm:ss",
		minuteInterval: 5,
		secondsInterval: 5,
	});

	// select page layout
	var layout = $("#post_layout");
	var option = layout.find('option');

	if(option.is(':selected')) page_layout(layout);

	layout.on("change", function(e){
		page_layout($(this));
	});

	function page_layout(elem)
	{
		var layout = elem.find("option:selected").val();		

		if (layout == 'right_sidebar' || layout == 'left_sidebar') {
			$("#frontend_sidebar").removeClass('d-none');
		} else {
			$("#frontend_sidebar").addClass('d-none');
			$("#frontend_sidebar").find('option:eq(0)').prop('selected', true);
		}
	}
});