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
			<label for="seller_group_name"><?php echo lang('seller_group_name')?>:</label>			
			<?php echo form_input(array('id'=>'seller_group_name', 'name'=>'seller_group_name', 'value'=>set_value('seller_group_name', isset($record->seller_group_name) ? $record->seller_group_name : ''), 'class'=>'form-control'));?>
			<div id="error-seller_group_name"></div>			
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="seller_group_status"><?php echo lang('seller_group_status')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Active,Disabled'); ?>
				<?php echo form_dropdown('seller_group_status', $options, set_value('seller_group_status', (isset($record->seller_group_status)) ? $record->seller_group_status : ''), 'id="seller_group_status" class="form-control"'); ?>
				<div id="error-seller_group_status"></div>
			</div>
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