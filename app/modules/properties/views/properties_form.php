<section id="roles">
	<div class="container-fluid">

		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->property_id) AND isset($record->property_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/properties/properties/' . $record->property_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">	
				<div class="row">
					<div class="col-sm-9 prop_left_details">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

						<div class="form-group">
							<div style="display: none">
								<?php echo form_input(array('id'=>'property_name_original', 'name'=>'property_name_original', 'value'=>set_value('property_name_original', isset($record->property_name) ? $record->property_name : ''), 'class'=>'form-control form-control-lg'));?>
							</div>

							<label for="property_name"><?php echo lang('property_name')?>:</label><span class="error_asterisk"> *</span>				
							<?php echo form_input(array('id'=>'property_name', 'name'=>'property_name', 'value'=>set_value('property_name', isset($record->property_name) ? $record->property_name : ''), 'class'=>'form-control form-control-lg'));?>
							<div id="error-property_name"></div>			
						</div>

						<div class="form-group">
							<label for="property_slug"><?php echo lang('property_slug')?>:</label>			
							<?php echo form_input(array('id'=>'property_slug', 'name'=>'property_slug', 'value'=>set_value('property_slug', isset($record->property_slug) ? $record->property_slug : ''), 'class'=>'form-control form-control-lg'));?>
							<div id="error-property_slug"></div>			
						</div>

						<div class="row">
							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_estate_id"><?php echo lang('property_estate_id')?>:</label><span class="error_asterisk"> *</span>	
									<?php echo form_dropdown('property_estate_id', $estates, set_value('property_estate_id', (isset($record->property_estate_id)) ? $record->property_estate_id : ''), 'id="property_estate_id" class="form-control"'); ?>
									<div id="error-property_estate_id"></div>
								</div>
							</div>
							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_category_id"><?php echo lang('property_category_id')?>:</label><span class="error_asterisk"> *</span>	
									<?php echo form_dropdown('property_category_id', $categories, set_value('property_category_id', (isset($record->property_category_id)) ? $record->property_category_id : ''), 'id="property_category_id" class="form-control"'); ?>
									<div id="error-property_category_id"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_location_id"><?php echo lang('property_location_id')?>:</label><span class="error_asterisk"> *</span>	
									<?php echo form_dropdown('property_location_id', $locations, set_value('property_location_id', (isset($record->property_location_id)) ? $record->property_location_id : ''), 'id="property_location_id" class="form-control"'); ?>
									<div id="error-property_location_id"></div>
								</div>
							</div>
							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_prop_type_id"><?php echo lang('property_prop_type_id')?>:</label><span class="error_asterisk"> *</span>	
									<?php echo form_dropdown('property_prop_type_id', $property_types, set_value('property_prop_type_id', (isset($record->property_prop_type_id)) ? $record->property_prop_type_id : ''), 'id="property_prop_type_id" class="form-control"'); ?>
									<div id="error-property_prop_type_id"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_price_range_id"><?php echo lang('property_price_range_id')?>:</label>
									<?php echo form_dropdown('property_price_range_id', $price_range, set_value('property_price_range_id', (isset($record->property_price_range_id)) ? $record->property_price_range_id : ''), 'id="property_price_range_id" class="form-control"'); ?>
									<div id="error-property_price_range_id"></div>
								</div>
							</div>

							<div class="col-sm-6 property_vital_details">
								<div class="form-group">
									<label for="property_featured" class="property_featured_label"><?php echo lang('property_featured')?>?</label>
									<div>
										<?php echo form_radio('property_featured', 1, set_value('property_featured', (isset($record->property_is_featured) && $record->property_is_featured) ? TRUE: FALSE), 'id="property_featured1"'); ?><label for="property_featured1" class="pointer pointer1">Yes</label>
										<?php echo form_radio('property_featured', 0, set_value('property_featured', (isset($record->property_is_featured) && $record->property_is_featured) ? FALSE : TRUE), 'id="property_featured2"'); ?><label for="property_featured2" class="pointer">No</label>
									</div>
									<div id="error-property_featured"></div>
								</div>
							</div>
							
						</div>
						
						<?php
							if(isset($record->property_id) && $record->property_id){
								$data['section_type'] = 'properties';
								$data['section_id'] = $record->property_id;
								
								echo $this->load->view('image_sliders_index', $data); 
							}
						?>

						<div id="accordion">
							<div class="card">
						      <div class="card-header">
						        <a class="card-link" data-toggle="collapse" href="#property_descriptions"><label><?php echo lang('property_description')?> <span class="error_asterisk"> *</span></label>
						        	<div id="error-property_overview"></div>	
									<div id="error-property_bottom_overview"></div>
						        </a>
						      </div>
						      <div id="property_descriptions" class="collapse" data-parent="#accordion">
						        <div class="card-body">		
						        	<div class="property_snippet_quote">
										<div class="form-group">
											<label for="property_snippet_quote"><?php echo lang('property_snippet_quote')?>:</label><span class="error_asterisk"> *</span>				
											<?php echo form_textarea(array('id'=>'property_snippet_quote', 'name'=>'property_snippet_quote', 'rows'=>'2', 'value'=>set_value('property_snippet_quote', isset($record->property_snippet_quote) ? utf8_decode($record->property_snippet_quote) : '', false), 'class'=>'form-control')); ?> 
											<div id="error-property_snippet_quote"></div>			
										</div>
									</div>

									<div class="property_overview">
										<div class="form-group">
											<label for="property_overview"><?php echo lang('property_overview')?>:</label><span class="error_asterisk"> *</span>				
											<?php echo form_textarea(array('id'=>'property_overview', 'name'=>'property_overview', 'rows'=>'3', 'value'=>set_value('property_overview', isset($record->property_overview) ? utf8_decode($record->property_overview) : '', false), 'class'=>'form-control')); ?> 
											<div id="error-property_overview"></div>			
										</div>
									</div>

									<div class="property_bottom_overview hidden hide">
										<div class="form-group">
											<label for="property_bottom_overview"><?php echo lang('property_bottom_overview')?>:</label>			
											<?php echo form_textarea(array('id'=>'property_bottom_overview', 'name'=>'property_bottom_overview', 'rows'=>'3', 'value'=>set_value('property_bottom_overview', isset($record->property_bottom_overview) ? utf8_decode($record->property_bottom_overview) : '', false), 'class'=>'form-control')); ?> 
											<div id="error-property_bottom_overview"></div>			
										</div>
									</div>

									<div class="">
										<div class="form-group">
											<label for="property_estate_id"><?php echo lang('property_page_id')?>:</label>
											<?php echo form_dropdown('property_page_id', $property_pages, set_value('property_page_id', (isset($record->property_page_id)) ? $record->property_page_id : ''), 'id="property_page_id" class="form-control form-control-lg"'); ?>
											<div id="error-property_page_id"></div>
										</div>
									</div>
						        </div>
						      </div>
						    </div>

							<?php
							if(isset($record->property_id) && $record->property_id){
								$data['sliders'] = $construction_sliders;
								$data['section_type'] = 'construction';
								$data['section_id'] = $record->property_id;
								
								echo $this->load->view('image_sliders_index2', $data); 
							}
						?>							
						   <div class="card">
						      <div class="card-header">
						        <a class="card-link" data-toggle="collapse" href="#construction_update"><label><?php echo lang('property_construction')?></label></a>
						      </div>
						      <div id="construction_update" class="collapse" data-parent="#accordion">
						        <div class="card-body">		
									<div class="property_construction_update_container">
										<input type="range" min="1" max="5" class="property_construction_update" id="property_construction_update" value = "<?php echo isset($record->property_construction_update) ? $record->property_construction_update : ''; ?>">
									</div>
									<div class="row year">
									  	<div class="col-sm-4 ground">
									  		<?php echo form_input(array('id'=>'property_ground', 'name'=>'property_ground', 'value'=>set_value('property_ground', isset($record->property_ground) ? $record->property_ground : ''), 'class'=>'form-control'));?>
									  	</div>
									  	<div class="col-sm-4 presell">
									  		<center><?php echo form_input(array('id'=>'property_presell', 'name'=>'property_presell', 'value'=>set_value('property_presell', isset($record->property_presell) ? $record->property_presell : ''), 'class'=>'form-control'));?></center>
									  	</div>
									  	<div class="col-sm-4 turnover">
									  		<?php echo form_input(array('id'=>'property_turnover', 'name'=>'property_turnover', 'value'=>set_value('property_turnover', isset($record->property_turnover) ? $record->property_turnover : ''), 'class'=>'form-control'));?>
									  	</div>

									  	<div class="col-sm-4 ground">
									  		<label>Ground Breaking</label>
									  	</div>
									  	<div class="col-sm-4 presell">
									  		<label>Preselling</label>
									  	</div>
									  	<div class="col-sm-4 turnover">
									  		<label>Turnover</label>
									  	</div>
									</div>
						        </div>
						      </div>
						    </div>
						
							<?php if(isset($record->property_id) && $record->property_id){ ?>
								<div id="amenities_container">
									<?php $data['property_id'] = $record->property_id; ?>								
									<?php echo $this->load->view('properties/amenities_index', $data); ?>
								</div>

							<?php } ?>

						    <div class="card">
						      <div class="card-header">
						        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
						       <label for="property_map_location"><?php echo lang('property_map_location')?> & </label><label for="property_nearby_facilities"><?php echo lang('property_nearby_facilities')?></label>
						       <div id="error-property_latitude"></div><div id="error-property_longitude"></div>
						      </a>
						      </div>
						      <div id="collapseTwo" class="collapse" data-parent="#accordion">
						        <div class="card-body">

						        	<div class="form-group">
										<label class="control-label" for="property_location_description">
											<?php echo lang('property_location_description'); ?>
										</label>
										<?php echo form_textarea(array('id'=>'property_location_description', 'name'=>'property_location_description', 'rows'=>'2', 'value'=>set_value('property_location_description', isset($record->property_location_description) ? $record->property_location_description : '',FALSE), 'class'=>'form-control meta-title '));?>
										<div id="error-property_location_description"></div>
									</div>

						        	<div class="form-group">
										<label class="control-label" for="property_map_name"><?php echo lang('property_map_name'); ?> Override <span style="color:#CCC">(Optional)</span>: </label>
										<?php echo form_textarea(array('id'=>'property_map_name', 'name'=>'property_map_name', 'rows'=>'2', 'value'=>set_value('property_map_name', isset($record->property_map_name) ? $record->property_map_name : '',FALSE), 'class'=>'form-control meta-title '));?>
										<div id="error-property_map_name"></div>
									</div>


									<div class="form-group">
														
										<input id="pac-input" type="text" placeholder="Search">
										<div id="map"></div>
										<div style="display: none;">
											<?php echo form_input(array('id'=>'property_longitude', 'name'=>'property_longitude', 'value'=>set_value('property_longitude', isset($record->property_longitude) ? $record->property_longitude : ''), 'class'=>'form-control'));?>
											<?php echo form_input(array('id'=>'property_latitude', 'name'=>'property_latitude', 'value'=>set_value('property_latitude', isset($record->property_latitude) ? $record->property_latitude : ''), 'class'=>'form-control'));?>
										</div>
									</div>     
									<div class="row hidden hide">
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
										 <label for="property_link_label" class="fa fa-external-link">&nbsp;</label><label for="property_link_label"> <?php echo lang('property_link_label')?></label>	
										<?php echo form_input(array('id'=>'property_link_label', 'name'=>'property_link_label', 'value'=>set_value('property_link_label', isset($record->property_link_label) ? $record->property_link_label : ''), 'class'=>'form-control'));?>
										<div id="error-property_link_label"></div>			
									</div>

							        <div class="form-group">
										 <label for="property_website" class="fa fa-globe">&nbsp;</label><label for="property_website"> <?php echo lang('property_website')?></label>	
										<?php echo form_input(array('id'=>'property_website', 'name'=>'property_website', 'value'=>set_value('property_website', isset($record->property_website) ? $record->property_website : ''), 'class'=>'form-control'));?>
										<div id="error-property_website"></div>			
									</div>

									<div class="form-group">
										<label for="property_facebook" class="fa fa-facebook-square">&nbsp;</label><label for="property_website"> <?php echo lang('property_facebook')?></label>			
										<?php echo form_input(array('id'=>'property_facebook', 'name'=>'property_facebook', 'value'=>set_value('property_facebook', isset($record->property_facebook) ? $record->property_facebook : ''), 'class'=>'form-control'));?>
										<div id="error-property_facebook"></div>			
									</div>

									<div class="form-group">
										<label for="property_twitter" class="fa fa-twitter-square">&nbsp;</label><label for="property_website"> <?php echo lang('property_twitter')?></label>		
										<?php echo form_input(array('id'=>'property_twitter', 'name'=>'property_twitter', 'value'=>set_value('property_twitter', isset($record->property_twitter) ? $record->property_twitter : ''), 'class'=>'form-control'));?>
										<div id="error-property_twitter"></div>			
									</div>

									<div class="form-group">
										<label for="property_instagram" class="fa fa-instagram">&nbsp;</label><label for="property_website"> <?php echo lang('property_instagram')?></label>	
										<?php echo form_input(array('id'=>'property_instagram', 'name'=>'property_instagram', 'value'=>set_value('property_instagram', isset($record->property_instagram) ? $record->property_instagram : ''), 'class'=>'form-control'));?>
										<div id="error-property_instagram"></div>			
									</div>

									<div class="form-group">
										<label for="property_linkedin" class="fa fa-linkedin-square">&nbsp;</label><label for="property_website"> <?php echo lang('property_linkedin')?></label>			
										<?php echo form_input(array('id'=>'property_linkedin', 'name'=>'property_linkedin', 'value'=>set_value('property_linkedin', isset($record->property_linkedin) ? $record->property_linkedin : ''), 'class'=>'form-control'));?>
										<div id="error-property_linkedin"></div>			
									</div>

									<div class="form-group">
										<label for="property_youtube" class="fa fa-youtube">&nbsp;</label><label for="property_website"> <?php echo lang('property_youtube')?></label>				
										<?php echo form_input(array('id'=>'property_youtube', 'name'=>'property_youtube', 'value'=>set_value('property_youtube', isset($record->property_youtube) ? $record->property_youtube : ''), 'class'=>'form-control'));?>
										<div id="error-property_youtube"></div>			
									</div>

						        </div>
						      </div>
						    </div><!-- /3rd card -->

						    <?php if(isset($record->property_id) && $record->property_id){ ?>

								<div id="related_link">
									<?php $data['section_id'] = $record->property_id; ?>
									<?php $data['section_type'] = 'properties'; ?>
									<?php echo $this->load->view('properties/related_links_index', $data); ?>
								</div>

								<div id="faq_index">
									<?php $data['property_id'] = $record->property_id; ?>
									<?php echo $this->load->view('properties/faq_index', $data); ?>
								</div>

							<?php } ?>

						</div>
					</div>

					<div class="col-sm-3  prop_right_details">
						<div class="form-group">
							<label for="property_image"><?php echo lang('property_image')?>: <span class="error_asterisk"> *</span></label>
							<br>		
							<a href="<?php echo site_url('properties/properties/form_upload/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="property_active_image" src="<?php echo isset($record->property_image) ? getenv('UPLOAD_ROOT').$record->property_image : site_url('ui/images/placeholder.png') ; ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</a>
							<?php echo form_textarea(array('id'=>'property_alt_image', 'name'=>'property_alt_image', 'rows'=>'2', 'value'=>set_value('property_alt_image', isset($record->property_alt_image) ? $record->property_alt_image : '', false), 'class'=>'form-control', 'placeholder' => lang('property_alt_image') )); ?> 

							<br>
							<div id="error-property_image"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'property_image', 'name'=>'property_image', 'value'=>set_value('property_image', isset($record->property_image) ? $record->property_image : ''), 'class'=>'form-control'));?>
							</div>		
						</div>

						<div class="form-group">
							<label for="property_image"><?php echo lang('property_thumb')?>: <span class="error_asterisk"> *</span></label>
							<br>		
							<a href="<?php echo site_url('properties/properties/form_upload_thumb/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="property_active_thumb" src="<?php echo isset($record->property_thumb) ? getenv('UPLOAD_ROOT').$record->property_thumb : site_url('ui/images/placeholder.png') ; ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</a>
							<?php echo form_textarea(array('id'=>'property_alt_thumb', 'name'=>'property_alt_thumb', 'rows'=>'2', 'value'=>set_value('property_alt_thumb', isset($record->property_alt_thumb) ? $record->property_alt_thumb : '', false), 'class'=>'form-control', 'placeholder' => lang('property_alt_thumb') )); ?> 
							<br>
							<div id="error-property_thumb"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'property_thumb', 'name'=>'property_thumb', 'value'=>set_value('property_thumb', isset($record->property_thumb) ? $record->property_thumb : ''), 'class'=>'form-control'));?>
							</div>		
						</div>

						<div class="form-group">
							<label for="property_image"><?php echo lang('property_logo')?>: 
							<br>	
								<?php if(isset($record->property_logo) && $record->property_logo && $action == 'edit'): ?>
									<i class="fa fa-window-close clear_logo" aria-hidden="true"></i>
								<?php endif;?>	
							<a href="<?php echo site_url('properties/properties/form_upload_logo/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="property_active_logo" src="<?php echo isset($record->property_logo) ? getenv('UPLOAD_ROOT').$record->property_logo : site_url('ui/images/placeholder.png') ; ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</a>
								
							<?php echo form_textarea(array('id'=>'property_alt_logo', 'name'=>'property_alt_logo', 'rows'=>'2', 'value'=>set_value('property_alt_logo', isset($record->property_alt_logo) ? $record->property_alt_logo : '', false), 'class'=>'form-control', 'placeholder' => lang('property_alt_logo') )); ?> 
							<br>
							<div id="error-property_logo"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'property_logo', 'name'=>'property_logo', 'value'=>set_value('property_logo', isset($record->property_logo) ? $record->property_logo : ''), 'class'=>'form-control'));?>
							</div>		
						</div>

						<div class="form-group">
							<label for="property_tags"><?php echo lang('property_tags')?>:</label>			
							<?php echo form_input(array('id'=>'property_tags', 'name'=>'property_tags', 'value'=>set_value('property_tags', isset($record->property_tags) ? $record->property_tags : ''), 'class'=>'form-control',  'data-role'=>'tagsinput'));?>
							<div id="error-property_tags"></div>			
						</div>

						<div class="form-group">
							<label for="property_availability"><?php echo lang('property_availability')?>:</label>
							<?php $options = create_dropdown('array', 'RFO,Pre-selling,Sold-Out'); ?>
								<?php echo form_dropdown('property_availability', $options, set_value('property_availability', (isset($record->property_availability)) ? $record->property_availability : ''), 'id="property_availability" class="form-control"'); ?>
								<div id="error-property_availability"></div>
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
var featured_numrows = '<?php echo $featured_numrows ?>';
var action = '<?php echo $action ?>';
var property_id = '<?php echo isset($record->property_id) ? $record->property_id : 0 ; ?>'
</script>