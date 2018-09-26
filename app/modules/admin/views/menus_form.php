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
			<div class="col-sm form-group">
				<label for="menu_text"><?php echo lang('menu_text')?>:</label>
				<?php echo form_input(array('id'=>'menu_text', 'name'=>'menu_text', 'value'=>set_value('menu_text', isset($record->menu_text) ? $record->menu_text : ''), 'class'=>'form-control')); ?>
				<div id="error-menu_text"></div>
			</div>

			<div class="col-sm form-group">
				<label for="menu_link"><?php echo lang('menu_link')?>:</label>
				<?php echo form_input(array('id'=>'menu_link', 'name'=>'menu_link', 'value'=>set_value('menu_link', isset($record->menu_link) ? $record->menu_link : ''), 'class'=>'form-control')); ?>
				<div id="error-menu_link"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm form-group">
				<label for="menu_perm"><?php echo lang('menu_perm')?>:</label>
				<?php echo form_input(array('id'=>'menu_perm', 'name'=>'menu_perm', 'value'=>set_value('menu_perm', isset($record->menu_perm) ? $record->menu_perm : ''), 'class'=>'form-control')); ?>
				<div id="error-menu_perm"></div>
			</div>

			<div class="col-sm form-group">
				<label for="menu_icon"><?php echo lang('menu_icon')?>:</label>
				<?php echo form_input(array('id'=>'menu_icon', 'name'=>'menu_icon', 'value'=>set_value('menu_icon', isset($record->menu_icon) ? $record->menu_icon : ''), 'class'=>'form-control')); ?>
				<div id="error-menu_icon"></div>
			</div>
		</div>

		<div class="form-group">
			<label for="menu_parent"><?php echo lang('menu_parent')?>:</label>
			<?php echo form_dropdown('menu_parent', $menu_items, set_value('menu_parent', (isset($record->menu_parent) && $record->menu_parent != '') ? $record->menu_parent : ''), 'id="menu_parent" class="form-control"'); ?>
			<div id="error-menu_parent"></div>
		</div>

		<div class="row">
			<div class="col-sm form-group">
				<label for="menu_order"><?php echo lang('menu_order')?>:</label>
				<?php $options = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10); ?>
				<?php echo form_dropdown('menu_order', $options, set_value('menu_order', isset($record->menu_order) ? $record->menu_order : 1), 'id="menu_order" class="form-control"'); ?>
				<div id="error-menu_order"></div>
			</div>
			
			<div class="col-sm form-group pt-3">
				<label for="menu_active"></label>
				<div class="checkbox">
					<label>
						<input <?php echo ($page_type == 'view') ? 'disabled="disabled"' : ''; ?> id="menu_active" name="menu_active" type="checkbox" value="1" <?php echo set_checkbox('menu_active', 1, (isset($record->menu_active) && $record->menu_active == 1) ? TRUE : FALSE); ?> /> <?php echo lang('menu_active')?>
					</label>
				</div>
				<div id="error-menu_active"></div>
			</div>
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