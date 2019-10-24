<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<!-- <div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('payments.payments.add', 'return')): ?>
						<a href="<?php echo site_url('payments/payments/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
					<?php endif; ?>
				</div>
			</div> -->
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">				
				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="all"><?php echo lang('index_id'); ?></th>
			<th class="all"><?php echo lang('index_reservation_id'); ?></th>
			<th class="min-desktop"><?php echo lang('index_paynamics_reference_no'); ?></th>
			<th class="min-desktop"><?php echo lang('index_fullname'); ?></th>
			<th class="min-desktop"><?php echo lang('index_reservation_project'); ?></th>
			<th class="min-desktop"><?php echo lang('index_payment_type'); ?></th>
			<th class="min-desktop"><?php echo lang('index_reservation_fee'); ?></th>
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