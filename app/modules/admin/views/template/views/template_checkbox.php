		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-8">
				<div class="checkbox">
					<label>
						<input id="{{form_name}}" name="{{form_name}}" type="checkbox" value="1" <?php echo set_checkbox('{{form_name}}', 1, (isset($record->{{form_name}}) && $record->{{form_name}} == 1) ? TRUE : FALSE); ?> /> <?php echo lang('{{form_name}}')?>
					</label>
				</div>
				<div id="error-{{form_name}}"></div>
			</div>
		</div>

