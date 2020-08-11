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
			<label for="city_name"><?php echo lang('city_name')?>:</label>			
			<?php echo form_input(array('id'=>'city_name', 'name'=>'city_name', 'value'=>set_value('city_name', isset($record->city_name) ? $record->city_name : ''), 'class'=>'form-control'));?>
			<div id="error-city_name"></div>			
		</div>

		<div class="row">
			<div class="col-sm form-group">
				<label for="city_code"><?php echo lang('city_code')?>:</label>			
				<?php echo form_input(array('id'=>'city_code', 'name'=>'city_code', 'value'=>set_value('city_code', isset($record->city_code) ? $record->city_code : ''), 'class'=>'form-control'));?>
				<div id="error-city_code"></div>			
			</div>

			<div class="col-sm form-group">
				<label for="city_type"><?php echo lang('city_type')?>:</label>			
				<?php $options = create_dropdown('array', 'City,Municipality,Other'); ?>
				<?php echo form_dropdown('city_type', $options, set_value('city_type', (isset($record->city_type)) ? $record->city_type : ''), 'id="city_type" class="form-control"'); ?>
				<div id="error-city_type"></div>			
			</div>
		</div>

		<div class="form-group">
			<label for="city_province"><?php echo lang('city_province')?>:</label>			
			<?php echo form_dropdown('city_province', $provinces, set_value('city_province', (isset($record->city_province)) ? $record->city_province : ''), 'id="city_province" class="form-control"'); ?>
			<div id="error-city_province"></div>		
		</div>

		<div class="form-group">
			<label for="city_country"><?php echo lang('city_country')?>:</label>			
			<?php echo form_dropdown('city_country', $countries, set_value('city_country', (isset($record->city_country)) ? $record->city_country : ''), 'id="city_country" class="form-control"'); ?>
			<div id="error-city_country"></div>		
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