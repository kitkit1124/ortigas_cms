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
			<label  for="province_name"><?php echo lang('province_name')?>:</label>			
			<?php echo form_input(array('id'=>'province_name', 'name'=>'province_name', 'value'=>set_value('province_name', isset($record->province_name) ? $record->province_name : ''), 'class'=>'form-control'));?>
			<div id="error-province_name"></div>			
		</div>

		<div class="form-group">
			<label  for="province_code"><?php echo lang('province_code')?>:</label>			
			<?php echo form_input(array('id'=>'province_code', 'name'=>'province_code', 'value'=>set_value('province_code', isset($record->province_code) ? $record->province_code : ''), 'class'=>'form-control'));?>
			<div id="error-province_code"></div>			
		</div>

		<div class="form-group">
			<label  for="province_region"><?php echo lang('province_region')?>:</label>
			<?php echo form_dropdown('province_region', $regions, set_value('province_region', (isset($record->province_region)) ? $record->province_region : ''), 'id="province_region" class="form-control"'); ?>
			<div id="error-province_region"></div>			
		</div>

		<div class="form-group">
			<label  for="province_country"><?php echo lang('province_country')?>:</label>			
			<?php echo form_dropdown('province_country', $countries, set_value('province_country', (isset($record->province_country)) ? $record->province_country : ''), 'id="province_country" class="form-control"'); ?>
			<div id="error-province_country"></div>			
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