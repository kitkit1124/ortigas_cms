<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only"><?php echo lang('button_close')?></span>
	</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo $page_heading?></h4>
</div>

<div class="modal-body">

	<div class="form-horizontal">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

		<!-- <div class="form-group">
			<label class="col-sm-3 control-label" for="navigroup_name"><?php echo lang('navigroup_name')?>:</label>
			<div class="col-sm-8">
				<?php //echo form_input(array('id'=>'navigroup_name', 'name'=>'navigroup_name', 'value'=>set_value('navigroup_name', isset($record->navigroup_name) ? $record->navigroup_name : ''), 'class'=>'form-control'));?>
				<div id="error-navigroup_name"></div>
			</div>
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

<script>
var ajax_url = '<?php echo current_url() ?>';
var site_url = '<?php echo site_url() ?>';
</script>