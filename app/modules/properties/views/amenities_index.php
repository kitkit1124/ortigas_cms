<div id="accordion_amenities">
   <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne_amenities">
        	<label><?php echo lang('property_amenities')?></label>		          
        </a>
    	<div class="button_add_amenities">
        	<?php if ($this->acl->restrict('properties.amenities.add', 'return')): ?>
				<a href="<?php echo site_url('properties/amenities/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add_amenities')?></a>
			<?php endif; ?>
		</div>
      </div>
      <div id="collapseOne_amenities" class="collapse" data-parent="#accordion_amenities">
       	<div class="card-body">
       		<div class="form-group">
       			<label class="control-label" for="property_amenities_description">
					<?php echo lang('property_amenities_description'); ?>
				</label>
	       		<?php echo form_textarea(array('id'=>'property_amenities_description', 'name'=>'property_amenities_description', 'rows'=>'2', 'value'=>set_value('property_amenities_description', isset($record->property_amenities_description) ? $record->property_amenities_description : '',FALSE), 'class'=>'form-control meta-title '));?>
	       	</div>
        	<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
				<thead>
					<tr>
						<th class="all"><?php echo lang('index_id'); ?></th>
						<th class="all"><?php echo lang('index_name'); ?></th>
						<th class="min-desktop"><?php echo lang('index_status'); ?></th>

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
	var property_id = '<?php echo $property_id; ?>'
</script>