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
			<label for="seller_first_name"><?php echo lang('seller_first_name')?>:</label>			
			<?php echo form_input(array('id'=>'seller_first_name', 'name'=>'seller_first_name', 'value'=>set_value('seller_first_name', isset($record->seller_first_name) ? $record->seller_first_name : ''), 'class'=>'form-control'));?>
			<div id="error-seller_first_name"></div>			
		</div>

		<div class="form-group">
			<label for="seller_middle_name"><?php echo lang('seller_middle_name')?>:</label>			
			<?php echo form_input(array('id'=>'seller_middle_name', 'name'=>'seller_middle_name', 'value'=>set_value('seller_middle_name', isset($record->seller_middle_name) ? $record->seller_middle_name : ''), 'class'=>'form-control'));?>
			<div id="error-seller_middle_name"></div>			
		</div>

		<div class="form-group">
			<label for="seller_last_name"><?php echo lang('seller_last_name')?>:</label>			
			<?php echo form_input(array('id'=>'seller_last_name', 'name'=>'seller_last_name', 'value'=>set_value('seller_last_name', isset($record->seller_last_name) ? $record->seller_last_name : ''), 'class'=>'form-control'));?>
			<div id="error-seller_last_name"></div>			
		</div>

		<div class="form-group">
			<label for="seller_email"><?php echo lang('seller_email')?>:</label>			
			<?php echo form_input(array('id'=>'seller_email', 'name'=>'seller_email', 'value'=>set_value('seller_email', isset($record->seller_email) ? $record->seller_email : ''), 'class'=>'form-control'));?>
			<div id="error-seller_email"></div>			
		</div>

		<div class="form-group">
			<label for="seller_mobile"><?php echo lang('seller_mobile')?>:</label>			
			<?php echo form_input(array('id'=>'seller_mobile', 'name'=>'seller_mobile', 'value'=>set_value('seller_mobile', isset($record->seller_mobile) ? $record->seller_mobile : ''), 'class'=>'form-control'));?>
			<div id="error-seller_mobile"></div>			
		</div>

		<div class="form-group">
			<label for="seller_address"><?php echo lang('seller_address')?>:</label>			
			<?php echo form_textarea(array('id'=>'seller_address', 'name'=>'seller_address', 'rows'=>'3', 'value'=>set_value('seller_address', isset($record->seller_address) ? $record->seller_address : ''), 'class'=>'form-control')); ?>
			<div id="error-seller_address"></div>			
		</div>

		<div class="form-group">
			<label class=" control-label" for="seller_group_id"><?php echo lang('seller_group_id')?>:</label>
				<?php echo form_dropdown('seller_group_id', $seller_groups, set_value('seller_group_id', (isset($record->seller_group_id)) ? $record->seller_group_id : ''), 'id="seller_group_id" class="form-control"'); ?>
				<div id="error-seller_group_id"></div>
		</div>

		<div class="form-group">
			<label class="control-label" for="seller_status"><?php echo lang('seller_status')?>:</label>
				<?php $options = create_dropdown('array', ',Active,Disabled'); ?>
				<?php echo form_dropdown('seller_status', $options, set_value('seller_status', (isset($record->seller_status)) ? $record->seller_status : ''), 'id="seller_status" class="form-control"'); ?>
				<div id="error-seller_status"></div>
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