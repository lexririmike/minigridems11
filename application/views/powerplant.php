<div id="page-wrapper">
			<div class="main-page">
<?php
echo("<p><h3 class='title1'>Mini-Grid Overview</h3></p>");

?>
<p><?php echo $this->session->flashdata('email_sent');?></p>
<div class="row">
<div class="col-md-10 tables"style="min-height:300px;">
		<div class="widget-shadow" data-example-id="hoverable-table" style="padding: 1.5em 2em;"> 
		
						<h4>MINI-GRIDS:</h4>
						<table class="table table-hover"> 
						<thead> 
						<tr> 
						<th></th> 
						<th>ADMINISTRATOR</th> 		
						<th>MINI-GRID NAME</th> 
						<th>SIZE(KW)</th> 
						<th>EDIT GRID</i></th>
						<th>DELETE GRID</i></th>
						</tr> 
						</thead>
						<tbody> 
						<?php       if(!empty($posts))
      {       
      foreach($posts as $post){?>
						<tr> 
						<th scope="row"></th>
						<td><?php echo $post->selectadmin;?></td> 
						<td><a href="<?php echo base_url($post->slug.'/dashboard'); ?>"><?php echo $post->gridname;?></td> 
						<td><?php echo $post->sizegrid;?></td> 
						<td><a href="<?php echo base_url($post->slug.'/settings'); ?>" ><i class="fa fa-pencil" aria-hidden="true" ></i></a></td>
						<td><a href="<?php echo base_url('powerplants/deletegrid/'.$post->slug); ?>" name="remove_levels<?php echo $post->slug;?>" value="delete"><i class="fa fa-eraser" aria-hidden="true"></i></a></td>	
							<div id="confirm<?php echo $post->slug;?>" class="modal fade" role="dialog">
						<div class="modal-dialog" role="document">
								<div class="modal-content">
					<div class="modal-body">
						Are you sure you want to Delete?
						</div>
					<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-primary" id="delete<?php echo $post->slug;?>">Delete</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
				</div>
				</div>
				</div>
				</div>
						<script type="text/javascript">
                            $(function(){
								$('a[name="remove_levels<?php echo $post->slug;?>"]').on('click', function(e){
			
			e.preventDefault();
				$('#confirm<?php echo $post->slug;?>').modal({ backdrop: 'static', keyboard: false })
				.one('click', '#delete<?php echo $post->slug;?>', function (e) {
					window.location = $('a[name="remove_levels<?php echo $post->slug;?>"]').attr('href');
        });
});
								});
                               </script>
						</tr>
						<?php }
						}?> 
						
						</tbody> 
						</table>
					
						
		</div>
		
	
		<div class="clearfix"> </div>	
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#gridSystemModal">Create New GRID</button>
						<div class="modal fade" id="gridSystemModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
									</div>
									    <div class="form-body">
											<form method="post" accept-charset="utf-8" class="form-horizontal"action="<?php echo base_url('powerplants');?>" >
									<div class="modal-body">
										<div class="row-info"> 
											<div class="col-md-8">Create a new grid and give its size!</div> 
											
										</div>  
										<div class="row"> 
<div class="clearfix"> </div>		
<div class="form-group">
									<label for="GridNameInput" class="col-sm-2 control-label">Grid Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridNameInput" name="GridNameInput" placeholder="Grid Name">
									</div>
									<div class="col-sm-2">
										<p class="help-block">Name of the Grid! must be more than 4 Letters long</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
<div class="form-group">
									<label for="GridSizeInput" class="col-sm-2 control-label">Size of Grid</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="GridSizeInput" name="GridSizeInput" placeholder="Grid Size">
									</div>
									<div class="col-sm-2">
										<p class="help-block">Size of Grid!</p>
									</div>
									<div class="clearfix"> </div>	
								</div>
											
										</div> 
 
 </div>

									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Save changes</button>
									</div>
									</form>
</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
</div>

			</div>
			<div class="row">
			<div class=" col-md-10 charts" style="margin:0;">
					<div class=" chrt-page-grids" style="width:100%;">
						<h4 class="title">GRID ANALYSIS</h4>
						<div id="chartContainer" style="height: 250px; width: 100%;"></div>
					</div>
			
			</div>
			</div>

