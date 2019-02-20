<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">									
				  <!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
			    	<?php if ($banner_groups): ?>
						<?php foreach ($banner_groups as $banner_group): ?>
							<li class="nav-item">
								<a  class="nav-link <?php echo ($banner_group->banner_group_id == $banner_group_id) ? 'active' : ''; ?>" 
									href="<?php echo site_url('website/banners/' . $banner_group->banner_group_id); ?>">
									<?php echo $banner_group->banner_group_name; ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					<li class="nav-item">
				      <a class="nav-link" data-toggle="modal" data-target="#modal-lg" href="<?php echo site_url('website/banner_groups/form/add'); ?>"><i class="fa fa-plus"></i> Add Banner Group</a>
				    </li>
				</ul>

				  <!-- Tab panes -->
				 <div class="tab-content">
				 	<?php if ($banner_group_id == 1){ ?>	

	 			   		<div class="form-group">
	 			   			<input type="hidden" id='csrf' name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							
							<?php //echo form_radio('banner_display', 'Active', set_value('banner_display', (isset($video->video_status) && $video->video_status == 'Active') ? TRUE: FALSE), 'id="banner_display1" data-text="Video Display"'); ?><!-- <label for="banner_display1" class="pointer">Video</label> -->
				 			<?php //echo form_radio('banner_display', 'Inactive', set_value('banner_display', (isset($video->video_status) && $video->video_status  == 'Active') ? FALSE : TRUE), 'id="banner_display2" data-text="Banner Slider"'); ?><!-- <label for="banner_display2" class="pointer">Slider</label>  -->
							
						<div class="form-group selected_display_form">
							<div class="col-sm-3">
								<label class="banner_display_label"><h2><?php echo lang('banner_display')?></h2></label>	
							</div>
							<div class="col-sm-3"><?php $options = array('Active'=>'Video','Inactive'=>'Slider'); ?>
								<?php echo form_dropdown('banner_display', $options, set_value('banner_display', (isset($video->video_status)) ? $video->video_status : ''), 'id="banner_display" class="form-control"'); ?>
							</div>	
							<div class="col-sm-3"><?php $options = create_dropdown('array', 'Video,Slider'); ?>
								<button id="banner_display_button" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
									<i class="fa fa-save"> </i> Update
								</button>
							</div>
						</div>

						<!-- Nav tabs -->
						  <ul class="nav nav-tabs" role="tablist">
						    <li class="nav-item">
						      <a class="nav-link <?php echo isset($video->video_status) && $video->video_status  == 'Active' ? 'active show' : ''; ?>" data-toggle="tab" href="#video">Video</a>
						    </li>
						    <li class="nav-item" >
						      <a class="nav-link <?php echo isset($video->video_status) && $video->video_status  == 'Inactive' ? 'active show' : ''; ?>" data-toggle="tab" href="#slider">Slider</a>
						    </li>
						  </ul>

						<!-- Tab panes -->
						  <div class="tab-content">
						    <div id="video" class="tab-pane <?php echo isset($video->video_status) && $video->video_status  == 'Active' ? 'active' : ''; ?>"><br>
						 			<div id="video_upload">
						 				<div class="row">
						 					<div class="col-sm-4">
								 				<video width="400" controls autoplay="true">
												  <source src="<?php echo getenv('UPLOAD_ROOT').$video->video_location; ?>" type="video/mp4">
												  Your browser does not support HTML5 video.
												</video><br>
												<a href="<?php echo site_url('website/banners/video_upload/add')?>" data-toggle="modal" data-target="#modal" id="upload_button" class="btn btn-sm btn-primary" style="min-width: 400px">
													<i class="fa fa-upload"></i>
												</a>
						 					</div>
						 					<div class="col-sm-8">
						 						<h1>Video Details</h1>

						 						<input type="hidden" id='csrf_video' value="<?php echo $this->security->get_csrf_hash(); ?>" />

						 						<div class="form-group row">
						 							<div class="col-sm-3">
								 						<label class="col-form-label"><?php echo lang('video_title')?>:</label>
									 				</div>
									 				<div class="col-sm">
									 					<?php echo form_input(array('id'=>'video_title', 'name'=>'video_title', 'value'=>set_value('video_title', isset($video->video_title) ? $video->video_title : '', FALSE), 'class'=>'form-control')); ?>
									 					<div id="error-video_title"></div>
									 				</div>
									 			</div>

									 			<div class="form-group row">
						 							<div class="col-sm-3">
									 					<label class="col-form-label"><?php echo lang('video_caption')?>:</label>	
									 				</div>
									 				<div class="col-sm">
									 					<?php echo form_textarea(array('id'=>'video_caption', 'name'=>'video_caption', 'rows'=>'3', 'value'=>set_value('video_caption', isset($video->video_caption) ? $video->video_caption : '', FALSE), 'class'=>'form-control')); ?>
									 					<div id="error-video_caption"></div>
									 				</div>
									 			</div>

									 			<div class="form-group row">
						 							<div class="col-sm-3">
									 					<label class="col-form-label"><?php echo lang('video_text_position')?>:</label>
									 				</div>
									 				<div class="col-sm">
									 					<?php $options = create_dropdown('array', 'Top,Bottom,Left,Center,Right'); ?>
														<?php echo form_dropdown('video_text_pos', $options, set_value('video_text_pos', (isset($video->video_text_pos)) ? $video->video_text_pos : ''), 'id="video_text_pos" class="form-control"'); ?>
														<div id="error-video_text_pos"></div>
									 				</div>
									 			</div>

									 			<div class="form-group row">
						 							<div class="col-sm-3">
									 					<label class="col-form-label"><?php echo lang('video_button_text')?>:</label>
									 				</div>
									 				<div class="col-sm">
									 					<?php echo form_input(array('id'=>'video_button_text', 'name'=>'video_button_text', 'value'=>set_value('video_button_text', isset($video->video_button_text) ? $video->video_button_text : ''), 'class'=>'form-control')); ?>
									 					<div id="error-video_button_text"></div>
									 				</div>
									 			</div>

									 			<div class="form-group row">
						 							<div class="col-sm-3">
									 					<label class="col-form-label"><?php echo lang('video_link')?>:</label>
									 				</div>
									 				<div class="col-sm">
									 					<?php echo form_input(array('id'=>'video_link', 'name'=>'video_link', 'value'=>set_value('video_link', isset($video->video_link) ? $video->video_link : ''), 'class'=>'form-control')); ?>
									 					<div id="error-video_link"></div>
									 				</div>
									 			</div>

									 			<div class="form-group row">
						 							<div class="col-sm-3"></div>
									 				<div class="col-sm">
									 					<button id="post" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
															<i class="fa fa-save"></i> <?php echo lang('button_update')?>
														</button>
									 				</div>
									 			</div>													
						 					</div>
						 				</div>

									</div>
						    </div>
						    <div id="slider" class="tab-pane <?php echo isset($video->video_status) && $video->video_status  == 'Inactive' ? 'active' : ''; ?>"><br>

							<?php } ?>
						    		<div class="text-right add_banner">
										<a href="<?php echo site_url('website/banners/form/add/' . $banner_group_id); ?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i>
										<?php echo lang('button_add')?></a>
										
										<a href="<?php echo site_url('website/banner_groups/form/edit/' . $banner_group_id); ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-edit"></i> Edit Group</a>
										<?php if ($banner_group_id > 10){ ?>
										<a href="<?php echo site_url('website/banner_groups/delete/' . $banner_group_id); ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal"><i class="fa fa-trash"></i> Delete Group</a>
										<?php } ?>
									</div>	    	

					
						     		<?php if ($banners): ?>
										<div id="sortable" class="row">
											<?php foreach ($banners as $banner): ?>
												<li class="ui-state-default col-sm-3" data-id="<?php echo $banner->banner_id; ?>">
													<div class="thumbnail">
														<div class="pull-right btn-actions">
															<a data-toggle="modal" data-target="#modal-lg" class="btn btn-xs btn-success" href="<?php echo site_url('website/banners/form/edit/' . $banner->banner_id); ?>"><div class="fa fa-pencil"></div></a>
															<a data-toggle="modal" data-target="#modal" class="btn btn-xs btn-danger" href="<?php echo site_url('website/banners/delete/' . $banner->banner_id); ?>"><div class="fa fa-trash"></div></a>
														</div>
														<img src="<?php echo getenv('UPLOAD_ROOT').$banner->banner_image; ?>"  onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" width="100%"/>
													</div>
												</li>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>		
								   
					<?php if ($banner_group_id == 1){ ?>
						    </div>
						  </div>
					<?php } ?>
				 </div>
			</div>
		</div>
		<!-- <h4 class="top-margin4">Embed Codes:</h4>
		<p>PHP: <code>&lt;?php echo frontend_banners(<?php echo $banner_group_id; ?>); ?&gt;</code></p>
		<p>Content: <code>##frontend_banners(<?php echo $banner_group_id; ?>)##</code></p> -->
	</div>
</section>

<script>
var site_url = '<?php echo site_url() ?>';
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>