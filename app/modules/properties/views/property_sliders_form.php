<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div id="form" class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		<div style="display: none;">	
			<?php echo form_input(array('id'=>'property_slider_property_id', 'name'=>'property_slider_property_id', 'value'=>set_value('property_slider_property_id', isset($record->property_slider_property_id) ? $record->property_slider_property_id : ''), 'class'=>'form-control'));?>			
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-2">
			     	<label for="property_slider_image"><?php echo lang('property_slider_image')?>:</label>			
			     </div>
			    <div class="col-sm-10">
			        <a href="javascript:;" id="property_slider_image_link" class="property_slider_image" data-target="property_slider_image">
			        	<img id="preview_image_thumb" src="<?php echo (isset($record->property_slider_image) && $record->property_slider_image) ? site_url($record->property_slider_image) : site_url('ui/images/transparent.png'); ?>" height="140" /></a>
			        <div id="error-property_slider_image"></div>
			    </div>
			</div>
		</div>

		<div style="display: none;">
			<?php echo form_input(array('id'=>'property_slider_image', 'name'=>'property_slider_image', 'value'=>set_value('property_slider_image', isset($record->property_slider_image) ? $record->property_slider_image : ''), 'class'=>'form-control'));?>		
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-2">
			     	<label for="property_slider_title"><?php echo lang('property_slider_title')?>:</label>
			     </div>
			    <div class="col-sm-10">
			       	<?php echo form_input(array('id'=>'property_slider_title', 'name'=>'property_slider_title', 'value'=>set_value('property_slider_title', isset($record->property_slider_title) ? $record->property_slider_title : ''), 'class'=>'form-control'));?>
					<div id="error-property_slider_title"></div>	
			    </div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-2">
			     		<label for="property_slider_caption"><?php echo lang('property_slider_caption')?>:</label>			
			    </div>
			    <div class="col-sm-10">
			       		<?php echo form_textarea(array('id'=>'property_slider_caption', 'name'=>'property_slider_caption', 'rows'=>'3', 'value'=>set_value('property_slider_caption', isset($record->property_slider_caption) ? $record->property_slider_caption : ''), 'class'=>'form-control')); ?>
						<div id="error-property_slider_caption"></div>			
			    </div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-2">
			     		<label for="property_slider_caption"><?php echo lang('property_slider_status')?>:</label>			
			    </div>
			    <div class="col-sm-10">
			       		<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
						<?php echo form_dropdown('property_slider_status', $options, set_value('property_slider_status', (isset($record->property_slider_status)) ? $record->property_slider_status : ''), 'id="property_slider_status" class="form-control"'); ?>
						<div id="error-property_slider_status"></div>			
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
								<div class="note_container <?php echo isset($record->property_slider_image) ? 'hide' : ''; ?>">
								<p class="note" style="text-align: left; width: auto;">Note:</p>
								<i>Recommended file type JPEG | PNG</i><br><i> Max file size: 2.0 Mb</i>
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

<script type="text/javascript"> var site_url = '<?php echo site_url(); ?>' </script>