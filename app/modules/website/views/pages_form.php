<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->page_id) AND isset($record->page_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/website/pages/' . $record->page_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">

				<div class="row">

					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

					<div class="col-sm-9">

						<div class="form-group">
							<label class="control-label" for="page_title"><?php echo lang('page_title'); ?>:</label>	
							<?php echo form_input(array('id'=>'page_title', 'name'=>'page_title', 'value'=>set_value('page_title', isset($record->page_title) ? $record->page_title : ''), 'class'=>'form-control meta-title'));?>
							<div id="error-page_title"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="page_content"><?php echo lang('page_content'); ?>:</label>
							<div class="pull-right" style="margin-top:-5px">
								<a href="<?php echo site_url('files/images/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-image-o"></span> Image</a>
								<a href="<?php echo site_url('files/documents/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-pdf-o"></span> Document</a>
								<a href="<?php echo site_url('files/videos/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-video-o"></span> Video</a>
							</div>
							<div id="my-grid" class="grid-editor">
								<?php //echo isset($record->page_content) ? $record->page_content : ''; ?>
							</div>										
							<?php echo form_textarea(array('id'=>'page_content', 'name'=>'page_content', 'rows'=>'15', 'value'=>set_value('page_content', isset($record->page_content) ? $record->page_content : '', FALSE), 'class'=>'form-control meta-description')); ?>
							<div id="error-page_content"></div>
						</div>

					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="page_parent_id"><?php echo lang('page_parent_id')?>:</label>
							<?php echo form_dropdown('page_parent_id', $pages, set_value('page_parent_id', (isset($record->page_parent_id)) ? $record->page_parent_id : ''), 'id="page_parent_id" class="form-control"'); ?>
							<div id="error-page_parent_id"></div>
						</div>

						<div class="form-group">
							<label class="control-label bottom-margin" for="page_status"><?php echo lang('page_status'); ?>:</label>
							<div class="radio top-margin">
								<label class="radio-inline">
									<input class="page_status" name="page_status" type="radio" value="Posted" <?php echo set_radio('page_status', 'Posted', (isset($record->page_status) && $record->page_status == 'Posted') ? TRUE : FALSE); ?> /> Posted
								</label>
						
								<label class="radio-inline">
									<input class="page_status" name="page_status" type="radio" value="Draft" <?php echo set_radio('page_status', 'Draft', ($action == 'add' OR isset($record->page_status) && $record->page_status == 'Draft') ? TRUE : FALSE); ?> /> Draft
								</label>
							</div>
							<div id="error-page_status"></div>
						</div>

						<div class="form-group">
							<label class="control-label" for="page_layout"><?php echo lang('page_layout')?>:</label>
							<?php echo form_dropdown('page_layout', config_item('theme_layouts'), set_value('page_layout', (isset($record->page_layout)) ? $record->page_layout : ''), 'id="page_layout" class="form-control"'); ?>
							<div id="error-page_layout"></div>
						</div>

						<div class="form-group">
							<label for="page_properties"><?php echo lang('page_properties'); ?>:</label>
							<div id="properties">
								<select id="page_properties" class="page_properties form-control" multiple="multiple">
									<?php foreach($properties as $key => $property) { 
										if (in_array($key, $current_properties)) { $select = 'selected'; }else {$select = ''; }?>
										<option value="<?php echo $key; ?>"  <?php echo $select; ?> > <?php echo $property; ?></option>
								 	<?php }?>
								</select>
							</div>
							<div id="error-page_properties"></div>
						</div>

						<div class="form-group">
							<label for="page_posts"><?php echo lang('page_posts'); ?>:</label>
							<div id="posts">
								<select id="page_posts" class="page_posts form-control" multiple="multiple">
									<?php foreach($posts as $key => $post) { 
										if (in_array($key, $current_posts)) { $select = 'selected'; }else {$select = ''; }?>
										<option value="<?php echo $key; ?>"  <?php echo $select; ?> > <?php echo $post; ?></option>
								 	<?php }?>
								</select>
							</div>
							<div id="error-page_posts"></div>
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
<script>
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>