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
			<label for="subscriber_email"><?php echo lang('subscriber_email')?>:</label>			
			<?php echo form_input(array('id'=>'subscriber_email', 'name'=>'subscriber_email', 'value'=>set_value('subscriber_email', isset($record->subscriber_email) ? $record->subscriber_email : ''), 'class'=>'form-control'));?>
			<div id="error-subscriber_email"></div>			
		</div>

		<div class="form-group">
			<label for="subscriber_status"><?php echo lang('subscriber_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('subscriber_status', $options, set_value('subscriber_status', (isset($record->subscriber_status)) ? $record->subscriber_status : ''), 'id="subscriber_status" class="form-control"'); ?>
			<div id="error-subscriber_status"></div>
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