// Dropzone.autoDiscover = false;

$(function() {

	// $('#my-grid').gridEditor({
		// tinymce: {
		// 	config: { paste_as_text: true }
		// }
	// });

	//grid_editor('#my-grid');

	// handles the post action

	$('#page_properties, #page_posts').select2();

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

		var properties = 0;
		if($('#page_properties').val()) { var properties = $('#page_properties').val(); }

		var articles = 0;
		if($('#page_posts').val()) { var articles = $('#page_posts').val(); }

		// submits the data to the backend
		$.post(post_url, {
			page_parent_id: $('#page_parent_id').val(),
			page_title: $('#page_title').val(),
			page_heading_text: $('#page_heading_text').val(),
			page_content: tinyMCE.get('page_content').getContent(),
			page_bottom_content: tinyMCE.get('page_bottom_content').getContent(),
			page_layout: $('#page_layout').val(),
			page_status: $('.page_status:checked').val(),
			page_status: $('.page_status:checked').val(),
			page_properties: properties,
			page_tagposts: articles,
			// page_sidebar_id: $('#page_sidebar_id').val(),
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
					}
				}
			} else {
				if (o.action == 'add') {
					window.location.replace(site_url + 'website/pages/form/edit/' + o.id);
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
		selector: "#page_content, #page_bottom_content",
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
		// setup: function (editor) {
		// 	editor.addButton('images', {
		// 		text: 'Image',
		// 		icon: 'image',
		// 		onclick: function () {
		// 			$('#modal').modal({
		// 				remote: site_url + 'files/images/rte/mce'
		// 			})
		// 		}
		// 	});
		// 	editor.addButton('documents', {
		// 		text: 'Document',
		// 		icon: 'newdocument',
		// 		onclick: function () {
		// 			$('#modal').modal({
		// 				remote: site_url + 'files/documents/rte/mce'
		// 			})
		// 		}
		// 	});
		// 	editor.addButton('videos', {
		// 		text: 'Video',
		// 		icon: 'media',
		// 		onclick: function () {
		// 			$('#modal').modal({
		// 				remote: site_url + 'files/videos/rte/mce'
		// 			})
		// 		}
		// 	});
		// },
		// content_css: site_url + 'themes/aceadmin/css/tinymce.css'
	});

	// select page layout
	var layout = $("#page_layout");
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