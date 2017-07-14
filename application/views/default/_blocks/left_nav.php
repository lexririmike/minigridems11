		<!--left-fixed -navigation-->
<div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left cbp-spmenu-open" id="cbp-spmenu-s1">
					<ul class="nav" id="side-menu">
						<li>
							<a href="<?php echo  base_url('mroutes/index');?>"><i class="fa fa-home nav_icon"></i>START PAGE</a>
						</li>
						<?php if( $_SESSION['set_template'] == '1') { ?>
						<li>
							<a href="<?php echo  base_url('mroutes/index/dashboard');?>"><i class="fa fa-bullseye nav_icon"></i>DASHBOARD</a>
						</li>
						<li>
							<a href="<?php echo  base_url('mroutes/index/livedata');?>"><i class="fa fa-columns nav_icon"></i>LIVE DATA</a>
						</li>
						<li>
							<a href="<?php echo base_url('mroutes/index/chat');?>"><i class="fa fa-exchange nav_icon"></i>MESSAGE BOARD</a>
						</li>
						
						<li>
							<a href="<?php echo base_url('mroutes/index/settings');?>"><i class="fa fa-cogs nav_icon"></i>SETTINGS</a>
		
						</li>
						
						<li>
							<a href=""><i class="fa fa-envelope nav_icon"></i>LOGS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo  base_url('mroutes/index/logs');?>">SYSTEM LOGS</a>
								</li>
								
							</ul>
	
						</li>
						<?php }?>
						<li>
							<a href=""><i class="fa fa-check-square-o nav_icon"></i>HELP<span class="fa arrow"></span></a>
							<?php if(isset($_SESSION['set_grid'])){?>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo base_url('mroutes/index/help');?>">USER MANUAL</a>
								</li>
								<li>
									<a href="<?php echo base_url('mroutes/index/help/contactus');?>">CONTACT US</a>
								</li>
								<li>
									<a href="<?php echo base_url('mroutes/index/help/aboutus');?>">ABOUT US</a>
								</li>
							</ul>
							
							<?php }else{?>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo base_url('help');?>">USER MANUAL</a>
								</li>
								<li>
									<a href="<?php echo base_url('help/contactus');?>">CONTACT US</a>
								</li>
								<li>
									<a href="<?php echo base_url('help/aboutus');?>">ABOUT US</a>
								</li>
							</ul>
							<?php }?>
							<!-- //nav-second-level -->
						</li>
						
					</ul>
					<div class="clearfix"> </div>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
		<!--left-fixed -navigation-->
		<!-- header-starts -->