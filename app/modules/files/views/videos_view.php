<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only"><?php echo lang('button_close')?></span>
	</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo $page_heading?> </h4>
</div>
<div class="modal-body">
	<div class="nav-tabs-custom bottom-margin">
		<?php if($record->video_type == "Youtube"): ?>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $record->video_link_id ?>"></iframe>
			</div>
		<?php elseif($record->video_type == "Vimeo"): ?>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?php echo $record->video_link_id ?>"></iframe>
			</div>
		<?php endif; ?>
	</div>
</div>