		<div class="form-group">
			<label for="{{form_name}}"><?php echo lang('{{form_name}}')?>:</label>			
			<?php echo form_input(array('id'=>'{{form_name}}', 'name'=>'{{form_name}}', 'value'=>set_value('{{form_name}}', isset($record->{{form_name}}) ? $record->{{form_name}} : ''), 'class'=>'form-control'));?>
			<div id="error-{{form_name}}"></div>			
		</div>

