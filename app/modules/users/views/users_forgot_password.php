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
												<?php echo lang('forgot_password_heading');?>
											</h4>

											<div class="space-6"></div>
											<p>
												<?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
											</p>

											<?php echo form_open("users/forgot_password");?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php echo form_input($email);?>
															<i class="ace-icon fa fa-envelope"></i>
														</span>
														<?php echo form_error('email'); ?>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-send"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
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
