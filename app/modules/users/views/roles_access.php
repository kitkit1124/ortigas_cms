<section id="permissions">
	<div class="container-fluid">
		<div class="cardx">

			<?php echo form_open(current_url());?>

				<h3 class="clearfix">
					<?php echo strtoupper($group->name); ?>

					<div class="pull-right">
						<small><a href="#" id="expand_collapse_all" class="btn btn-default btn-xs collapsed">Expand All <i class="fa fa-caret-down"></i></a></small>
					</div>
				</h3>

				<?php foreach ($grants as $module => $permissions):?>
			
					<?php 
					if ($permissions)
					{
						$select_all_module_permissions = array();
						$select_none_module_permissions = array();
						$modules_list = array();
						foreach ($permissions as $grant)
						{
							// extract code
							list($modules, $submodules, $action) = explode(".", $grant["code"]);
							// select all permission
							$select_all_module_permissions[$modules][$action] 	= $action ? '<a class="dropdown-item" href="javascript:;" class="select_all" data-action="' . $action . '" data-module="' . $module . '">'.ucfirst($action).'</a>' : NULL;
							// select none permission
							$select_none_module_permissions[$modules][$action] 	= $action ? '<a class="dropdown-item" href="javascript:;" class="select_none" data-action="' . $action . '" data-module="' . $module . '">'.ucfirst($action).'</a>' : NULL;
							// all module permissions
							$modules_list[$submodules][] = $grant;
						}
					}
					?>

					<div class="card mt-3 mb-1">

						<div class="card-header clearfix">
							<!-- Parent Module Name -->
							<a href="#<?php echo $module?>" data-toggle="collapse" class="toggle-accordion collapsed" style="margin-top: 5px; font-size:18px"><i class="fa fa-plus-circle fa-lg"></i><i class="fa fa-minus-circle fa-lg"></i> <?php echo strtoupper($module); ?></a>
							
							<div class="pull-right">

								<!-- Select All -->
								<div class="btn-group select-none" role="group" aria-label="Button group">
									<button type="button" class="btn btn-primary btn-xs select_all" data-module="<?php echo $module; ?>">Select All</button>

									<div class="btn-group" role="group">
										<button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
										<div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
											<?php echo implode("\n", $select_all_module_permissions[$module]); ?>
										</div>
									</div>
								</div>
								
								<!-- Select None -->
								<div class="btn-group select-none" role="group" aria-label="Button group">
									<button type="button" class="btn btn-warning btn-xs select_none" data-module="<?php echo $module; ?>">Select None</button>

									<div class="btn-group" role="group">
										<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
										<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
											<?php echo implode("\n", $select_none_module_permissions[$module]); ?>
										</div>
									</div>
								</div>

								
							</div>
						</div>

						<?php if ($modules_list): ?>
							
							<div id="<?php echo $module?>" class="card-body clearfix collapse">
								<div class="row">
								<?php foreach ($modules_list as $key => $value): ?>
									<div class="col-sm-6">
										<table class="table table-hover">
											<thead>
												<tr>
													<th colspan="2"><h3 class="mb-0"><?php echo ucfirst($key) ?></h3></th>
												</tr>
											</thead>
											<tbody>
										<?php foreach ($value as $submod): ?>
										<?php $action = explode(".", $submod["code"]); ?>
											<tr>
												<td width="95%" class="align-middle"><label class="mb-0" for="<?php echo $submod['id']; ?>"><?php echo $submod['name']; ?></label></td>
												<td width="5%">
													<label class="switch">
													<input id="<?php echo $submod['id']; ?>" data-group-id="<?php echo $group->id; ?>" data-permission-id="<?php echo $submod['id']; ?>" data-permission-code="<?php echo $submod['code']; ?>" class="access <?php echo $module; ?> <?php echo $action[2]; ?> form-controlx" name="permission[]" type="checkbox" value="1"<?php echo ($submod['access'] == 'allow') ? ' checked' : '' ?> />
														<span class="slider"></span>
													</label>													
													<!-- <span class="lbl pull-left"></span> -->
												</td>
											</tr>
										<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php endforeach; ?>
								</div>

							</div>

						<?php endif; ?>

					</div>

				<?php endforeach; ?>

			<?php echo form_close();?>

		</div>
	</div>
</section>