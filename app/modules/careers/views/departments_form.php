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
		<label for="department_division_id"><?php echo lang('department_division_id')?>:</label><span class="error_asterisk"> *</span>	
			<?php echo form_dropdown('department_division_id', $divisions, set_value('department_division_id', (isset($record->department_division_id)) ? $record->department_division_id : ''), 'id="department_division_id" class="form-control"'); ?>
			<?php echo form_dropdown('department_division_id_original', $divisions, set_value('department_division_id_original', (isset($record->department_division_id)) ? $record->department_division_id : ''), 'id="department_division_id_original" style="display:none"'); ?>
			<div id="error-department_division_id"></div>
		</div>

		<div class="form-group">
			<label for="department_name"><?php echo lang('department_name')?>:</label><span class="error_asterisk"> *</span>				
			<?php echo form_input(array('id'=>'department_name', 'name'=>'department_name', 'value'=>set_value('department_name', isset($record->department_name) ? $record->department_name : '',false), 'class'=>'form-control'));?>
			<?php echo form_input(array('id'=>'department_name_original', 'name'=>'department_name_original', 'value'=>set_value('department_name_original', isset($record->department_name) ? $record->department_name : '',false), 'style'=>'display:none'));?>
			<div id="error-department_name"></div>			
		</div>

		<div class="form-group">
			<label for="department_status"><?php echo lang('department_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('department_status', $options, set_value('department_status', (isset($record->department_status)) ? $record->department_status : ''), 'id="department_status" class="form-control"'); ?>
			<div id="error-department_status"></div>
		</div>



	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if ($action == 'add'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php elseif ($action == 'edit'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php else: ?>
		<script>$(".modal-body :input").attr("disabled", true);</script>
	<?php endif; ?>
</div>	