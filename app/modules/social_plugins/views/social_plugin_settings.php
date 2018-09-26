<div class="nav-tabs-custom bottom-margin">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_general" data-toggle="tab"><span class="fa fa-share-alt"></span> Share Buttons</a></li>
	</ul>
	<div class="tab-content">

		<div class="tab-pane active" id="tab_general">

			<div class="form-horizontal">

				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

				<?php $social_buttons = json_decode($social_media_button[0]->config_value); ?>
				<?php foreach ($social_buttons as $key => $button) : ?>
					<div class="form-group">
						<label class="col-xs-4 col-sm-2 control-label" for="<?php echo $button->id ?>"><?php echo $button->name; ?>:</label>
						<div class="col-xs-2 col-sm-1">
							<input type="checkbox" id="<?php echo $button->id?>" data-name="<?php echo $button->name?>" value="1" <?php echo $button->status==1 ? 'checked' : '' ?> class="form-control ace ace-switch ace-switch-4 btn-flat social-button-status" />
							<span class="lbl pull-left"></span>
							<div id="error-<?php echo $key; ?>"></div>
						</div>
						<label class="col-xs-12 col-sm-2 control-label" for="<?php echo $button->id ?>_icon">Icon: </label>
						<div class="col-xs-12 col-sm-3">
							<input type="text" id="<?php echo $button->id ?>_icon" data-name="<?php echo $button->name?>" value="<?php echo $button->icon; ?>" class="form-control social-button-icon" />
							<span class="lbl pull-left"></span>
							<div id="error-<?php echo $key; ?>"></div>
						</div>
					</div>
				<?php endforeach; ?>
				<hr />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="orientation">Orientation:</label>
					<div class="col-sm-4">
						<?php $options = create_dropdown('array', 'vertical,horizontal'); ?>
						<?php echo form_dropdown('orientation', $options, set_value('orientation', ($social_media_orientation[0]->config_value) ? $social_media_orientation[0]->config_value : ''), 'id="orientation" class="form-control"'); ?>
						<div class="help-text"><?php echo $social_media_orientation[0]->config_notes; ?></div>
						<div id="error-<?php echo $key; ?>"></div>
					</div>
				</div>

			</div>

		</div>

	</div>

</div>

<div class="clearfix form-actions">
	<button id="submit" class="btn btn-info" type="button" data-loading-text="<?php echo lang('processing')?>">
		<i class="ace-icon fa fa-save bigger-110"></i>
		Save Changes
	</button>
</div>


<script>var post_url = '<?php echo current_url() ?>';</script>