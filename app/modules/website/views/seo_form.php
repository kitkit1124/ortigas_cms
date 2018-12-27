<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal-lg" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
		<div class="form-group">
			<label for="seo_title"><?php echo lang('seo_title')?>:</label>&nbsp;<span id="error-asterisk-seo_title" class="error_asterisk">*</span>				
			<?php echo form_input(array('id'=>'seo_title', 'name'=>'seo_title', 'value'=>set_value('seo_title', isset($record->seo_title) ? $record->seo_title : ''), 'class'=>'form-control'));?>
			<div id="error-seo_title"></div>			
		</div>

		<div class="form-group">
			<label for="seo_content"><?php echo lang('seo_content')?>:</label>&nbsp;<span id="error-asterisk-seo_content" class="error_asterisk">*</span>			
			<?php echo form_textarea(array('id'=>'seo_content', 'name'=>'seo_content', 'rows'=>'14', 'value'=>set_value('seo_content', isset($record->seo_content) ? $record->seo_content : '',false), 'class'=>'form-control')); ?>
			<div id="error-seo_content"></div>			
		</div>

		<div class="form-group">
			<label for="seo_status"><?php echo lang('seo_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('seo_status', $options, set_value('seo_status', (isset($record->seo_status)) ? $record->seo_status : ''), 'id="seo_status" class="form-control"'); ?>
			<div id="error-seo_status"></div>
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