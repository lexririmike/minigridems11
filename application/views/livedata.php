<div id="page-wrapper">
			<div class="main-page">
<?php
 echo("<p><h3>Live data page</h3></p>");
 
 ?>
	<div class="row-one">
					<div class="col-md-4 widget">
						<div class="stats-left ">
							<h5>CURRENT  </h5>
				<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 8px;"><span class="glyphicon glyphicon-transfer"></span></h4><h4>DISTRIBUTED POWER </h4>
						</div>
						<div class="stats-right" id="cpower">
							<label>0(kW)</label>
						</div>
							<div class="clearfix"> </div>

						
					</div>
					<div class="col-md-4 widget states-mdl">
						<div class="stats-left">
							<h5>TODAY's ENERGY </h5>
							<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 8px;"><span class="glyphicon glyphicon-flash"></span></h4><h4>DISTRIBUTION</h4>
						</div>
						<div class="stats-right">
							<label><?php
							$kwhdt = number_format((float)$datas,2,'.','');
							echo $kwhdt; ?>(kWh)</label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-last">
						<div class="stats-left">
							<h5>CO2</h5>
							<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 8px;"><span class="glyphicon glyphicon-warning-sign"></span></h4><h4>AVOIDED TODAY</h4>
						</div>
						<div class="stats-right" id="cc02">
							<label>0(kg)</label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="clearfix"> </div>	
				</div>
 
				<div class="charts">
					<div >
						<h4 class="title">Distributed & Generated Power  After Every Minute</h4>
						
<script src="<?php echo base_url('asset/js/canvasjs.min.js');?>"></script>
<?php if(!empty($data_points)){
 $p= $data_points;}?>

<div class=" chrt-page-grids" style="width:100%;">
						
						<div id="chartContainer" style="height: 400px; width: 100%;"></div>
						</div>
						
					
					
					<div class="clearfix"> </div>

				</div>
 </div>
 </div>