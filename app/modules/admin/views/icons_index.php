<span class="btn-actions">
	<?php if ($this->acl->restrict('develop.icons.add', 'return')): ?>
		<a href="<?php echo site_url('develop/icons/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-success btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
	<?php endif; ?>
</span>
	
<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
	<thead>
		<tr>
			<th class="all"><?php echo lang('index_id')?></th>
					<th class="min-desktop"><?php echo lang('index_group'); ?></th>
					<th class="min-desktop"><?php echo lang('index_code'); ?></th>
					<th class="min-desktop"><?php echo lang('index_status'); ?></th>

			<th class="none"><?php echo lang('index_created_on')?></th>
			<th class="none"><?php echo lang('index_created_by')?></th>
			<th class="none"><?php echo lang('index_modified_on')?></th>
			<th class="none"><?php echo lang('index_modified_by')?></th>
			<th class="min-tablet"><?php echo lang('index_action')?></th>
		</tr>
	</thead>
</table>