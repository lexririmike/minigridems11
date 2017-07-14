<div id="page-wrapper">
			<div class="main-page">
<?php
 echo("<p><h3 class='title1'>Settings Page</h3></p>");
 //echo GRID;
 ?>

					
<div class="form-grids row widget-shadow" data-example-id="user-forms"> 
<form method="post" accept-charset="utf-8" class="form-horizontal" action="<?php echo current_url();?>" >
						<div class="form-title">
							<h4>Grid Management System :</h4>
						</div>
						<p><h4 class='alert alert-info'>API-KEY: <?php echo $api->api_key;?></h4></p>
                       
	
						<div class="form-body">
							
							<div class="form-group">
							<input type="hidden" name="HiddenUrl" id="HiddenUrl" value="<?php echo $this->uri->segment(1);?>" />
							<input type="hidden" name="HiddenId" id="HiddenId" value="<?php echo $posts->id;?>" />
									<label for="selector1" class="col-sm-2 control-label">Administrator Select</label>
									<div class="col-sm-8">
								
									<select name="selector1" id="selectoradmin" class="form-control1">
									<?php foreach($users as $user){?>
										<option><?php echo $user->first_name; ?></option>
										<?php }?>
									</select>
								</div>
					
									</div>
										
									<label class="col-sm-8 control-label">Current administrator is:<?php echo $posts->selectadmin;  ?></label>
										<div class="clearfix"> </div>		
								
								<div class="form-group">
									<label for="GridNameInput" class="col-sm-2 control-label">Grid Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridNameInput" name="GridNameInput" placeholder="Grid Name" value="<?php echo $posts->gridname;?>" />
									</div>
									<div class="col-sm-2">
										<p class="help-block">Name of the Grid</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
							
						<label for="selectinterval" class="col-sm-2 control-label">Interval for data transmission</label>
									<div class="col-sm-8">
								
									<select name="selectinterval" id="selectinterval" class="form-control1">
									
										<option value="360000">10s</option>
										<option value="120000">30s</option>
										<option value="60000">1min</option>
										<option value="12000">5min</option>
										<option value="6000">10min</option>
										<option value="3000">20min</option>
										<option value="2000">30min</option>
										<option value="1000">1hr</option>
										
									</select>
								</div>
					<div class="clearfix"> </div>
									</div>
									
								<div class="form-group">
									<label for="GridSizeInput" class="col-sm-2 control-label">Size of Grid</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridSizeInput" name="GridSizeInput" placeholder="Grid Size" value="<?php echo $posts->sizegrid;?>" />
									</div>
									<div class="col-sm-2">
										<p class="help-block">Size of Grid!</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
									<label for="GridNameInput" class="col-sm-2 control-label">Date of Commissioning</label>
									<div class="col-sm-8">
										
								<div class="controls input-append date" id="form_datetime1" data-date="" >
            <input type="text" class="form-control1" id="GridDateComeInput" name="GridDateComInput" placeholder="Date of Commissioning" value="<?php echo $posts->commissioningdate;?>" />
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">Date of Comissioning</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
									<label for="GridNameInput" class="col-sm-2 control-label">Manufacturer</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridManufactureInput" name="GridManufactureInput" placeholder="Manufacturer" value="<?php echo $posts->manufacturer;?>" />
									</div>
									<div class="col-sm-2">
										<p class="help-block">PV manufacturer</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
									<label for="GridNameInput" class="col-sm-2 control-label">Model Type</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridModelTypeInput" name="GridModelTypeInput" placeholder="Model Type" value="<?php echo $posts->modeltype;?>" />
									</div>
									<div class="col-sm-2">
										<p class="help-block">PV Model Type</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
<div class="row">
<div class="col-md-8 map widget-shadow">
						<h4 class="title">GRID MAP </h4>
						<div class="map_container"><div id="vmap" style="width: 100%; height: 354px;"></div></div>
						<!--map js-->
					
						<script type="text/javascript">
						var latdim = <?php if(isset($posts->latitude)){echo $posts->latitude;}else{echo'0';}?>;
						var longdim = <?php if(isset($posts->longitude)){echo $posts->longitude;}else{echo"0";}?>;
							 function initMap() {
        var mapDiv = document.getElementById('vmap');
        var map = new google.maps.Map(mapDiv, {
            center: {lat: <?php if(isset($posts->latitude)){echo $posts->latitude;}else{echo'0';}?>, lng: <?php if(isset($posts->longitude)){echo $posts->longitude;}else{echo"0";}?>},
            zoom: 2
        });
        citMarker=new google.maps.Marker({
position:new google.maps.LatLng(<?php if(isset($posts->latitude)){echo $posts->latitude;}else{echo'0';}?>, <?php if(isset($posts->longitude)){echo $posts->longitude;}else{echo"0";}?>),
animation:google.maps.Animation.BOUNCE
});

var infowindow = new google.maps.InfoWindow({
content:'<b><?php echo $posts->gridname;?></b>'
});

infowindow.open(map,citMarker);
citMarker.setMap(map);

google.maps.event.addListener(citMarker, 'click', function() {
map.setZoom(15);
map.setCenter(citMarker.getPosition());
infowindow.open(map,citMarker);
});

google.maps.event.addListener(map, 'rightclick', function(event) {

placeMarker(event.latLng);
});

function placeMarker(location) {
citMarker.setPosition(location);

document.getElementById('displayLat').value = location.lat();
document.getElementById('displayLong').value = location.lng();

latdim= location.lat();
longdim = location.lng();
}


      }
      


