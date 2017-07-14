<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}

	</style>
</head>
<body>
	<?php
					
					$stinputs=array();
					$stlosss=array();
					$stinput1=array();
					$stloss1=array();
		foreach ($inputdata as $data){
			foreach ($data as $k =>$v)
 {
	 foreach ($v as $vin)
	{
	if($vin['datatype']== '1'){
						$date=$vin['value'];
						array_push($stinputs,$date);
                                        array_push($stlosss,$vin["loss"]);
                                        }
                   elseif($vin['datatype'] == '0' )
                   {
                   $datest=$vin['value'];
						array_push($stinput1,$datest);
                                        array_push($stloss1,$vin["loss"]);
                   
                   }
        }
 }
		}
		$all_numeric = true;
foreach ($stlosss as $key) { 
    if (!(is_numeric($key))) {
        $all_numeric = false;
        break;
    } 
}
		if($all_numeric)
		{
		$tloss = array_sum($stlosss);
		}
		else
		{
		$tloss = 0;
		}
		$tloss1 = array_sum($stloss1);
        $tinput = array_sum($stinputs);
        $ttinput = $tinput;
        $kwhinput = number_format((float)$ttinput,2,'.','');
		$co2input = $kwhinput * 0.332297783;
		
		
	$tinput1 = array_sum($stinput1);
	$geninput = number_format((float)$tinput1,2,'.','');			?>
<div id="container">
<div id="body">
						
					<h3>Perfomance Report of Talek</h3>
					
						Retrieved on <?php echo date("Y/m/d"); ?>

										<?php  
						
	if($dates == 1)
{
	$monthst = 'Data for the duration  '.$duration.' in Months';
	$timelabel = 'Months';
}
elseif($dates == 2)
{
	$monthst = 'Data for the duration  '.$duration.' in Days';
	$timelabel = 'Days';
}
elseif($dates == 3)
{
	$monthst = 'Data for the duration  '.$duration.' in hours';
	$timelabel = 'Hours';
}

