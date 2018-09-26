<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<div class="form">
		<div class="col-xs-12">
			<div class="form-group">
				<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone')); ?>
				<div class="fallback">
					<input name="file" type="file" class="d-none" />
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>


