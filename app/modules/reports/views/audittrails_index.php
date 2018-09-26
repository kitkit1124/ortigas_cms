<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php if ($this->acl->restrict('reports.audittrails.truncate', 'return')) : ?>
						<a href="<?php echo base_url('reports/audittrails/truncate') ?>" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Truncate" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> <?php echo lang('button_truncate') ?></a>
					<?php endif; ?>
					<a href="<?php echo base_url('reports/audittrails/export') ?>" target="_blank" id="export" class="btn btn-primary btn-sm"><i class="fa fa-download"></i>  <?php echo lang('button_export') ?></a>
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
							<th class="all"><?php echo lang('index_action')?></th>
							<th class="all"><?php echo lang('index_table')?></th>
							<th class="min-tablet"><?php echo lang('index_user')?></th>
							<th class="min-desktop"><?php echo lang('index_ip')?></th>
							<th class="min-tablet"><?php echo lang('index_date')?></th>
							<th class="min-tablet"><?php echo lang('index_action')?></th>
						</tr>
					</thead>			
				</table>				
			</div>
		</div>
	</div>
</section>	


<div class="modal" id="audittrails_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel"><?php echo lang('text_audittrail_details'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center"><img src="<?php echo site_url('ui/images/loading3.gif'); ?>" alt="Loading..." /><p>Loading...</p></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('button_close')?></button>
			</div>
		</div>
	</div>
</div>