<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('customers.customers.add', 'return')): ?>
						<a href="<?php echo site_url('customers/customers/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
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
			<th class="all"><?php echo lang('index_fname'); ?></th>
			<th class="min-desktop"><?php echo lang('index_lname'); ?></th>
			<th class="min-desktop"><?php echo lang('index_telno'); ?></th>
			<th class="min-desktop"><?php echo lang('index_mobileno'); ?></th>
			<th class="min-desktop"><?php echo lang('index_email'); ?></th>
			<th class="none"><?php echo lang('index_id_type'); ?></th>
			<th class="none"><?php echo lang('index_id_details'); ?></th>
			<th class="none"><?php echo lang('index_mailing_country'); ?></th>
			<th class="none"><?php echo lang('index_mailing_house_no'); ?></th>
			<th class="none"><?php echo lang('index_mailing_street'); ?></th>
			<th class="none"><?php echo lang('index_mailing_city'); ?></th>
			<th class="none"><?php echo lang('index_mailing_brgy'); ?></th>
			<th class="none"><?php echo lang('index_mailing_zip_code'); ?></th>
			<th class="none"><?php echo lang('index_billing_country'); ?></th>
			<th class="none"><?php echo lang('index_billing_house_no'); ?></th>
			<th class="none"><?php echo lang('index_billing_street'); ?></th>
			<th class="none"><?php echo lang('index_billing_city'); ?></th>
			<th class="none"><?php echo lang('index_billing_brgy'); ?></th>
			<th class="none"><?php echo lang('index_billing_zip_code'); ?></th>

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