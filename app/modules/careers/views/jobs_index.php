<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php /*if ($this->acl->restrict('careers.jobs.add', 'return')): ?>
						<a href="<?php echo site_url('careers/jobs/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
					<?php endif;*/ ?>
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
							<th class="all"><?php echo lang('index_career_id'); ?></th>
							<th class="min-desktop"><?php echo lang('index_application_name'); ?></th>
							<th class="all"><?php echo lang('index_time_stamp'); ?></th>
							<th class="none"><?php echo lang('index_mobile'); ?></th>
							<th class="none"><?php echo lang('index_document'); ?></th>
							<th class="none"><?php echo lang('index_pitch'); ?></th>

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