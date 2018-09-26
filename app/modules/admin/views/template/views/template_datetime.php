		<div class="form-group">
			<label class="col-sm-3 control-label" for="{{form_name}}"><?php echo lang('{{form_name}}')?>:</label>
			<div class="col-sm-8">
				<?php echo form_input(array('id'=>'{{form_name}}', 'name'=>'{{form_name}}', 'value'=>set_value('{{form_name}}', isset($record->{{form_name}}) ? $record->{{form_name}} : ''), 'class'=>'form-control', 'data-field'=>'datetime', 'readonly'=>'' ));?>
				<div id="error-{{form_name}}"></div>
			</div>
		</div>

<div class="time_box"></div>
