<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('files.images.add', 'return')): ?>
						<a href="<?php echo site_url('files/images/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">
				<div class="box">
					<div class="box-body">						
						<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
							<thead>
								<tr>
									<th class="all"><?php echo lang('index_id')?></th>
									<th class="min-desktop"><?php echo lang('index_width'); ?></th>
									<th class="min-desktop"><?php echo lang('index_height'); ?></th>
									<th class="min-desktop"><?php echo lang('index_name'); ?></th>
									<th class="min-desktop"><?php echo lang('index_file'); ?></th>
									<th class="min-desktop"><?php echo lang('index_file'); ?></th>
									<th class="min-desktop"><?php echo lang('index_file'); ?></th>
									<th class="min-desktop"><?php echo lang('index_file'); ?></th>
									<th class="min-desktop"><?php echo lang('index_thumb'); ?></th>

									<th class="d-none"><?php echo lang('index_created_on')?></th>
									<th class="d-none"><?php echo lang('index_created_by')?></th>
									<th class="d-none"><?php echo lang('index_modified_on')?></th>
									<th class="d-none"><?php echo lang('index_modified_by')?></th>
									<th class="min-tablet"><?php echo lang('index_action')?></th>
								</tr>
							</thead>
						</table>
						<br>
						<div id="thumbnails" class="row text-center"></div>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
