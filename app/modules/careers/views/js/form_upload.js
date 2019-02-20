Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");

	myDropzone.on("success", function(file, response) {

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());

		} else {

			// closes the modal
			$('#modal').modal('hide'); 
		
			$('#career_image').val(response.image);
			$('#career_active_image').attr('src', asset_url + response.image);

			// restores the modal content to loading state
			restore_modal(); 

			// shows the success message
			//alertify.success(response.message);
		}
		
		$('.dz-image, .dz-preview').remove();
		$('.dz-message').show();


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
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[8] + '" data-thumb="' + full[5] + '">Small</button> ';
					}
					if (full[7]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[7] + '" data-thumb="' + full[5] + '">Medium</button> ';
					}
					if (full[6]) {
						buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + full[6] + '" data-thumb="' + full[5] + '">Large</button> ';
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
		$('#career_image').val(image);
		$('#career_active_image').attr('src', asset_url + image);

		// show the form
/*		$('#image').css('display','none');
		$('#form').css('display', 'block');*/

		$('.modal-footer .btn').trigger('click');
	});

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

});
