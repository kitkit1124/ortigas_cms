<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">									
				  <!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
		    		<?php if ($navigroups): ?>
						<?php foreach ($navigroups as $navigroup): ?>
							<li class="nav-item">
								<a  class="nav-link <?php echo ($navigroup->navigroup_id == $navigroup_id) ? 'active' : ''; ?>" 
									href="<?php echo site_url('website/navigations/' . $navigroup->navigroup_id); ?>">
									<?php echo $navigroup->navigroup_name; ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					<li class="nav-item d-none">
				      <a class="nav-link hide" data-toggle="modal" data-target="#modal-lg" href="<?php echo site_url('website/navigation_settings/form/edit'); ?>"><i class="fa fa-paint-brush" aria-hidden="true"></i> Color Theme</a>
				    </li>

					<li class="nav-item">
				      <a class="nav-link" data-toggle="modal" data-target="#modal-lg" href="<?php echo site_url('website/navigroups/form/add'); ?>"><i class="fa fa-plus"></i> Add Navigation Group</a>
				    </li>
				</ul>

				  <!-- Tab panes -->
				 <div class="tab-content">
				 	
					<div class="tab-pane active">
						<div class="row link_selection_container">
							<div class="col-sm-4">

								<div id="accordion">
								    <?php /* <div class="card hidden">
								      <div class="card-header">
								        <a class="card-link" data-toggle="collapse" href="#collapseOne">
								         Categories
								        </a>
								      </div>
								      <div id="collapseOne" class="collapse show" data-parent="#accordion">
								        <div class="card-body">
								         	<?php if ($categories): ?>
												<ul class="list-group">
													<?php foreach ($categories as $category): ?>					
														<li class="list-group-item">
															<a href="javascript:;" class="badge navadd btn-primary" data-name="<?php echo $category->category_name; ?>" data-link="<?php echo $category->category_uri; ?>" data-res="categories" data-resid="<?php echo $category->category_id; ?>"><span class="fa fa-long-arrow-right"></span></a>
															<?php echo $category->category_name; ?> <?php //echo $category->category_uri; ?>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
								        </div>
								      </div>
								    </div> */?>
								    <div class="card">
								      <div class="card-header">
								        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
								        Pages
								      </a>
								      </div>
								      <div id="collapseTwo" class="collapse" data-parent="#accordion">
								        <div class="card-body">
								        	<?php if ($pages): ?>
												<ul class="list-group">
													<li class="list-group-item">
														<a href="javascript:;" class="badge navadd btn-primary" data-name="Home" data-link=""><span class="fa fa-long-arrow-right"></span></a>
														Home
													</li>
													<?php foreach ($pages as $page): ?>
														<?php if ($page->page_uri == 'home') continue; ?>		
														<li class="list-group-item">
															<a href="javascript:;" class="badge navadd btn-primary" data-name="<?php echo $page->page_title; ?>" data-link="<?php echo $page->page_uri; ?>" data-res="pages" data-resid="<?php echo $page->page_id; ?>"><span class="fa fa-long-arrow-right"></span></a>
															<?php echo $page->page_title; ?><?php //echo '/' . $page->page_uri; ?>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
								        </div>
								      </div>
								    </div>
								    <div class="card">
								      <div class="card-header">
								        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
								          Custom Link
								        </a>
								      </div>
								      <div id="collapseThree" class="collapse" data-parent="#accordion">
								        <div class="card-body">
								          	<div class="panel-body">
												<div class="form-horizontal">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="custom_nav_name"><?php echo lang('custom_nav_name')?>:</label>
														<div class="col-sm-8">
															<?php echo form_input(array('id'=>'custom_nav_name', 'name'=>'custom_nav_name', 'value'=>set_value('custom_nav_name'), 'class'=>'form-control'));?>
															<div id="error-custom_nav_name"></div>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label" for="custom_nav_link"><?php echo lang('custom_nav_link')?>:</label>
														<div class="col-sm-8">
															<?php echo form_input(array('id'=>'custom_nav_link', 'name'=>'custom_nav_link', 'value'=>set_value('custom_nav_link'), 'class'=>'form-control'));?>
															<div id="error-custom_nav_link"></div>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label" for="custom_nav_target"><?php echo lang('custom_nav_target')?>:</label>
														<div class="col-sm-8">
															<?php $targets = array('_top' => 'Same Window', '_blank' => 'New Window'); ?>
															<?php echo form_dropdown('custom_nav_target', $targets, set_value('custom_nav_target'), 'id="custom_nav_target" class="form-control"'); ?>
															<div id="error-custom_nav_target"></div>
														</div>
													</div>

													<div class="form-group">
														<div class="col-sm-offset-3 col-sm-8">
															<a href="javascript:;" class="btn btn-default btn-custom-link">Add Custom Link <span class="fa fa-long-arrow-right"></span></a>
														</div>
													</div>
												</div>
											</div>
								        </div>
								      </div>
								    </div>
								</div>

							</div>

							<div class="col-sm-4">
								<div class="dd">
									<?php echo ($navigations) ? $navigations : '<ol class="dd-list outer"></ol>'; ?>
								</div>
								<div class="top-margin4">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									<button href="javascript:;" class="btn btn-success btn-save" data-id="<?php echo $navigroup_id; ?>" data-loading-text="<?php echo lang('processing')?>"><i class="fa fa-save"></i> Save Changes</button>
									<?php if ($navigroup_id > 2): ?> 
										<a href="<?php echo site_url('website/navigroups/form/edit/' . $navigroup_id); ?>" class="btn btn-warning" data-toggle="modal" data-target="#modal" title="Edit Group"><i class="fa fa-pencil"></i> Edit Group</a>
										<a href="<?php echo site_url('website/navigroups/delete/' . $navigroup_id); ?>" class="btn btn-danger" data-toggle="modal" data-target="#modal" title="Delete Group"><i class="fa fa-trash"></i></a>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-sm-4">
								<h4>Instruction:</h4>
								<ol id="instruction">
									<li>Add the navigation items from Categories, Pages or Custom Link</li>
									<li>Drag and drop the navigation items</li>
									<li><strong>Save changes</strong></li>
								</ol>
							</div>
						</div>
					</div>
							


				 </div>
			</div>
		</div>

	</div>
</section>


<script>
var ajax_url = '<?php echo current_url() ?>';
var site_url = '<?php echo site_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>