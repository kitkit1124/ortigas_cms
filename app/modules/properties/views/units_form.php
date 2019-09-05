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
			<label for="unit_number"><?php echo lang('unit_number')?>:</label>			
			<?php echo form_input(array('id'=>'unit_number', 'name'=>'unit_number', 'value'=>set_value('unit_number', isset($record->unit_number) ? $record->unit_number : ''), 'class'=>'form-control form-control-lg'));?>
			<div id="error-unit_number"></div>			
		</div>

		<div class="row">
			<div class="form-group col-sm-12">
				<label for="unit_property_id"><?php echo lang('unit_property_id')?>:</label>
				<?php echo form_dropdown('unit_property_id', $properties, set_value('unit_property_id', (isset($record->unit_property_id)) ? $record->unit_property_id : ''), 'id="unit_property_id" class="form-control"'); ?>
				<div id="error-unit_property_id"></div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-sm-6">
				<label for="unit_floor_id"><?php echo lang('unit_floor_id')?>:</label>
				<?php if(isset($record->unit_floor_id)) { $options = $floors; } else { $options = array(null=>'Please select Property first'); }?>
				<?php echo form_dropdown('unit_floor_id', $options, set_value('unit_floor_id', (isset($record->unit_floor_id)) ? $record->unit_floor_id : ''), 'id="unit_floor_id" class="form-control"'); ?>
				<div id="error-unit_floor_id"></div>
			</div>

			<div class="form-group col-sm-6">
				<label for="unit_room_type_id"><?php echo lang('unit_room_type_id')?>:</label>
				<?php if(isset($record->unit_floor_id)) { $options = $room_types; } else { $options = array(null=>'Please select Property first'); }?>
				<?php echo form_dropdown('unit_room_type_id', $options, set_value('unit_room_type_id', (isset($record->unit_room_type_id)) ? $record->unit_room_type_id : ''), 'id="unit_room_type_id" class="form-control"'); ?>
				<div id="error-unit_room_type_id"></div>
			</div>
		</div>

		<div style="display: none">
			<?php echo form_dropdown('unit_property_id_original', $properties, set_value('unit_property_id_original', (isset($record->unit_property_id)) ? $record->unit_property_id : ''), 'id="unit_property_id_original" class="form-control"'); ?>
			<?php if(isset($record->unit_floor_id)) { $options = $floors; } else { $options = array(null=>'Please select Property first'); }?>
			<?php echo form_dropdown('unit_floor_id_original', $options, set_value('unit_floor_id_original', (isset($record->unit_floor_id)) ? $record->unit_floor_id : ''), 'id="unit_floor_id_original" class="form-control"'); ?>
			<?php if(isset($record->unit_floor_id)) { $options = $room_types; } else { $options = array(null=>'Please select Property first'); }?>
			<?php echo form_dropdown('unit_room_type_id_original', $options, set_value('unit_room_type_id_original', (isset($record->unit_room_type_id)) ? $record->unit_room_type_id : ''), 'id="unit_room_type_id_original" class="form-control"'); ?>
			<?php echo form_input(array('id'=>'unit_number_original', 'name'=>'unit_number_original', 'value'=>set_value('unit_number_original', isset($record->unit_number) ? $record->unit_number : ''), 'class'=>'form-control'));?>
		</div>



		<div class="row">	
			<div class="form-group col-sm-6">
				<label for="unit_price"><?php echo lang('unit_price')?>:</label>			
				<?php echo form_input(array('id'=>'unit_price', 'name'=>'unit_price', 'value'=>set_value('unit_price', isset($record->unit_price) ? $record->unit_price : ''), 'class'=>'form-control'));?>
				<div id="error-unit_price"></div>			
			</div>
			<div class="form-group col-sm-6">
				<label for="unit_size"><?php echo lang('unit_size')?>:</label>			
				<?php echo form_input(array('id'=>'unit_size', 'name'=>'unit_size', 'value'=>set_value('unit_size', isset($record->unit_size) ? $record->unit_size : ''), 'class'=>'form-control'));?>
				<div id="error-unit_size"></div>			
			</div>
		</div>


		<div style="display: none;">
			<label for="unit_downpayment"><?php echo lang('unit_downpayment')?>:</label>			
			<?php echo form_input(array('id'=>'unit_downpayment', 'name'=>'unit_downpayment', 'value'=>set_value('unit_downpayment', isset($record->unit_downpayment) ? $record->unit_downpayment : ''), 'class'=>'form-control'));?>
			<div id="error-unit_downpayment"></div>			
		</div>
		<div class="form-group">
			<?php if(isset($record->unit_floor_id)) { ?> <style type="text/css"> #dropzone{ display: none; } </style> <?php } 
			else {  ?> <style type="text/css"> #image_container{ display: none; } </style> <?php } ?>

			<div class="form image_upload">
				<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
					<div class="fallback">
						<input name="file" type="file"/>
					</div>
				<?php echo form_close();?> 
			</div>
			<div id="image_container">
				<!-- <button id="clear_photo_button" class="fa fa-window-close"></button> -->
				<center>
					<img id="unit_active_image" src="<?php echo isset($record->unit_image) ? getenv('UPLOAD_ROOT').$record->unit_image : site_url('ui/images/placeholder.png'); ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
				</center>

			</div>
			<p class="note <?php echo isset($record->unit_image) ? 'hide' : ''; ?>"><i style="float: left;margin-left: 6px;">Recommended file type JPEG | PNG</i>
				<i style="float: right; margin-right: 6px;"><?php echo $image_quality['size']; ?></i>
				<br>
				<i style="float: left;margin-left: 6px;"><?php echo $image_quality['resolution']; ?></i>
				<span style="clear: both;"></span>
			</p>
			<div id="error-unit_image"></div>

			<div style="display: none">
			<?php echo form_input(array('id'=>'unit_image', 'name'=>'unit_image', 'value'=>set_value('unit_image', isset($record->unit_image) ? $record->unit_image : ''), 'class'=>'form-control'));?>
			</div>				
		</div>

		<div class="form-group">
			<label for="unit_status"><?php echo lang('unit_status')?>:</label>	
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('unit_status', $options, set_value('unit_status', (isset($record->unit_status)) ? $record->unit_status : ''), 'id="unit_status" class="form-control"'); ?>
			<div id="error-unit_status"></div>
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