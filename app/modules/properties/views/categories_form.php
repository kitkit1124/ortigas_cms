<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->category_id) AND isset($record->category_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/properties/categories/' . $record->category_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">	
				<div class="row">
						<div class="col-sm-9">
								<div class="form">

									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									
									<div class="form-group">
										<div style="display: none">
										<?php echo form_input(array('id'=>'category_name_original', 'name'=>'category_name_original', 'value'=>set_value('category_name_original', isset($record->category_name) ? $record->category_name : ''), 'class'=>'form-control'));?>
										</div>
										
										<label for="category_name"><?php echo lang('category_name')?>:</label><span class="error_asterisk"> *</span>				
										<?php echo form_input(array('id'=>'category_name', 'name'=>'category_name', 'value'=>set_value('category_name', isset($record->category_name) ? $record->category_name : ''), 'class'=>'form-control'));?>
										<div id="error-category_name"></div>			
									</div>

									<div class="form-group">
										<label for="category_snippet_quote"><?php echo lang('category_snippet_quote')?>:</label><span class="error_asterisk"> *</span>				
										<?php echo form_textarea(array('id'=>'category_snippet_quote', 'name'=>'category_snippet_quote', 'rows'=>'3', 'value'=>set_value('category_snippet_quote', isset($record->category_snippet_quote) ? utf8_decode($record->category_snippet_quote) : '', false), 'class'=>'form-control')); ?>
										<div id="error-category_snippet_quote"></div>			
									</div>

									<div class="form-group">
										<label for="category_description"><?php echo lang('category_description')?>:</label><span class="error_asterisk"> *</span>				
										<?php echo form_textarea(array('id'=>'category_description', 'name'=>'category_description', 'rows'=>'6', 'value'=>set_value('category_description', isset($record->category_description) ? utf8_decode($record->category_description) : '', false), 'class'=>'form-control')); ?>
										<div id="error-category_description"></div>			
									</div>

									<div class="form-group bottom_description hide">
										<label for="category_bottom_description"><?php echo lang('category_bottom_description')?>:</label>			
										<?php echo form_textarea(array('id'=>'category_bottom_description', 'name'=>'category_bottom_description', 'rows'=>'6', 'value'=>set_value('category_bottom_description', isset($record->category_bottom_description) ? utf8_decode($record->category_bottom_description) : '', false), 'class'=>'form-control')); ?>
										<div id="error-category_bottom_description"></div>			
									</div>

									<div id="related_link">
									<?php if(isset($record->category_id)): ?>
										<?php $data['section_id'] = $record->category_id; ?>
										<?php $data['section_type'] = 'categories'; ?>
										<?php echo $this->load->view('properties/related_links_index', $data); ?>
									<?php endif; ?>
									</div>
								</div>
						</div>
						<div class="col-sm-3">
							
							<div class="form-group">
								<label for="category_image"><?php echo lang('category_image')?>:</label>
								<br>		
								<a href="<?php echo site_url('properties/properties/form_upload/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
									<img id="category_image_img" src="<?php echo isset($record->category_image) ? getenv('UPLOAD_ROOT').$record->category_image : site_url('ui/images/placeholder.png') ; ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive active_image_thumb" width="100%" alt=""/>
								</a>
								<?php echo form_textarea(array('id'=>'category_alt_image', 'name'=>'category_alt_image', 'rows'=>'2', 'value'=>set_value('category_alt_image', isset($record->category_alt_image) ? $record->category_alt_image : '', false), 'class'=>'form-control', 'placeholder'=>lang('category_alt_image'),'title'=>lang('category_alt_image') )); ?>
								<br>
								<div id="error-category_image"></div>	

								<div style="display: none">
								<?php echo form_input(array('id'=>'category_image', 'name'=>'category_image', 'value'=>set_value('category_image', isset($record->category_image) ? $record->category_image : ''), 'class'=>'form-control selected_image'));?>
								</div>		
							</div>

							<div class="form-group">
								<label for="category_status"><?php echo lang('category_status')?>:</label>
								<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
								<?php echo form_dropdown('category_status', $options, set_value('category_status', (isset($record->category_status)) ? $record->category_status : ''), 'id="category_status" class="form-control"'); ?>
								<div id="error-category_status"></div>
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
</section>
<script>
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>