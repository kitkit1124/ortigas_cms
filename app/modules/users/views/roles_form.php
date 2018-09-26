<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>


<div class="modal-body">
		
	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

		<div class="form-group">
			<label for="group_name"><?php echo lang('label_role')?>:</label> 
			<?php echo form_input(array('id'=>'group_name', 'name'=>'group_name', 'value'=>set_value('group_name', isset($record->name) ? $record->name : ''), 'class'=>'form-control'));?>
			<div id="error-group_name"></div>
		</div>

		<div class="form-group">
			<label for="group_description"><?php echo lang('label_description')?>:</label>
			<?php echo form_textarea(array('id'=>'group_description', 'name'=>'group_description', 'rows'=>'5', 'value'=>set_value('group_description', isset($record->description) ? $record->description : ''), 'class'=>'form-control')); ?>
			<div id="error-group_description"></div>
		</div>
	
	</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if ($page_type == 'add'): ?>
		<button id="submit" class="btn btn-primary" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php else: ?>
		<button id="submit" class="btn btn-primary" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php endif; ?>
</div>