<div class="modal-header">
	<h5 class="modal-title" id="modalLabel"><?php echo lang('text_audittrail_details'); ?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo lang('header_audittrail_info')?></h3>
		</div>

		<div class="box-body">

			<table class="table table-condensed">
				<tr><td><?php echo lang('label_id')?></td><td><?php echo $audittrail->audittrail_id?></td></tr>
				<tr><td><?php echo lang('label_action')?></td><td><?php echo $audittrail->audittrail_action?></td></tr>
				<tr><td><?php echo lang('label_table')?></td><td><?php echo $audittrail->audittrail_table?></td></tr>
				<tr><td><?php echo lang('label_user')?></td><td><?php echo $audittrail->first_name?> <?php echo $audittrail->last_name?></td></tr>
				<tr><td><?php echo lang('label_user_ip')?></td><td><?php echo $audittrail->audittrail_user_ip?></td></tr>
				<tr><td nowrap><?php echo lang('label_user_agent')?></td><td><?php echo $audittrail->audittrail_user_agent?></td></tr>
				<tr><td><?php echo lang('label_date')?></td><td><?php echo $audittrail->audittrail_created_on?></td></tr>
				<tr><td><?php echo lang('label_data')?></td><td><?php echo $data ?></td></tr></tr>
			</table>

		</div>
	</div>

</div> 
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('button_close')?></button>
</div>
