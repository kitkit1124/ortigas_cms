Dropzone.autoDiscover = false;

$(function() {
	
	var myDropzone = new Dropzone("#dropzone");
	 Dropzone.options.myDropzone = {
	    maxFilesize: 500,
	    init: function() {
	      this.on("uploadprogress", function(file, progress) {
	        console.log("File progress", progress);
	      });
	    }
	  }
	myDropzone.on("success", function(file, response) {

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());
		} else {

			// var image = '<img src="' + response.host + response.thumb + '" class="img-responsive" />';

			var buttons = '';

			if (response.small) {
				buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + response.small+'" data-thumb="' + response.thumb+'">Small</button> ';
			}
			if (response.medium) {
				buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + response.medium+'" data-thumb="' + response.thumb+'">Medium</button> ';
			}
			if (response.large) {
				buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + response.large+'" data-thumb="' + response.thumb+'">Large</button> ';
			}
			if (response.image) {
				buttons += '<button class="btn btn-xs btn-default btn-image" data-image="' + response.image+'" data-thumb="' + response.thumb+'">Original</button>';
			}

			html = '<div class="thumbnail"><div class="caption"><h4>Select the image size</h4>' + buttons + '</div><img src="' + asset_url+ response.thumb + '" class="img-responsive" width="100%" /></div><h4>Hover on the image then select the size</h4>';

			$('#image_sizes').html(html);
		}

		myDropzone.removeFile(file);

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
			banner_banner_group_id: $('#banner_banner_group_id').val(),
			banner_thumb: $('#banner_thumb').val(),
			banner_image: $('#banner_image').val(),
			banner_alt_image: $('#banner_alt_image').val(),
			banner_caption: $('#banner_caption').val(),
			banner_link: $('#banner_link').val(),
			banner_target: $('#banner_target').val(),
			banner_order: $('#banner_order').val(),
			banner_status: $('#banner_status').val(),

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
				window.location.reload(true);
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

$('#banner_image_link').click(function(){
	$('#form').css('display','none');
	$('#image').css('display', 'block');
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
	$('#banner_image').val(image);
	$('#banner_thumb').val(thumb);
	$('#preview_image_thumb').attr('src', asset_url + thumb);

	// show the form
	$('#image').css('display','none');
	$('#form').css('display', 'block');
});

$('.go-back').click(function(){
	$('#form').css('display','block');
	$('#image').css('display', 'none');
});