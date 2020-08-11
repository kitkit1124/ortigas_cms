<div id="accordion_links">
   <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#Collapse_faq_index">
        	<label><?php echo 'FAQ'?></label>		          
        </a>
    	<div class="button_add_related">
			<a href="<?php echo site_url('properties/faq/form/add')?>" data-toggle="modal" data-target="#modal-lg" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"> </span> Add FAQ</a>
		</div>
      </div>
      <div id="Collapse_faq_index" class="collapse" data-parent="#datatables_faq">
       	<div class="card-body">
        	<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables_faq">
				<thead>
					<tr>
						<th class="none"><?php echo lang('index_id'); ?></th>
						<th class="all" width="30%">Question</th>
						<th class="none" width="45%"><?php echo lang('index_status'); ?></th>
						<th class="min-desktop" width="10%"><?php echo lang('index_status'); ?></th>

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
</div>

<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>'
</script>