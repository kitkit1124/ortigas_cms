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
			<label for="payment_encoded_details"><?php echo lang('payment_encoded_details')?>:</label>			
			<?php echo form_textarea(array('id'=>'payment_encoded_details', 'name'=>'payment_encoded_details', 'rows'=>'3', 'value'=>set_value('payment_encoded_details', isset($record->payment_encoded_details) ? $record->payment_encoded_details : ''), 'class'=>'form-control')); ?>
			<div id="error-payment_encoded_details"></div>			
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