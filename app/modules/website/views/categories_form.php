<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

		<div class="form-group row">
			<label for="category_parent_id" class="col-sm-5 col-form-label"><?php echo lang('category_parent_id')?>:</label>
			<div class="col-sm-7">
				<?php echo form_dropdown('category_parent_id', $categories, set_value('category_parent_id', (isset($record->category_parent_id)) ? $record->category_parent_id : ''), 'id="category_parent_id" class="form-control"'); ?>
				<div id="error-category_parent_id"></div>
			</div>
		</div>

		<div class="form-group row">
			<label for="category_name" class="col-sm-5 col-form-label"><?php echo lang('category_name')?>: &nbsp;<span id="error-asterisk-category_name" class="error_asterisk">*</span></label>
			<div class="col-sm-7">
				<?php echo form_input(array('id'=>'category_name', 'name'=>'category_name', 'value'=>set_value('category_name', isset($record->category_name) ? $record->category_name : ''), 'class'=>'form-control'));?>
				<div id="error-category_name"></div>
			</div>
		</div>

		<div class="form-group row">
			<label for="category_layout" class="col-sm-5 col-form-label"><?php echo lang('category_layout')?>:</label>
			<div class="col-sm-7">
				<?php echo form_dropdown('category_layout', config_item('theme_layouts'), set_value('category_layout', (isset($record->category_layout)) ? $record->category_layout : ''), 'id="category_layout" class="form-control"'); ?>
				<div id="error-category_layout"></div>
			</div>
		</div>

		<div class="form-group row">
			<label for="category_status" class="col-sm-5 col-form-label"><?php echo lang('category_status')?>:</label>
			<div class="col-sm-7">
				<div class="radio">
					<label>
						<input class="category_status" name="category_status" type="radio" value="Active" <?php echo set_radio('category_status', 'Active', ($action == 'add' OR isset($record->category_status) && $record->category_status == 'Active') ? TRUE : FALSE); ?> /> Active
					</label>
				</div>
				<div class="radio">
					<label>
						<input class="category_status" name="category_status" type="radio" value="Disabled" <?php echo set_radio('category_status', 'Disabled', (isset($record->category_status) && $record->category_status == 'Disabled') ? TRUE : FALSE); ?> /> Disabled
					</label>
				</div>
				<div id="error-category_status"></div>
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