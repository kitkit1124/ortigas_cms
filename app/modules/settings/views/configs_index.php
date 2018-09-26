<section id="configs">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close d-none">
				<div class="card-buttons">
					<a href="<?php echo site_url('settings/configs/form/add') ?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-success btn-add" id="btn_add">
						<span class="fa fa-plus"></span> <?php echo lang('button_add')?>
					</a>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">

				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="all"><?php echo lang('index_id')?></th>
							<th class="all"><?php echo lang('index_name')?></th>
							<th class="min-tablet"><?php echo lang('index_value')?></th>
							<th class="min-desktop"><?php echo lang('index_description')?></th>

							<th class="none"><?php echo lang('index_modified_on')?></th>
							<th class="none"><?php echo lang('index_modified_by')?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>