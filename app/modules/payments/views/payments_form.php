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
			<label for="payment_reservation_id"><?php echo lang('payment_reservation_id')?>:</label>			
			<?php echo form_input(array('id'=>'payment_reservation_id', 'name'=>'payment_reservation_id', 'value'=>set_value('payment_reservation_id', isset($record->payment_reservation_id) ? $record->payment_reservation_id : ''), 'class'=>'form-control'));?>
			<div id="error-payment_reservation_id"></div>			
		</div>

		<div class="form-group">
			<label for="payment_paynamics_no"><?php echo lang('paynamics_reference_no')?>:</label>			
			<?php echo form_input(array('id'=>'payment_paynamics_no', 'name'=>'payment_paynamics_no', 'rows'=>'3', 'value'=>set_value('payment_paynamics_no', isset($record->payment_paynamics_no) ? $record->payment_paynamics_no : ''), 'class'=>'form-control')); ?>
			<div id="error-payment_paynamics_no"></div>			
		</div>
		<div class="form-group">
			<label for="fullname"><?php echo lang('fullname')?>:</label>			
			<?php echo form_input(array('id'=>'fullname', 'name'=>'fullname', 'rows'=>'3', 'value'=>set_value('fullname', isset($record->customer_fname) ? $record->customer_fname." ".$record->customer_lname : ''), 'class'=>'form-control')); ?>
			<div id="error-fullname"></div>			
		</div>
		<div class="form-group">
			<label for="reservation_project"><?php echo lang('reservation_project')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_project', 'name'=>'reservation_project', 'rows'=>'3', 'value'=>set_value('reservation_project', isset($record->reservation_project) ? $record->reservation_project : ''), 'class'=>'form-control')); ?>
			<div id="error-reservation_project"></div>			
		</div>
		<div class="form-group">
			<label for="payment_type"><?php echo lang('payment_type')?>:</label>			
			<?php echo form_input(array('id'=>'payment_type', 'name'=>'payment_type', 'rows'=>'3', 'value'=>set_value('payment_type', isset($record->payment_type) ? $record->payment_type : ''), 'class'=>'form-control')); ?>
			<div id="error-payment_type"></div>			
		</div>
		<div class="form-group">
			<label for="reservation_fee"><?php echo lang('reservation_fee')?>:</label>			
			<?php echo form_input(array('id'=>'reservation_fee', 'name'=>'reservation_fee', 'rows'=>'3', 'value'=>set_value('reservation_fee', isset($record->reservation_fee) ? $record->reservation_fee : ''), 'class'=>'form-control')); ?>
			<div id="error-reservation_fee"></div>			
		</div>
		<div class="form-group">
			<label for="payment_status"><?php echo lang('payment_status')?>:</label>			
			<?php echo form_input(array('id'=>'payment_status', 'name'=>'payment_status', 'value'=>set_value('payment_status', isset($record->payment_status) ? $record->payment_status : ''), 'class'=>'form-control'));?>
			<div id="error-payment_status"></div>			
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