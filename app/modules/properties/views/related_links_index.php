<div id="accordion_links">
   <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne_links">
        	<label><?php echo 'Recommended Links'?></label>		          
        </a>
    	<div class="button_add_related">
        	<?php if ($this->acl->restrict('properties.related_links.add', 'return')): ?>
				<a href="<?php echo site_url('properties/related_links/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"> </span> Add Recommended Links</a>
			<?php endif; ?>
		</div>
      </div>
      <div id="collapseOne_links" class="collapse" data-parent="#accordion_links">
       	<div class="card-body">
        	<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables_links">
				<thead>
					<tr>
						<th class="none"><?php echo lang('index_id'); ?></th>
						<th class="all" width="30%">Label</th>
						<th class="min-desktop" >Link</th>
						<th class="min-desktop" width="15%"><?php echo lang('index_status'); ?></th>

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
	var section_id = '<?php echo $section_id; ?>'
	var section_type = '<?php echo $section_type; ?>'
</script>