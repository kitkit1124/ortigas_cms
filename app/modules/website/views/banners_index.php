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
				 			<div id="video_upload">
				 				<video width="400" controls>
								  <source src="<?php echo site_url().$video->video_location; ?>" type="video/mp4">
								  Your browser does not support HTML5 video.
								</video><br>
								<a href="<?php echo site_url('website/banners/video_upload/add')?>" data-toggle="modal" data-target="#modal" id="upload_button" class="btn btn-sm btn-primary" style="min-width: 400px">
									<i class="fa fa-upload"></i>
								</a>
							</div>
				 		<?php } else{ ?>
				 			<div class="text-right">
								<a href="<?php echo site_url('website/banners/form/add/' . $banner_group_id); ?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i>
								<?php echo lang('button_add')?></a>
								<a href="<?php echo site_url('website/banner_groups/form/edit/' . $banner_group_id); ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-edit"></i> Edit Group</a>
								<?php if ($banner_group_id > 8){ ?>
								<a href="<?php echo site_url('website/banner_groups/delete/' . $banner_group_id); ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal"><i class="fa fa-trash"></i> Delete Group</a>
								<?php } ?>
							</div>
						<?php } ?>

				    <div id="home" class="tab-pane active"><br>
				    	<?php if ($banner_group_id == 1){ ?>

				    	<?php } else { ?>
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
						<?php endif; }?>		
				    </div>
				 </div>
			</div>
		</div>
		<h4 class="top-margin4">Embed Codes:</h4>
		<p>PHP: <code>&lt;?php echo frontend_banners(<?php echo $banner_group_id; ?>); ?&gt;</code></p>
		<p>Content: <code>##frontend_banners(<?php echo $banner_group_id; ?>)##</code></p>
	</div>
</section>
<script type="text/javascript">
var site_url = '<?php site_url(); ?>';
</script>