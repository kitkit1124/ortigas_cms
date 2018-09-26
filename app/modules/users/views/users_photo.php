<div class="row mt-5">
	<div class="offset-md-4 col-md-3 text-center">

		<?php echo form_open(current_url(), array('class'=>'dropzone', 'id' => 'dropzone'));?>
			<div class="fallback">
				<input name="file" type="file" multiple />
			</div>
		<?php echo form_close();?>

	</div>
</div>