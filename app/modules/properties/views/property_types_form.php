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
			<label for="property_type_name"><?php echo lang('property_type_name')?>:</label><span class="error_asterisk"> *</span>				
			<?php echo form_input(array('id'=>'property_type_name', 'name'=>'property_type_name', 'value'=>set_value('property_type_name', isset($record->property_type_name) ? $record->property_type_name : ''), 'class'=>'form-control'));?>

			<?php echo form_input(array('id'=>'property_type_name_original', 'name'=>'property_type_name_original', 'style' => 'display:none' , 'value'=>set_value('property_type_name_original', isset($record->property_type_name) ? $record->property_type_name : ''), 'class'=>'form-control'));?>
			<div id="error-property_type_name"></div>			
		</div>

		<div class="form-group">
			<label for="property_type_status"><?php echo lang('property_type_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('property_type_status', $options, set_value('property_type_status', (isset($record->property_type_status)) ? $record->property_type_status : ''), 'id="property_type_status" class="form-control"'); ?>
			<div id="error-property_type_status"></div>
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