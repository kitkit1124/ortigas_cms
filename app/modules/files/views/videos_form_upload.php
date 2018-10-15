<link href="<?php echo site_url('npm/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="modal-header">
	<h5 class="modal-title" id="modalLabel">Video Upload</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="form">
		<?php echo form_open(site_url('files/videos/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
			<div class="fallback">
				<input name="file" type="file"/>
			</div>
		<?php echo form_close();?> 
		<p class="note"><i style="float: left;margin-left: 6px;">Recommended file type MP4 | AVI</i> <i style="float: right; margin-right: 6px;"> Max file size: ?.0 Mb</i><span style="clear: both;"></span></p>
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

