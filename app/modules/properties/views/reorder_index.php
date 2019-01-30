<section id="roles">
	<div class="container-fluid">
		<div class="card">
			
			<?php 

			if(isset($property) && $property){ 
				$subject = $property;
				$field = 'property'; 
				$controller = 'properties';
			}

			if(isset($estates) && $estates){ 
				$subject = $estates;
				$field = 'estate'; 
				$controller = 'estates';
			}

			if(isset($categories) && $categories){ 
				$subject = $categories;
				$field = 'category'; 
				$controller = 'categories';
			}

				$name  = $field.'_name';
				$id    = $field.'_id';
				$order = $field.'_order';
				$image = $field.'_image';
			?>

			<div class="card-header d-flex align-items-center">
				<h3 class="h3"><?php echo $field; ?> Order</h3>
			</div>
			<div class="card-body">	
				<div class="division_container">	
					<div class="heading_division">Available <?php echo $field; ?></div>
					<ul id="sortable">					
						<?php foreach ($subject as $key => $value) { ?>
							<li class="ui-state-default" data-id="<?php echo $value->$id; ?>"">
								
								<img src="<?php echo base_url().$value->$image; ?>" onerror="this.onerror=null;this.src='<?php echo site_url('ui/images/placeholder.png')?>';">
								<span class="ui-icon ui-icon-arrowthick-2-n-s ">
									<span class="order_text"><?php echo $value->$order < 98 ? $value->$order+1: ''; ?></span>
									<?php echo $value->$name; ?>
								</span>
							</li>
						<?php }  ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var controller = '<?php echo $controller ?>';
</script>