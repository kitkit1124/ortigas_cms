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
							<label class="banner_display_label"><h2><?php echo lang('banner_display')?></h2></label>
							<?php echo form_radio('banner_display', 'Active', set_value('banner_display', (isset($record->banner_display) && $record->banner_display) ? TRUE: FALSE), 'id="banner_display1"'); ?><label for="banner_display1" class="pointer">Video</label>
				 			<?php echo form_radio('banner_display', 'Inactive', set_value('banner_display', (isset($record->banner_display) && $record->banner_display) ? FALSE : TRUE), 'id="banner_display2"'); ?><label for="banner_display2" class="pointer">Slider</label> 
						
							<div id="error-banner_display"></div>
						</div>

						<!-- Nav tabs -->
						  <ul class="nav nav-tabs" role="tablist">
						    <li class="nav-item">
						      <a class="nav-link active" data-toggle="tab" href="#video">Video</a>
						    </li>
						    <li class="nav-item">
						      <a class="nav-link" data-toggle="tab" href="#slider">Slider</a>
						    </li>
						  </ul>

						<!-- Tab panes -->
						  <div class="tab-content">
						    <div id="video" class="tab-pane active"><br>
						 			<div id="video_upload">
						 				<video width="400" controls>
										  <source src="<?php echo site_url().$video->video_location; ?>" type="video/mp4">
										  Your browser does not support HTML5 video.
										</video><br>
										<a href="<?php echo site_url('website/banners/video_upload/add')?>" data-toggle="modal" data-target="#modal" id="upload_button" class="btn btn-sm btn-primary" style="min-width: 400px">
											<i class="fa fa-upload"></i>
										</a>
									</div>
						    </div>
						    <div id="slider" class="tab-pane fade"><br>


						    		<div class="text-right">
										<a href="<?php echo site_url('website/banners/form/add/' . $banner_group_id); ?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i>
										<?php echo lang('button_add')?></a>
										<?php if ($banner_group_id > 10){ ?>
										<a href="<?php echo site_url('website/banner_groups/form/edit/' . $banner_group_id); ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-edit"></i> Edit Group</a>
										<a href="<?php echo site_url('website/banner_groups/delete/' . $banner_group_id); ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal"><i class="fa fa-trash"></i> Delete Group</a>
										<?php } ?>
									</div>	    	

					<?php } ?>
						     		<?php if ($banners): ?>
										<div id="sortable" class="row">
											<?php foreach ($banners as $banner): ?>
												<li class="ui-state-default col-sm-3" data-id="<?php echo $banner->banner_id; ?>">
													<div class="thumbnail">
														<div class="pull-right btn-actions">
															<a data-toggle="modal" data-target="#modal" class="btn btn-xs btn-success" href="<?php echo site_url('website/banners/form/edit/' . $banner->banner_id); ?>"><div class="fa fa-pencil"></div></a>
															<a data-toggle="modal" data-target="#modal" class="btn btn-xs btn-danger" href="<?php echo site_url('website/banners/delete/' . $banner->banner_id); ?>"><div class="fa fa-trash"></div></a>
														</div>
														<img src="<?php echo site_url($banner->banner_image); ?>" width="100%" />
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
<script type="text/javascript">
var site_url = '<?php site_url(); ?>';
</script>