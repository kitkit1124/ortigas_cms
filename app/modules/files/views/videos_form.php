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
			<label for="video_name">Video Name:</label>
			<input type="text" name="video_name" value="" id="video_name" class="form-control" />
			<div id="error-video_name"></div>
		</div>

		<div class="form-group">
			<label for="video_link"><?php echo lang('video_link')?>:</label>			
			<?php echo form_input(array('id'=>'video_link_id', 'name'=>'video_link_id', 'value'=>set_value('video_link_id', isset($record->video_link_id) ? $record->video_link_id : ''), 'class'=>'form-control'));?>
			<div id="error-video_link"></div>			
		</div>
		<div class="form-group">
				<label for="video_type"><?php echo lang('video_type')?>:</label>			
				<select name="video_type" id="video_type" class="form-control">
					<option value="Youtube">Youtube</option>
					<!-- <option value="Vimeo">Vimeo</option> -->
				</select>
				<div id="error-video_type"></div>
				<p class="help-block">
					Instructions : <br /> youtube - https://www.youtube.com/watch?v=qZFLz1-23tk the ID is after v= which is <b>qZFLz1-23tk</b>.<!--  <br />
					vimeo - https://vimeo.com/174304761 the ID is after domain name which is <b>174304761</b>. -->
				</p>			
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