echo "<h2>".$monthst."</h2>";

    ?>		
						<h4>System Properties</h4>
						<p>Commissioning date:	 		<?php echo $posts->commissioningdate;?></p>
						<p>Total installed capacity:	<?php
      echo $posts->sizegrid;?>	kW</p>
						<p><h2>location </h2>  </p><p>   <h4>longitude</h4> :		<?php echo $posts->longitude;?></p>
						               <p><h4>latitude</h4> :		<?php echo $posts->latitude;?>  </p>
				
					
							
							
					
						

				
				<h4>Performance overview </h4>
		<h5>This is the cumulative  <?php echo "".$monthst."</h5>";

    ?>		

						<table class="gridtable"> 
						<thead> 
						<tr> 
						<th>#</th>
						<th><?php echo $posts->gridname;?></th>
						</tr> 
						</thead>
						<tbody> 
						<tr> 
						<th scope="row">Generated Energy (kWh) </th> 
						<td><?php if(empty($geninput)){
						echo 0;
						}
						else
						{
						echo $geninput;
						}
						?>
						</td>
						</tr> 
						<tr> 
						<th scope="row">Distributed Energy (kWh) </th> 
						<td><?php  if(empty($kwhinput)){
						echo 0;
						}
						else
						{
						echo $kwhinput;
						}?></td> 
						</tr> 
						<tr>
						<th scope="row">Duration of interruption[h]</th> 
						<td><?php echo $tloss;?></td> 
						</tr> 
						<tr>
						<th scope="row">Avoided CO2 [kg] </th> 
						<td><?php 
						  
						  echo number_format((float)$co2input,2,'.','');?></td> 
						</tr> 
						<tr>
						<th scope="row">Total Losses </th> 
						<td><?php if($geninput !=0 && $kwhinput !=0){
						$ttloss = $geninput - $kwhinput;
						echo $ttloss;
						}
						else
						{
						echo 0;
						}?>
						 </td> 
						</tr> 
						<tr>
						<th scope="row">Number of Metering Points </th> 
						<td><?php echo $connections;?></td> 
						</tr> 
						</tbody> 
						</table> 
						
						<p></p>
						<p></p>
						<p></p>
						
					<h4 class="title">Energy Data for <?php echo $posts->gridname;?></h4>
                                             <p></p>
							<table class="gridtable"> 
						<thead> 
						<tr> 
						<th><?php echo $timelabel;?></th>
						<th scope="row">Generated Energy [kWh}</th>
						<th scope="row">Distributed Energy [kWh]</th> 
						<th scope="row" colspan="<?php echo $numofconnections;?>" >Duration of interruption[h]</th> 
						<th scope="row">Avoided CO2 [kg] </th> 
						<th scope="row">Losses </th> 
						<th scope="row">Number of Metering Points</th>
						</tr> 
						</thead>
						<tbody> 
						
					<?php  
						$month =array();
						 $time = array();
						
						foreach($inputdata as $v) {
						 foreach ($v as$k=>$vt) {
						 
						 
						  foreach ($vt as$vin) {
						  
						  $dte=$vin["time"];
						 
						  	
        		                             array_push($time,$dte);
						 
						  }
						  }
						  }
						  $times = array_unique($time);
						  sort($times);
						  foreach($times as $dtime){
						  $input = array();
						$geninput = array();
						$tloss = array();
						$points = array();?>
						
						<tr>
						
						<?php
						  foreach ($inputdata as$v) {
						 foreach ($v as$k=>$vt) {
						 array_push($points,$k);
						 
						  foreach ($vt as$vin) {
						  
						  $dte=$vin["time"];
						 if($dte == $dtime){
						  	if($vin['datatype'] == 1){
        		                             array_push($input,$vin['value']);
        		                             array_push($tloss,$vin['loss']);
						 }
						 else
						 {
						 array_push($geninput,$vin['value']);
						 }
						  }
						  }
						  }
						  }
						  
						     $ttinput = array_sum($input);
        
        $kwhinput = number_format((float)$ttinput,2,'.','');
         $ttinput2 = array_sum($geninput);
        $kwhgeninput = number_format((float)$ttinput2,2,'.','');
        echo '<td>'.$dtime.'</td>';
						  
						  ?>
						  
						  <?php  
						if(empty($kwhgeninput)){echo '<td>0</td>';}else{echo '<td>'.$kwhgeninput.'</td>';}
						?>
						  <?php  
						if(empty($kwhinput)){echo '<td>0</td>';}else{echo '<td>'.$kwhinput.'</td>';}
						?>
						 <?php  
						if(empty($tloss)){echo '<td>0</td>';}else{foreach ($tloss as $totlosses)
						{
						echo "<td>".$totlosses."</td>";
						} }
						?>
						<?php  
						if(empty($kwhinput)){
						echo '<td>0</td>';}
						else{
						$cc2o =($kwhinput* 0.332297783);
						echo '<td>'.number_format((float)$cc2o,2,".","").'</td>';}
						?>
						 <?php  
						echo '<td>0</td>';
						?>
						<?php  
						if(empty($points)){echo '<td>0</td>';}else{echo '<td>'.count($points).'</td>';}
						?>
						</tr> 
						<?php
						}
						?>
						  </tbody> 
						</table> 
						  <?php
						 foreach ($inputdata as$v) {
						 foreach ($v as$k=>$vt) {
						 $datattp = array();
						 
						  foreach ($vt as$vin) {
						  
						  $dte=$vin["datatype"];
						  if($dte == 1){
						  array_push($datattp,$dte);
						  }}
							?>
							<p></p>
							<h5> FEED NAME: <?php echo $k;?></h5>
							<p></p>
							<table class="gridtable"> 
						<thead>
						<tr> 
						<th><?php echo $timelabel;?></th>
						<?php if (!empty($datattp)){?>
						
						
						<th scope="row">Distributed Energy [kWh]</th> 
						<th scope="row">Duration of interruption[h]</th> 
						<th scope="row">Avoided CO2 [kg] </th> 
						
						<?php
						}else
						{?>
						<th scope="row">Generated Energy [kWh]</th>
						<th scope="row">Generated Losses </th>
						
						<?php }?>
						</tr> 
						</thead>
						<tbody>
<?php							
						 foreach ($vt as$vin) {
							 	

	 
		
			$date=$vin["time"];	
        		
        
        echo '<tr><th>'.$date.'</th>';
      
    ?>		
						
						
					
						
						 
						 
						<?php  
						if($vin['datatype']== '0'){
        echo '<td>'.number_format((float)$vin['value'],2,'.','').'</td>';
    }
    ?>
						
						
						<?php  
						if($vin['datatype']== '1'){
        echo '<td>'.number_format((float)$vin['value'],2,'.','').'</td>';
    }
    
    ?>
						
						
						  <td><?php echo $vin["loss"];?></td>
						
						  <td><?php 
						  if($vin['datatype']== '1'){
         $cc2o =$vin['value']* 0.332297783;
           echo number_format((float)$cc2o,4,'.','');
    }
   
						 
						 
						?></td>
						<?php if($vin['datatype']== '0'){
						 echo" <td>0</td>";
						 }
						 ?>
						
						  
						
						 
	
						</tr> 
						 <?php }
						 ?>
						 </tbody> 
						</table> 
						 <?php }}?>
						
						</div>
			
	</div><?php
	if(!empty($graph))
	{?>
         <img src="<?php  echo $graph;?>"/>
         <?php
         }
         elseif(!empty($gengraph))
         {?>
         <img src="<?php  echo $gengraph;?>"/>
       <?php  }?>
       <p></p>
						
</body>
</html>
					