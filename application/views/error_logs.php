		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page general">
				<h3 class="title1">Metering Logs</h3>
<div class="panel-info widget-shadow">
<div class="col-md-12 panel-grids">
						<div class="panel panel-info">
						<div class="panel-heading"> 
						<h3 class="panel-title"> Metering Logs</h3>
						</div> 
						<div class="panel-body"style ="overflow-x: scroll;height: 400px;">
						<h4>SMS Logs </h4>
						<hr \>
						<hr \>
						<?php 
						foreach($logs as $log)
						{?>
						<p><strong><?php echo $log->response_code;?> </strong>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from : <?php echo $log->ip_address;?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;at: <?php echo date('d-M-Y H:i',$log->time);?></p>
						<?php }?>
						<hr \>
						<hr \>
						<h4>Email Logs </h4>
						<hr \>
						<hr \>
						<?php 
						foreach($emlogs as $emlog)
						{?>
						<p><strong><?php echo $emlog->emailaddress;?> </strong>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sent : <?php echo $emlog->emailtext;?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;at: <?php echo $emlog->emailtime;?></p>
						<?php }?>
						</div> 
						</div>
					</div>
					<div class="clearfix"> </div>
</div>
</div>
</div>