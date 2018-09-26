<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>


<div class="modal-body">
	<div id="confirm-message" class="callout callout-danger callout-dismissable hide"></div>
	<span class="font-130"><?php echo $page_confirm?></span>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<i class="fa fa-times"></i> <?php echo lang('button_close'); ?>
	</button>

	<button id="confirm-submit" class="btn btn-warning" type="submit" data-loading-text="<?php echo lang('processing')?>">
		<i class="fa fa-check"></i> <?php echo $page_button?>
	</button>
</div>

<script>
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';

$(function(){
	$('#confirm-submit').click(function(e){

		// change the button to loading state
		var $this = $(this);
		var loadingText = '<i class="fa fa-spinner fa-spin"></i> Loading...';
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}

		e.preventDefault();

		var ajax_url = "<?php echo current_url(); ?>";
		var ajax_load = '<span class="help-block text-center">Loading...</span>';

		$.post(ajax_url, {
			'confirm': 1,
			[csrf_name]: $('input[name=' + csrf_name + ']').val(),
		}, function(data, status) {
			var o = jQuery.parseJSON(data);
			if (o.success === false) {
				// reset the button
				$this.html($this.data('original-text'));

				alertify.error(o.message);
				$('#modal').modal('hide');
			}
			else {
				<?php if (isset($datatables_id)): ?>
					$('<?php echo $datatables_id; ?>').dataTable().fnDraw(false);
					alertify.success(o.message);
				<?php elseif (isset($redirect_url)): ?>
					window.location.replace('<?php echo $redirect_url; ?>');
				<?php else: ?>
					window.location.reload(true);
				<?php endif; ?>
				$('#modal').modal('hide');
			}
		}).fail(function() {
			// shows the error message
			alertify.alert('Error', unknown_form_error);

			// reset the button
			$this.html($this.data('original-text'));
		});
	});
});
</script>