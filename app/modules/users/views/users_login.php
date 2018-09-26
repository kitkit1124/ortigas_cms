<div class="page login-page">
	<div class="container d-flex align-items-center">
		<div class="form-holder has-shadow">
			<div class="row">
				<!-- Logo & Information Panel-->
				<div class="col-lg-6">
					<div class="info d-flex align-items-center">
						<div class="content">
							<div class="logo">
								<h1><?php echo config_item('app_name'); ?></h1>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</div>
					</div>
				</div>
				<!-- Form Panel -->
				<div class="col-lg-6 bg-white">
					<div class="form d-flex align-items-center">
						<div class="content">
							<?php $return = ($this->input->get('return')) ? '?return=' . urlencode($this->input->get('return')) : ''; ?>
							<?php echo form_open(current_url() . $return);?>
								<div class="form-group">
									<label for="identitye">Email</label>
									<?php echo form_input(array('name'=>'identity', 'value'=>set_value('identity'), 'class'=>'form-control', 'placeholder' => 'Email', 'autocomplete'=>'off'));?>
								</div>
								<div class="form-group">
									<label for="login-password">Password</label>
									<input name="password" type="password" class="form-control" autocomplete="off"/>	
								</div>
								<div class="form-group">
									<label class="inline">
										<input name="remember" type="checkbox">
										<span class="lbl"> Remember Me</span>
									</label>
								</div>
								<?php echo form_hidden('submit', 1); ?>
								<?php echo form_hidden('return', ($this->input->get('return') ? $this->input->get('return') : '')); ?>
								<button id="submit" type="submit" class="btn btn-lg btn-primary">
									<i class="fa fa-lock"></i> Login
								</button>
							</form>

							<!-- <a href="#" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="register.html" class="signup">Signup</a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyrights text-center">
		<p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a>
			<!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
		</p>
	</div>
</div>