<?php $types = create_dropdown('array', '--,VARCHAR,CHAR,TEXT,SET,DATE,DATETIME,BIGINT,INT,MEDIUMINT,SMALLINT,TINYINT,DECIMAL,FLOAT,BOOLEAN'); ?>
<?php $form_types = create_dropdown('array', 'INPUT,SELECT,TEXTAREA,CHECKBOX,RADIO,PASSWORD,NUMBER,NOFORM'); ?>
<?php $is_unsigned = create_dropdown('array', '--,Unsigned'); ?>
<?php $is_null = create_dropdown('array', '--,Null'); ?>
<?php $is_index = create_dropdown('array', '--,Index,Primary'); ?>

<section id="roles">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><h3 class="form-title">Module Information</h3></h3>
			</div>
			<div class="card-body">
				<?php echo form_open(current_url());?>
					<div class="box-body">
						<div class="row">

							<div class="col-md">

								<div class="row">
									<div class="col-sm form-group">
										<label for="module_name_plural"><?php echo lang('module_name'); ?> (Plural):</label>
										<?php echo form_input(array('id'=>'module_name_plural', 'name'=>'module_name_plural', 'value'=>set_value('module_name_plural'), 'class'=>'form-control', 'placeholder' => lang('module_name_plural')));?>
										<?php echo form_error('module_name_plural'); ?>
									</div>
									
									<div class="col-sm form-group">
										<label for="module_name_plural"><?php echo lang('module_name'); ?> (Singular):</label>
										<?php echo form_input(array('id'=>'module_name_singular', 'name'=>'module_name_singular', 'value'=>set_value('module_name_singular'), 'class'=>'form-control', 'placeholder' => lang('module_name_singular')));?>
										<?php echo form_error('module_name_singular'); ?>
									</div>
								</div>

								<div class="row">
									<div class="col-sm form-group">
										<label for="parent_module"><?php echo lang('parent_module')?>:</label>
										<?php echo form_dropdown('parent_module', $modules, set_value('parent_module'), 'id="parent_module" class="form-control"'); ?>
										<?php echo form_error('parent_module'); ?>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm form-group">
										<label for="module_version"><?php echo lang('module_version'); ?>:</label>
										<?php echo form_input(array('id'=>'module_version', 'name'=>'module_version', 'value'=>set_value('module_version', '1.0'), 'class'=>'form-control'));?>
										<?php echo form_error('module_version'); ?>
									</div>
									<div class="col-sm form-group">
										<label for="package_name"><?php echo lang('package_name'); ?>:</label>									
										<?php echo form_input(array('id'=>'package_name', 'name'=>'package_name', 'value'=>set_value('package_name', 'Codifire'), 'class'=>'form-control'));?>
										<?php echo form_error('package_name'); ?>
									</div>

									<div class="col-sm form-group">
										<label for="table_availability"><?php echo lang('module_database'); ?>:</label>
										<div>
											<label class="switch">
												<?php 
												$is_checked = TRUE;
												if ($this->input->post('table_availability'))
												{
													$is_checked =   $this->input->post('table_availability');
												}

												if ($is_checked) {
													$is_checked = 'true';
												} else {
													$is_checked = 'false';
												}

												echo form_input(array('name'=>'table_availability', 'type'=>'checkbox',  'id'=>'table_availability', 'value'=> $is_checked, 'class'=>'access form-control ace ace-switch ace-switch-4 btn-flat')); ?>
												<span class="slider_btn "></span> 
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md">
								<div class="row">
									<div class="col-sm form-group">
										<label for="author_name"><?php echo lang('author_name'); ?>:</label>
										<?php echo form_input(array('id'=>'author_name', 'name'=>'author_name', 'value'=>set_value('author_name', $user->first_name . ' ' . $user->last_name), 'class'=>'form-control', 'placeholder' => lang('author_name')));?>
										<?php echo form_error('author_name'); ?>
									</div>
									<div class="col-sm form-group">
										<label for="author_email"><?php echo lang('author_email'); ?>:</label>
										<?php echo form_input(array('id'=>'author_email', 'name'=>'author_email', 'value'=>set_value('author_email', $user->email), 'class'=>'form-control', 'placeholder' => lang('author_email')));?>
										<?php echo form_error('author_email'); ?>
									</div>
								</div>

								<div class="row">
									<div class="col-sm form-group">
										<label for="copyright_name"><?php echo lang('copyright_name'); ?>:</label>
										<?php echo form_input(array('id'=>'copyright_name', 'name'=>'copyright_name', 'value'=>set_value('copyright_name',  $user->company), 'class'=>'form-control'));?>
										<?php echo form_error('copyright_name'); ?>
									</div>
									<div class="col-sm form-group">
										<label for="copyright_link"><?php echo lang('copyright_link'); ?>:</label>
										<?php echo form_input(array('id'=>'copyright_link', 'name'=>'copyright_link', 'value'=>set_value('copyright_link', 'http://www.digify.com.ph'), 'class'=>'form-control'));?>
										<?php echo form_error('copyright_link'); ?>
									</div>
								</div>

								<div class="row">
									<div class="col-sm form-group">
										<label for="copyright_year"><?php echo lang('copyright_year'); ?>:</label>
										<?php echo form_input(array('id'=>'copyright_year', 'name'=>'copyright_year', 'value'=>set_value('copyright_year', date('Y')), 'class'=>'form-control', 'type'=>'number'));?>
										<?php echo form_error('copyright_year'); ?>
									</div>
									<div class="col-sm form-group">
										<label for="module_icon"><?php echo lang('module_icon'); ?>:</label>
										<?php echo form_input(array('id'=>'module_icon',  'name'=>'module_icon',  'data-input-search'=>'true', 'type'=>'text', 'value'=>set_value('module_icon', 'fa-leaf'), 'class'=>'form-control icp icp-auto' ));?>
										<?php echo form_error('module_icon'); ?>
									</div>
									<div class="col-sm form-group">
										<label for="module_order"><?php echo lang('module_order'); ?>:</label>
										<?php echo form_input(array('id'=>'module_order', 'name'=>'module_order', 'value'=>set_value('module_order', 2), 'class'=>'form-control', 'type'=>'number'));?>
										<?php echo form_error('module_order'); ?>
									</div>
								</div>	
							</div>
						</div>

						<hr class="my-4">
						<h3 class="form-title">Table Information</h3>
						<hr class="my-4">
						
						<div class="alert alert-info"><strong>Database name</strong> will be the lowercased plural name of the module (eg. customers). Use underscore to separate column names. After adding the module, go to <strong>Develop > Modules </strong> to install or upgrade.</div>

						<div class="table-responsive">
							<table id="table_fields" class="table">
								<thead>
									<tr>
										<td nowrap>Field Name</td>
										<td nowrap>Data Type</td>
										<td>Length</td>
										<td nowrap>Form Type</td>
										<td>Attribute</td>
										<td>Null</td>
										<td>Index</td>
									</tr>
								</thead>
								<tbody>
									<?php if ($table): ?>
										<?php foreach ($table as $row): ?>
											<tr class="table_row">
												<td>
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text table-name">table_</span>
														</div>
														<?php echo form_input(array('name'=>'column_name[]', 'value'=>$row['column_name'], 'class'=>'form-control column_name', 'placeholder' => 'column_name')); ?>
													</div>
												</td>
												<td>
													<?php echo form_dropdown('column_type[]', $types, ($row['column_type']) ? $row['column_type'] : '--', 'class="form-control form-control-sm column_type"'); ?>
												</td>
												<td>
													<?php echo form_input(array('name'=>'column_length[]', 'value'=>$row['column_length'], 'class'=>'form-control form-control-sm column_length')); ?>
												</td>
												<td>
													<?php echo form_dropdown('form_type[]', $form_types, ($row['form_type']) ? $row['form_type'] : '--', 'class="form-control form-control-sm form_type"'); ?>
												</td>
												<td>
													<?php echo form_dropdown('column_unsigned[]', $is_unsigned, ($row['column_unsigned']) ? $row['column_unsigned'] : '--', 'class="form-control form-control-sm"'); ?>
												</td>
												<td>
													<?php echo form_dropdown('column_null[]', $is_null, ($row['column_null']) ? $row['column_null'] : '--', 'class="form-control form-control-sm"'); ?>
												</td>
												<td>
													<?php echo form_dropdown('column_index[]', $is_index, ($row['column_index']) ? $row['column_index'] : '--', 'class="form-control form-control-sm"'); ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>

						<div class="help-block"><em>Use underscore to separate words.</em></div>
						<div class="box-footer">
							<button id="clone" class="btn btn-warning btn-sm" type="button"><i class="fa fa-copy"></i> Another Row</button>
						</div>
					</div>

					<div class="box-footer">
						<button id="submit" class="btn btn-primary pull-right" type="submit" data-loading-text="<?php echo lang('processing')?>"><i class="fa fa-save"></i> Create Module</button>
					</div>

					<?php echo form_hidden('submit', 1); ?>	
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>