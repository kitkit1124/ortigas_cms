<link href="<?php echo site_url('npm/datatables.net-bs4/css/dataTables.bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('npm/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('npm/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<style>
	#datatables_wrapper .row:last-child {
		background-color: #FFF;
		border-bottom: none;
	}

	#datatables_wrapper .row:first-child {
		display: none;
	}

	.dataTables_info {
		font-size: .8em;
	}

	.thumbnail {
		position: relative;
		height: 100px;
		overflow: hidden;
		padding: 0;
	}
	.popover {
		z-index: 99999;
	}
	.caption {
		position:absolute;
		top:0;
		right:0;
		background:rgba(0, 0, 0, 0.75);
		width:100%;
		height:100%;
		padding:1%;
		display: none;
		text-align:center;
		color:#fff !important;
		z-index:2;
	}
	.btn-image {
		font-size: .8em;
		padding: 1px;
	}
</style>
<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<div class="nav-tabs-custom bottom-margin">
		<ul class="nav nav-tabs">
			<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Upload Documents</a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Add Existing Documents</a></li>
		</ul>
		<div class="tab-content mt-4">
			<div class="tab-pane active" id="tab_1">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<?php echo form_open(site_url('files/documents/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
							<div class="fallback">
								<input name="file" type="file" class="d-none" />
							</div>
							<?php echo form_close();?>
						</div>
					</div>
					<div class="col-sm-8 text-center">
						<div id="new_documents"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="tab-pane" id="tab_2">
				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="all"><?php echo lang('index_id')?></th>
							<th class="min-desktop"><?php echo lang('index_width'); ?></th>
							<th class="min-desktop"><?php echo lang('index_height'); ?></th>
							<th class="min-desktop"><?php echo lang('index_name'); ?></th>
							<th class="min-desktop"><?php echo lang('index_file'); ?></th>
							<th class="min-desktop"><?php echo lang('index_thumb'); ?></th>

							<th class="none"><?php echo lang('index_created_on')?></th>
							<th class="none"><?php echo lang('index_created_by')?></th>
							<th class="none"><?php echo lang('index_modified_on')?></th>
							<th class="none"><?php echo lang('index_modified_by')?></th>
							<th class="min-tablet"><?php echo lang('index_action')?></th>
						</tr>
					</thead>
				</table>
				<div id="thumbnails" class="row text-center"></div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo site_url('npm/datatables.net/js/jquery.dataTables.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-bs4/js/dataTables.bootstrap4.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/dropzone/dropzone.min.js'); ?>" type="text/javascript"></script>
<script>
Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");

	myDropzone.on("success", function(file, response) {

		var response = jQuery.parseJSON(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());
		} else {
		//	var buttons = '<button class="btn btn-mini btn-default btn-doc" data-name="' + response.document_name +'" data-src="' + site_url + response.document_file + '">Insert</button>';

			var name = response.document_name;
			var src = response.document_file;

			console.log(src);

			tinyMCE.execCommand('mceInsertContent', false, '<a href="' + asset_url + src + '">' + name + '</a>');

			// closes the modal
			$('#modal').modal('hide');

			// restores the modal content to loading state
			restore_modal();

		//	$('#new_documents').html(buttons);
		}
	});

	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": site_url + "files/documents/datatables",
		"lengthMenu": [[6, 27, 50, 100, 300, -1], [6, 27, 50, 100, 300, "All"]],
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
				"aTargets": [0],
				"mRender": function (data, type, full) {
					var buttons = '';

					buttons = '<button class="btn btn-mini btn-default btn-doc" data-name="' + full[1] +'" data-src="' + asset_url + full[2] + '">Insert</button>';

					return '<div class="col-mini-6 col-sm-4 col-md-4 col-lg-4"><div class="thumbnail mb-3"><a data-toggle="modal" data-target="#modal" class="close" href="documents/delete/' + full[0] + '">&times;</a><a href="' + 'documents/view/' + full[0] + '" data-toggle="modal" data-target="#modal"><div><strong>' + full[1] + '</strong></div><div class="caption text-center"><strong>' + buttons + '</strong></div><i class="' + full[3] + '" aria-hidden="true"></i></a></div></div>';
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
			$('#datatables').hide();

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

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});

// $('#thumbnails').on("hover", ".thumbnail", function() {
// 	console.log($(this).attr('data-id'));
// });
/*
$('#new_documents').on("click", ".btn-doc", function() {
	// remove the dropzone
	$('#dropzone').hide();

	// insert the image
	var name = $(this).attr('data-name');
	var src = $(this).attr('data-src');
	tinyMCE.execCommand('mceInsertContent', false, '<a href="' + src + '">' + name + '</a>');

	// closes the modal
	$('#modal').modal('hide');

	// restores the modal content to loading state
	restore_modal();
}); */

$('#thumbnails').on("click", ".btn-doc", function() {
	// remove the dropzone
	$('#dropzone').hide();

	// insert the image
	var name = $(this).attr('data-name');
	var src = $(this).attr('data-src');
	tinyMCE.execCommand('mceInsertContent', false, '<a href="' + src + '">' + name + '</a>');

	// closes the modal
	$('#modal').hide();

	// restores the modal content to loading state
	restore_modal();
});

$( "#thumbnails" ).on( "mouseenter", ".thumbnail", function( event ) {
	$(this).find('.caption').slideDown(250);
}).on( "mouseleave", ".thumbnail", function( event ) {
	$(this).find('.caption').slideUp(250);
});
</script>