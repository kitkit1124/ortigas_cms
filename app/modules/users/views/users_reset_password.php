<div class="login-box hide">
	<div class="login-logo"><b><?php echo lang('reset_password_heading');?></b></div>
	<div class="login-box-body">
		<?php echo form_open('users/reset_password/' . $code);?>

			<p>
				<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
				<?php echo form_input($new_password);?>
				<?php echo form_error('new'); ?>
			</p>

			<p>
				<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
				<?php echo form_input($new_password_confirm);?>
				<?php echo form_error('new_confirm'); ?>
			</p>

			<?php echo form_input($user_id);?>
			<?php echo form_hidden($csrf); ?>

			<p><button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('reset_password_submit_btn'); ?></button></p>
		<?php echo form_close();?>

	</div>
</div>

		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1 top-margin6">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-leaf white"></i>
									<span class="white"><?php echo config_item('app_name'); ?></span>
								</h1>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">

									<div class="widget-body">

										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												<?php echo lang('reset_password_heading');?>
											</h4>

											<div class="space-6"></div>

											<?php echo form_open('users/reset_password/' . $code);?>
												<fieldset>
													<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php echo form_input($new_password);?>
															<i class="ace-icon fa fa-lock"></i>
														</span>
														<?php echo form_error('new'); ?>
													</label>

													<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
													<p class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php echo form_input($new_password_confirm);?>
															<i class="ace-icon fa fa-lock"></i>
														</span>
														<?php echo form_error('new_confirm'); ?>
													</p>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-save"></i>
															<span class="bigger-110"><?php echo lang('reset_password_submit_btn'); ?></span>
														</button>
													</div>
												</fieldset>
												<?php echo form_input($user_id);?>
												<?php echo form_hidden($csrf); ?>
											</form>

											<div class="space-6"></div>

											<div class="social-or-login center">
												<span class="bigger-110">
													<a href="<?php echo site_url('users/login'); ?>" class="back-to-login-link">
														Back to login
													</a>
												</span>
											</div>

										</div><!-- /.widget-main -->

	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
