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
			<label for="country_name"><?php echo lang('country_name')?>:</label>
			<?php echo form_input(array('id'=>'country_name', 'name'=>'country_name', 'value'=>set_value('country_name', isset($record->country_name) ? $record->country_name : ''), 'class'=>'form-control'));?>
			<div id="error-country_name"></div>			
		</div>

		<div class="form-group">
			<label for="country_code2"><?php echo lang('country_code2')?>:</label>
			<?php echo form_input(array('id'=>'country_code2', 'name'=>'country_code2', 'value'=>set_value('country_code2', isset($record->country_code2) ? $record->country_code2 : ''), 'class'=>'form-control'));?>
			<div id="error-country_code2"></div>
		</div>

		<div class="form-group">
			<label for="country_code3"><?php echo lang('country_code3')?>:</label>
			<?php echo form_input(array('id'=>'country_code3', 'name'=>'country_code3', 'value'=>set_value('country_code3', isset($record->country_code3) ? $record->country_code3 : ''), 'class'=>'form-control'));?>
			<div id="error-country_code3"></div>			
		</div>

		<div class="form-group">
			<label for="country_continent"><?php echo lang('country_continent')?>:</label>
			<?php echo form_dropdown('country_continent', $continents, set_value('country_continent', (isset($record->country_continent)) ? $record->country_continent : ''), 'id="country_continent" class="form-control"'); ?>
			<div id="error-country_continent"></div>			
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