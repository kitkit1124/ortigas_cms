<link href="<?php echo site_url('npm/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo 'Upload Image'?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	

	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item active"><a href="#tab_1"  class="nav-link" data-toggle="tab">Upload Image</a></li>
		<li class="nav-item"><a href="#tab_2"  class="nav-link "data-toggle="tab">Add Existing Image</a></li>
	</ul>
	<div class="tab-content" data-target="">	

		<div class="tab-pane active" id="tab_1">
			<div class="form">
				<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
					<div class="fallback">
						<input name="file" type="file"/>
					</div>
				<?php echo form_close();?> 
				<p class="note">
					<i style="float: left;margin-left: 6px;">Recommended file type JPEG | PNG</i>
					<i style="float: right; margin-right: 6px;"> Max file size: 2.0 Mb</i>
					<br>
					<i style="float: left;margin-left: 6px;">Ideal image size: 1920 x 400</i>
					<span style="clear: both;"></span>
				</p>
			</div>
		</div>

		<div class="tab-pane" id="tab_2">
			<table class="table table-striped table-bordered table-hover dt-responsive" id="dt-images">
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

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
</div>	
<script>
var site_url = '<?php echo site_url() ?>';
</script>

