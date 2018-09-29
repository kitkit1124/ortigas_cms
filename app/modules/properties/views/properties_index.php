<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('properties.properties.add', 'return')): ?>
						<a href="<?php echo site_url('properties/properties/form/add')?>" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">				
				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="all"><?php echo lang('index_id'); ?></th>
							<th class="min-desktop"><?php echo lang('index_name'); ?></th>
							<th class="none"><?php echo lang('index_estate_id'); ?></th>
							<th class="none"><?php echo lang('index_category_id'); ?></th>
							<th class="none"><?php echo lang('index_location_id'); ?></th>
							<th class="none"><?php echo lang('index_slug'); ?></th>
							<th class="none"><?php echo lang('index_price_range_id'); ?></th>
							<th class="none"><?php echo lang('index_overview'); ?></th>
							<th class="none"><?php echo lang('index_image'); ?></th>
							<th class="none"><?php echo lang('index_website'); ?></th>
							<th class="none"><?php echo lang('index_facebook'); ?></th>
							<th class="none"><?php echo lang('index_twitter'); ?></th>
							<th class="none"><?php echo lang('index_instagram'); ?></th>
							<th class="none"><?php echo lang('index_linkedin'); ?></th>
							<th class="none"><?php echo lang('index_youtube'); ?></th>
							<th class="none"><?php echo lang('index_latitude'); ?></th>
							<th class="none"><?php echo lang('index_longitude'); ?></th>
							<th class="none"><?php echo lang('index_nearby_malls'); ?></th>
							<th class="none"><?php echo lang('index_nearby_markets'); ?></th>
							<th class="none"><?php echo lang('index_nearby_hospitals'); ?></th>
							<th class="none"><?php echo lang('index_nearby_schools'); ?></th>
							<th class="none"><?php echo lang('index_tags'); ?></th>
							<th class="min-desktop"><?php echo lang('index_status'); ?></th>

							<th class="none"><?php echo lang('index_created_on')?></th>
							<th class="none"><?php echo lang('index_created_by')?></th>
							<th class="none"><?php echo lang('index_modified_on')?></th>
							<th class="none"><?php echo lang('index_modified_by')?></th>
							<th class="min-tablet"><?php echo lang('index_action')?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>