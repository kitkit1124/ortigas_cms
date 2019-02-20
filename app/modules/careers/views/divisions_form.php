<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->division_id) AND isset($record->division_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/careers/divisions/' . $record->division_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">				
					<div class="row">
						<div class="col-sm-9">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							
							<div class="form-group">
								<label for="division_name"><?php echo lang('division_name')?>:</label><span class="error_asterisk"> *</span>				
								<?php echo form_input(array('id'=>'division_name', 'name'=>'division_name', 'value'=>set_value('division_name', isset($record->division_name) ? $record->division_name : '',false), 'class'=>'form-control'));?>
								<?php echo form_input(array('id'=>'division_name_original', 'name'=>'division_name_original', 'value'=>set_value('division_name_original', isset($record->division_name) ? $record->division_name : '',false), 'style'=>'display:none'));?>
								<div id="error-division_name"></div>			
							</div>

							<div class="form-group">
								<label for="division_content"><?php echo lang('division_content')?>:</label><span class="error_asterisk"> *</span>				
								<?php echo form_textarea(array('id'=>'division_content', 'name'=>'division_content', 'rows'=>'5', 'value'=>set_value('division_content', isset($record->division_content) ? $record->division_content : '', false), 'class'=>'form-control')); ?>
								<div id="error-division_content"></div>			
							</div>

							<div class="form-group bottom_text">
								<label for="division_seo_content"><?php echo lang('division_seo_content')?>:</label>			
								<?php echo form_textarea(array('id'=>'division_seo_content', 'name'=>'division_seo_content', 'rows'=>'5', 'value'=>set_value('division_seo_content', isset($record->division_seo_content) ? $record->division_seo_content : '', false), 'class'=>'form-control')); ?>
								<div id="error-division_seo_content"></div>			
							</div>


							<?php if(isset($record->division_id) && $record->division_id){ ?>

								<div id="related_link">
									<?php $data['section_id'] = $record->division_id; ?>
									<?php $data['section_type'] = 'divisions'; ?>
									<?php echo $this->load->view('properties/related_links_index', $data); ?>
								</div>

							<?php } ?>

						</div>
						<div class="col-sm-3">

							<div class="form-group">
								<label for="division_image"><?php echo lang('division_image')?>:</label><span class="error_asterisk"> *</span>				
								<br>
								<a style="padding: 0;" href="<?php echo site_url('/careers/divisions/form_upload/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
									<img id="division_active_photo" src="<?php echo isset($record->division_image) ? getenv('UPLOAD_ROOT').$record->division_image : site_url('ui/images/placeholder.png'); ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
								</a>
								<?php echo form_textarea(array('id'=>'division_alt_image', 'name'=>'division_alt_image', 'rows'=>'2', 'value'=>set_value('division_alt_image', isset($record->division_alt_image) ? $record->division_alt_image : '', false), 'class'=>'form-control', 'placeholder' => lang('division_alt_image'), 'title' => lang('division_alt_image') )); ?>
								<br />

								<div id="error-division_image"></div>	

								<div style="display: none;">
								<?php echo form_input(array('id'=>'division_image', 'name'=>'division_image', 'value'=>set_value('division_image', isset($record->division_image) ? $record->division_image : ''), 'class'=>'form-control'));?>
								</div>		
							</div>

							<div class="form-group">
								<label for="division_status"><?php echo lang('division_status')?>:</label>
								<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
								<?php echo form_dropdown('division_status', $options, set_value('division_status', (isset($record->division_status)) ? $record->division_status : ''), 'id="division_status" class="form-control"'); ?>
								<div id="error-division_status"></div>
							</div>

							<?php if ($action == 'add'): ?>
								<button id="post" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
									<i class="fa fa-save"></i> <?php echo lang('button_add')?>
								</button>
							<?php elseif ($action == 'edit'): ?>
								<button id="post" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
									<i class="fa fa-save"></i> <?php echo lang('button_update')?>
								</button>
							<?php endif; ?>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>
<script>
var site_url = '<?php echo site_url() ?>';
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
var action = '<?php echo $action ?>';
</script>