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
				<?php echo form_input(array('id'=>'price_range_label_original', 'name'=>'price_range_label_original', 'value'=>set_value('price_range_label_original', isset($record->price_range_label) ? $record->price_range_label : ''), 'class'=>'form-control form-control-lg'));?>
			</div>
			<label for="price_range_label"><?php echo lang('price_range_label')?>:</label>			
			<?php echo form_input(array('id'=>'price_range_label', 'name'=>'price_range_label', 'value'=>set_value('price_range_label', isset($record->price_range_label) ? $record->price_range_label : ''), 'class'=>'form-control form-control-lg'));?>
			<div id="error-price_range_label"></div>			
		</div>

		<div class="form-group">
			<label for="price_range_min"><?php echo lang('price_range_min')?>:</label>
			<input type="range" class="form-control price_range_min_slide" min="1" max="20000000" value="1000000">	

			<?php echo form_input(array('id'=>'price_range_min', 'name'=>'price_range_min', 'value'=>set_value('price_range_min', isset($record->price_range_min) ? $record->price_range_min : ''), 'class'=>'form-control'));?>
			<div id="error-price_range_min"></div>			
		</div>

		<div class="form-group">
			<label for="price_range_max"><?php echo lang('price_range_max')?>:</label>		
			<input type="range" class="form-control price_range_max_slide" min="1" max="20000000" value="1000000">	
			<?php echo form_input(array('id'=>'price_range_max', 'name'=>'price_range_max', 'value'=>set_value('price_range_max', isset($record->price_range_max) ? $record->price_range_max : ''), 'class'=>'form-control'));?>
			<div id="error-price_range_max"></div>			
		</div>

		<div class="form-group">
			<label for="price_range_status"><?php echo lang('price_range_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('price_range_status', $options, set_value('price_range_status', (isset($record->price_range_status)) ? $record->price_range_status : ''), 'id="price_range_status" class="form-control"'); ?>
			<div id="error-price_range_status"></div>
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