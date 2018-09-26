		<div class="form-group">
			<label class="col-sm-3 control-label" for="{{form_name}}"><?php echo lang('{{form_name}}')?>:</label>
			<div class="col-sm-8">
				<div class="radio">
					<label>
						<input class="{{form_name}}" name="{{form_name}}" type="radio" value="one" <?php echo set_radio('{{form_name}}', 'one', (isset($record->{{form_name}}) && $record->{{form_name}} == 'one') ? TRUE : FALSE); ?> /> Option 1
					</label>
				</div>
				<div class="radio">
					<label>
						<input class="{{form_name}}" name="{{form_name}}" type="radio" value="two" <?php echo set_radio('{{form_name}}', 'two', (isset($record->{{form_name}}) && $record->{{form_name}} == 'two') ? TRUE : FALSE); ?> /> Option 2
					</label>
				</div>
				<div id="error-{{form_name}}"></div>
			</div>
		</div>

