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
			<label for="page_title"><?php echo lang('page_title')?>:</label><span class="error_asterisk"> *</span>				
			<?php echo form_input(array('id'=>'page_title', 'name'=>'page_title', 'value'=>set_value('page_title', isset($record->page_title) ? $record->page_title : ''), 'class'=>'form-control form-control-lg'));?>
			<div id="error-page_title"></div>			
		</div>

		<div class="form-group">
			<label for="page_content"><?php echo lang('page_content')?>:</label><span class="error_asterisk"> *</span>			
			<?php echo form_textarea(array('id'=>'page_content', 'name'=>'page_content', 'rows'=>'7', 'value'=>set_value('page_content', isset($record->page_content) ? utf8_decode($record->page_content) : '', FALSE), 'class'=>'form-control')); ?>
			<div id="error-page_content"></div>			
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="page_status"><?php echo lang('page_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('page_status', $options, set_value('page_status', (isset($record->page_status)) ? $record->page_status : ''), 'id="page_status" class="form-control"'); ?>
			<div id="error-page_status"></div>
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