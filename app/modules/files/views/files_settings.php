<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">				
			</div>			
			<div class="card-body">
				<div class="nav-tabs-custom bottom-margin">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_images" data-toggle="tab"><span class="fa fa-file-image-o"></span> Images</a></li>
						<!-- <li><a href="#tab_documents" data-toggle="tab"><span class="fa fa-file-text-o"></span> Documents</a></li> -->
						<li><a href="#tab_videos" data-toggle="tab"><span class="fa fa-file-video-o"></span> Videos</a></li>
					</ul>
					<div class="tab-content">

						<div class="tab-pane active" id="tab_images">
							<br>
							<div class="form-horizontal">

								<?php if ($configs_img): ?>
									<?php foreach ($configs_img as $config): ?>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="<?php echo $config->config_name; ?>"><?php echo $config->config_label; ?>:</label>
											<div class="col-sm-4">
												<?php echo form_input(array('id'=>$config->config_name, 'name'=>$config->config_name, 'value'=>set_value($config->config_name, $config->config_value), 'class'=>'form-control')); ?>
												<div class="help-text"><?php echo $config->config_notes; ?></div>
												<div id="error-<?php echo $config->config_name; ?>"></div>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>

							</div>
							
						</div>

						<div class="tab-pane" id="tab_documents">
							
						</div>

						<div class="tab-pane" id="tab_videos">

							<div class="form-horizontal">

								<?php if ($configs_vid): ?>
									<?php foreach ($configs_vid as $config): ?>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="<?php echo $config->config_name; ?>"><?php echo $config->config_label; ?>:</label>
											<div class="col-sm-4">
												<?php echo form_input(array('id'=>$config->config_name, 'name'=>$config->config_name, 'value'=>set_value($config->config_name, $config->config_value), 'class'=>'form-control')); ?>
												<div class="help-text"><?php echo $config->config_notes; ?></div>
												<div id="error-<?php echo $config->config_name; ?>"></div>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>

							</div>
							
						</div>
					</div>
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
<script>var post_url = '<?php echo current_url() ?>';</script>