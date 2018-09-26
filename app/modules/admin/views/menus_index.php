<section id="menus">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close d-none">
				<div class="dropdown">
					<button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-plus"></i></button>
					<div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
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
							<th class="all"><?php echo lang('index_text')?></th>
							<th class="min-desktop"><?php echo lang('index_link')?></th>
							<th class="min-desktop"><?php echo lang('index_permission')?></th>
							<th class="min-desktop"><?php echo lang('index_icon')?></th>
							<th class="min-desktop"><?php echo lang('index_order')?></th>
							<th class="min-tablet"><?php echo lang('index_active')?></th>
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