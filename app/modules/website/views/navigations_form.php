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
			<label class="col-sm-3 control-label" for="navigation_group_id"><?php echo lang('navigation_group_id')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'navigation_group_id', 'name'=>'navigation_group_id', 'value'=>set_value('navigation_group_id', isset($record->navigation_group_id) ? $record->navigation_group_id : ''), 'class'=>'form-control'));?>
				<div id="error-navigation_group_id"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_parent_id"><?php echo lang('navigation_parent_id')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'navigation_parent_id', 'name'=>'navigation_parent_id', 'value'=>set_value('navigation_parent_id', isset($record->navigation_parent_id) ? $record->navigation_parent_id : ''), 'class'=>'form-control'));?>
				<div id="error-navigation_parent_id"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_name"><?php echo lang('navigation_name')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'navigation_name', 'name'=>'navigation_name', 'value'=>set_value('navigation_name', isset($record->navigation_name) ? $record->navigation_name : ''), 'class'=>'form-control'));?>
				<div id="error-navigation_name"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_link"><?php echo lang('navigation_link')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'navigation_link', 'name'=>'navigation_link', 'value'=>set_value('navigation_link', isset($record->navigation_link) ? $record->navigation_link : ''), 'class'=>'form-control'));?>
				<div id="error-navigation_link"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_target"><?php echo lang('navigation_target')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Option 1,Option 2'); ?>
				<?php echo form_dropdown('navigation_target', $options, set_value('navigation_target', (isset($record->navigation_target)) ? $record->navigation_target : ''), 'id="navigation_target" class="form-control"'); ?>
				<div id="error-navigation_target"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_type"><?php echo lang('navigation_type')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Option 1,Option 2'); ?>
				<?php echo form_dropdown('navigation_type', $options, set_value('navigation_type', (isset($record->navigation_type)) ? $record->navigation_type : ''), 'id="navigation_type" class="form-control"'); ?>
				<div id="error-navigation_type"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="navigation_status"><?php echo lang('navigation_status')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Option 1,Option 2'); ?>
				<?php echo form_dropdown('navigation_status', $options, set_value('navigation_status', (isset($record->navigation_status)) ? $record->navigation_status : ''), 'id="navigation_status" class="form-control"'); ?>
				<div id="error-navigation_status"></div>
			</div>
		</div>



	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if ($action == 'add'): ?>
		<button id="submit" class="btn btn-success" type="submit">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php elseif ($action == 'edit'): ?>
		<button id="submit" class="btn btn-success" type="submit">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php else: ?>
		<script>$(".modal-body :input").attr("disabled", true);</script>
	<?php endif; ?>
</div>