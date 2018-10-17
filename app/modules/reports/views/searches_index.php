<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<?php /*if ($this->acl->restrict('reports.searches.add', 'return')): ?>
						<a href="<?php echo site_url('reports/searches/form/add')?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-add" id="btn_add"><span class="fa fa-plus"></span> <?php echo lang('button_add')?></a>
					<?php endif;*/ ?>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">				
				<div class="row adsearch">
					<div class="col-sm-4">
						<table class="table table-striped table-bordered table-hover dt-responsive">
							<th><?php echo lang('index_cat_id'); ?></th>
							<th style="text-align: center; width: 50px;"><?php echo "Views"; ?></th>
							<?php 
								if($searches_category){
									foreach ($searches_category as $key => $value) {
										if($value->search_cat_id != '0'){ ?>
											<tr>
												<td>
													<?php echo $value->category_name; ?>
												</td>
												<td style="text-align: center;">
													<?php echo $value->numrows; ?>
												</td>
											</tr>
							<?php 
										}//if $value 
									}//foreach
								}//if $searches_category
							?>
						</table>
					</div>

					<div class="col-sm-4">
						<table class="table table-striped table-bordered table-hover dt-responsive">
							<th><?php echo lang('index_loc_id'); ?></th>
							<th style="text-align: center; width: 50px;"><?php echo "Views"; ?></th>
							<?php 
								if($searches_location){
									foreach ($searches_location as $key => $value) {
										if($value->search_loc_id != '0'){ ?>
										<tr>
											<td>
												<?php echo $value->location_name; ?>
											</td>
											<td style="text-align: center;">
												<?php echo $value->numrows; ?>
											</td>
										</tr>
							<?php 
										}//if $value 
									}//foreach
								}//if $searches_category
							?>
						</table>
					</div>

					<div class="col-sm-4">
						<table class="table table-striped table-bordered table-hover dt-responsive">
							<th><?php echo lang('index_price_id'); ?></th>
							<th style="text-align: center; width: 50px;"><?php echo "Views"; ?></th>
							<?php 
								if($searches_price){
									foreach ($searches_price as $key => $value) {
										if($value->search_price_id != '0'){ ?>
										<tr>
											<td>
												<?php echo $value->price_range_label; ?>
											</td>
											<td style="text-align: center;">
												<?php echo $value->numrows; ?>
											</td>
										</tr>
							<?php 
										}//if $value 
									}//foreach
								}//if $searches_category
							?>
						</table>
					</div>

				</div>
			
				<table class="table table-striped table-bordered table-hover dt-responsive" id="datatables">
					<thead>
						<tr>
							<th class="none"><?php echo lang('index_id'); ?></th>
							<th class="all"><?php echo lang('index_keyword'); ?></th>
							<th class="none"><?php echo lang('index_cat_id'); ?></th>
							<th class="none"><?php echo lang('index_price_id'); ?></th>
							<th class="none"><?php echo lang('index_loc_id'); ?></th>

							<th class="none"><?php echo lang('index_created_on')?></th>
							<th class="none"><?php echo lang('index_created_by')?></th>
							<th class="none"><?php echo lang('index_modified_on')?></th>
							<th class="none"><?php echo lang('index_modified_by')?></th>
							<th class="none"><?php echo lang('index_action')?></th>
						</tr>
					</thead>
				</table> 
			</div>
		</div>
	</div>
</section>