<?php 
$this->template->add_css(module_css('properties', 'image_sliders_index'), 'embed'); 
$this->template->add_js(module_js('properties', 'image_sliders_index'), 'embed');
$this->template->add_js('mods/jquery-ui/jquery-ui.min.js');
?>

<div id="accordion">
	<?php if(isset($section_id)){ ?>
	   <div class="card">
	      <div class="card-header">
	        <a class="card-link" data-toggle="collapse" href="#<?php echo $section_type; ?>">
	        	<label><?php echo ucwords($section_type).' Slider'; ?></label>		          
	        </a>
        	<div class="button_add_slider">
	        	<?php if ($this->acl->restrict('properties.image_sliders.add', 'return')): ?>
					<a href="<?php echo site_url('properties/image_sliders/form/add?section_type='.$section_type.'&section_id='.$section_id)?>" data-toggle="modal" data-target="#modal-lg" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo 'Add Slider'?></a>
				<?php endif; ?>
			</div>
	      </div>
	      <div id="<?php echo $section_type; ?>" class="collapse show" data-parent="#accordion">
	        <div class="card-body">

	     		<?php if ($sliders): ?>
					<div id="sortable" class="row">
						<?php foreach ($sliders as $slider): 
							$src = $slider->image_slider_image;
							if(substr($src,-3) == 'png') {
								$src = str_replace(".png", "_thumb.png", $src); 
							}else{
								$src = str_replace(".jpg", "_thumb.jpg", $src); 
							}
						?>

							<li class="ui-state-default col-sm-3" data-id="<?php echo $slider->image_slider_id; ?>">
								<div class="thumbnail">
									<div class="pull-right thumbnail_buttons">
										<a data-toggle="modal" data-target="#modal-lg" class="btn btn-xs btn-success" href="<?php echo site_url('properties/image_sliders/form/edit/' . $slider->image_slider_id); ?>"><div class="fa fa-pencil"></div></a>
										<a data-toggle="modal" data-target="#modal-lg" class="btn btn-xs btn-danger" href="<?php echo site_url('properties/image_sliders/delete/' . $slider->image_slider_id); ?>"><div class="fa fa-trash"></div></a>
									</div>
									<img src="<?php echo getenv('UPLOAD_ROOT').$src; ?>" width="100%" />
								</div>
							</li>
						<?php endforeach; ?>
					</div>
				<?php endif; ?> 

	        </div>
	      </div>
	    </div>
	<?php } ?>
</div>

<script type="text/javascript">
	var section_id =  '<?php echo $section_id; ?>';
	var section_type = '<?php echo $section_type ?>';
</script>

							
			