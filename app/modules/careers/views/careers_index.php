<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('careers.careers.add', 'return')): ?>
						<a href="<?php echo site_url('careers/careers/form/add')?>" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
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
							<th class="all"><?php echo lang('index_position_title'); ?></th>
							<th class="min-desktop"><?php echo lang('index_dept'); ?></th>
							<th class="none"><?php echo lang('index_created_on'); ?></th>
							<th class="none"><?php echo lang('index_res'); ?></th>
							<th class="none"><?php echo lang('index_location'); ?></th>
							<th class="none"><?php echo lang('index_latitude'); ?></th>
							<th class="none"><?php echo lang('index_longitude'); ?></th>
							<th class="min-desktop"><?php echo lang('index_status'); ?></th>

							<th class="none"><?php echo lang('index_req')?></th>
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