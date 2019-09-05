<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<div class="form">
		<div class="row">
			<div class="col-sm-7">
				<div class="form-group">
					<div class="disimg">
						<?php /*if(isset($record->floor_image)) { ?> <style type="text/css"> #dropzone{ display: unset; } </style> <?php } 
						else {  ?> <style type="text/css"> #image_container{ display: unset; } </style> <?php }*/ ?>
						
					
						<div id="image_container">
							<!-- <button id="clear_photo_button" class="fa fa-window-close"></button> -->
							<center>
								<img id="floor_active_image" src="<?php echo isset($record->floor_image) ? getenv('UPLOAD_ROOT').$record->floor_image : site_url('ui/images/placeholder.png'); ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</center>
						</div>

						<p class="note <?php echo isset($record->floor_image) ? 'hide' : ''; ?>">
							<i style="float: left;margin-left: 6px;">Recommended file type JPEG | PNG</i>
							<i style="float: right; margin-right: 6px;"><?php echo $image_quality['size']; ?></i>
							<br>
							<i style="float: left;margin-left: 6px;"><?php echo $image_quality['resolution']; ?></i>
							<span style="clear: both;"></span>
						</p>
						<div id="error-floor_image"></div>

						<div style="display: none">
						<?php echo form_input(array('id'=>'floor_image', 'name'=>'floor_image', 'value'=>set_value('floor_image', isset($record->floor_image) ? $record->floor_image : ''), 'class'=>'form-control'));?>
						</div>	

						<?php echo form_textarea(array('id'=>'floor_alt_image', 'name'=>'floor_alt_image', 'rows'=>'2', 'value'=>set_value('floor_alt_image', isset($record->floor_alt_image) ? $record->floor_alt_image : '', false), 'class'=>'form-control', 'placeholder'=> lang('floor_alt_image'), 'title'=> lang('floor_alt_image') )); ?>		
					</div>	
					<div class="uplimg hide">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item active"><a href="#tab_1"  class="nav-link" data-toggle="tab">Upload Image</a></li>
							<li class="nav-item"><a href="#tab_2"  class="nav-link "data-toggle="tab">Add Existing Image</a></li>
							<li class="nav-item"><a href=""  class="nav-link go-back" data-toggle="tab">Back</a></li>
						</ul>
						<div class="tab-content" data-target="">	

							<div class="tab-pane active" id="tab_1">
								<div class="form">
									<div class="form image_upload">
										<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
											<div class="fallback">
												<input name="file" type="file"/>
											</div>
										<?php echo form_close();?> 
									</div>
								</div>
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
			<div class="col-sm-5">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="form-group">
					<label for="floor_property_id"><?php echo lang('floor_property_id')?>:</label>
					<?php $options = create_dropdown('array', ',5'); ?>
					<?php echo form_dropdown('floor_property_id', $properties, set_value('floor_property_id', (isset($record->floor_property_id)) ? $record->floor_property_id : ''), 'id="floor_property_id" class="form-control"'); ?>
					<div id="error-floor_property_id"></div>
				</div>
				<div class="form-group">
					<label for="floor_level"><?php echo lang('floor_level')?>:</label>			
					<?php echo form_input(array('id'=>'floor_level', 'name'=>'floor_level', 'value'=>set_value('floor_level', isset($record->floor_level) ? $record->floor_level : ''), 'class'=>'form-control'));?>
					<div id="error-floor_level"></div>			
				</div>

				<div style="display: none">
					<?php echo form_input(array('id'=>'floor_level_original', 'name'=>'floor_level_original', 'value'=>set_value('floor_level_original', isset($record->floor_level) ? $record->floor_level : ''), 'class'=>'form-control'));?>
					<?php echo form_dropdown('floor_property_id_original', $properties, set_value('floor_property_id_original', (isset($record->floor_property_id)) ? $record->floor_property_id : ''), 'id="floor_property_id_original" class="form-control"'); ?>
				</div>
				<div class="form-group">
					<label for="floor_status"><?php echo lang('floor_status')?>:</label>
					<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
					<?php echo form_dropdown('floor_status', $options, set_value('floor_status', (isset($record->floor_status)) ? $record->floor_status : ''), 'id="floor_status" class="form-control"'); ?>
					<div id="error-floor_status"></div>
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