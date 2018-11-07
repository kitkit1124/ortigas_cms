<section id="roles">
	<div class="container-fluid">
		<div class="card">
	
			<div class="card-header d-flex align-items-center">
				<h3 class="h4">Property Division Order</h3>
			</div>
			<div class="card-body">	
				<div class="division_container">	
					<div class="heading_division">Available Divisions</div>
					<ul id="sortable">
						<?php foreach ($divisions as $key => $value) { ?>
							<li class="ui-state-default" data-id="<?php echo $value->setting_id; ?>">
								<i class="fa fa-arrows-v" aria-hidden="true"></i>
								<span class="ui-icon ui-icon-arrowthick-2-n-s "></span>
								<?php echo $value->setting_division; ?>
							</li>
						<?php }  ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>