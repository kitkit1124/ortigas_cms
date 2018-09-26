<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN6cUNcHO88eddYIc5mo4nW4t-sOPILCE&libraries=places&callback=initMap" type="text/javascript"></script>
<section id="roles">
	<div class="container-fluid">

		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">	
				<div class="row">
					<div class="col-sm-9 prop_left_details">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

						<div class="form-group"><span style="color: red">*</span>
							<div style="display: none">
								<?php echo form_input(array('id'=>'property_name_original', 'name'=>'property_name_original', 'value'=>set_value('property_name_original', isset($record->property_name) ? $record->property_name : ''), 'class'=>'form-control form-control-lg'));?>
							</div>

							<label for="property_name"><?php echo lang('property_name')?>:</label>			
							<?php echo form_input(array('id'=>'property_name', 'name'=>'property_name', 'value'=>set_value('property_name', isset($record->property_name) ? $record->property_name : ''), 'class'=>'form-control form-control-lg'));?>
							<div id="error-property_name"></div>			
						</div>
						<div class="row">
							<div class="col-sm-4 property_vital_details">
								<div class="form-group"><span style="color: red">*</span> 
									<label for="property_estate_id"><?php echo lang('property_estate_id')?>:</label>
									<?php echo form_dropdown('property_estate_id', $estates, set_value('property_estate_id', (isset($record->property_estate_id)) ? $record->property_estate_id : ''), 'id="property_estate_id" class="form-control"'); ?>
									<div id="error-property_estate_id"></div>
								</div>

								<div class="form-group"><span style="color: red">*</span>
									<label for="property_category_id"><?php echo lang('property_category_id')?>:</label>
									<?php echo form_dropdown('property_category_id', $categories, set_value('property_category_id', (isset($record->property_category_id)) ? $record->property_category_id : ''), 'id="property_category_id" class="form-control"'); ?>
									<div id="error-property_category_id"></div>
								</div>

								<div class="form-group"><span style="color: red">*</span>
									<label for="property_location_id"><?php echo lang('property_location_id')?>:</label>
									<?php echo form_dropdown('property_location_id', $locations, set_value('property_location_id', (isset($record->property_location_id)) ? $record->property_location_id : ''), 'id="property_location_id" class="form-control"'); ?>
									<div id="error-property_location_id"></div>
								</div>
							</div>
							<div class="col-sm-8 property_overview">
								<div class="form-group"><span style="color: red">*</span>
									<label for="property_overview"><?php echo lang('property_overview')?>:</label>			
									<?php echo form_textarea(array('id'=>'property_overview', 'name'=>'property_overview', 'rows'=>'3', 'value'=>set_value('property_overview', isset($record->property_overview) ? $record->property_overview : '', false), 'class'=>'form-control')); ?>
									<div id="error-property_overview"></div>			
								</div>
							</div>
						</div>

						<div id="accordion">

							<?php if(isset($record->property_id)){ ?>
							   <div class="card">
							      <div class="card-header">
							        <a class="card-link" data-toggle="collapse" href="#collapseOne">
							        	<?php echo lang('property_slider')?>		          
							        </a>
						        	<div class="button_add_slider">
							        	<?php if ($this->acl->restrict('properties.property_sliders.add', 'return')): ?>
											<a href="<?php echo site_url('properties/property_sliders/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add_slider')?></a>
										<?php endif; ?>
									</div>
									<input type="hidden" id="property_id" data-id="<?php echo $record->property_id; ?>" />
							      </div>
							      <div id="collapseOne" class="collapse" data-parent="#accordion">
							        <div class="card-body">

							     		<?php if ($sliders): ?>
											<div id="sortable" class="row">
												<?php foreach ($sliders as $slider): ?>
													<li class="ui-state-default col-sm-3" data-id="<?php echo $slider->property_slider_id; ?>">
														<div class="thumbnail">
															<div class="pull-right btn-actions">
																<a data-toggle="modal" data-target="#modal" class="btn btn-xs btn-success" href="<?php echo site_url('properties/property_sliders/form/edit/' . $slider->property_slider_id); ?>"><div class="fa fa-pencil"></div></a>
																<a data-toggle="modal" data-target="#modal" class="btn btn-xs btn-danger" href="<?php echo site_url('properties/property_sliders/delete/' . $slider->property_slider_id); ?>"><div class="fa fa-trash"></div></a>
															</div>
															<img src="<?php echo site_url($slider->property_slider_image); ?>" width="100%" />
														</div>
													</li>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
			
							        </div>
							      </div>
							    </div>
							<?php } ?>

						    <div class="card">
						      <div class="card-header">
						        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
						       <label for="property_map_location"><?php echo lang('property_map_location')?></label> & <label for="property_nearby_facilities"><?php echo lang('property_nearby_facilities')?></label>
						      </a>
						      </div>
						      <div id="collapseTwo" class="collapse" data-parent="#accordion">
						        <div class="card-body">
									<div class="form-group">
													
										<input id="pac-input" type="text" placeholder="Search">
										<div id="map"></div>
										<div id="error-property_latitude"></div><div id="error-property_longitude"></div>	

										<div style="display: none;">
											<?php echo form_input(array('id'=>'property_longitude', 'name'=>'property_longitude', 'value'=>set_value('property_longitude', isset($record->property_longitude) ? $record->property_longitude : ''), 'class'=>'form-control'));?>
											<?php echo form_input(array('id'=>'property_latitude', 'name'=>'property_latitude', 'value'=>set_value('property_latitude', isset($record->property_latitude) ? $record->property_latitude : ''), 'class'=>'form-control'));?>
										</div>
									</div>     
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label for="property_nearby_malls"><?php echo lang('property_nearby_malls')?>:</label>			
												<?php echo form_textarea(array('id'=>'property_nearby_malls', 'name'=>'property_nearby_malls', 'rows'=>'3', 'value'=>set_value('property_nearby_malls', isset($record->property_nearby_malls) ? $record->property_nearby_malls : '', false), 'class'=>'form-control')); ?>
												<div id="error-property_nearby_malls"></div>			
											</div>

											<div class="form-group">
												<label for="property_nearby_markets"><?php echo lang('property_nearby_markets')?>:</label>			
												<?php echo form_textarea(array('id'=>'property_nearby_markets', 'name'=>'property_nearby_markets', 'rows'=>'3', 'value'=>set_value('property_nearby_markets', isset($record->property_nearby_markets) ? $record->property_nearby_markets : '', false), 'class'=>'form-control')); ?>
												<div id="error-property_nearby_markets"></div>			
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="property_nearby_hospitals"><?php echo lang('property_nearby_hospitals')?>:</label>			
												<?php echo form_textarea(array('id'=>'property_nearby_hospitals', 'name'=>'property_nearby_hospitals', 'rows'=>'3', 'value'=>set_value('property_nearby_hospitals', isset($record->property_nearby_hospitals) ? $record->property_nearby_hospitals : '', false), 'class'=>'form-control')); ?>
												<div id="error-property_nearby_hospitals"></div>			
											</div>

											<div class="form-group">
												<label for="property_nearby_schools"><?php echo lang('property_nearby_schools')?>:</label>			
												<?php echo form_textarea(array('id'=>'property_nearby_schools', 'name'=>'property_nearby_schools', 'rows'=>'3', 'value'=>set_value('property_nearby_schools', isset($record->property_nearby_schools) ? $record->property_nearby_schools : '', false), 'class'=>'form-control')); ?>
												<div id="error-property_nearby_schools"></div>			
											</div>  
										</div>
									</div>
						        </div>
						      </div>
						    </div><!-- /2nd card -->

						    <div class="card">
						      <div class="card-header">
						        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
						         <label for="property_website"><?php echo lang('property_website')?></label> & <label for="property_social_page"><?php echo lang('property_social_page')?></label>	
						        </a>
						      </div>
						      <div id="collapseThree" class="collapse" data-parent="#accordion">
						        <div class="card-body">

							        <div class="form-group">
										 <label for="property_website"><?php echo lang('property_website')?></label>		
										<?php echo form_input(array('id'=>'property_website', 'name'=>'property_website', 'value'=>set_value('property_website', isset($record->property_website) ? $record->property_website : ''), 'class'=>'form-control'));?>
										<div id="error-property_website"></div>			
									</div>

									<div class="form-group">
										<label for="property_facebook" class="fa fa-facebook-square"></label>			
										<?php echo form_input(array('id'=>'property_facebook', 'name'=>'property_facebook', 'value'=>set_value('property_facebook', isset($record->property_facebook) ? $record->property_facebook : ''), 'class'=>'form-control'));?>
										<div id="error-property_facebook"></div>			
									</div>

									<div class="form-group">
										<label for="property_twitter" class="fa fa-twitter-square"></label>			
										<?php echo form_input(array('id'=>'property_twitter', 'name'=>'property_twitter', 'value'=>set_value('property_twitter', isset($record->property_twitter) ? $record->property_twitter : ''), 'class'=>'form-control'));?>
										<div id="error-property_twitter"></div>			
									</div>

									<div class="form-group">
										<span for="property_instagram" class="fa fa-instagram"></span>			
										<?php echo form_input(array('id'=>'property_instagram', 'name'=>'property_instagram', 'value'=>set_value('property_instagram', isset($record->property_instagram) ? $record->property_instagram : ''), 'class'=>'form-control'));?>
										<div id="error-property_instagram"></div>			
									</div>

									<div class="form-group">
										<label for="property_linkedin" class="fa fa-linkedin-square"></label>				
										<?php echo form_input(array('id'=>'property_linkedin', 'name'=>'property_linkedin', 'value'=>set_value('property_linkedin', isset($record->property_linkedin) ? $record->property_linkedin : ''), 'class'=>'form-control'));?>
										<div id="error-property_linkedin"></div>			
									</div>

									<div class="form-group">
										<label for="property_youtube" class="fa fa-youtube"></label>				
										<?php echo form_input(array('id'=>'property_youtube', 'name'=>'property_youtube', 'value'=>set_value('property_youtube', isset($record->property_youtube) ? $record->property_youtube : ''), 'class'=>'form-control'));?>
										<div id="error-property_youtube"></div>			
									</div>

						        </div>
						      </div>
						    </div><!-- /3rd card -->

						</div>
	
					</div>

					<div class="col-sm-3  prop_right_details">
						<div class="form-group">
							<!-- <label for="property_image"><?php echo lang('property_image')?>:</label>		 -->	
							<br>		
							<a href="<?php echo site_url('properties/properties/form_upload/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="property_active_image" src="<?php echo site_url(isset($record->property_image) ? $record->property_image : 'ui/images/placeholder.png'); ?>" class="img-responsive" width="100%" alt=""/>
							</a>
							<br>
							<div id="error-property_image"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'property_image', 'name'=>'property_image', 'value'=>set_value('property_image', isset($record->property_image) ? $record->property_image : ''), 'class'=>'form-control'));?>
							</div>		
						</div>

						<input type="text" value="İstanbul, Adıyaman, Adana, Urfa" data-role="tagsinput" class="form-control" />

						<div class="form-group">
						
							<label for="property_tags"><?php echo lang('property_tags')?>:</label>			
							<?php echo form_input(array('id'=>'property_tags', 'name'=>'property_tags', 'value'=>set_value('property_tags', isset($record->property_tags) ? $record->property_tags : ''), 'class'=>'form-control'));?>
							<div id="error-property_tags"></div>			
						</div>

						<div class="form-group">
							<label for="property_status"><?php echo lang('property_status')?>:</label>
							<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
								<?php echo form_dropdown('property_status', $options, set_value('property_status', (isset($record->property_status)) ? $record->property_status : ''), 'id="property_status" class="form-control"'); ?>
								<div id="error-property_status"></div>
						</div>

						<?php if ($action == 'add'): ?>
							<button id="post" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
								<i class="fa fa-save"></i> <?php echo lang('button_add')?>
							</button>
						<?php elseif ($action == 'edit'): ?>
							<button id="post" class="btn btn-success btn-lg btn-block" type="submit" data-loading-text="<?php echo lang('processing')?>">
								<i class="fa fa-save"></i> <?php echo lang('button_update')?>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>