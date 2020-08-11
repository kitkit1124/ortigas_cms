<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN6cUNcHO88eddYIc5mo4nW4t-sOPILCE&libraries=places&callback=initMap" type="text/javascript"></script>
<section id="roles">
	<div class="container-fluid">

		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if (isset($record->career_id) AND isset($record->career_metatag_id)): ?>
						<a class="nav-link" href="<?php echo site_url('metatags/form/careers/careers/' . $record->career_id); ?>" data-toggle="modal" data-target="#modal" class="btn btn-info"><span class="fa fa-cog"></span> Meta Tags</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">	
				<div class="row">
					<div class="col-sm-9 media768">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						
					
						<div class="form-group">
							<label for="career_position_title"><?php echo lang('career_position_title')?>:</label><span class="error_asterisk"> *</span>				
							<?php echo form_input(array('id'=>'career_position_title', 'name'=>'career_position_title', 'value'=>set_value('career_position_title', isset($record->career_position_title) ? $record->career_position_title : ''), 'class'=>'form-control'));?>
							<?php echo form_input(array('id'=>'career_position_title_original', 'name'=>'career_position_title_original', 'value'=>set_value('career_position_title_original', isset($record->career_position_title) ? $record->career_position_title : ''), 'style'=>'display:none;'));?>
							<div id="error-career_position_title"></div>			
						</div>

						<div class="form-group">
							<label for="career_position_title"><?php echo lang('career_slug')?>:</label>			
							<?php echo form_input(array('id'=>'career_slug', 'name'=>'career_slug', 'value'=>set_value('career_slug', isset($record->career_slug) ? $record->career_slug : ''), 'class'=>'form-control'));?>
							<div id="error-career_slug"></div>			
						</div>
				
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label for="career_div"><?php echo lang('career_div')?>:</label><span class="error_asterisk"> *</span>	
										
									<?php echo form_dropdown('career_div', $divisions, set_value('career_div', (isset($record->career_div)) ? $record->career_div : ''), 'id="career_div" class="form-control"'); ?>
									<?php echo form_dropdown('career_div_original', $divisions, set_value('career_div_original', (isset($record->career_div)) ? $record->career_div : ''), 'id="career_div_original" style="display:none;"'); ?>
									<div id="error-career_div"></div>	
								</div>

								<div class="col-sm-6">
									<label for="career_dept"><?php echo lang('career_dept')?>:</label><span class="error_asterisk"> *</span>	

									<?php if(isset($record->career_div)) { $options = $departments; } else { $options = array(null=>'Please select Divisions first'); }?>	

									<?php echo form_dropdown('career_dept', $options, set_value('career_dept', (isset($record->career_dept)) ? $record->career_dept : ''), 'id="career_dept" class="form-control"'); ?>
									<?php echo form_dropdown('career_dept_original', $options, set_value('career_dept_original', (isset($record->career_dept)) ? $record->career_dept : ''), 'id="career_dept_original" style="display:none;"'); ?>
									<div id="error-career_dept"></div>
								</div>
							
							</div>	
						</div>
				
						<div class="row">
							<div class="form-group col-sm-6 media1024">
								<label for="career_req"><?php echo lang('career_req')?>:</label><span class="error_asterisk"> *</span>				
								<?php echo form_textarea(array('id'=>'career_req', 'name'=>'career_req', 'rows'=>'3', 'value'=>set_value('career_req', isset($record->career_req) ? utf8_decode($record->career_req) : '', false), 'class'=>'form-control')); ?>
								<div id="error-career_req"></div>			
							</div>

							<div class="form-group col-sm-6 media1024">
								<label for="career_res"><?php echo lang('career_res')?>:</label><span class="error_asterisk"> *</span>				
								<?php echo form_textarea(array('id'=>'career_res', 'name'=>'career_res', 'rows'=>'3', 'value'=>set_value('career_res', isset($record->career_res) ? utf8_decode($record->career_res) : '', false), 'class'=>'form-control')); ?>
								<div id="error-career_res"></div>			
							</div>
						</div>
					

						<?php echo form_input(array('id'=>'pac-input', 'placeholder'=>'Search', 'name'=>'pac-input', 'value'=>set_value('career_location', isset($record->career_location) ? $record->career_location : ''), 'class'=>''));?>
						<div id="map"></div>
						<div id="error-career_latitude"></div><div id="error-career_longitude"></div>	

						<div class="form-group" style="display: none;">
							<?php echo form_input(array('id'=>'career_latitude', 'name'=>'career_latitude', 'value'=>set_value('career_latitude', isset($record->career_latitude) ? $record->career_latitude : ''), 'class'=>'form-control'));?>
										
							<?php echo form_input(array('id'=>'career_longitude', 'name'=>'career_longitude', 'value'=>set_value('career_longitude', isset($record->career_longitude) ? $record->career_longitude : ''), 'class'=>'form-control'));?>		
						</div>


						<div class="form-group">
							<label for="career_location"><?php echo lang('career_location')?>:</label><span class="error_asterisk"> *</span>				
							<?php echo form_input(array('id'=>'career_location', 'name'=>'career_location', 'value'=>set_value('career_location', isset($record->career_location) ? $record->career_location : ''), 'class'=>'form-control'));?>
							<div id="error-career_location"></div>			
						</div>

					</div>
					<div class="col-sm-3 media768">
						<div class="form-group">
							<label for="career_active_image"><?php echo lang('career_image')?>:</label><span class="error_asterisk"> *</span>	
							<a href="<?php echo site_url('careers/careers/form_upload/add')?>"data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
								<img id="career_active_image" src="<?php echo isset($record->career_image) ? getenv('UPLOAD_ROOT').$record->career_image : site_url('ui/images/placeholder.png'); ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';" class="img-responsive" width="100%" alt=""/>
							</a>
							<br>
							<div id="error-career_image"></div>	

							<div style="display: none">
							<?php echo form_input(array('id'=>'career_image', 'name'=>'career_image', 'value'=>set_value('career_image', isset($record->career_image) ? $record->career_image : ''), 'class'=>'form-control'));?>
							</div>		
							<?php echo form_textarea(array('id'=>'career_alt_image', 'name'=>'career_alt_image', 'rows'=>'2', 'value'=>set_value('career_alt_image', isset($record->career_alt_image) ? $record->career_alt_image : '', false), 'class'=>'form-control', 'placeholder' =>  lang('career_alt_image'), 'title' =>  lang('career_alt_image') )); ?>
						</div>

						<div class="form-group">
							<label for="career_status"><?php echo lang('career_status')?>:</label>	
							<?php $options = create_dropdown('array', 'Active,Disabled'); ?>		
							<?php echo form_dropdown('career_status', $options, set_value('career_status', (isset($record->career_status)) ? $record->career_status : ''), 'id="career_status" class="form-control"'); ?>
							<div id="error-career_status"></div>
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

<!-- 	<iframe 
	  width="600" 
	  height="370" 
	  frameborder="0" 
	  scrolling="no" 
	  marginheight="0" 
	  marginwidth="0" 
	  src="https://maps.google.com/maps?q=14.6337,121.044&hl=es;z=14&amp;output=embed"
	 >
	 </iframe>
	 </small> -->

</section>
<script>
var site_url = '<?php echo site_url() ?>';
var post_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>