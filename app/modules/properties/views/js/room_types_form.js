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

			$('#room_type_image').val(img.image);
			$('#room_type_active_image').attr('src', asset_url + img.image);
			$('.dz-image, .dz-preview').remove();
			$('.dz-message').show();
			
			$('p.note').fadeOut(500);
			$('#dropzone').hide();
			$('#image_container').show();

			$('.disimg').css('display','block');
			$('.uplimg').css('display', 'none');
		}
	});

	
	$("#room_type_active_image").click(function(){
		$('#image_container').hide();
		$('#dropzone').fadeIn(500);
		$('p.note').fadeIn(500);
	});	

	$('#room_type_active_image').click(function(){
		$('.disimg').css('display','none');
		$('.uplimg').css('display', 'block');

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
			room_type_property_id_original: $('#room_type_property_id_original').val(),
			room_type_name_original: $('#room_type_name_original').val(),
			room_type_property_id: $('#room_type_property_id').val(),
			room_type_name: $('#room_type_name').val(),
			room_type_image: $('#room_type_image').val(),
			room_type_alt_image: $('#room_type_alt_image').val(),
			room_type_status: $('#room_type_status').val(),

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

	var oTable = $('#dt-images').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": site_url + "files/images/datatables",
		"lengthMenu": [[4, 27, 50, 100, 300, -1], [4, 27, 50, 100, 300, "All"]],
		"pagingType": "simple",
		"language": {
			"paginate": {
				"previous": 'Prev',
				"next": 'Next',
			}
		},
		"bAutoWidth": false,
		"aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": 
		[
			{
				"aTargets": [5],
				"mRender": function (data, type, full) {
					var buttons = '';
					if (full[8]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[8] + '" data-thumb="' + full[5] + '">S</button> ';
					}
					if (full[7]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[7] + '" data-thumb="' + full[5] + '">M</button> ';
					}
					if (full[6]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[6] + '" data-thumb="' + full[5] + '">L</button> ';
					}
					if (full[4]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[4] + '" data-thumb="' + full[5] + '">Original</button> ';
					}
					return '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-6"><div class="thumbnail"><div class="caption"><h4>Select the image size</h4>' + buttons + '</div><img src="' + asset_url + data + '" class="img-responsive" width="100%" data-id="' + full[0] + '" /></div></div>';
				},
			},

			{
				"aTargets": [0,1,2,3,4,6,7,8,9,10],
				"mRender": function (data, type, full) {
					return '<span style="display:none;">' + data + '</span>';
				},
			},

		],
		"fnDrawCallback": function( oTable ) {
			// hide the table
			$('#dt-images').hide();

			// then recreate the table as divs
			var html = '';
			$('tr', this).each(function() {
				$('td', this).each(function() {
					html += $(this).html();
					// console.log(html);
				});
			});

			$('#thumbnails').html(html);
		}
	});

	$("#image_sizes, #thumbnails").on( "mouseenter", ".thumbnail", function( event ) {
		$(this).find('.caption').slideDown(250);
	}).on( "mouseleave", ".thumbnail", function( event ) {
		$(this).find('.caption').slideUp(250);
	});

	$('#image_sizes, #thumbnails').on("click", ".btn-image", function() {
		// insert the image
		var image = $(this).attr('data-image');
		var thumb = $(this).attr('data-thumb');
		$('#room_type_image').val(image);
		$('#room_type_active_image').attr('src', asset_url + image);

		$('.disimg, #image_container').show();
		$('.uplimg').css('display', 'none');
	});

	$('.go-back').click(function(){
		$('.disimg, #image_container').show();
		$('.uplimg').css('display', 'none');
	});
});