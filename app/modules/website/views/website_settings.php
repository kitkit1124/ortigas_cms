<section id="roles">
	<div class="container-fluid">
		<div class="card">			
			<div class="card-body">
				
				<div class="form">

					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />


					<?php if ($configs): ?>
						<?php foreach ($configs as $config): ?>
							<div class="form-group row">
								<label for="<?php echo $config->config_name; ?>" class="col-sm-3 col-form-label"><?php echo $config->config_label; ?>:</label>
								<div class="col-sm-9">
									<?php if ($config->config_type == 'input' OR $config->config_type == 'text'): ?>
										<?php echo form_input(array('id'=>$config->config_name, 'name'=>$config->config_name, 'value'=>set_value($config->config_name, $config->config_value), 'class'=>'form-control')); ?>
									<?php elseif ($config->config_type == 'textarea'): ?>
										<?php echo form_textarea(array('id'=>$config->config_name, 'name'=>$config->config_name, 'rows'=>'10', 'value'=>set_value($config->config_name, isset($config->config_value) ? $config->config_value : '', TRUE), 'class'=>'form-control')); ?>
									<?php elseif ($config->config_type == 'dropdown'): ?>
										<?php $options = create_dropdown('array', $config->config_values); ?>
										<?php echo form_dropdown($config->config_name, $options, set_value($config->config_name, (isset($config->config_value)) ? $config->config_value: ''), 'id="' . $config->config_name . '" class="form-control"'); ?>
									<?php endif; ?>
									<small class="form-text"><?php echo $config->config_notes; ?></small>
									<div id="error-<?php echo $config->config_name; ?>"></div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>


				</div>
				

				<div class="clearfix form-actions">
					<button id="submit" class="btn btn-info" type="button" data-loading-text="<?php echo lang('processing')?>">
						<i class="ace-icon fa fa-save bigger-110"></i>
						Save Changes
					</button>
				</div>
			</div>
		</div>
</div>		
</section>			


<script>
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>