<div class="row">
<div class="col-md-10 map widget-shadow">
						<h4 class="title">GRID MAP </h4>
<div id="map"></div>
 <script>
      function initMap() {
       

        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
           
        });
   var infoWindow = new google.maps.InfoWindow;
       downloadUrl("<?php echo base_url('powerplants/get_coordinates');?>", function(data) {
       var points = []
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
              points.push(point);
          var html = "<b>" + name + "</b> <br/>";
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
          var markerBounds = new google.maps.LatLngBounds();
for (var i = 0; i < points.length; i++) {
 markerBounds.extend(points[i]);
}
        map.fitBounds(markerBounds);
      });
  

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}


      }
    </script>
					</div>
					</div>

					

</div>
<div class="table-responsive bs-example  widget-shadow" style="overflow-x: scroll; overflow-y: hidden; padding:10px;">
						<h4 class="title">ENERGY DATA FOR THE CURRENT YEAR</h4>
						
						<table class="table table-bordered"> 
						<thead> 
						<tr> 
						<th style="width: 300px;">Mini-grid Names</th>
						<th scope="row" style="width: 300px;">Generated Energy [kWh]</th> 
						<th scope="row" style="width: 300px;">Distributed Energy [kWh] </th>
						<th scope="row" style="width: 300px;">Duration of interruption[h] </th> 
						<th scope="row" style="width: 300px;">Avoided CO2 [kg] </th>
						<th scope="row" style="width: 300px;">Total Losses </th>
						<th scope="row" style="width: 300px;">Number of connections </th> 
						
						</tr> 
						</thead>
						<tbody> 
						<?php       if(!empty($posts))
      {       
      foreach($posts as $post){?>
						<tr> 
						<th><?php echo $post->gridname;?></th>
						<td><?php if(!empty($cumdata))
						{
							foreach ($cumdata as $cdata)
							{
							if($cdata['slug']==$post->slug)
							{
							
								if(!empty($cdata['geninput']))
								{
									$ttgeninput = $cdata['geninput'];
                            $kwhinput = number_format((float)$ttgeninput,2,'.','');
									echo $kwhinput ;
								}
								else
								{
									echo 0;
								}
								
							}
							
							}
						}else
						{
							echo '0';
						}?></td>
						 
						 
						<td><?php if(!empty($cumdata))
						{
							foreach ($cumdata as $cdata)
							{
							if($cdata['slug']==$post->slug)
							{
								if(!empty($cdata['input']))
								{
									$ttinput = $cdata['input'];
                            $kwginput = number_format((float)$ttinput,2,'.','');
									echo $kwginput ;
								}
								else
								{
									$kwginput = '0';
									$ttinput = 0;
							echo $kwginput;
								}
							}
							
							}
						}?></td>
					
						
						
						<td><?php
						 if(!empty($cumdata))
						{
						 foreach ($cumdata as $cdata)
						{
							if($cdata['slug'] == $post->slug)
							{
							echo $cdata['inter'];
							
							
							
							}
							
						}
						}
						else
						{
						
						echo 0;
						}
							?></td> 
						 
						<td><?php  $cval=$ttinput * 0.332297783;
						
						echo number_format($cval,2);?></td> 
						
						 
						<td><?php if(!empty($cumdata))
						{
							foreach ($cumdata as $cdata)
							{
							if((!empty($cdata['input'])) && (!empty($cdata['geninput'])))
							{
							$loss = $cdata['geninput'] - $cdata['input'];
							}
							else
							{
							$loss = 0;
							}
							}
							echo $loss;
							}?> </td> 
						
						
						<td><?php if(!empty($cumdata))
						{
							foreach ($cumdata as $cdata)
							{
							if($cdata['slug']==$post->slug)
							{
								if(!empty($cdata['connections']))
								{
									
									echo $cdata['connections'] ;
								}
								else
								{
									$kwginput = '0';
							            echo $kwginput;
								}
							}
							}
						}else
						{
							echo '0';
						}?></td> 
						 
						
						</tr>
						<?php }
						}?> 
						</tbody> 
						</table> 
						
					</div>
					
</div>
</div>