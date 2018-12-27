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
		<label for="division_department_id"><?php echo lang('division_department_id')?>:</label>
			<?php echo form_dropdown('division_department_id', $departments, set_value('division_department_id', (isset($record->division_department_id)) ? $record->division_department_id : ''), 'id="division_department_id" class="form-control"'); ?>
			<?php echo form_dropdown('division_department_id_original', $departments, set_value('division_department_id_original', (isset($record->division_department_id)) ? $record->division_department_id : ''), 'id="division_department_id_original" style="display:none"'); ?>
			<div id="error-division_department_id"></div>
		</div>

		<div class="form-group">
			<label for="division_name"><?php echo lang('division_name')?>:</label><span class="error_asterisk"> *</span>				
			<?php echo form_input(array('id'=>'division_name', 'name'=>'division_name', 'value'=>set_value('division_name', isset($record->division_name) ? $record->division_name : ''), 'class'=>'form-control'));?>
			<?php echo form_input(array('id'=>'division_name_original', 'name'=>'division_name_original', 'value'=>set_value('division_name_original', isset($record->division_name) ? $record->division_name : ''), 'style'=>'display:none'));?>
			<div id="error-division_name"></div>			
		</div>

		<div class="form-group">
			<label for="division_status"><?php echo lang('division_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('division_status', $options, set_value('division_status', (isset($record->division_status)) ? $record->division_status : ''), 'id="division_status" class="form-control"'); ?>
			<div id="error-division_status"></div>
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