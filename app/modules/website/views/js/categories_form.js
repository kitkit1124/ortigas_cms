/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2015, Digify, Inc.
 * @link		http://www.digify.com.ph
 */
$(function() {

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
			category_parent_id: $('#category_parent_id').val(),
			category_name: $('#category_name').val(),
			category_layout: $('#category_layout').val(),
			// category_sidebar_id: $('#category_sidebar_id').val(),
			category_status: $('.category_status:checked').val(),
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
						$('#error-asterisk-' + form_name).html('<span style="color:red">*</span>');
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

	// select page layout
	var layout = $("#category_layout");
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