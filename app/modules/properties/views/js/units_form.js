Dropzone.autoDiscover = false;
$(function() {
	
	var myDropzone = new Dropzone("#dropzone");
   
	myDropzone.on("success", function(file, response) {
		img = jQuery.parseJSON(response);

		if (img.status == 'failed') {
			$('.dz-image, .dz-preview').remove();
			$('.dz-message').show();
			alertify.error(img.error);
		} else {

			$('#unit_image').val(img.image);
			$('#unit_active_image').attr('src', asset_url + img.image);
			$('.dz-image, .dz-preview').remove();
			$('.dz-message').show();
			

			$('p.note').fadeOut(500);
			$('#dropzone').hide();
			$('#image_container').css('display','inline');
		}
	});

	
	$("#unit_active_image").click(function(){
		$('#image_container').hide();
		$('#dropzone').fadeIn(500);
		$('p.note').fadeIn(500);
	});	
	

	var unit_id = $('#unit_property_id').val();
	if(unit_id){}
	else{
		$('#unit_floor_id, #unit_room_type_id').prop( "disabled", true ).css('color','#999');
	}

	$('#unit_property_id').change(function() {
		$('#unit_floor_id, #unit_room_type_id').prop( "disabled", false ).css('color','#495057');
		var id = $(this).val();
		$('#unit_floor_id, #unit_room_type_id').html(' ').append('<option value=""> </option>');

		if(id){
			$.ajax({method: "GET",url: "units/get_floors",data: { property_id : id } })
			.done(function( data ) {
				d = jQuery.parseJSON(data);
				$.each(d, function( index, value ) {
					$('#unit_floor_id').append('<option value="' + value.floor_id + '">' + value.floor_level + '</option>');
				});
			});

			$.ajax({method: "GET", url: "units/get_room_type",data: { property_id : id } })
			.done(function( data ) {
				d = jQuery.parseJSON(data);
				$.each(d, function( index, value ) {
					$('#unit_room_type_id').append('<option value="' + value.room_type_id + '">' + value.room_type_name + '</option>');
				});
			});
		}
		else{
			$('#unit_floor_id, #unit_room_type_id').html('<option value="">Please select Property first</option>');
			$('#unit_floor_id, #unit_room_type_id').prop( "disabled", true ).css('color','#999');
		}
    });	
	
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
			unit_property_id_original: $('#unit_property_id_original').val(),
			unit_floor_id_original: $('#unit_floor_id_original').val(),
			unit_room_type_id_original: $('#unit_room_type_id_original').val(),
			unit_number_original: $('#unit_number_original').val(),
			unit_property_id: $('#unit_property_id').val(),
			unit_floor_id: $('#unit_floor_id').val(),
			unit_room_type_id: $('#unit_room_type_id').val(),
			unit_number: $('#unit_number').val(),
			unit_size: $('#unit_size').val(),
			unit_price: $('#unit_price').val(),
			unit_downpayment: $('#unit_downpayment').val(),
			unit_image: $('#unit_image').val(),
			unit_status: $('#unit_status').val(),

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
				$('#modal-lg').modal('hide'); 

				// restores the modal content to loading state
				restore_modal(); 

				// shows the success message
				alertify.success(o.message); 
				//$('.modal-footer button').trigger('click'); 

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
});