<div id="page-wrapper">
			<div class="main-page">
<?php
echo ("<h3>Dashboard</h3>");

?>
				<div class="row-one">
					<div class="col-md-4 widget">
						<div class="stats-left ">
							<h5>  TOTAL </h5>
							<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 7px;"><span class="glyphicon glyphicon-flash"></span></h4><h4>DISTRIBUTED ENERGY</h4>
						</div>
						<div class="stats-right">
							<label><?php $input =array();
							
        $tinput = array_sum($datas);
        $hrsyes = count($datas);
        $ttinputs = $tinput ;
		$ttinput = $ttinputs;
        $kwhinput = number_format((float)$ttinput,2,'.','');
        echo $kwhinput;?> (kWh)</label>
						</div>
							<div class="clearfix"> </div>
							
									
					
					 <div id=""></div>
					</div>
						
					</div>
					<div class="col-md-4 widget states-mdl">
						<div class="stats-left">
							<h5>Live</h5>
							<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 8px;"><span class="glyphicon glyphicon-transfer"></span> </h4><h4>Distributed Power </h4>
						</div>
						<div class="stats-right" id = "lenergy">
						             	</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-last">
						<div class="stats-left">
							 <h5> TOTAL</h5>
							<h4 style="float: left;font-size: 2em;margin-top: -3px;margin-right: 8px;"><span class="glyphicon glyphicon-warning-sign"></span></h4><h4> Losses</h4>
						</div>
						<div class="stats-right" >
							<label>0(W)</label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="clearfix"> </div>	
				</div>
				<div class="col-md-6 col-md-offset-4 datems "style="width:100%;    margin: 2em 0;">
                   <div class="form-grids  widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
				
				<form action="<?php echo base_url('mroutes/export');?>" method="post" class="form-horizontal" target="_blank">
				<input type="hidden" name="HiddenUrl" id="HiddenUrl" value="<?php echo $this->uri->segment(1);?>" />
							<div class="form-group">
									<div class="col-md-4  demo">
            <h4>Date Range Picker</h4>
