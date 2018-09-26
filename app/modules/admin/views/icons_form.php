<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only"><?php echo lang('button_close')?></span>
	</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo $page_heading?></h4>
</div>

<div class="modal-body">

	<div class="form-horizontal">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

		<div class="form-group">
			<label class="col-sm-3 control-label" for="icon_group"><?php echo lang('icon_group')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'icon_group', 'name'=>'icon_group', 'value'=>set_value('icon_group', isset($record->icon_group) ? $record->icon_group : ''), 'class'=>'form-control'));?>
				<div id="error-icon_group"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="icon_code"><?php echo lang('icon_code')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'icon_code', 'name'=>'icon_code', 'value'=>set_value('icon_code', isset($record->icon_code) ? $record->icon_code : ''), 'class'=>'form-control'));?>
				<div id="error-icon_code"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="icon_status"><?php echo lang('icon_status')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Active,Inactive'); ?>
				<?php echo form_dropdown('icon_status', $options, set_value('icon_status', (isset($record->icon_status)) ? $record->icon_status : ''), 'id="icon_status" class="form-control"'); ?>
				<div id="error-icon_status"></div>
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