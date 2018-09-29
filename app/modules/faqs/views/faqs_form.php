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
			<label for="faq_question"><?php echo lang('faq_question')?>:</label>			
			<?php echo form_input(array('id'=>'faq_question', 'name'=>'faq_question', 'value'=>set_value('faq_question', isset($record->faq_question) ? $record->faq_question : ''), 'class'=>'form-control'));?>
			<div id="error-faq_question"></div>			
		</div>

		<div class="form-group">
			<label for="faq_instruction" class="faq_instruction"><?php echo lang('faq_instruction')?>:</label>			
			<?php echo form_textarea(array('id'=>'faq_instruction', 'name'=>'faq_instruction', 'rows'=>'3', 'value'=>set_value('faq_instruction', isset($record->faq_instruction) ? $record->faq_instruction : '', false), 'class'=>'form-control')); ?>
			<div id="error-faq_instruction"></div>			
		</div>
		<?php if($action != "view") { ?>
		<div class="form-group">
			<label for="faq_status"><?php echo lang('faq_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('faq_status', $options, set_value('faq_status', (isset($record->faq_status)) ? $record->faq_status : ''), 'id="faq_status" class="form-control"'); ?>
			<div id="error-faq_status"></div>		
		</div>
		<?php } ?>


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

<script type="text/javascript">
	var action = "<?php echo $action; ?>"
</script>