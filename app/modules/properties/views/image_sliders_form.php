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
			     	<label for="image_slider_image_link"><?php echo lang('image_slider_image')?>:</label>			
			     </div>
			    <div class="col-sm-9">
			        <a href="javascript:;" id="image_slider_image_link">
			        	<img id="image_slider_image_thumb" src="<?php echo (isset($record->image_slider_image) && $record->image_slider_image) ? getenv('UPLOAD_ROOT').$record->image_slider_image : site_url('ui/images/transparent.png'); ?>" height="200" /></a>
			        <div id="error-image_slider_image"></div>
			    </div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
			    <div class="col-sm-3">
			     	<label for="image_slider_image_link"><?php echo lang('image_slider_alt_image')?>:</label>			
			     </div>
			    <div class="col-sm-9">
					<?php echo form_textarea(array('id'=>'image_slider_alt_image', 'name'=>'image_slider_alt_image', 'rows'=>'3', 'value'=>set_value('image_slider_alt_image', isset($record->image_slider_alt_image) ? $record->image_slider_alt_image : ''), 'class'=>'form-control', 'placeholder'=> lang('image_slider_alt_image') )); ?>	
			    </div>
			</div>
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_section_type"><?php echo lang('image_slider_section_type')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_section_type', 'name'=>'image_slider_section_type', 'value'=>$this->input->get('section_type'), 'class'=>'form-control'));?>
			<div id="error-image_slider_section_type"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_section_id"><?php echo lang('image_slider_section_id')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_section_id', 'name'=>'image_slider_section_id', 'value'=>$this->input->get('section_id'), 'class'=>'form-control'));?>
			<div id="error-image_slider_section_id"></div>			
		</div>

		<div class="form-group" style="display: none;">		
			<?php echo form_input(array('id'=>'image_slider_image', 'name'=>'image_slider_image', 'value'=>set_value('image_slider_image', isset($record->image_slider_image) ? $record->image_slider_image : ''), 'class'=>'form-control'));?>	
	
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_title"><?php echo lang('image_slider_title')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_title', 'name'=>'image_slider_title', 'value'=>set_value('image_slider_title', isset($record->image_slider_title) ? $record->image_slider_title : ''), 'class'=>'form-control'));?>
			<div id="error-image_slider_title"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_title_size"><?php echo lang('image_slider_title_size')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_title_size', 'name'=>'image_slider_title_size', 'value'=>set_value('image_slider_title_size', isset($record->image_slider_title_size) ? $record->image_slider_title_size : ''), 'class'=>'form-control'));?>
			<div id="error-image_slider_title_size"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_title_pos"><?php echo lang('image_slider_title_pos')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_title_pos', 'name'=>'image_slider_title_pos', 'value'=>set_value('image_slider_title_pos', isset($record->image_slider_title_pos) ? $record->image_slider_title_pos : ''), 'class'=>'form-control'));?>
			<div id="error-image_slider_title_pos"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_caption"><?php echo lang('image_slider_caption')?>:</label>			
			<?php echo form_textarea(array('id'=>'image_slider_caption', 'name'=>'image_slider_caption', 'rows'=>'3', 'value'=>set_value('image_slider_caption', isset($record->image_slider_caption) ? $record->image_slider_caption : ''), 'class'=>'form-control')); ?>
			<div id="error-image_slider_caption"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_caption_size"><?php echo lang('image_slider_caption_size')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_caption_size', 'name'=>'image_slider_caption_size', 'value'=>set_value('image_slider_caption_size', isset($record->image_slider_caption_size) ? $record->image_slider_caption_size : ''), 'class'=>'form-control'));?>
			<div id="error-image_slider_caption_size"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="image_slider_caption_pos"><?php echo lang('image_slider_caption_pos')?>:</label>			
			<?php echo form_input(array('id'=>'image_slider_caption_pos', 'name'=>'image_slider_caption_pos', 'value'=>set_value('image_slider_caption_pos', isset($record->image_slider_caption_pos) ? $record->image_slider_caption_pos : ''), 'class'=>'form-control'));?>
			<div id="error-image_slider_caption_pos"></div>			
		</div>

		<div class="form-group">
			<div class="row">
			<div class="col-sm-3">
		     	<label for="image_slider_caption_pos"><?php echo lang('image_slider_status')?>:</label>			
		    </div>
		    <div class="col-sm-7">
		        <?php $options = create_dropdown('array', 'Active,Disabled'); ?>
				<?php echo form_dropdown('image_slider_status', $options, set_value('image_slider_status', (isset($record->image_slider_status)) ? $record->image_slider_status : ''), 'id="image_slider_status" class="form-control"'); ?>
				<div id="error-image_slider_status"></div>
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