$.ajax({
      url:"https://maps.googleapis.com/maps/AIzaSyAzMgGdEBPXAkh1DPG9a5x3SB7GvZOhMUs/timezone/json?location="+latdim+","+longdim+"&timestamp="+(Math.round((new Date().getTime())/1000)).toString()+"&sensor=false",
}).done(function(response){
   if(response.timeZoneId != null){
     document.getElementById('timeZoneId').value = response.timeZoneId;
   }
});
						</script>
						<!-- //map js -->
					</div>
					<label class="col-sm-2 control-label">Latitude: <input type="text" size="20" maxlength="50" name="displayLat" id="displayLat" value="<?php echo $posts->latitude;?>" /></label>
					<label class="col-sm-2 control-label">Longitude:<input type="text" size="20" maxlength="50" name="displayLong" id="displayLong"value="<?php echo $posts->longitude;?>" /></label>
					<label class="col-sm-2 control-label">Timezone:<input type="text" size="20" maxlength="50" name="displayTimezone" id="timezone"value="<?php echo $posts->timezone;?>" /></label>
</div>
<label class="col-sm-2 control-label"> Right click! to select coordinates  </label>

								<div class="clearfix"> </div>
								<div class="clearfix"> </div>
								
								<div class=" row  col-sm-offset-8"> 
								<input type="submit" class="btn btn-default" value="Save" />
								</div>
			
		</div>	
		</form>
		</div>
				
				<div class="clearfix"> </div>
								<div class="clearfix"> </div>
								
								
							</div>
						</div>
									
								
						<div class=" form-grids row form-grids-right">
						<div class="widget-shadow " data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>DATA INPUT for <?php echo $posts->gridname;?>:</h4>
							</div>
							
								</div>
								</div>
								<div class="form-group bs-example row widget-shadow" data-example-id="hoverable-table"> 
								<label for="inputPassword3" class="col-sm-2 control-label form-title">DATA</label>
								<div class="col-sm-9"> 
								 
						<table class="table table-hover"> 
						<thead>
						<tr>
						<th>#</th> 
						<th>TOTAL CONSUMPTION(kWh)</th>
						<th>TOTAL CONNECTED</th>
						</tr> 
						</thead>
						<tbody>
						<?php       if(!empty($apiread))
      {       
    
	$timemnth=array();
      foreach($apiread as $post){
		  $time=strtotime($post['date_connected']);
		  array_push($timemnth,$time);
		  }
		  $sttimemnth = array_unique($timemnth);
		  foreach ($sttimemnth as $stimemnth){
		  $tsv=array();
$month=date("F",$stimemnth);
$year=date("Y",$stimemnth);
$stval = 0;
                               foreach($apiread as $post){
                               $time=strtotime($post['date_connected']);
                               if($time == $stimemnth){
                               $stval =$post['consumption']+$stval;
                               array_push($tsv,$stval);
                               }
                               
			       }
		  ?>
						<tr>
						<th scope="row"><?php echo $month.' '.$year;?></th>
						<td><?php echo $stval ;?></td>
						<td><?php echo count($tsv) ;?></td>
						</tr> 
						
						<?php }
						}?> 
						</tbody> 
						</table>
					
					</div> 
								</div>
								</div>
			<div class="form-group bs-example row widget-shadow" data-example-id="hoverable-table"> 
								<label for="inputPassword3" class="col-sm-2 control-label form-title">USERS</label>
											<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#gridSystemModal">ADD USER</button>
					<div class="modal fade" id="gridSystemModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							<form method="post" accept-charset="utf-8" class="form-horizontal" action="<?php echo base_url('settings/add_user');?>" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="gridSystemModalLabel">Add Data of User</h4>
									</div>
									<div class="modal-body">
									
								  <input type="hidden" name="HiddenUrl" id="HiddenUrl" value="<?php echo $this->uri->segment(1);?>" />
										<div class="row"> 
											<div class="form-group">
									<label for="GridrefInput" class="col-sm-2 control-label">Reference Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridrefInput" name="GridrefInput" placeholder="Reference Number">
									</div>
									<div class="col-sm-2">
								
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
									<label for="GridpowerInput" class="col-sm-2 control-label">Power Allocated</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridpowerInput" name="GridpowerInput" placeholder="Power in KiloWatts">
									</div>
									<div class="col-sm-2">
										
									</div>
									<div class="clearfix"> </div>	
								</div>
								    <div class="form-group">
									<label for="GriddateInput" class="col-sm-2 control-label">Month</label>
									<div class="col-sm-8">
					<div class="controls input-append date" id="form_datetime" data-date="">
                    <input class="form-control" name="GriddateInput" id="GriddateInput" type="text" value="" readonly />
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
									</div>
									<div class="col-sm-2">
										
									</div>
									<div class="clearfix"> </div>	
								</div>
								<div class="form-group">
									<label for="GridSizeInput" class="col-sm-2 control-label">Consumption</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridconsumInput" name="GridconsumInput" placeholder="Consumption in KiloWatts">
									</div>
									<div class="col-sm-2">
										
									</div>
									<div class="clearfix"> </div>	
								</div>
										</div> 
										</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<input type="submit" class="btn btn-primary" value="Save changes"/>
									</div>
									</form>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
								<div class="col-sm-9"> 
								 
						<table class="table table-hover"> 
						<thead>
						<tr>
						<th>REFERENCE NUMBER</th> 
						<th>POWER ALLOCATED(kW)</th>
						<th>DATE CONNECTED</th>
						<th>CONSUMPTION (kWh)</th>
						</tr> 
						</thead>
						<tbody>
							<?php       if(!empty($apiread))
      {       
      foreach($apiread as $post){?>
						<tr>
						<th scope="row"><?php echo $post['ref_num'];?></th>
						<td><?php echo $post['power'];?></td>
						<td><?php echo $post['date_connected'];?></td>
						<td><?php echo $post['consumption'];?></td>
						</tr> 
						
						<?php }
						}?> 
						</tbody> 
						</table>
					
					</div> 
								</div>
								<div class="clearfix"> </div>
								<div class="clearfix"> </div>
								
								
							</div>
						</div>
					</div>	

							

					
				

								<div class="bs-example row widget-shadow" data-example-id="hoverable-table"> 
						<div class="title">
							<h4>INPUTS:</h4>
						</div>
						<table class="table table-hover" id="inpower" > 
						<thead>
						<tr>
						<th>NODE</th>
						<th>NAME</th>						
						<th>KEY</th>						
						<th>UPDATED</th>
						<th>POWER(W)</th>
						<th>EDIT</th>
						<th>DELETE</th>
						</tr> 
						</thead>
						<tbody>
						<?php foreach($inputs as $input){?>
						<tr>
						<?php if($input['slug']==$this->uri->segment(1)){?>
						<td><?php echo $input['input_node'];?></td>
						<td><?php echo $input['name'];?></td>
						<td><?php echo $input['key_num'];?></td>
						<td><?php echo $input['timestamp'];?></td>
						<td><?php echo $input['inputvalue'];?></td>
						
						<td><a name="add_feed_<?php echo $input['id'];?>"  ><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<?php 
						$pdata = array(
						'id'=>$input['id'],
						'node'=>$input['input_node'],
						'fname'=>$input['name'],
						'feeddb'=>$input['feed_input']
						);
						$this->load->view("process/process_ui",$pdata);  ?>
						<script type="text/javascript">
						 $(function(){
							 	$('a[name="remove_input_<?php echo $input['id'];?>"]').on('click', function(e){
			
			e.preventDefault();
				$('#confirm').modal({ backdrop: 'static', keyboard: false })
				.one('click', '#delete', function (e) {
					window.location = $('a[name="remove_input_<?php echo $input['id'];?>').attr('href');
        });
});
$('a[name="add_feed_<?php echo $input['id'];?>"]').on('click', function(e){
			
			e.preventDefault();
				$('#processlistModal<?php echo $input["id"];?>').modal({ backdrop: 'static', keyboard: false })

});
								});
                               </script>
						</td>
						<td><a name="remove_input_<?php echo $input['id'];?>" href="<?php echo base_url('settings/del_input/'.$input['id'].'/'.$this->uri->segment(1));?>"><i class="fa fa-eraser" aria-hidden="true"></i></i></a></td>
						</tr>
						<?php }}?>
						</tbody>
						</table>
						<div id="confirm" class="modal fade" role="dialog">
						<div class="modal-dialog" role="document">
								<div class="modal-content">
					<div class="modal-body">
						Are you sure you want to Delete?
						</div>
					<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
				</div>
				</div>
				</div>
				</div>						
	<script type="text/javascript">
                            $(function(){
							

								});
                               </script>

					</div>	
				
				
 </div>
 </div>
  <script type="text/javascript">
  $("#form_datetime").datetimepicker({
		        startDate:"2016-01-01 00:00",
			format: 'yyyy-mm',
		   weekStart: 1,
		    icons: {
		   time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
            },
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 3,
		minView: 4,
		forceParse: 0,
        showMeridian: 1,
		
		  });
	$("#form_datetime1").datetimepicker({
		        startDate:"2000-01-01 00:00",
			format: 'yyyy-mm-dd',
		   weekStart: 1,
		     icons: {
		    time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
            },
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 4,
		forceParse: 0,
        showMeridian: 1,
		
		  });	  
  
  
  </script>