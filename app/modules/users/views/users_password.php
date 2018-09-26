<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<?php echo form_open(current_url(), array('class'=>'form'));?>

		<div class="form-group">
			<label for="old"><?php echo lang('old')?>:</label>
			<?php echo form_password(array('id'=>'old', 'name'=>'old', 'value'=>set_value('old'), 'class'=>'form-control'));?>
			<div id="error-old"></div>
		</div>

		<div class="form-group">
			<label for="new"><?php echo lang('new')?>:</label>
			<?php echo form_password(array('id'=>'new', 'name'=>'new', 'value'=>set_value('new'), 'class'=>'form-control'));?>
			<div id="error-new"></div>
		</div>

		<div class="form-group">
			<label for="new_confirm"><?php echo lang('new_confirm')?>:</label>
			<?php echo form_password(array('id'=>'new_confirm', 'name'=>'new_confirm', 'value'=>set_value('new_confirm'), 'class'=>'form-control'));?>
			<div id="error-new_confirm"></div>
		</div>

	<?php echo form_close();?>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>

	<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
		<i class="fa fa-save"></i> <?php echo lang('button_password')?>
	</button>
</div>