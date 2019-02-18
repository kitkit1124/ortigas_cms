<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo $page_heading?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">

	<div class="form">

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />


		<ul class="nav nav-tabs">
			<li class="nav-item"><a class="nav-link active" href="#meta_tab" data-toggle="tab"><span class="fa fa-code"></span> <?php echo lang('title_meta_tags'); ?></a></li>
			<li class="nav-item"><a class="nav-link" href="#twitter_tab" data-toggle="tab"><span class="fa fa-twitter"></span> <?php echo lang('title_twitter_tags'); ?></a></li>
			<li class="nav-item"><a class="nav-link" href="#facebook_tab" data-toggle="tab"><span class="fa fa-facebook"></span> <?php echo lang('title_facebook_tags'); ?></a></li>
			<li class="nav-item d-none"><a class="nav-link" href="#image_tab" data-toggle="tab"><span class="fa fa-image"></span></a></li>
		</ul>
		<div class="tab-content mt-3">
			<div class="tab-pane active" id="meta_tab">

				<div class="form-group">
					<label for="metatag_robots"><?php echo lang('metatag_robots')?>:</label>
					<?php $options = create_dropdown('array', 'Default,No Index'); ?>
					<?php echo form_dropdown('metatag_robots', $options, set_value('metatag_robots', (isset($record->metatag_robots)) ? $record->metatag_robots : ''), 'id="metatag_robots" class="form-control"'); ?>
					<div id="error-metatag_robots"></div>
				</div>

				<div class="form-group">
					<label for="metatag_title"><?php echo lang('metatag_title')?>:</label>
					<?php echo form_input(array('id'=>'metatag_title', 'name'=>'metatag_title', 'value'=>set_value('metatag_title', isset($record->metatag_title) ? $record->metatag_title : '',false), 'class'=>'form-control'));?>
					<div id="error-metatag_title"></div>
				</div>

				<div class="form-group">
					<label for="metatag_keywords"><?php echo lang('metatag_keywords')?>:</label>
					<?php echo form_textarea(array('id'=>'metatag_keywords', 'name'=>'metatag_keywords', 'rows'=>'2', 'value'=>set_value('metatag_keywords', isset($record->metatag_keywords) ? $record->metatag_keywords : '',false), 'class'=>'form-control')); ?>
					<div id="error-metatag_keywords"></div>
				</div>

				<div class="form-group">
					<label for="metatag_description"><?php echo lang('metatag_description')?>:</label>
					<?php echo form_textarea(array('id'=>'metatag_description', 'name'=>'metatag_description', 'rows'=>'2', 'value'=>set_value('metatag_description', isset($record->metatag_description) ? $record->metatag_description : '', false), 'class'=>'form-control')); ?>
					<div id="error-metatag_description"></div>
				</div>

				<div class="form-group">
					<label for="metatag_code"><?php echo lang('metatag_code')?>:</label>
					<?php echo form_textarea(array('id'=>'metatag_code', 'name'=>'metatag_code', 'rows'=>'2', 'value'=>set_value('metatag_code', isset($record->metatag_code) ? $record->metatag_code : '', false), 'class'=>'form-control')); ?>
					<div id="error-metatag_code"></div>
				</div>
			</div>

			<div class="tab-pane" id="twitter_tab">

				<div class="form-group">
					<label for="metatag_twitter_title"><?php echo lang('metatag_twitter_title')?>:</label>
					<?php echo form_input(array('id'=>'metatag_twitter_title', 'name'=>'metatag_twitter_title', 'value'=>set_value('metatag_twitter_title', isset($record->metatag_twitter_title) ? $record->metatag_twitter_title : '',false), 'class'=>'form-control'));?>
					<div id="error-metatag_twitter_title"></div>
				</div>

				<div class="form-group">
					<label for="metatag_twitter_description"><?php echo lang('metatag_twitter_description')?>:</label>
					<?php echo form_textarea(array('id'=>'metatag_twitter_description', 'name'=>'metatag_twitter_description', 'rows'=>'2', 'value'=>set_value('metatag_twitter_description', isset($record->metatag_twitter_description) ? $record->metatag_twitter_description : '',false), 'class'=>'form-control')); ?>
					<div id="error-metatag_twitter_description"></div>
				</div>

				<div class="form-group">
					<label for="metatag_twitter_image"><?php echo lang('metatag_twitter_image')?>:</label><br />
					<a href="javascript:;" id="metatag_twitter_image_link" class="metatag_image" data-target="metatag_twitter_image"><img id="metatag_twitter_image_thumb" class="metatag_image_thumb" src="<?php echo (isset($record->metatag_twitter_image) && $record->metatag_twitter_image) ? site_url($record->metatag_twitter_image) : site_url('ui/images/transparent.png'); ?>" height="100" />
					<?php echo form_input(array('id'=>'metatag_twitter_image', 'name'=>'metatag_twitter_image', 'value'=>set_value('metatag_twitter_image', isset($record->metatag_twitter_image) ? $record->metatag_twitter_image : ''), 'class'=>'form-control metatag_image_path d-none'));?></a>
					<div id="error-metatag_twitter_image"></div>
				</div>
			</div>

			<div class="tab-pane" id="facebook_tab">

				<div class="form-group">
					<label for="metatag_og_title"><?php echo lang('metatag_og_title')?>:</label>
					<?php echo form_input(array('id'=>'metatag_og_title', 'name'=>'metatag_og_title', 'value'=>set_value('metatag_og_title', isset($record->metatag_og_title) ? $record->metatag_og_title : '',false), 'class'=>'form-control'));?>
					<div id="error-metatag_og_title"></div>
				</div>

				<div class="form-group">
					<label for="metatag_og_description"><?php echo lang('metatag_og_description')?>:</label>
					<?php echo form_textarea(array('id'=>'metatag_og_description', 'name'=>'metatag_og_description', 'rows'=>'2', 'value'=>set_value('metatag_og_description', isset($record->metatag_og_description) ? $record->metatag_og_description : '',false), 'class'=>'form-control')); ?>
					<div id="error-metatag_og_description"></div>
				</div>

				<div class="form-group">
					<label for="metatag_og_image"><?php echo lang('metatag_og_image')?>:</label><br />
					<a href="javascript:;" id="metatag_og_image_link" class="metatag_image" data-target="metatag_og_image"><img id="metatag_og_image_thumb" class="metatag_image_thumb" src="<?php echo (isset($record->metatag_og_image) && $record->metatag_og_image) ? site_url($record->metatag_og_image) : site_url('ui/images/transparent.png'); ?>" height="100" />
					<?php echo form_input(array('id'=>'metatag_og_image', 'name'=>'metatag_og_image', 'value'=>set_value('metatag_og_image', isset($record->metatag_og_image) ? $record->metatag_og_image : ''), 'class'=>'form-control metatag_image_path d-none'));?></a>
					<div id="error-metatag_og_image"></div>
				</div>

			</div>


			<div class="tab-pane" id="image_tab">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Add Existing Image</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Upload Image</a></li>
				</ul>
				<div class="tab-content mt-3" data-target="">

					<div class="tab-pane active" id="tab_1">
						<table class="table table-striped table-bordered table-hover dt-responsive" id="dt-images">
							<thead>
								<tr>
									<th class="all"><?php echo lang('index_id')?></th>
									<th class="min-desktop"><?php echo lang('index_width'); ?></th>
									<th class="min-desktop"><?php echo lang('index_height'); ?></th>
									<th class="min-desktop"><?php echo lang('index_name'); ?></th>
									<th class="min-desktop"><?php echo lang('index_file'); ?></th>
									<th class="min-desktop"><?php echo lang('index_thumb'); ?></th>

									<th class="none"><?php echo lang('index_created_on')?></th>
									<th class="none"><?php echo lang('index_created_by')?></th>
									<th class="none"><?php echo lang('index_modified_on')?></th>
									<th class="none"><?php echo lang('index_modified_by')?></th>
									<th class="min-tablet"><?php echo lang('index_action')?></th>
								</tr>
							</thead>
						</table>
						<div id="thumbnails" class="row text-center"></div>
					</div>

					<div class="tab-pane" id="tab_2">
						<div class="row">

							<div class="col">

								<div class="form-group">

									<?php echo form_open(site_url('files/images/upload'), array('class'=>'dropzone', 'id'=>'dropzone'));?>
									<div class="fallback">
										<input name="file" type="file" class="d-none" />
									</div>
									<?php echo form_close();?>

								</div>

							</div>

							<div class="col text-center">
								<div id="image_sizes"></div>
							</div>

						</div>

						<div class="clearfix"></div>
					</div>
				</div>
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