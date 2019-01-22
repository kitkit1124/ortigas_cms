<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		
		<div class="row">
			<div class="col-sm-3">
				<label for="message_type"><?php echo lang('message_type')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">			
					<?php echo form_input(array('id'=>'message_type', 'name'=>'message_type', 'value'=>set_value('message_type', isset($record->message_type) ? $record->message_type : ''), 'class'=>'form-control'));?>
					<div id="error-message_type"></div>			
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<label for="message_section"><?php echo lang('message_section')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">		
					<?php echo form_input(array('id'=>'message_section', 'name'=>'message_section', 'value'=>set_value('message_section', isset($record->message_section) ? $record->message_section : ''), 'class'=>'form-control'));?>
					<div id="error-message_section"></div>			
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<label for="message_section_id"><?php echo lang('message_section_id')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">		
					<?php echo form_input(array('id'=>'message_section_id', 'name'=>'message_section_id', 'value'=>set_value('message_section_id', isset($section) ? $section : ''), 'class'=>'form-control'));?>
					<div id="error-message_section_id"></div>			
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<label for="message_name"><?php echo lang('message_name')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">
					<?php echo form_input(array('id'=>'message_name', 'name'=>'message_name', 'value'=>set_value('message_name', isset($record->message_name) ? $record->message_name : ''), 'class'=>'form-control'));?>
					<div id="error-message_name"></div>				
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<label for="message_email"><?php echo lang('message_email')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">	
					<?php echo form_input(array('id'=>'message_email', 'name'=>'message_email', 'value'=>set_value('message_email', isset($record->message_email) ? $record->message_email : ''), 'class'=>'form-control'));?>
					<div id="error-message_email"></div>			
				</div>
			</div>
		</div>
	
		<?php if($record->message_mobile != 0 && isset($record->message_mobile)):?>
		<div class="row">
			<div class="col-sm-3">
				<label for="message_mobile"><?php echo lang('message_mobile')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">	
					<?php echo form_input(array('id'=>'message_mobile', 'name'=>'message_mobile', 'value'=>set_value('message_mobile', isset($record->message_mobile) ? $record->message_mobile : ''), 'class'=>'form-control'));?>
					<div id="error-message_mobile"></div>			
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if($record->message_location != 0 && isset($record->message_location)):?>
		<div class="row">
			<div class="col-sm-3">
				<label for="message_location"><?php echo lang('message_location')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">	
					<?php echo form_input(array('id'=>'message_location', 'name'=>'message_location', 'value'=>set_value('message_location', isset($record->message_location) ? $record->message_location : ''), 'class'=>'form-control'));?>
					<div id="error-message_location"></div>			
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-sm-3">
				<label for="message_content"><?php echo lang('message_content')?>:</label>
			</div>
			<div class="col-sm-9">
				<div class="form-group">
					<?php echo form_textarea(array('id'=>'message_content', 'name'=>'message_content', 'rows'=>'3', 'value'=>set_value('message_content', isset($record->message_content) ? $record->message_content : ''), 'class'=>'form-control')); ?>
					<div id="error-message_content"></div>			
				</div>
			</div>
		</div>

		<!-- <div class="form-group">
			<label for="message_status"><?php echo lang('message_status')?>:</label>
			<?php $options = create_dropdown('array', ',Active,Disabled'); ?>
			<?php echo form_dropdown('message_status', $options, set_value('message_status', (isset($record->message_status)) ? $record->message_status : ''), 'id="message_status" class="form-control"'); ?>
			<div id="error-message_status"></div>
		</div> -->



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