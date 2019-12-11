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
			<label class=" control-label" for="reservation_customer_id">Customer Name</label>
			
			
				<?php echo form_dropdown('reservation_customer_id', $customers, set_value('reservation_customer_id', (isset($record->reservation_customer_id)) ? $record->reservation_customer_id : ''), 'id="reservation_customer_id" class="form-control"'); ?>
				<div id="error-reservation_customer_id"></div>
			
		</div>

		<!-- <div class="form-group">
			<label for="reservation_reference_no"><?php echo lang('reservation_reference_no')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_reference_no', 'name'=>'reservation_reference_no', 'value'=>set_value('reservation_reference_no', isset($record->reservation_reference_no) ? $record->reservation_reference_no : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_reference_no"></div>			
		</div> -->

		<div class="form-group">
			<label for="reservation_project"><?php echo lang('reservation_project')?>:</label>		

			<?php echo form_dropdown('reservation_project', $properties, set_value('reservation_project', (isset($record->reservation_project)) ? $record->reservation_project : ''), 'id="reservation_project" class="form-control"'); ?>
				<div id="error-reservation_project"></div>
	
			<!-- <?php echo form_input(array('id'=>'reservation_project', 'name'=>'reservation_project', 'value'=>set_value('reservation_project', isset($record->reservation_project) ? $record->reservation_project : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_project"></div>		 -->	
		</div>

		<div class="form-group">
			<label for="reservation_property_specialist"><?php echo lang('reservation_property_specialist')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_property_specialist', 'name'=>'reservation_property_specialist', 'value'=>set_value('reservation_property_specialist', isset($record->reservation_property_specialist) ? $record->reservation_property_specialist : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_property_specialist"></div>			
		</div>

		<div class="form-group">
			<label for="reservation_sellers_group"><?php echo lang('reservation_sellers_group')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_sellers_group', 'name'=>'reservation_sellers_group', 'value'=>set_value('reservation_sellers_group', isset($record->reservation_sellers_group) ? $record->reservation_sellers_group : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_sellers_group"></div>			
		</div>

		<div class="form-group">
			<label for="reservation_unit_details"><?php echo lang('reservation_unit_details')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_unit_details', 'name'=>'reservation_unit_details', 'value'=>set_value('reservation_unit_details', isset($record->reservation_unit_details) ? $record->reservation_unit_details : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_unit_details"></div>			
		</div>

		<div class="form-group">
			<label for="reservation_allocation"><?php echo lang('reservation_allocation')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_allocation', 'name'=>'reservation_allocation', 'value'=>set_value('reservation_allocation', isset($record->reservation_allocation) ? $record->reservation_allocation : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_allocation"></div>			
		</div>

		<div class="form-group">
			<label for="reservation_fee"><?php echo lang('reservation_fee')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_fee', 'name'=>'reservation_fee', 'value'=>set_value('reservation_fee', isset($record->reservation_fee) ? $record->reservation_fee : ''), 'class'=>'form-control'));?>
			<div id="error-reservation_fee"></div>			
		</div>

		<div class="form-group">
			<label for="reservation_notes"><?php echo lang('reservation_notes')?>:</label>			
			<?php echo form_textarea(array('id'=>'reservation_notes', 'name'=>'reservation_notes', 'rows'=>'3', 'value'=>set_value('reservation_notes', isset($record->reservation_notes) ? $record->reservation_notes : ''), 'class'=>'form-control')); ?>
			<div id="error-reservation_notes"></div>			
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