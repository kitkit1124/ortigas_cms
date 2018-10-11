<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
		<div class="form-group">
			<div style="display: none">
			<?php echo form_input(array('id'=>'category_name_original', 'name'=>'category_name_original', 'value'=>set_value('category_name_original', isset($record->category_name) ? $record->category_name : ''), 'class'=>'form-control'));?>
			</div>
			
			<label for="category_name"><?php echo lang('category_name')?>:</label>			
			<?php echo form_input(array('id'=>'category_name', 'name'=>'category_name', 'value'=>set_value('category_name', isset($record->category_name) ? $record->category_name : ''), 'class'=>'form-control'));?>
			<div id="error-category_name"></div>			
		</div>

		<div class="form-group">
			<label for="category_description"><?php echo lang('category_description')?>:</label>			
			<?php echo form_textarea(array('id'=>'category_description', 'name'=>'category_description', 'rows'=>'6', 'value'=>set_value('category_description', isset($record->category_description) ? $record->category_description : '', false), 'class'=>'form-control')); ?>
			<div id="error-category_description"></div>			
		</div>

		<div class="form-group">
			<label for="category_image"><?php echo lang('category_image')?>:</label>
			<?php if(isset($record->category_image)) { ?> <style type="text/css"> #dropzone{ display: none; } </style> <?php } 
			else {  ?> <style type="text/css"> #image_container{ display: none; } </style> <?php } ?>
			
			<div class="form image_upload">
				<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
					<div class="fallback">
						<input name="file" type="file"/>
					</div>
				<?php echo form_close();?> 
			</div>
			<div id="image_container">
				<center>
					<img id="category_active_image" src="<?php echo site_url(isset($record->category_image) ? $record->category_image : 'ui/images/placeholder.png'); ?>" class="img-responsive" width="100%" alt=""/>
				</center>

			</div>
			<p class="note <?php echo isset($record->category_image) ? 'hide' : ''; ?>"><i style="float: left;margin-left: 6px;">Recommended file type JPEG | PNG</i> <i style="float: right; margin-right: 6px;"> Max file size: 2.0 Mb</i><span style="clear: both;"></span></p>
			
			<div id="error-category_image"></div>
			

			<div style="display: none">
			<?php echo form_input(array('id'=>'category_image', 'name'=>'category_image', 'value'=>set_value('category_image', isset($record->category_image) ? $record->category_image : ''), 'class'=>'form-control'));?>
			</div>				
		</div>

		<div class="form-group">
			<label for="category_status"><?php echo lang('category_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('category_status', $options, set_value('category_status', (isset($record->category_status)) ? $record->category_status : ''), 'id="category_status" class="form-control"'); ?>
			<div id="error-category_status"></div>
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