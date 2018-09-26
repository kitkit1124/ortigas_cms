<section id="menus">
	<div class="container-fluid">
		<div class="card">
			<div class="card-close">
				<div class="card-buttons">
					<a href="<?php echo site_url('admin/module/action/add'); ?>" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> New Module</a>
				</div>
			</div>
			<div class="card-header d-flex align-items-center">
				<h3 class="h4"><?php echo $page_heading; ?></h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th scope="col" class="text-center"><?php echo lang('modules_list_module')?></th>
								<th scope="col" width="240"><?php echo lang('modules_list_controllers')?></th>
								<th scope="col" class="text-center"><?php echo lang('modules_list_version')?></th>
								<th scope="col"><?php echo lang('modules_list_versions')?></th>
								<th scope="col" width="240"><?php echo lang('modules_list_action')?></th>
							</tr>	
						</thead>
						<tbody>
							<?php foreach ($modules as $module => $files): ?>
								<?php if ($module == 'CI_core') continue; ?>
								<?php $files = (isset($migrations[$module])) ? array_reverse($migrations[$module]) : FALSE; ?>
								<?php $latest = (isset($versions[$module])) ? $versions[$module] : 0; ?>
								<tr>
									<td class="text-center"><?php echo $module; ?></td>
									<td class="">
										<?php if ($modules[$module]): ?>
											<?php foreach ($modules[$module] as $file => $details): ?>
												<?php $module_folder = str_replace(APPPATH . 'modules/', '', $details["relative_path"]) ?>
												<?php $module_folder = str_replace("/controllers/", '', $module_folder) ?>
												<span class="badge badge-success"><?php echo $file; ?> 
												<?php if (count($modules[$module]) > 1) : ?> 
													<a href="<?php echo site_url('admin/module/action/delete/' . $module_folder . '/' . strtolower(basename($details['server_path'], '.php'))) ?>" data-toggle="modal" data-target="#modal"><i class="fa fa-remove fa-inverse"></i></a></span>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php if ($files): ?>
											<?php echo $latest; ?>
										<?php endif; ?>
									</td>
									<td class="">
										<?php if ($files): ?>
											<div class="input-group input-group-sm">
												<select class="custom-select custom-select-sm migration-files">
													<?php $last_version_checked = FALSE; ?>
													<?php foreach ($files as $file): ?>
														<?php //echo $file; ?>
														<?php $parts = explode("/", $file); ?>
														<?php $file = array_pop($parts); ?>
														<?php list($ver, $name) = explode('_', ltrim($file, '0')); ?>
														<?php if (! in_array($file, $core_migrations)): ?>
															<option value="<?php echo $ver; ?>"><?php echo $file; ?></option>
															<?php if (! $last_version_checked): ?>
																<?php $last_version = $ver; $last_version_checked = TRUE; ?>
															<?php endif; ?>
														<?php endif; ?>
													<?php endforeach; ?>
												</select>
												<div class="input-group-append">
													<a href="<?php echo site_url('admin/migrations/rollback/' . $module . '/' . $latest); ?>" data-toggle="modal" data-target="#modal" class="btn btn-smx btn-warning btn-rollback"><span class="fa fa-level-down"></span> <?php echo lang('button_rollback'); ?></a>
												</div>
											</div>
										<?php endif; ?>								
									</td>
									<td class="">
										<?php if ($files): ?>
											<?php if ($latest <= 1): ?>
												<a href="<?php echo site_url('admin/migrations/migrate/' . $module); ?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-success btn-install"><span class="fa fa-level-up"></span> <?php echo lang('button_install'); ?></a>
											<?php elseif ($latest < $last_version): ?>
												<a href="<?php echo site_url('admin/migrations/migrate/' . $module . '/upgrade'); ?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-primary btn-migrate"><span class="fa fa-level-up"></span> <?php echo lang('button_upgrade'); ?></a>
											<?php endif; ?>
										<?php endif; ?>
										<?php if (! in_array($module, $core_modules)): ?>
											<a href="<?php echo site_url('admin/module/action/delete/' . $module); ?>" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-danger btn-delete"><span class="fa fa-trash"></span> <?php echo lang('button_delete'); ?></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</section>