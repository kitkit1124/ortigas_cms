<div class="box">
	<form method="POST" action="<?php echo base_url() ?>files/images/crop">
		<input type="hidden" name="cropx" id="cropx" value="0" />
		<input type="hidden" name="cropy" id="cropy" value="0" />
		<input type="hidden" name="cropw" id="cropw" value="0" />
		<input type="hidden" name="croph" id="croph" value="0" />
		<input type="hidden" name="cropname" id="cropname" value="<?php echo $record->image_name ?>" />
		<input type="hidden" name="path" id="path" value="<?php echo site_url($record->image_file); ?>" />
		<input type="hidden" name="path_only" id="path_only" value="<?php echo $record->image_file; ?>" />
		<input type="submit" id="btncrop" value="Crop" class="btn btn-default" data-loading-text="<?php echo lang('processing')?>" />
	</form> <br />
	<div id="interface" class="full-image">
		<img src="<?php echo site_url($record->image_file); ?>" class="img-responsive" id="target" />
	</div>
</div>