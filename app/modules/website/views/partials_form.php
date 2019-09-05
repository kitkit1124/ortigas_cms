<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->partial_id) AND isset($record->partial_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/website/partials/' . $record->partial_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
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

						<div class="form-group">
							<label class="control-label" for="partial_title"><?php echo lang('partial_title'); ?>:</label>&nbsp;<span id="error-asterisk-partial_title" class="error_asterisk">*</span>		
							<?php echo form_input(array('id'=>'partial_title', 'name'=>'partial_title', 'value'=>set_value('partial_title', isset($record->partial_title) ? $record->partial_title : ''), 'class'=>'form-control meta-title'));?>
							<div id="error-partial_title"></div>
						</div>


						<div class="form-group">
							<label for="partial_content"><?php echo lang('partial_content'); ?>:</label>&nbsp;<span id="error-asterisk-partial_content" class="error_asterisk">*</span>	
							<div class="pull-right" style="margin-top:-5px; display: none;">
								<a href="<?php echo site_url('files/images/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-image-o"></span> Image</a>
								<a href="<?php echo site_url('files/documents/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-pdf-o"></span> Document</a>
								<a href="<?php echo site_url('files/videos/rte/mce'); ?>" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal"><span class="fa fa-file-video-o"></span> Video</a>
							</div>
							<div id="partial-content" class="grid-editor">
								<?php //echo isset($record->partial_content) ? $record->partial_content : ''; ?>
							</div>
							<?php echo form_textarea(array('id'=>'partial_content', 'name'=>'partial_content', 'rows'=>'15', 'value'=>set_value('partial_content', isset($record->partial_content) ? $record->partial_content : '', FALSE), 'class'=>'form-control meta-description')); ?>
							<div id="error-partial_content"></div>
						</div>

					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label bottom-margin" for="partial_status"><?php echo lang('partial_status'); ?>:</label>
							<div class="radio top-margin">
								<label class="radio-inline">
									<input class="partial_status" name="partial_status" type="radio" value="Posted" <?php echo set_radio('partial_status', 'Posted', (isset($record->partial_status) && $record->partial_status == 'Posted') ? TRUE : FALSE); ?> /> Posted
								</label>
						
								<label class="radio-inline">
									<input class="partial_status" name="partial_status" type="radio" value="Draft" <?php echo set_radio('partial_status', 'Draft', ($action == 'add' OR isset($record->partial_status) && $record->partial_status == 'Draft') ? TRUE : FALSE); ?> /> Draft
								</label>
							</div>
							<div id="error-partial_status"></div>
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
<div class="tab-pane" id="tab_seo">

<script>
var post_url = '<?php echo current_url() ?>';
var app_url = '<?php echo site_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>