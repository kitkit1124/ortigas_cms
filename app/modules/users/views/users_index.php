<section id="users">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<a href="<?php echo site_url('users/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="all"><?php echo lang('index_th_id')?></th>
							<th class="all"><?php echo lang('index_th_firstname')?></th>
							<th class="min-desktop"><?php echo lang('index_th_lastname')?></th>
							<th class="none"><?php echo lang('index_th_email')?></th>
							<th class="min-desktop"><?php echo lang('index_created_on')?></th>
							<th class="min-desktop"><?php echo lang('index_last_login')?></th>
							<th class="min-tablet"><?php echo lang('index_th_status')?></th>
							<th class="min-desktop"><?php echo lang('index_th_action')?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>