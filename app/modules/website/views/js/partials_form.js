/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

$(function() {

	// handles the post action
	$('#post').click(function(e){
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');

		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(post_url, {
			partial_title: $('#partial_title').val(),
			partial_content: tinyMCE.activeEditor.getContent(),
			partial_status: $('.partial_status:checked').val(),
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
					window.location.replace(app_url + 'website/partials/form/edit/' + o.id);
				} else {
					// shows the success message
					alertify.success(o.message); 
				}
			}
			// reset the button
			btn.button('reset');
		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			btn.button('reset');
		});
	});

	// initialize tinymce
	tinymce.init({
		selector: "#partial_content",
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
		toolbar1: 'undo redo | styleselect | bold italic | fontsizeselect  alignleft aligncenter alignright alignjustify | bullist numlist | link fontawesome',
		image_advtab: true,

	});

	// toolbar1: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | fontsizeselect  alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link fontawesome',
});