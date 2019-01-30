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
			<label class="col-sm-3 control-label" for="nav_setting_color_theme"><?php echo lang('nav_setting_color_theme')?>:</label>
			<div class="col-sm-8">
				<?php $options = create_dropdown('array', ',Default,White'); ?>
				<?php echo form_dropdown('nav_setting_color_theme', $options, set_value('nav_setting_color_theme', (isset($record->nav_setting_color_theme)) ? $record->nav_setting_color_theme : ''), 'id="nav_setting_color_theme" class="form-control"'); ?>
				<div id="error-nav_setting_color_theme"></div>
			</div>

<!-- 			<label class="switch">
			  <input type="checkbox">
			  <span class="slider"></span>
			</label>
 -->

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