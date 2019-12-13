<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('reservations.reservations.add', 'return')): ?>
						<a href="<?php echo site_url('reservations/reservations/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
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
							<th class="all">First Name</th>
							<th class="all">Last Name</th>
							<th class="min-desktop"><?php echo lang('index_reference_no'); ?></th>
							<th class="min-desktop"><?php echo lang('index_project'); ?></th>
							<th class="min-desktop"><?php echo lang('index_property_specialist'); ?></th>
							<th class="min-desktop"><?php echo lang('index_sellers_group'); ?></th>
							<th class="min-desktop"><?php echo lang('index_unit_details'); ?></th>
							<th class="min-desktop"><?php echo lang('index_allocation'); ?></th>
							<th class="min-desktop"><?php echo lang('index_fee'); ?></th>
							<th class="min-desktop"><?php echo lang('index_notes'); ?></th>

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