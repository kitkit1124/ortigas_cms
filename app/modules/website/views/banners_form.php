<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div id="form" class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-3">
			     	<label for="banner_image"><?php echo lang('banner_image')?>:</label>
			     </div>
			    <div class="col-sm-9">
			        <a href="javascript:;" id="banner_image_link" class="banner_image" data-target="banner_thumb"><img id="preview_image_thumb" src="<?php echo (isset($record->banner_thumb) && $record->banner_thumb) ? getenv('UPLOAD_ROOT').$record->banner_thumb : site_url('ui/images/transparent.png'); ?>" height="140" /></a>
			        <div id="error-banner_image"></div>
			    </div>
			</div>
		</div>

		<div style="display: none">
			<label for="banner_thumb"><?php echo lang('banner_thumb')?>:</label>			
			<?php echo form_input(array('id'=>'banner_thumb', 'name'=>'banner_thumb', 'value'=>set_value('banner_thumb', isset($record->banner_thumb) ? $record->banner_thumb : ''), 'class'=>'form-control'));?>
			<div id="error-banner_thumb"></div>			

			<label for="banner_image"><?php echo lang('banner_image')?>:</label>			
			<?php echo form_input(array('id'=>'banner_image', 'name'=>'banner_image', 'value'=>set_value('banner_image', isset($record->banner_image) ? $record->banner_image : ''), 'class'=>'form-control'));?>
			<div id="error-banner_image"></div>				
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-3">
			     	<label for="banner_caption"><?php echo lang('banner_alt_image')?>:</label>
			     </div>
			    <div class="col-sm-9">
			        <?php echo form_textarea(array('id'=>'banner_alt_image', 'name'=>'banner_alt_image', 'rows'=>'2', 'value'=>set_value('banner_alt_image', isset($record->banner_alt_image) ? $record->banner_alt_image : ''), 'class'=>'form-control', 'placeholder' => lang('banner_alt_image'), 'title'=> lang('banner_alt_image') )); ?>
					<div id="error-banner_alt_image"></div>	
			    </div>
			</div>
		</div>

		<div class="form-group" style="display: none;">
			<div class="row">
			    <div class="col-sm-2">
			     	<label for="banner_caption"><?php echo lang('banner_caption')?>:</label>
			     </div>
			    <div class="col-sm-10">
			        <?php echo form_textarea(array('id'=>'banner_caption', 'name'=>'banner_caption', 'rows'=>'3', 'value'=>set_value('banner_caption', isset($record->banner_caption) ? $record->banner_caption : ''), 'class'=>'form-control')); ?>
					<div id="error-banner_caption"></div>	
			    </div>
			</div>
		</div>

		<div class="form-group" style="display: none;">
			<div class="row">
			    <div class="col-sm-2">
			     	<label for="banner_link"><?php echo lang('banner_link')?>:</label>
			     </div>
			    <div class="col-sm-7">
			        <?php echo form_input(array('id'=>'banner_link', 'name'=>'banner_link', 'value'=>set_value('banner_link', isset($record->banner_link) ? $record->banner_link : ''), 'class'=>'form-control'));?>
					<div id="error-banner_link"></div>			
			    </div>
			     <div class="col-sm-3">
			        <?php $options = array('_top' => 'Same Window', '_blank' => 'New Window'); ?>
					<?php echo form_dropdown('banner_target', $options, set_value('banner_target', (isset($record->banner_target)) ? $record->banner_target : ''), 'id="banner_target" class="form-control"'); ?>
					<div id="error-banner_target"></div>		
			    </div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-3">
			     	<label  for="banner_status"><?php echo lang('banner_status')?>:</label>
			     </div>
			    <div class="col-sm-7">
			        <?php $options = create_dropdown('array', 'Active,Disabled'); ?>
					<?php echo form_dropdown('banner_status', $options, set_value('banner_status', (isset($record->banner_status)) ? $record->banner_status : ''), 'id="banner_status" class="form-control"'); ?>
					<div id="error-banner_status"></div>	
			    </div>
			</div>
		</div>

	</div>

	<div id="image" style="display: none">
		<div class="nav-tabs bottom-margin">
	
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active"><a href="#tab_1"  class="nav-link" data-toggle="tab">Upload Image</a></li>
				<li class="nav-item"><a href="#tab_2"  class="nav-link "data-toggle="tab">Add Existing Image</a></li>
				<li class="nav-item"><a href="javascript:;" class="nav-link go-back">Go Back</a></li>
			</ul>
	
			<div class="tab-content" data-target="">
				
				<div class="tab-pane active" id="tab_1">
					<div class="form">
						<div class="row">
							<div class="col-sm-6">

								<div class="form-group">

									<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
									<div class="fallback">
										<input name="file" type="file" class="hide" />
									</div>
									<?php echo form_close();?>

								</div>
							
								<div class="note_container <?php echo isset($record->image_slider_image) ? 'hide' : ''; ?>">
									<p class="note" style="text-align: left; width: auto;">Note:</p><br><br>
									<i>Recommended file type JPEG | PNG</i><br><i>Ideal image size: 1920 x 400</i><br><i> Max file size: 2.0 Mb</i>
								</div>

							</div>

							<div class="col-sm-6 text-center">
								<div id="image_sizes"></div>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
				</div>

				<div class="tab-pane" id="tab_2">
					<table class="table table-striped table-bordered table-hover dt-responsive" id="dt-images">
						<thead>
							<tr>
								<th class="all"><?php echo lang('index_id')?></th>
								<th class="min-desktop"><?php echo lang('index_width'); ?></th>
								<th class="min-desktop"><?php echo lang('index_height'); ?></th>
								<th class="min-desktop"><?php echo lang('index_name'); ?></th>
								<th class="min-desktop"><?php echo lang('index_file'); ?></th>
								<th class="min-desktop"><?php echo lang('index_thumb'); ?></th>

								<th class="none"><?php echo lang('index_created_on')?></th>
								<th class="none"><?php echo lang('index_created_by')?></th>
								<th class="none"><?php echo lang('index_modified_on')?></th>
								<th class="none"><?php echo lang('index_modified_by')?></th>
								<th class="min-tablet"><?php echo lang('index_action')?></th>
							</tr>
						</thead>
					</table>
					<div id="thumbnails" class="row text-center"></div>
				</div>

				
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


<script>
var site_url = '<?php echo site_url() ?>';
</script>