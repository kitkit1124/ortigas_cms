<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form related_link_container">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
		<div class="form-group">
			<label for="faq_topic"><?php echo lang('faq_topic')?>:</label>			
			<?php echo form_textarea(array('id'=>'faq_topic', 'rows'=>'3', 'name'=>'faq_topic', 'value'=>set_value('faq_topic', isset($record->faq_topic) ? $record->faq_topic : ''), 'class'=>'form-control'));?>
			<div id="error-faq_topic"></div>			
		</div>

		<div class="form-group">
			<label for="faq_answer"><?php echo lang('faq_answer')?>:</label>			
			<?php echo form_textarea(array('id'=>'faq_answer', 'rows'=>'3',  'name'=>'faq_answer', 'value'=>set_value('faq_answer', isset($record->faq_answer) ? $record->faq_answer : ''), 'class'=>'form-control'));?>
			<div id="error-faq_answer"></div>			
		</div>

		<div class="form-group">
			<label for="faq_status"><?php echo lang('faq_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('faq_status', $options, set_value('faq_status', (isset($record->faq_status)) ? $record->faq_status : ''), 'id="faq_status" class="form-control"'); ?>
			<div id="error-faq_status"></div>
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

<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>'
</script>