<div class="form-group">
                
                    <select class="form-control" id="daterange" name="selector1" >
					<option value=""></option>
					<option value="1">Annual Data</option>
					<option value="2">Monthly Data</option>
					<option value="3">Daily Data</option>
					
                    </select>
            <script type="text/javascript">
            var d = new Date();
			 $("#daterange").change(function(){
             $("#form_datetime").val('');
             
             $("#form_datetime").attr('data-date',"");
             $("#dtp_input1").val('');
			// $("#form_datetime").attr("data-date-format","0");
			// $("#form_datetime").attr("data-link-format","0");
				 
			 $("#form_datetime").datetimepicker("update");
			 $("#form_datetime").datetimepicker("remove");
			 var data =$(this).val();
        if(data == 1)
		{
		$("#form_datetime").datetimepicker({
		        startDate:"2016-01-01 00:00",
			format: 'yyyy',
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
		startView: 4,
		minView: 4,
		forceParse: 0,
        showMeridian: 1
		
		  });
		//  $("#form_datetime").attr("data-date-format","YYYY");
		//  $("#form_datetime").attr("data-link-format","YYYY");
		}
		 else if(data == 2)
		{
		$("#form_datetime").datetimepicker({
		        startDate:"2016-01-01 00:00",
			format: 'mm-yyyy',
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
		//  $("#form_datetime").attr("data-date-format","MM");
		//  $("#form_datetime").attr("data-link-format","MM");
		}
		else if(data == 3)
		{
		$("#form_datetime").datetimepicker({
		        startDate:"2016-01-01 00:00",
			format: 'dd-mm-yyyy',
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
		 // $("#form_datetime").attr("data-date-format","DD");
		 // $("#form_datetime").attr("data-link-format","DD");
		}
		
		
    }); </script>
            </div>
            </div>
          
		<div class="col-md-4 col-md-offset-1 demo" style=" margin-top:-0.5em;">
          <div class="control-group">
                <label class="control-label">DateTime Picking</label>
                <div class="controls input-append date" id="form_datetime" data-date="" data-link-field="dtp_input1">
                    <input class="form-control" name="dtpmain" id="dtpmain" type="text" value="" readonly />
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
				<input type="hidden" id="dtp_input1" name="dtp_input1" value="" /><br/>
				<input type="hidden" id="connectionsnum" name="connectionsnum" value="<?php echo $connections;?>" /><br/>
            </div>
		  </div>

								</div>
							<button type="button" class="btn btn-primary btn-lg" id="chndatadash" onclick="ChangeView()">VIEW DATA</button>	
							
							<button type="button" class="btn btn-primary btn-lg" style="float: right;" data-toggle="modal" data-target="#gridSystemModal">EXPORT DATA</button>
						<div class="modal fade" id="gridSystemModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="gridSystemModalLabel">Eport Data</h4>
									</div>
									<div class="modal-body">
										<div class="row-info"> 
										<select name="selector2" id="selector2" class="form-control1">
										<option value="csv">Export as CSV</option>
										<option value="pdf">Export as PDF</option>
										
									</select>
											
										</div>  
										<div class="row"> 
											<div class="col-md-6 col-md-offset-2">With the selected format download the data below.</div>
											 <!--<button id="emailreport" type="button" class="btn btn-default" >Email the Report.</button>-->
										</div> 
										 </div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Export Data</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal --></form>
						
					</div>
						</div>
						<div class="clearfix"> </div>	
						<div class="clearfix"> </div>	
						</div>
					<div class="charts">
					<div class="col-md-12  charts-grids "style="margin-bottom: 2em;">
						<h4 class="title">Total Energy</h4>
						 <div id="charttotalContainer" style="height: 400px; width: 100%;"></div></div>
						<div class="clearfix"> </div>
						<div class="clearfix"> </div>
					<div class="col-md-6 charts-grids ">
						<h4 class="title">Energy</h4>
						 <div id="chartContainer" style="height: 400px; width: 100%;"></div></div>
						
					
					
					<div class="col-md-6 charts-grids " style="border-left:1em;border-color:#F1F1F1;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:solid;">
						<h4 class="title">Summary</h4>
						<div id="chartContainer2" style="height: 400px; width: 100%;"></div>
					</div>
					<div class="clearfix"> </div>
							
							
				</div>
				<div class="panel-group tool-tips widget-shadow" id="accordion" role="tablist" aria-multiselectable="true">
				<h4 class="title">Energy Data for <?php echo $_SESSION['set_gridname'];?></h4>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						  Per Duration Data
						</a>
					  </h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
				<div class="table-responsive bs-example  widget-shadow" style="overflow-x: scroll; overflow-y: hidden; padding:10px;">
						
						<table id="results" class="table table-bordered"> 
						<thead> 
						<tr> 
						<th>Time</th>
						<th scope="row">Generated Energy [kWh}</th>
						<th scope="row">Distributed Energy [kWh]</th> 
						<th scope="row" colspan="<?php echo $numofconnections;?>">Duration of interruption[h]</th> 
						<th scope="row">Avoided CO2 [kg] </th> 
						<th scope="row">Generated Losses </th> 
						<th scope="row">Number of Connected points</th>
						</tr> 
						</thead>
						<tbody> 
						</tbody>
						</table>
						</div>
						 </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						
					  <h4 class="panel-title">
	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Overall Data 
						</a>
					  </h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					  <div class="panel-body">
					  <div class="row">
					<button type="button" class="btn btn-smaill btn-sm" data-toggle="modal" data-target="#gridGraphsModal">View Graphs</button>
						<div class="modal fade" id="gridGraphsModal" tabindex="-1" role="dialog" aria-labelledby="gridGraphsModalLabel" >
							<div class="modal-dialog" role="document" style="width:100%; height:100%;">
								<div class="modal-content" style="height: auto; min-height: 100%;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="gridGraphsModalLabel">Graphs</h4>
									</div>
									<div class="modal-body" style="height: 500px; overflow-y: scroll;">
										<div class="row-info"> 
										<p>MINIGRID PERFORMANCE</p>
											
										</div>  
										<div class="row"> 
										<div class="charts">
					
					<div class="clearfix"> </div>
					<div class="col-md-6 charts-grids " style="margin-left:2em">
						<h4 class="title">Minigrid Clients</h4>
						<div id="chartclientscontainer" style="height: 400px; width: 100%;"></div>
					</div>
					<div class="col-md-4 charts-grids " style="margin-left:5em">
						<h4 class="title">Distributed Losses</h4>
						<div id="chartavoidedcontainer" style="height: 400px; width: 100%;"></div>
					</div>		
						<div class="clearfix"> </div>	
				</div>	
										</div> 
										 </div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					 </div>
						<div class="row">
				<div class="table-responsive bs-example  widget-shadow" style="overflow-x: scroll; overflow-y: scroll; padding:10px;">
						
						<table class="table table-bordered"> 
						<thead> 
						<tr> 
						<th>Time</th>
						<th scope="row">Distributed Energy [kWh]</th> 
						<th scope="row">Duration of interruption[h]</th> 
						<th scope="row">Avoided CO2 [kg] </th> 
						<th scope="row">Number Grid Connections</th>
						<th scope="row">Total Consumption</th>
						<th scope="row">Distributed Losses </th> 
						</tr> 
						</thead>
						<tbody> 
						
						<?php
						$month =array();
						$sdm = array();
						
						foreach ($cumulativedata as $data){
						
						$months = $data['month']."-".$data['year'];
						
						
						array_push($month,$months);
        
        }
        
        $smonth = array_unique($month);
       

        foreach($smonth as $singlemonth){
        
	array_push($sdm,$singlemonth);
    }
    foreach($sdm as $d)
						{ 
						
				echo"<tr> ";		
						
						 $input = array();
						$geninput = array();						
						 foreach ($cumulativedata as $vin) {
						 $dbtime = $vin['month']."-".$vin['year'];
		if($d == $dbtime)
							{				
		if($vin['datatype'] == 1)	{				 	

	 
		
			$date=$vin["inputvalue"];	
        		array_push($input,$date);
							}
							
							else
							{
							
							$dates=$vin["inputvalue"];	
        		array_push($geninput,$dates);
							
							}
							
        }
        }
        $ttinput = array_sum($input);
        
        $kwhinput = number_format((float)$ttinput,2,'.','');
         $ttinput2 = array_sum($geninput);
        $kwhgeninput = number_format((float)$ttinput2,2,'.','');
        echo '<td>'.$d.'</td>';
      
    ?>		
						
						
					
						
						 
						 
						 
						 
						 
						
						<?php  
						if(empty($kwhinput)){echo '<td>0</td>';}else{echo '<td>'.$kwhinput.'</td>';}
    
    ?>
						
						
						 <td><?php 
						 $tlosses=array();      
						  foreach ($dataloss as $vsin) {
						  $dbtimels = $vsin['month']."-".$vsin['year'];
						 if($d == $dbtimels)
							{
						 
						 array_push($tlosses,$vsin["inputvalue"]);
						         }
						        
						}
						 $loss = count($tlosses);
						 if($loss>0){
						         echo $loss;
						         }
						         elseif($loss <0)
						         {
						         echo 0;
						         
						         }
						         elseif(empty($loss))
						         {
						         echo 0;
						         }
						
						?></td>
						
						  <td><?php 
						  $cc2o =($kwhinput* 0.332297783);
						  echo number_format((float)$cc2o,2,'.','');?></td>
						
						  
						
						   
						
						 
						<?php 
						$tsv=array();
	$stval = 0;
						    if(!empty($apiread))
      {       
    
	$timemnth=array();
	$timmnth=array();
	
      foreach($apiread as $post){
		  $time=strtotime($post['date_connected']);
		  array_push($timemnth,$time);
		  }
		  $sttimemnth = array_unique($timemnth);
		  foreach ($sttimemnth as $stimemnth){
		  
$month=date("n",$stimemnth);
$year=date("Y",$stimemnth);

$gdate = $month."-".$year;
				   
				   if($d == $gdate)
				   {
                               foreach($apiread as $post){
                              
                               $time=strtotime($post['date_connected']);
                               if($time == $stimemnth){
                               $stval =$post['consumption']+$stval;
                               
                               }
                               
			       }
				array_push($tsv,$stval);   
					  
				   }
				  
		 }
		  echo '  <td>'.count($tsv).'</td>';
		  echo '  <td>'.array_sum($tsv).'</td>';
						}
						else
						{
						 echo '<td>0</td>';
						}	
      
    
    ?><td><?php echo $kwhinput -$stval;?> </td>
						</tr> 
						 <?php }
						 ?>
						 
						</tbody> 
						</table> 
					</div>
					
					</div>
					</div>
				  </div>
</div>
</div>
</div>
</div>
  <script type="text/javascript">
        $(document).ready(function () {

            $.getJSON("dashboard/getdist_loss", function (result) {

                var chartm = new CanvasJS.Chart("chartavoidedcontainer", {
                    data: [
                        {
                        
                         xValueType: "dateTime",
                         type: "column",
                            dataPoints: result
                        }
                    ]
                });

                chartm.render();
            });
              $.getJSON("dashboard/getgriduser", function (result) {

                var chartg = new CanvasJS.Chart("chartclientscontainer", {
                    data: [
                        {xValueType: "dateTime",
                         type: "spline",
                            dataPoints: result
                        }
                    ]
                });

                chartg.render();
            });
        });
        $('#emailreport').click(function() {
     var report = $('#selector2').val();
     var slug = "<?php echo $this->uri->segment(1);?>";
 $.ajax({
  type: "POST",
  url: "dashboard/sendmail/"+slug+"/"+report,
  data: { name: "John" }
}).done(function( msg ) {
  alert( "Data Saved: " + msg );
});    

    });
    </script>