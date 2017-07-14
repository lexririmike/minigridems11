<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo">
					<a href="<?php echo base_url('mroutes/index');?>">
						<h1>EMS</h1>
						<span><?php echo $title;?></span>
					</a>
				</div>
				<!--//logo-->
				<!--search-box-->
				<div class="search-box">
					<h1> <?php if(!empty($_SESSION['set_gridname']))
					{
					echo $_SESSION['set_gridname'];
					}?></h1>
				</div><!--//end-search-box-->
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="<?php echo base_url('uploads/profilepics/'.$user_profile); ?>" alt="" height=34 width=34 > </span> 
									<div class="user-name">
										<p><?php $user = $this->ion_auth->user()->row();
															echo $user->username;
											?></p>
										<span></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
							<?php 
							if ($this->ion_auth->is_admin())
							{?>
								<li> <a href="<?php echo base_url('auth'); ?>"><i class="fa fa-cog"></i> Manage Users</a> </li> 
								<li> <a href="<?php echo base_url('auth/grouplists'); ?>"><i class="fa fa-cog"></i> Manage Groups</a> </li>
								<?php 
								
							}?>
								<li> <a href="<?php echo base_url('auth/edit_user/'.$user->id); ?>"><i class="fa fa-user"></i> Profile</a> </li> 
								<li> <a href="<?php echo base_url('auth/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
					</ul>
				</div>	
				<div class="clearfix"> </div>	
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->