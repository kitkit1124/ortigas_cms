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
			<label for="region_name"><?php echo lang('region_name')?>:</label>
				<?php echo form_input(array('id'=>'region_name', 'name'=>'region_name', 'value'=>set_value('region_name', isset($record->region_name) ? $record->region_name : ''), 'class'=>'form-control'));?>
				<div id="error-region_name"></div>
		</div>

		<div class="row">
			<div class="col-sm form-group">
				<label for="region_code"><?php echo lang('region_code')?>:</label>
					<?php echo form_input(array('id'=>'region_code', 'name'=>'region_code', 'value'=>set_value('region_code', isset($record->region_code) ? $record->region_code : ''), 'class'=>'form-control'));?>
					<div id="error-region_code"></div>
			</div>

			<div class="col-sm form-group">
				<label for="region_short_name"><?php echo lang('region_short_name')?>:</label>
					<?php echo form_input(array('id'=>'region_short_name', 'name'=>'region_short_name', 'value'=>set_value('region_short_name', isset($record->region_short_name) ? $record->region_short_name : ''), 'class'=>'form-control'));?>
					<div id="error-region_short_name"></div>
			</div>
		</div>

		<div class="form-group">
			<label for="region_group"><?php echo lang('region_group')?>:</label>
				<?php echo form_input(array('id'=>'region_group', 'name'=>'region_group', 'value'=>set_value('region_group', isset($record->region_group) ? $record->region_group : ''), 'class'=>'form-control'));?>
				<div id="error-region_group"></div>
		</div>

		<div class="form-group">
			<label for="region_country"><?php echo lang('region_country')?>:</label>
				<?php echo form_dropdown('region_country', $countries, set_value('region_country', (isset($record->region_country)) ? $record->region_country : ''), 'id="region_country" class="form-control"'); ?>
				<div id="error-region_country"></div>
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