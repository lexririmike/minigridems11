<!-- main content start-->
		<div id="page-wrapper" style="margin:0;" >
			<div class="main-page login-page ">
				<h3 class="title1"><?php echo $title;?></h3>
				<div class="widget-shadow">
					<div class="login-top">
						<h4>Welcome back to EMS! <br>  </h4>
						<div id="infoMessage"><?php //echo $message;?></div>
					</div>
					<div class="login-body">
						<?php echo form_open("auth/login");?>
							<input type="text" class="user" name="identity" placeholder="<?php echo lang('login_identity_label');?> " required="">
							<input type="password" name="password" class="lock" placeholder="  <?php echo lang('login_password_label');?>">
							<input type="submit" name="Sign In" value="Sign In">
							<div class="forgot-grid">
								<label class="checkbox"><input type="checkbox" name="remeber" checked="checked"><i></i>Remember me</label>
								<div class="forgot">
									<a href="#"><?php echo lang('login_forgot_password');?></a>
								</div>
								<div class="clearfix"> </div>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
				
				
			</div>
		</div>