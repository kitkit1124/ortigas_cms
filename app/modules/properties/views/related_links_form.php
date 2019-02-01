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
			<label for="related_link_label"><?php echo lang('related_link_label')?>:</label>			
			<?php echo form_input(array('id'=>'related_link_label', 'name'=>'related_link_label', 'value'=>set_value('related_link_label', isset($record->related_link_label) ? $record->related_link_label : ''), 'class'=>'form-control'));?>
			<div id="error-related_link_label"></div>			
		</div>

		<div class="form-group">
			<label for="related_link_link"><?php echo lang('related_link_link')?>:</label>			
			<?php echo form_input(array('id'=>'related_link_link', 'name'=>'related_link_link', 'value'=>set_value('related_link_link', isset($record->related_link_link) ? $record->related_link_link : ''), 'class'=>'form-control'));?>
			<i>Sample URL: "http://ortigas.com.ph"</i>
			<div id="error-related_link_link"></div>			
		</div>

		<div class="form-group">
			<label for="related_link_status"><?php echo lang('related_link_status')?>:</label>
			<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
			<?php echo form_dropdown('related_link_status', $options, set_value('related_link_status', (isset($record->related_link_status)) ? $record->related_link_status : ''), 'id="related_link_status" class="form-control"'); ?>
			<div id="error-related_link_status"></div>
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