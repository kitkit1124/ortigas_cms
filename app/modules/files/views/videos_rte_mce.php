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
		overflow: hidden;
		padding: 10px 0;
		border: 0 solid;
		height: 120px;
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
	.img-vid {
		width:90%;
		margin:0 3%;
	}

</style>
<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Add Videos</a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Add Existing Videos</a></li>
	</ul>
	<div class="tab-content mt-3">
		<div class="tab-pane active" id="tab_1">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<?php echo form_open(site_url('files/videos/form'));?>
						<div class="form-group">
							<label for="video_link_id">Video ID:</label>
							<input type="text" name="video_link_id" value="" id="video_link_id" class="form-control" />
							<div id="error-video_link"></div>
						</div>
						<div class="form-group">
							<label for="video_type"><?php echo lang('video_type')?>:</label>
							<select name="video_type" id="video_type" class="form-control">
								<option value="Youtube">Youtube</option>
								<!-- <option value="Vimeo">Vimeo</option> -->
							</select>
							<div id="error-video_type"></div>
							<p class="help-block">
								Instructions : <br /> youtube - https://www.youtube.com/watch?v=qZFLz1-23tk the ID is after v= which is <b>qZFLz1-23tk</b>. <!-- <br />
								vimeo - https://vimeo.com/174304761 the ID is after domain name which is <b>174304761</b>. -->
							</p>
						</div>
						<div class="form-group">
							<div class="col-sm-9 col-sm-offset-2">
								<button id="submit" class="btn btn-default">Add</button>
							</div>
						</div>
						<?php echo form_close();?>
					</div>
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
<script src="<?php echo site_url('npm/datatables.net/js/jquery.dataTables.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-bs4/js/dataTables.bootstrap4.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('npm/dropzone/dropzone.min.js'); ?>" type="text/javascript"></script>
<script>
Dropzone.autoDiscover = false;

$(function() {
	var oTable = $('#datatables').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": site_url + "files/videos/datatables",
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
					var imgVid;

					var buttons = '';
					buttons = '<button class="btn btn-mini btn-default btn-vid" data-type="' + full[3] + '" data-name="' + full[1] +'" data-src="' + full[2] + '">Insert</button> ';

					imgVid =  full[4];

					return '<div class="col-sm-4 col-md-4 col-lg-4"><div class="thumbnail thumbnail-custom mb-4"><a href="' + 'videos/view/' + full[0] + '" data-toggle="modal" data-target="#modal"><div><strong>' + full[1] + '</strong></div><img id="img' + full[2] + '" src="' + imgVid + '" alt="' + full[1] + '" class="img-responsive img-vid"><div class="caption text-center"><h5>' + buttons + '</h5></div></a></div></div>';
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

	// handles the submit action
	$('#submit').click(function(e){
		// change the button to loading state
		var btn = $(this);
		btn.button('loading');

		// prevents a submit button from submitting a form
		e.preventDefault();

		// submits the data to the backend
		$.post(site_url + 'files/videos/form', {
			video_name: $('#page_title').val() + ' Video',
			video_link_id: $('#video_link_id').val(),
			video_type: $('#video_type').val(),

			[csrf_name]: $('input[name=' + csrf_name + ']').val(),

		},
		function(data, status){
			// handles the returned data
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// reset the button
				btn.button('reset');

				// shows the error message
				alertify.error(o.message);

				// displays individual error messages
				if (o.errors) {
					for (var form_name in o.errors) {
						$('#error-' + form_name).html(o.errors[form_name]);
					}
				}
			} else {

				if(o.info.video_type == "Youtube") {
					tinyMCE.execCommand('mceInsertContent', false, '<p></p><div class="tinymce-clear"><div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" type="text/html" src="https://www.youtube.com/embed/' + o.info.video_link_id + '"></iframe></div></div><p></p>');
				} else if(o.info.video_type == "Vimeo") {
					tinyMCE.execCommand('mceInsertContent', false, '<p></p><div class="tinymce-clear"><div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' + o.info.video_link_id + '"></iframe></div></div><p></p>');
				}

				$('#video_name').val('');
				$('#video_link_id').val('');

				// shows the success message
				alertify.success(o.message);

				// closes the modal
				$('#modal').modal('hide');

				// restores the modal content to loading state
				restore_modal();
			}
		});
	});
});

// $('#thumbnails').on("hover", ".thumbnail", function() {
// 	console.log($(this).attr('data-id'));
// });
/*
$('#new_video').on("click", ".btn-vid", function() {
	// remove the dropzone
	$('#dropzone').hide();

	// insert the image
	var name = $(this).attr('data-name');
	var src = $(this).attr('data-src');
	var type = $(this).attr('data-type');
	if(type == "Youtube") {
		tinyMCE.execCommand('mceInsertContent', false, '<div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" type="text/html" src="https://www.youtube.com/embed/' + src + '" frameborder="0"><p>Your browser does not support iframe.</p></iframe></div><p></p>');
	} else if(type == "Vimeo") {
		tinyMCE.execCommand('mceInsertContent', false, '<div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' + src + '" frameborder="0"><p>Your browser does not support iframe.</p></iframe></div><p></p>');
	}

	// closes the modal
	$('#modal').modal('hide');

	// restores the modal content to loading state
	restore_modal();
}); */

$('#thumbnails').on("click", ".btn-vid", function() {
	var html = '';
	// remove the dropzone
	$('#dropzone').hide();

	// insert the image
	var name = $(this).attr('data-name');
	var src = $(this).attr('data-src');
	var type = $(this).attr('data-type');
	if(type == "Youtube") {
		html = '<p></p><div class="tinymce-clear"><div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" type="text/html" src="https://www.youtube.com/embed/' + src + '"></iframe></div></div><p></p>';
		tinyMCE.EditorManager.execCommand('mceRemoveEditor',true,'embed-responsive');
	} else if(type == "Vimeo") {
		html = '<p></p><div class="tinymce-clear"><div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' + src + '"></iframe></div></div><p></p>';
	}
	tinyMCE.execCommand('mceInsertContent', false, html);
	//$("#page_content").html(html);
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