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
						<div class="col-sm-9">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							
							<div class="form-group">
								<div style="display: none">
								<?php echo form_input(array('id'=>'estate_name_original', 'name'=>'estate_name_original', 'value'=>set_value('estate_name_original', isset($record->estate_name) ? $record->estate_name : ''), 'class'=>'form-control form-control-lg'));?>
								</div>
								<label for="estate_name"><?php echo lang('estate_name')?>:</label>			
								<?php echo form_input(array('id'=>'estate_name', 'name'=>'estate_name', 'value'=>set_value('estate_name', isset($record->estate_name) ? $record->estate_name : ''), 'class'=>'form-control form-control-lg'));?>
								<div id="error-estate_name"></div>			
							</div>

							<div class="form-group">
								<label for="estate_text"><?php echo lang('estate_text')?>:</label>			
								<?php echo form_textarea(array('id'=>'estate_text', 'name'=>'estate_text', 'rows'=>'5', 'value'=>set_value('estate_text', isset($record->estate_text) ? $record->estate_text : '', false), 'class'=>'form-control')); ?>
								<div id="error-estate_text"></div>			
							</div>

							<?php
								if(isset($record->estate_id) && $record->estate_id){
									$data['section_type'] = 'estates';
									$data['section_id'] = $record->estate_id;
									
									echo $this->load->view('image_sliders_index', $data); 
								}
							?>

							<div class="form-group bottom_text">
								<label for="estate_bottom_text"><?php echo lang('estate_bottom_text')?>:</label>			
								<?php echo form_textarea(array('id'=>'estate_bottom_text', 'name'=>'estate_bottom_text', 'rows'=>'5', 'value'=>set_value('estate_bottom_text', isset($record->estate_bottom_text) ? $record->estate_bottom_text : '', false), 'class'=>'form-control')); ?>
								<div id="error-estate_bottom_text"></div>			
							</div>

							<div class="form-group">
								<label for="estate_location"><?php echo lang('estate_location')?>:</label>
											
								
								<input id="pac-input" type="text" placeholder="Search">
								<div id="map"></div>
								<div id="error-estate_location"></div>

								<div style="display: none">				
									<?php echo form_input(array('id'=>'estate_latitude', 'name'=>'estate_latitude', 'value'=>set_value('estate_latitude', isset($record->estate_latitude) ? $record->estate_latitude : ''), 'class'=>'form-control'));?>
						
									<?php echo form_input(array('id'=>'estate_longtitude', 'name'=>'estate_longtitude', 'value'=>set_value('estate_longtitude', isset($record->estate_longtitude) ? $record->estate_longtitude : ''), 'class'=>'form-control'));?>
								</div>
								 
							</div>


							<?php if(isset($record->estate_id) && $record->estate_id){ ?>

								<div id="related_link">
									<?php $data['section_id'] = $record->estate_id; ?>
									<?php $data['section_type'] = 'estates'; ?>
									<?php echo $this->load->view('properties/related_links_index', $data); ?>
								</div>

							<?php } ?>

						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="estate_image"><?php echo lang('estate_image')?>:</label>			
								<br>
								<a href="<?php echo site_url('properties/estates/form_upload/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-add" id="upload_button">
									<img id="estate_active_photo" src="<?php echo site_url(isset($record->estate_image) ? $record->estate_image : 'ui/images/placeholder.png'); ?>" class="img-responsive" width="100%" alt=""/>
								</a>
								<br />

								<div id="error-estate_image"></div>	

								<div style="display: none;">
								<?php echo form_input(array('id'=>'estate_image', 'name'=>'estate_image', 'value'=>set_value('estate_image', isset($record->estate_image) ? $record->estate_image : ''), 'class'=>'form-control'));?>
								</div>		
							</div>

							<div class="form-group">
								<label for="estate_thumb"><?php echo lang('estate_thumb')?>:</label>			
								<br>
								<a href="<?php echo site_url('properties/estates/form_upload_thumb/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm  btn-add" id="upload_button_thumb">
									<img id="estate_active_thumb" src="<?php echo site_url(isset($record->estate_thumb) ? $record->estate_thumb : 'ui/images/placeholder.png'); ?>" class="img-responsive" width="100%" alt=""/>
								</a>
								<br />

								<div id="error-estate_thumb"></div>	

								<div style="display: none;">
								<?php echo form_input(array('id'=>'estate_thumb', 'name'=>'estate_thumb', 'value'=>set_value('estate_thumb', isset($record->estate_thumb) ? $record->estate_thumb : ''), 'class'=>'form-control'));?>
								</div>		
							</div>

							<div class="form-group">
								<label for="estate_status"><?php echo lang('estate_status')?>:</label>
								<?php $options = create_dropdown('array', 'Active,Disabled'); ?>
								<?php echo form_dropdown('estate_status', $options, set_value('estate_status', (isset($record->estate_status)) ? $record->estate_status : ''), 'id="estate_status" class="form-control"'); ?>
								<div id="error-estate_status"></div>
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