/**
 * @package		Codifire
 * @version		1.0
 * @author 		Randy Nivales <randy.nivales@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");
	
	myDropzone.on("success", function(file, response) {

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());
		} else {

			// var image = '<img src="' + response.host + response.thumb + '" class="img-responsive" />';

			var buttons = '';

			if (response.small) {
				buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + response.small+'">Small</button> ';
			}
			if (response.medium) {
				buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + response.medium+'">Medium</button> ';
			}
			if (response.large) {
				buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + response.large+'">Large</button> ';
			}
			if (response.image) {
				buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + response.image+'">Original</button>';
			}

			html = '<div class="thumbnail"><img src="' + response.host + response.thumb + '" class="img-responsive" width="100%" /></div><div class="text-center"><strong>Select the image size</strong><br />' + buttons + '</div>';

			$('#image_sizes').html(html);
		}

		myDropzone.removeFile(file);

	});

	// renders the datatables (datatables.net)
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
						buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + full[8] + '">Small</button> ';
					}
					if (full[7]) {
						buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + full[7] + '">Medium</button> ';
					}
					if (full[6]) {
						buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + full[6] + '">Large</button> ';
					}
					if (full[4]) {
						buttons += '<button class="btn btn-sm btn-default btn-image" data-src="' + full[4] + '">Original</button> ';
					}
					return '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-6"><div class="thumbnail mb-4"><div class="caption"><h4>Select the image size</h4>' + buttons + '</div><img src="' + asset_url + data + '" class="img-responsive" width="100%" data-id="' + full[0] + '" /></div></div>';
				},
			},

			{
				"aTargets": [0,1,2,3,4,6,7,8,9,10],
				"mRender": function (data, type, full) {
					return '<span class="d-none">' + data + '</span>';
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
			metatag_robots: $('#metatag_robots').val(),
			metatag_code: $('#metatag_code').val(),
			metatag_title: $('#metatag_title').val(),
			metatag_keywords: $('#metatag_keywords').val(),
			metatag_description: $('#metatag_description').val(),
			metatag_og_title: $('#metatag_og_title').val(),
			metatag_og_image: $('#metatag_og_image').val(),
			// metatag_og_url: $('#metatag_og_url').val(),
			metatag_og_description: $('#metatag_og_description').val(),
			metatag_twitter_title: $('#metatag_twitter_title').val(),
			metatag_twitter_image: $('#metatag_twitter_image').val(),
			// metatag_twitter_url: $('#metatag_twitter_url').val(),
			metatag_twitter_description: $('#metatag_twitter_description').val(),
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
				// $('#datatables').dataTable().fnDraw();

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

	// if ($('#metatag_title').val() == '') {
	// 	$('#metatag_title').val($('.meta-title').val());
	// }
	// if ($('#metatag_twitter_title').val() == '') {
	// 	$('#metatag_twitter_title').val($('.meta-title').val());
	// }
	// if ($('#metatag_og_title').val() == '') {
	// 	$('#metatag_og_title').val($('.meta-title').val());
	// }

	// var description = get_description();

	// if ($('#metatag_description').val() == '') {
	// 	$('#metatag_description').val(description);
	// }
	// if ($('#metatag_twitter_description').val() == '') {
	// 	$('#metatag_twitter_description').val(description);
	// }
	// if ($('#metatag_og_description').val() == '') {
	// 	$('#metatag_og_description').val(description);
	// }
});

// function get_description() {
// 	if (typeof tinyMCE !== 'undefined') {
// 		var description = tinyMCE.activeEditor.getContent();
// 	} else {
// 		var description = $('.meta-description').val();
// 	}

// 	if (description) {
// 		description = description.split('<!-- pagebreak -->')
// 		description = $(description[0]).text();

// 		return $.trim(description.replace(/[\t\n]+/g,' '));
// 	} else {
// 		return '';
// 	}
// }

// $('.metatag_image').click(function() {
// 	$('#modal').hide();

// 	$('#modal-lg').modal({
// 		remote: site_url + 'files/images/rte/mce'
// 	});
// });

$('.metatag_image').click(function() {
	// show the image tab
	$('a[href="#image_tab"]').tab('show');

	// save the target for later use
	$('#image_tab .tab-content').attr('data-target', $(this).attr('id'));
});

$("#thumbnails").on( "mouseenter", ".thumbnail", function( event ) {
	$(this).find('.caption').slideDown(250);
}).on( "mouseleave", ".thumbnail", function( event ) {
	$(this).find('.caption').slideUp(250);
});


$('#image_sizes, #thumbnails').on("click", ".btn-image", function() {
	// insert the image
	var src = $(this).attr('data-src');
	var target = $(this).closest('.tab-content').attr('data-target');
	$('#' + target + ' .metatag_image_path').val(src);
	$('#' + target + ' .metatag_image_thumb').attr('src', asset_url + src);

	// show the tab
	var target_tab = $('#' + target).closest('.tab-pane').attr('id');
	$('a[href="#' + target_tab + '"]').tab('show');
});