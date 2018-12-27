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
			<label for="news_tag_name"><?php echo lang('news_tag_name')?>:</label>&nbsp;<span id="error-asterisk-news_tag_name" class="error_asterisk">*</span>			
			<?php echo form_input(array('id'=>'news_tag_name', 'name'=>'news_tag_name', 'value'=>set_value('news_tag_name', isset($record->news_tag_name) ? $record->news_tag_name : ''), 'class'=>'form-control'));?>
			<div id="error-news_tag_name"></div>			
		</div>

		<div class="form-group" style="display: none;">
			<label for="news_tag_description"><?php echo lang('news_tag_description')?>:</label>			
			<?php echo form_textarea(array('id'=>'news_tag_description', 'name'=>'news_tag_description', 'rows'=>'3', 'value'=>set_value('news_tag_description', isset($record->news_tag_description) ? $record->news_tag_description : ''), 'class'=>'form-control')); ?>
			<div id="error-news_tag_description"></div>			
		</div>

		<div class="form-group">
			<label for="news_tag_status"><?php echo lang('news_tag_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('news_tag_status', $options, set_value('news_tag_status', (isset($record->news_tag_status)) ? $record->news_tag_status : ''), 'id="news_tag_status" class="form-control"'); ?>
			<div id="error-news_tag_status"></div>
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