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
			price_range_label_original: $('#price_range_label_original').val(),
			price_range_label: $('#price_range_label').val(),
			price_range_min: $('#price_range_min').val().replace(/,/g,""),
			price_range_max: $('#price_range_max').val().replace(/,/g,""),
			price_range_status: $('#price_range_status').val(),

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

	const numberWithCommas = (x) => {
	  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$('.price_range_min_slide').val($('#price_range_min').val());
	$('.price_range_max_slide').val($('#price_range_max').val());

	$('#price_range_min').val(numberWithCommas($(".price_range_min_slide").val()));
	$('#price_range_max').val(numberWithCommas($(".price_range_max_slide").val()));

	$(".price_range_min_slide").change(function(){
		$('#price_range_min').val(numberWithCommas($(this).val()));
	});

	$("#price_range_min").keyup(function(){
		$('.price_range_min_slide').val($(this).val());
	});

	$(".price_range_max_slide").change(function(){
		$('#price_range_max').val(numberWithCommas($(this).val()));
	});

	$("#price_range_max").keyup(function(){
		$('.price_range_max_slide').val($(this).val());
	});
});