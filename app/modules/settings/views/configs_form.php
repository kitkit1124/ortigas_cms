<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<?php echo form_open(current_url(), array('id' => 'form'));?>

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
		<div class="form-group">
			
			<label class="control-label"><?php echo $config->config_label; ?>:</label>

			<?php if ($config->config_type == 'input' OR $config->config_type == 'text'): ?>
				<?php echo form_input(array('id'=>'config_value', 'name'=>'config_value', 'value'=>set_value('config_value', $config->config_value), 'class'=>'form-control')); ?>

			<?php elseif ($config->config_type == 'textarea'): ?>
				<?php echo form_textarea(array('id'=>'config_value', 'name'=>'config_value', 'rows'=>'10', 'value'=>set_value('config_value', isset($config->config_value) ? $config->config_value : '', TRUE), 'class'=>'form-control')); ?>

			<?php elseif ($config->config_type == 'dropdown'): ?>
				<?php $options = create_dropdown('array', $config->config_values); ?>
				<?php echo form_dropdown('config_value', $options, set_value('config_value', (isset($config->config_value)) ? $config->config_value: ''), 'id="' . 'config_value' . '" class="form-control"'); ?>

			<!-- For Social Buttons -->
			<?php elseif ($config->config_type == 'input,checkbox'): ?>
				<?php if ($config_value = json_decode($config->config_value)) : ?>

					<div class="clearfix">
						<?php foreach ($config_value as $key => $value) : ?>
							<div class="form-group clearfix">
								<label class="col-xs-6 col-sm-3 control-label" for="<?php echo $value->id ?>"><?php echo $value->name; ?>:</label>
								<div class="col-xs-6 col-sm-3">
									<input type="checkbox" id="<?php echo $value->id?>" data-name="<?php echo $value->name?>" value="1" <?php echo $value->status==1 ? 'checked' : '' ?> class="form-control ace ace-switch ace-switch-4 btn-flat social-button-status" />
									<span class="lbl pull-left"></span>
								</div>
								<label class="col-xs-12 col-sm-2 control-label" for="<?php echo $value->id ?>_icon">Icon: </label>
								<div class="col-xs-12 col-sm-4">
									<input type="text" id="<?php echo $value->id ?>_icon" data-name="<?php echo $value->name?>" value="<?php echo $value->icon; ?>" class="form-control social-button-icon" />
									<span class="lbl pull-left"></span>
								</div>
							</div>
						<?php endforeach; ?>						
					</div>
				<?php endif; ?>

			<?php endif; ?>
			<div id="error-config_value"></div>
			<div class="help-block"><?php echo $config->config_notes; ?></div>
		</div>
	<?php echo form_close();?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>
	</button>
	<?php if($page_type == 'add'): ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_add')?>
		</button>
	<?php else: ?>
		<button id="submit" class="btn btn-success" type="submit" data-loading-text="<?php echo lang('processing')?>">
			<i class="fa fa-save"></i> <?php echo lang('button_update')?>
		</button>
	<?php endif; ?>
</div>