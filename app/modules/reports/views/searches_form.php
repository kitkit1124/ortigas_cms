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
			<label for="search_keyword"><?php echo lang('search_keyword')?>:</label>			
			<?php echo form_input(array('id'=>'search_keyword', 'name'=>'search_keyword', 'value'=>set_value('search_keyword', isset($record->search_keyword) ? $record->search_keyword : ''), 'class'=>'form-control'));?>
			<div id="error-search_keyword"></div>			
		</div>

		<div class="form-group">
			<label for="search_cat_id"><?php echo lang('search_cat_id')?>:</label>			
			<?php echo form_input(array('id'=>'search_cat_id', 'name'=>'search_cat_id', 'value'=>set_value('search_cat_id', isset($record->search_cat_id) ? $record->search_cat_id : ''), 'class'=>'form-control'));?>
			<div id="error-search_cat_id"></div>			
		</div>

		<div class="form-group">
			<label for="search_price_id"><?php echo lang('search_price_id')?>:</label>			
			<?php echo form_input(array('id'=>'search_price_id', 'name'=>'search_price_id', 'value'=>set_value('search_price_id', isset($record->search_price_id) ? $record->search_price_id : ''), 'class'=>'form-control'));?>
			<div id="error-search_price_id"></div>			
		</div>

		<div class="form-group">
			<label for="search_loc_id"><?php echo lang('search_loc_id')?>:</label>			
			<?php echo form_input(array('id'=>'search_loc_id', 'name'=>'search_loc_id', 'value'=>set_value('search_loc_id', isset($record->search_loc_id) ? $record->search_loc_id : ''), 'class'=>'form-control'));?>
			<div id="error-search_loc_id"></div>			
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