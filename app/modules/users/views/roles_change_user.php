<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div id="confirm-message" class="callout callout-danger callout-dismissable hide"></div>
	<span class="font-130"><?php echo lang('change_user_confirm')?></span>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close')?>	</button>

	<button id="confirm" class="btn btn-warning" type="submit" data-loading-text="<?php echo lang('processing')?>">
		<i class="fa fa-check"></i> <?php echo lang('button_change_user')?>	</button>
</div>
