<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->post_id) AND isset($record->post_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/website/posts/' . $record->post_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>	
			<div class="card-body">

				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

				<div class="row">

					<div class="col-sm-9">

						<div style="display: none">
							<?php echo form_input(array('id'=>'post_title_orig', 'name'=>'post_title_orig', 'value'=>set_value('post_title_orig', isset($record->post_title) ? $record->post_title : ''), 'class'=>'form-control meta-title'));?>
						</div>

						<div class="form-group">
							<label for="post_title"><?php echo lang('post_title'); ?>:</label>&nbsp;<span id="error-asterisk-post_title" class="error_asterisk">*</span>
							<?php echo form_input(array('id'=>'post_title', 'name'=>'post_title', 'value'=>set_value('post_title', isset($record->post_title) ? $record->post_title : '',FALSE), 'class'=>'form-control meta-title'));?>
							<div id="error-post_title"></div>
						</div>

						<div class="form-group">
							<label for="post_slug"><?php echo lang('post_slug'); ?>:</label>
							<?php echo form_input(array('id'=>'post_slug', 'name'=>'post_slug', 'value'=>set_value('post_slug', isset($record->post_slug) ? $record->post_slug : '',FALSE), 'class'=>'form-control meta-title'));?>
							<div id="error-post_slug"></div>
						</div>

						<div class="form-group">
							<label for="post_content"><?php echo lang('post_content'); ?>:</label>&nbsp;<span id="error-asterisk-post_content" class="error_asterisk">*</span>
							<div class="pull-right" style="margin-top:-5px">
								<a href="<?php echo site_url('files/images/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-image-o"></span> Image</a>
								<a href="<?php echo site_url('files/documents/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-pdf-o"></span> Document</a>
								<a href="<?php echo site_url('files/videos/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-video-o"></span> Video</a>
							</div>
							<div id="post-content" class="grid-editor">
								<?php //echo isset($record->post_content) ? $record->post_content : ''; ?>
							</div>
							<?php echo form_textarea(array('id'=>'post_content', 'name'=>'post_content', 'rows'=>'15', 'value'=>set_value('post_content', isset($record->post_content) ? $record->post_content : '', FALSE), 'class'=>'form-control meta-description')); ?>
							<div id="error-post_content"></div>
						</div>

					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label bottom-margin" for="post_status"><?php echo lang('post_status'); ?>:</label>
							<div class="radio top-margin">
								<label class="radio-inline">
									<input class="post_status" name="post_status" type="radio" value="Posted" <?php echo set_radio('post_status', 'Posted', (isset($record->post_status) && $record->post_status == 'Posted') ? TRUE : FALSE); ?> /> Posted
								</label>
						
								<label class="radio-inline">
									<input class="post_status" name="post_status" type="radio" value="Draft" <?php echo set_radio('post_status', 'Draft', ($action == 'add' OR isset($record->post_status) && $record->post_status == 'Draft') ? TRUE : FALSE); ?> /> Draft
								</label>
							</div>
							<div id="error-post_status"></div>
						</div>

						<div class="form-group">
							<label for="post_posted_on"><?php echo lang('post_posted_on'); ?>:</label>&nbsp;<span id="error-asterisk-page_content" class="error_asterisk">*</span>
							<?php echo form_input(array('id'=>'post_posted_on', 'name'=>'post_posted_on', 'value'=>set_value('post_posted_on', isset($record->post_posted_on) ? $record->post_posted_on : date('Y-m-d H:i:s')), 'class'=>'form-control', 'data-field'=>'datetime', 'readonly'=>''));?>
							<div id="error-post_posted_on"></div>
						</div>

						<div class="form-group">
							<label for="post_layout"><?php echo lang('post_layout')?>:</label>&nbsp;<span id="error-asterisk-page_content" class="error_asterisk">*</span>
							<?php echo form_dropdown('post_layout', config_item('theme_layouts'), set_value('post_layout', (isset($record->post_layout)) ? $record->post_layout : ''), 'id="post_layout" class="form-control"'); ?>
							<div id="error-post_layout"></div>
						</div>		

						<div class="form-group">
							<label for="post_image"><?php echo lang('post_image'); ?>:</label>&nbsp;<span id="error-asterisk-page_content" class="error_asterisk">*</span>
						</div>
						<div class="form-group">
							<a href="<?php echo site_url('website/posts/form_upload/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="post_active_image" src="<?php echo site_url(isset($record->post_image) ? $record->post_image : 'ui/images/placeholder.png'); ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</a>
							<?php echo form_textarea(array('id'=>'post_alt_image', 'name'=>'post_alt_image', 'rows'=>'2', 'value'=>set_value('post_alt_image', isset($record->post_alt_image) ? $record->post_alt_image : '', FALSE), 'class'=>'form-control meta-description','placeholder'=>lang('post_alt_image'), 'title'=>lang('post_alt_image') )); ?>
							<br>
							<div id="error-post_image"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'post_image', 'name'=>'post_image', 'value'=>set_value('post_image', isset($record->post_image) ? $record->post_image : ''), 'class'=>'form-control'));?>
							</div>		
						</div>

						<div class="form-group">
							<label for="post_properties"><?php echo lang('post_properties'); ?>:</label>
							<div id="properties">
								<select id="post_properties" class="post_properties form-control" multiple="multiple">
									<?php foreach($properties as $key => $property) { 
										if (in_array($key, $current_properties)) { $select = 'selected'; }else {$select = ''; }?>
										<option value="<?php echo $key; ?>"  <?php echo $select; ?> > <?php echo $property; ?></option>
								 	<?php }?>
								</select>
							</div>
							<div id="error-post_properties"></div>
						</div>

						<div class="form-group">
							<label for="post_tags"><?php echo lang('post_tags'); ?>:</label>&nbsp;<span id="error-asterisk-post_tags" class="error_asterisk">*</span>
							<div id="tags">
								<select id="post_tags" class="post_tags form-control" multiple="multiple">
									<?php foreach($tags as $key => $tag) { 
										if (in_array($key, $current_tags)) { $select = 'selected'; }else {$select = ''; }?>
										<option value="<?php echo $key; ?>"  <?php echo $select; ?> > <?php echo $tag; ?></option>
								 	<?php }?>
								</select>
							</div>
							<div id="error-post_tags"></div>
						</div>

						<div class="form-group">
							<label for="post_categories"><?php echo lang('post_categories'); ?>:</label>&nbsp;<span id="error-asterisk-post_categories" class="error_asterisk">*</span>
							<div id="categories">
								<?php if ($categories): ?>
									<?php foreach ($categories as $category): ?>
										<div class="checkbox" style="margin-left:<?php echo $category->category_indent; ?>px">
											<label>
												<input class="post_categories" name="post_categories[]" type="checkbox" value="<?php echo $category->category_id; ?>" <?php echo set_checkbox('post_categories', 1, (in_array($category->category_id, $current_categories)) ? TRUE : FALSE); ?> /> <?php echo $category->category_name; ?>
											</label>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<div id="error-post_categories"></div>
						</div>

						<div class="top-margin5">
							<?php if ($action == 'add'): ?>
								<button id="post" class="btn btn-default btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
									<i class="fa fa-plus"></i> <?php echo lang('button_add')?>
								</button>
							<?php elseif ($action == 'edit'): ?>
								<button id="post" class="btn btn-default btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
									<i class="fa fa-save"></i> <?php echo lang('button_update')?>
								</button>
							<?php endif; ?>
						</div>

					</div>

				</div>
			</div>
		</div>	
	</div>
</section>				
<div id="dtBox"></div>
<script>
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';

</script>