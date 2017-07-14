<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

public function index() 
	{
		$this->load->model('API_model');
		$ds=$this->API_model->read();
		$griddata = $this->grid_model->get_specific('slug',$_SESSION['set_grid']);
		$plist=array();
		 $cplist = '';
		 $numofconnections = 0;
		 
if( !empty($griddata->day_db))
					{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);
$numofconnections = count($plist);
		}
		
		$url = $_SESSION['set_grid'].'/dashboard/get_lastvalue';
		$stinput=array();
		$stime = array();
		$fds = array();
		$fts = array();
		$ttlloss = array();
		$f=array();
		$cmf=array();
		$tloss=array();
		$feeds = array();
		$apiread = $this->API_model->read_griduser();
		if(!empty($plist)){
        $cplist = count($plist);
			foreach($plist as $list)
			{


				$snd = $list;
            
				$datas = $this->API_model->get_feeds($snd);
				array_push($f,$snd);
				
				foreach ($datas as $data)
				{ 
				
					$td=array(
						'inputvalue'=>$data['inputvalue']/$ints,
						'month'=>$data['month'],
						'year'=>$data['year'],
						'day'=>$data['day'],
						'hours'=>$data['hours'],
						'datatype'=>$data['datatype']
					);
					if($data['inputvalue'] =='0')
					{
					$tdloss =array(
						'inputvalue'=>$data['inputvalue'],
						'month'=>$data['month'],
						'year'=>$data['year'],
						'day'=>$data['day'],
						'hours'=>$data['hours'],
						'datatype'=>$data['datatype']
					);
					array_push($tloss,$tdloss);
					}
					array_push($cmf,$td);
				$singday = $data['year'].'-'.$data['month'].'-'.$data['day'];
				
					$yesterday = date("Y-m-d",strtotime("-1 days"));
					
					if( $data['datatype']=='1')
							{
							$rawdata = $data['inputvalue']/$ints;
							
				array_push($fds,$rawdata);
							}
				
				
				}
			}
		}
		
		
	$inter = $this->API_model->get_feeds('interruptions');
		$ints =array();
		if(!empty($inter))
		{
		foreach($inter as $ter)
		{
		  if($inter['slug']==$_SESSION['set_grid'])
		  {
		     array_push($ints,$inter['duration']);
		  }
		}
		}
		if(!empty($ints))
		{
		  $setts = array_sum($ints);
		}
		else
		{
		    $setts =0;
		}
		
		$data =array(
		'title'=>'Dashboard',
		'datas'=>$fds,
		'js'=>$this->dash_graph($f),
		'intts'=>$setts,
		'cumulativedata'=>$cmf,
		'dataloss'=>$tloss,
		'apiread'=>$apiread,
  'feeds'=>$feeds,
  'connections'=>$cplist,
  'numofconnections'=>$numofconnections,
		);
		$this->template->load('default','dashboard',$data);
	}
	function dash_graph($sdn=array())
	{
	$stime=array();
		$array_final1 = 0;
		if(!empty($sdn))
		{ 
	      
	        foreach($sdn as $s)
			{
				$stinput=array();
				
			$datas = $this->API_model->get_feeds($s);
			 foreach ($datas as $data)
			 {
				 $date=$data['inputvalue'];
						$years = $data['year'];
						$month = $data['month'];
						$day = $data['day'];
						$hours = $data['hours'];
						$feedname = $data['feed_name'];
	                         $x= $years."-".$month."-".$day." ".$hours.":00:00";   
                       $val	= array(
					     'inputvalue'=>$date,
						 'xtime'=>strtotime($x)*1000,
						 'feedname'=>$feedname
					   );						 
						array_push($stime,$val);
						
			 }
			 
			  //array_push($stime,$stinput);
			}
			$stime = $this->getp_data(1,date('Y'));
			
		}
		if(!empty($stime))
		{
		$sstime = $stime;
		}
		else
		{
		$sstime = 0;
		}
		$url = $_SESSION['set_grid'].'/dashboard/get_lastvalue';
		$url2 =$_SESSION['set_grid']."/dashboard/get_data";
		$js='<script type="text/javascript">
		var sl =\''.$sstime.'\';

	var key =[];
	var val =[];
	var lb = [];
	var ab = [];
	var gendata = [];
	var disttotaldata = [];
	$.each($.parseJSON(sl), function(k, v) {
	$.each(v.data, function(m, d) {
		
    key.push(d.x);
	val.push(d.y);
	lb.push("\""+v.lb+"\"");
      var points = new Array(v.lb,d.x,d.y,v.datatp);
	  ab.push(points);
	  if(v.datatp == 0)
	  {
	      var dtpgen = d.y;
	      gendata.push(dtpgen);
	  }
	  else
	  {
	      var dtpdist = d.y;
	      disttotaldata.push(dtpdist);
	  }
});
});

function find_duplicate_in_array(arra1) {  
  var i,  
  len=arra1.length,  
  result = [],  
  obj = {};   
  for (i=0; i<len; i++)  
  {  
  obj[arra1[i]]=0;  
  }  
  for (i in obj) {  
  result.push(i);  
  }  
  return result;  
  }
  
  		function dtotalsdata()
{
	var id = find_duplicate_in_array(lb);
	
	var tn = [];
	var tnvary = [];
	if(id)
	{
		var inttime = []
		for(i=0;i<id.length;i++)
		{  
	           
			for(w=0;w<ab.length;w++)
			{
        var abs = \'"\'+ab[w][0]+\'"\';	
          	var n = abs.localeCompare(id[i]);	  
		var month=["0","January","February","March","April","May","June","July","August","September","October","November","December"];
		    if(n == 0)
		  {	
				var datval = ab[w][1];
				inttime.push(datval);
				
		   }
			
			}
		
		
		}
		inttime=find_duplicate_in_array(inttime);
		console.log(inttime);
		for(j=0;j<inttime.length; j++)
		{
			var datsval = [];
			var mainTotal = 0;
			for(i=0;i<id.length;i++)
		{  
	            
			for(w=0;w<ab.length;w++)
			{
        var abs = \'"\'+ab[w][0]+\'"\';	
          	var n = abs.localeCompare(id[i]);	  
		var month=["0","January","February","March","April","May","June","July","August","September","October","November","December"];
		    if(n == 0)
		  {	
	             if(parseInt(ab[w][1])===parseInt(inttime[j]))
				 {
				var datval = ab[w][2];
				datsval.push(datval);
				 }
		   }
			
			}
		}
		for(var m = 0; m <datsval.length; m++) {
    mainTotal += datsval[m];  // Iterate over your first array and then grab the second element add the values up
}
          var datamainpoint = {x:parseInt(inttime[j]),y:parseFloat(parseFloat(mainTotal).toFixed(2))};
			
		tnvary.push(datamainpoint);
		}
		
		var result = {type: \'column\',color: "#337ab7",zoomEnabled:true,animationEnabled: true, xValueType: "dateTime",name: "loads",legendText: "loads",showInLegend: true,dataPoints:tnvary};
		tn.push(result);
	
		
	}
	

	return tn;
}

		function dupdata()
{
	var id = find_duplicate_in_array(lb);
	
	var tn = [];
	if(id)
	{
		for(i=0;i<id.length;i++)
		{  
	            var datsval = [];
			for(w=0;w<ab.length;w++)
			{
        var abs = \'"\'+ab[w][0]+\'"\';	
          	var n = abs.localeCompare(id[i]);	  
		var month=["0","January","February","March","April","May","June","July","August","September","October","November","December"];
		    if(n == 0)
		  {	
				var datval = {x:ab[w][1],y:ab[w][2]};
				datsval.push(datval);
				
		   }
			
			}
		
		var result = {type: \'spline\',zoomEnabled:true,animationEnabled: true, xValueType: "dateTime",name: id[i],legendText: id[i],showInLegend: true,dataPoints:datsval};
		
	
		tn.push(result);
		}
	}
	

	return tn;
}
var dat = dupdata();
var dattotals = dtotalsdata();

function add(a,b) {
return a + b;
}
function dpdata()
{
	var id = find_duplicate_in_array(lb);
	
	var tn = [];
	if(id)
	{
		for(i=0;i<id.length;i++)
		{  
	            var datsval = [];
			for(w=0;w<ab.length;w++)
			{
        var abs = \'"\'+ab[w][0]+\'"\';	
          	var n = abs.localeCompare(id[i]);	  
		    if(n == 0)
		  {	
				var datval = ab[w][2];
				datsval.push(datval);
				
		   }
			
			}
		var stn = datsval.reduce(add,0);
		
		tn.push(stn);
		}
	}
	var result =tn.reduce(add);

	return result.toFixed(2);
}
var MyyearDistTotal = 0;
for(var m = 0; m <disttotaldata.length; m++) {
    MyyearDistTotal += disttotaldata[m];  // Iterate over your first array and then grab the second element add the values up
}
var ydatval = MyyearDistTotal;
var MyyearGenTotal = 0;
for(var m = 0; m <gendata.length; m++) {
    MyyearGenTotal += gendata[m];  // Iterate over your first array and then grab the second element add the values up
}
var ygendatval= MyyearGenTotal;
		var chartn = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Energy "
      },
	  
      axisY: {
        title: " Energy in kWh"
      },
	  axisX:{
	  interval:1,
        title: "Duration",
		  valueFormatString:"MMMM YYYY",
		intervalType: "month",
     },
      data: dat ,
    });

    chartn.render();
		var chartms = new CanvasJS.Chart("charttotalContainer",
    {
      title:{
        text: "Total Energy "
      },
	  
      axisY: {
        title: " Energy in kWh"
      },
	  axisX:{
	  interval:1,
        title: "Duration",
		  valueFormatString:"MMMM YYYY",
		intervalType: "month",
     },
      data: dattotals ,
    });
     chartms.render();

    var chartp = new CanvasJS.Chart("chartContainer2",
	{
		title:{
			text: "SYSTEM ENERGY REFERENCE FOR THE CURRENT YEAR",
			fontFamily: "arial black"
		},
                animationEnabled: true,
		legend: {
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},
		theme: "theme1",
		data: [
		{        
			type: "pie",
			indexLabelFontFamily: "Garamond",       
			indexLabelFontSize: 20,
			indexLabelFontWeight: "bold",
			startAngle:0,
			indexLabelFontColor: "MistyRose",       
			indexLabelLineColor: "darkgrey", 
			indexLabelPlacement: "inside", 
			toolTipContent: "{name}: {y}:Ratio",
			showInLegend: true,
			indexLabel: "#percent%", 
			dataPoints: [
				{  y: ydatval, legendText:"Distributed in (kWh)", indexLabel: "Distributed Energy " },
				{  y: ygendatval, legendText:"Generated in (kWh)", indexLabel: "Generated Energy" },
				
				
			]
		}
		]
	});
	chartp.render();
	
	</script>
	<script type="text/javascript">
	function add(a, b) {
    return a + b;
}
	window.onload = function () {
		
		var container = $("#lenergy");
        container.load("'.base_url($url).'");
        var refreshId = setInterval(function()
        {
            container.load("'.base_url($url).'");
        }, 60000);
	}
	

	function ChangeView(){
								var inval=document.getElementById("daterange").value;
								var otval=document.getElementById("dtpmain").value;
								var container = "'. base_url($url2).'/"+inval+"/"+otval+"";
								var gencontain = "'. base_url($url2).'/"+inval+"/"+otval+"";
								var abd = [];
					                        var timeabd = [];
					                        var valueabdt = [];
								var keysin = [];
								var vsin = [];
								var dttype = [];
			$.getJSON(container,function(data){
									
									$.each(data,function(i, value){
									  dttype.push(value.datatp);
									  keysin.push(value.lb);
										$.each(value.data,function(k, v){
										
											
											
											lb.push("\""+v.lb+"\"");
											 var pointss ={datatp:value.datatp,label:value.lb,x:v.x,y:v.y,l:v.l};
											vsin.push(pointss);
											timeabd.push(v.x);
											valueabdt.push({"val":v.y,"name":v.x});
										});
										
										abd.push(vsin);
									});
								var ids = find_duplicate_in_array(keysin);
								
								
	
	var tn = [];
	var markers = [];
	var markersm = [];
	var datsvalm = [];
          var uniquetimem = [];
	if(ids)
	{
	
	for (var i = 0; i <ids.length; ++i) {
    markers[i] = [];
}
          
		  
		for(i=0;i<ids.length;i++)
		{  
	            var datsval1 = [];
	            
				
			for(w=0;w<abd[i].length;++w)
			{
                        if(abd[i][w].label === ids[i]){
        	  
				var datval = {x:abd[i][w].x,y:abd[i][w].y};
				var time = abd[i][w].x;
				
				datsval1.push(datval);
				uniquetimem.push(time);
				
				}
			}	
		   
			
			
		markers[i] = {type: \'spline\',zoomEnabled:true,animationEnabled: true, xValueType: "dateTime",name: ids[i],legendText: ids[i],showInLegend: true,dataPoints:datsval1};
		
		
		}
			
								
								
		var dats = markers;
	var chartn = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: " Energy for "+otval,
      },
	  
      axisY: {
        title: " Energy in kWh"
      },
	  axisX:{
        title: "Duration",
     },
      data: dats ,
    });
     for (var i = 0; i <ids.length; ++i) {
     chartn.options.data[i].dataPoints.sort(compareDataPointYAscend);
	} 



    chartn.render();
	
	
	
		uniquetimem = find_duplicate_in_array(uniquetimem);
		var set =" ";
		for(j=0;j<uniquetimem.length;++j)
		{ 
	var datsvalsample = [];
	var datagensample = [];
	var myTotal = 0;
	var myTotalloss = 0;
	var myTotalgen = 0;
    var interruptiondistributed = [];
	 	for(i=0;i<1;i++)
		{

				
			for(w=0;w<abd[i].length;w++)
			{
                        if(parseInt(abd[i][w].x) === parseInt(uniquetimem[j]))
						{
        	  
				var datval = abd[i][w].y;
				var loss = abd[i][w].l;
				interruptiondistributed.push(loss);
			
				datsvalsample.push(datval);
				if (abd[i][w].datatp == 0)
				{
				    datagensample.push(datval);
				}
				
				}
				
			}
		
		
		}

for(var m = 0; m <datsvalsample.length; m++) {
    myTotal += datsvalsample[m];  // Iterate over your first array and then grab the second element add the values up
}
for(var m = 0; m <datagensample.length; m++) {
    myTotalgen += datagensample[m];  // Iterate over your first array and then grab the second element add the values up
}

           
			var datampoint = {x:parseInt(uniquetimem[j]),y:parseFloat(parseFloat(myTotal).toFixed(2))};
			
		   datsvalm.push(datampoint);
		   
		   var month=["0","January","February","March","April","May","June","July","August","September","October","November","December"];
			var monthnum =[1,2,3,4,5,6,7,8,9,10,11,12];
		   
		   //set table 
		   	var date = new Date(parseInt(uniquetimem[j]));
			var years = date.getFullYear();
			var months = date.getMonth();
			var spmonth = monthnum[months];
			var day = date.getDate();
// Hours part from the timestamp
var hours = date.getHours();
// Minutes part from the timestamp
var minutes = "0" + date.getMinutes();
// Seconds part from the timestamp
var seconds = "0" + date.getSeconds();


if(inval == 1)
{
	var formattedTime =years+"-"+spmonth;

}
if(inval == 2)
{
	
	var formattedTime =years+"-"+spmonth+"-"+day ;

}
if(inval == 3)
{
	var formattedTime =years+"-"+spmonth+"-"+day+"   "+hours + ":" + minutes.substr(-2) ;

}

var integ = 0.000;
var gen = myTotalgen.toFixed(3);
var dist = myTotal.toFixed(3);
var avco2 = myTotal*0.332297783;
avco2 = avco2.toFixed(4);

			if(dist == integ)
			{
				var valt =1;
				
			}
			if(gen == 0)
			{
			  var  genloss = 0;
			}
			else
			{
			    var genloss = gen - dist;
			}
			set += "<tr>";
			set +="<td>"+ formattedTime+"</td>";
			set +="<td>"+gen+"</td>";
			set +="<td>"+dist+"</td>";
			for(var m = 0; m <interruptiondistributed.length; m++) {
    	set +="<td>"+interruptiondistributed[m]+"</td>";
}
		
			set +="<td>"+avco2+"</td>";
			set +="<td>"+genloss+"</td>";
			
			set +="<td>"+ids.length+"</td></tr> ";
			}
			
			 
		  
		
		
		$("#results tbody").html(set);
		

	var datsm = [];
	var smdat = {type: \'column\',color: "#337ab7",xValueType: "dateTime",name: \'loads\',legendText: \'loads\',showInLegend: true,dataPoints:datsvalm};
		     datsm.push(smdat);  
			 
		var chartm = new CanvasJS.Chart("charttotalContainer",
    {
      title:{
        text: " Total Energy for "+otval,
      },
	  
      axisY: {
        title: " Energy in kWh"
      },
	  axisX:{
        title: "Duration",
		
		 
     },
      data:datsm  
	  
		,
    });

	chartm.render();
	}
								});
									
	}			
		function sortdata(array,array2)
		{
		var result = [];
		array.forEach(function(key) {
    var found = false;
    array2 = array2.filter(function(array2) {
        if(!found && array2[1] == key) {
            result.push(array2);
            found = true;
            return false;
        } else 
            return true;
    })
})
return result;
		}
		function compareDataPointYAscend(dataPoint1, dataPoint2) {
		return dataPoint1.x - dataPoint2.x;
}					
	</script>
	
	';
	return $js;	
	}
	function getLastInserted() {
	$this->load->model('API_model');
		$datas=$this->API_model->read();
		$v=array();
		foreach($datas as $data)
		{
			if(!empty($data['feed_input']) && $data['slug'] == $_SESSION['set_grid'] )
			{
		array_push($v,$data['feed_input']);
			}
		}
		
		if(!empty($v))
		{
		$idst=array();
		$vinst=array();
		foreach($v as $vin)
		{
			$stid=$this->API_model->getmaxid($vin);
			array_push($idst,$stid);
		}
		$cidcount = count($v);
		$curdate=date('Y-m-d H:i');
		for($i=0;$i<$cidcount;$i++){
             $query =$this->API_model->get_specificfeeds($v[$i],'id',$idst[$i]);
             if(!empty($query))
             {
			 $dbtime = strtotime($query->timestamp);
              if($curdate == date('Y-m-d H:i',$dbtime) && $query->datatype == 1 )
			  {
             array_push($vinst,$query->inputvalue);
			  }
			  else
			  {
				  array_push($vinst,0);
			  }
		
		}
		else
			  {
				  array_push($vinst,0);
			  }
		}
		$qst =array_sum($vinst);
		return $qst;
		}
		else
		{
			return "0";
		}
       }
	   public function get_lastvalue()
	{
	$lastinserted =$this->getLastInserted();
	echo '<label>'.$lastinserted.'(W)</label>';
	}
	function get_data($select,$sdate,$datatype=NULL)
	{
	    $this->load->model('API_model');
	$datatype = "";
		$url= $_SESSION['set_grid'];
		$value = array();
		$griddata = $this->grid_model->get_specific('slug',$url);
		if(!empty($griddata->day_db))
			{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);
						
					foreach($plist as $list)
					{
						
	$dsta=$this->getdata($select,$list,$sdate,$datatype,$ints);
	
	$feedname = substr($list,10);
	$dinput = $this->API_model->get_specific('name',$feedname);
	
	    $dset = $dinput->datatype;
	
	$feeds = array('lb'=>$feedname,'datatp'=>$dset,'data'=>$dsta);
	
    array_push($value,$feeds);
					}
					
			}
			$final = json_encode($value,JSON_NUMERIC_CHECK);
			echo $final;
	}
	function getp_data($select,$sdate)
	{
		$url= $_SESSION['set_grid'];
		$value = array();
		$datatype = "";
		$griddata = $this->grid_model->get_specific('slug',$url);
		if(!empty($griddata->day_db))
			{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);
						
					foreach($plist as $list)
					{
						
	$dsta=$this->getdata($select,$list,$sdate,$datatype,$ints);
	
	$feedname = substr($list,10);
	$dinput = $this->API_model->get_specific('name',$feedname);
	
	    $dset = $dinput->datatype;
	$feeds = array('lb'=>$feedname,'datatp'=>$dset,'data'=>$dsta);
	
    array_push($value,$feeds);
					}
					
			}
			$final = json_encode($value,JSON_NUMERIC_CHECK);
			return $final;
	}
	function getdata($date,$db,$specdate,$datatype=NULL,$ints)
	{
		
		$this->load->model('API_model');
		if($date == 1)
		{
			$months = array();
			$ydata=$this->API_model->get_specificfeedsdata($db,array('year'=>$specdate));
			
			foreach($ydata as $yrdata)
			{
				array_push($months,$yrdata->month);
			}
			$month = array_unique($months);
			$endata = array();

			for($i=1;$i<$month[0];$i++){
			
				$sndata = 0;
				$senddata = array(
				'x'=>strtotime($specdate."-".$i)*1000,
				'y'=>$sndata,
				'l'=>0,
				
				);
				array_push($endata,$senddata);
				
			}
			foreach($month as $mnth)
			{
			
			$mndata=array();
			$interupt=array();
			   if($datatype == NULL){
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$specdate,'month'=>$mnth));
				}
				else
				{
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$specdate,'month'=>$mnth,'datatype'=>$datatype));
				}
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
					$stdt = number_format($stdt, 2, '.', '');
					
					array_push($mndata,$stdt);
					if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					}
				}
				$sndata = array_sum($mndata);
				$loss = count($interupt);
				$senddata = array(
				'x'=>strtotime($specdate."-".$mnth)*1000,
				'y'=>$sndata,
				'l'=>$loss,
				
				);
				array_push($endata,$senddata);
				
			}
			//$endata = array_map("unserialize", array_unique(array_map("serialize", $endata)));
		}
		elseif($date == 2)
		{
			$dths = array();
			
			$plist = explode('-',$specdate);
			$mdata=$this->API_model->get_specificfeedsdata($db,array('month'=>$plist[0],'year'=>$plist[1]));
			
			foreach($mdata as $mrdata)
			{
				array_push($dths,$mrdata->day);
			}
			$days = array_unique($dths);
			
			$endata = array();
			if(!empty($days[0])){
			for($i=1;$i<$days[0];$i++){
			
				$sndata = 0;
				$senddata = array(
				'x'=>strtotime($plist[1]."-".$plist[0]."-".$i)*1000,
				'y'=>$sndata,
				'l'=>0,
				);
				array_push($endata,$senddata);
				
			}
			}
			foreach($days as $dth)
			{
			$interupt=array();
				$mndata=array();
				if($datatype == NULL){
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[1],'month'=>$plist[0],'day'=>$dth));
				}
				else
				{
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[1],'month'=>$plist[0],'day'=>$dth,'datatype'=>$datatype));
				}
				
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
						
					$stdt = number_format($stdt, 2, '.', '');
					array_push($mndata,$stdt);
					if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					}
				}
				$sndata = array_sum($mndata);
				$loss = count($interupt);
				$senddata = array(
				'x'=>strtotime($plist[1]."-".$plist[0]."-".$dth)*1000,
				'y'=>$sndata,
				'l'=>$loss,
				);
				array_push($endata,$senddata);
				
			}
		}
		elseif($date == 3)
		{
			$dths = array();
			$plist = explode('-',$specdate);
			
			$mdata=$this->API_model->get_specificfeedsdata($db,array('day'=>$plist[0],'month'=>$plist[1],'year'=>$plist[2]));
			foreach($mdata as $mrdata)
			{
				array_push($dths,$mrdata->hours);
			}
			$days = array_unique($dths);
			
			$aftdays = count($days);
			$endata = array();
			if(!empty($days)){
			for($i=0;$i<$days[0];$i++){
			
				$sndata = 0;
				$senddata = array(
				'x'=>strtotime($plist[2]."-".$plist[1]."-".$plist[0]." ".$i.":00:00")*1000,
				'y'=>$sndata,
				'l'=>1,
				);
				array_push($endata,$senddata);
				
			}
			}
			else
			{
			for($i=0;$i<24;$i++){
			
				$sndata = 0;
				$senddata = array(
				'x'=>strtotime($plist[2]."-".$plist[1]."-".$plist[0]." ".$i.":00:00")*1000,
				'y'=>$sndata,
				'l'=>1,
				);
				array_push($endata,$senddata);
				
			}
			
			
			
			}
			foreach($days as $dth)
			{
				$mndata=array();
				$interupt=array();
				if($datatype == NULL){
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[2],'month'=>$plist[1],'day'=>$plist[0],'hours'=>$dth));
				}
				else
				{
			           $data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[2],'month'=>$plist[1],'day'=>$plist[0],'hours'=>$dth,'datatype'=>$datatype));
				}
				
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
						
					$stdt = number_format($stdt, 2, '.', '');
					array_push($mndata,$stdt);
					if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					}
				}
				$sndata = array_sum($mndata);
				$loss = count($interupt);
				if($loss >0)
				{
				$loss = 0;
				}
				$senddata = array(
				'x'=>strtotime($plist[2]."-".$plist[1]."-".$plist[0]." ".$dth.":00:00")*1000,
				'y'=>$sndata,
				'l'=>$loss,
				);
				
				array_push($endata,$senddata);
			}
			
		}
		
		return $endata;
	}
	public function getdist_loss()
	{
	$this->load->model('API_model');
	  $data_points = array();
		$ds=$this->API_model->read();
		$griddata = $this->grid_model->get_specific('slug',$_SESSION['set_grid']);
		$plist=array();
		 $cplist = '';
		 $tsv=array();
		 
if( !empty($griddata->day_db))
					{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);

		}
		
		$cmf=array();
		
		
		$apiread = $this->API_model->read_griduser();
		if(!empty($plist)){
        $cplist = count($plist);
			foreach($plist as $list)
			{


				$snd = $list;
            
				$datas = $this->API_model->get_feeds($snd);
				
				
				foreach ($datas as $data)
				{ 
				
					$td=array(
						'inputvalue'=>$data['inputvalue']/$ints,
						'month'=>$data['month'],
						'year'=>$data['year'],
						'day'=>$data['day'],
						'hours'=>$data['hours'],
						'datatype'=>$data['datatype']
					);
				
					array_push($cmf,$td);
				
				}
			}
		}
	
	$month =array();
						$sdm = array();
						
						foreach ($cmf as $data){
						
						$months = $data['month']."-".$data['year'];
						
						
						array_push($month,$months);
        
        }
        
        $smonth = array_unique($month);
       

        foreach($smonth as $singlemonth){
        
	array_push($sdm,$singlemonth);
    }
    
    foreach($sdm as $d)
						{ 
						
						
						
						 $input = array();
												
						 foreach ($cmf as $vin) {
						 $dbtime = $vin['month']."-".$vin['year'];
		if($d == $dbtime)
							{				
		if($vin['datatype'] == 1)	{				 	

	 
		
			$date=$vin["inputvalue"];	
        		array_push($input,$date);
							}
							
							
							
        }
        }
        $ttinput = array_sum($input);
        
        $kwhinput = number_format((float)$ttinput,2,'.','');
        
        
	
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
				$distloss =$kwhinput - $stval;   
				$ttgridpoints = array('y'=>$distloss,'x'=>$stimemnth*1000);
				array_push($tsv,$ttgridpoints);	
				   }
				   else
				   {
				   $distloss =$kwhinput;   
				$ttgridpoints = array('y'=>$distloss,'x'=>strtotime("01-".$d)*1000);
				array_push($tsv,$ttgridpoints);	
				   
				   
				   }
				  
				   
				  
			  
				 
				   
				  
		 }
	}
	}
	
	echo json_encode($tsv, JSON_NUMERIC_CHECK);
	}
	
	public function getgriduser()
	{
	$this->load->model('API_model');
	   $data_points = array();
	$apiread = $this->API_model->read_griduser();
	
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
		  $ydata = array();
$month=date("n",$stimemnth);
$year=date("Y",$stimemnth);

$gdate = $month."-".$year;
				   
				   
                               foreach($apiread as $post){
                               $stval ="";
                               $time=strtotime($post['date_connected']);
                               if($time == $stimemnth){
                               $stval =$post['consumption']+$stval;
                              
                               array_push($ydata,$stval);
                               }
                               
			       }
				$ntime= $stimemnth *1000;   
				$ycount = count($ydata);
                               $dtata = array("y"=>$ycount,"x"=>$ntime);	  
				   array_push($tsv,$dtata);
				  
		 }
	}
	echo json_encode($tsv, JSON_NUMERIC_CHECK);
	}

	 public function sendmail($slug,$message) { 
	 $config = array();
                $config['useragent']           = "CodeIgniter";
                $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            = "smtp";
                $config['smtp_host']           = "localhost";
                $config['smtp_port']           = "25";
                $config['mailtype'] = 'html';
                $config['charset']  = 'utf-8';
                $config['newline']  = "\r\n";
                $config['wordwrap'] = TRUE;
	 //Load email library 
         $this->load->library('email'); 
         $this->email->initialize($config);
	 $this->load->model('API_model');
	 $adminuser = $this->ion_auth->user(1)->row();
	$grid=$this->API_model->get_specificfeeds('groups','name',$slug);
	$gridplant=$this->API_model->get_specificfeeds('grid','slug',$slug);
             $gusergroup =$this->API_model->getfspecificfeedsdata('users_groups',array('group_id'=>$grid->id));
             if(!empty($gusergroup))
             {
             
            foreach($gusergroup as $usergroup){
            $specuser = $this->ion_auth->user($usergroup['user_id'])->row();
         $from_email = $adminuser->email;
         $to_email = $specuser->email; 
   
         $plant = $gridplant->gridname;

   
         $this->email->from($from_email, 'MINIGRIDEMS'); 
         $this->email->to($to_email);
         $this->email->subject('MINIGRID  in  '.$plant); 
         $this->email->message($message); 
   $data = array(
   'emailaddress'=>$to_email,
   'slug'=>$slug,
   );
   
         //Send mail 
         if($this->email->send()) 
         $data['emailtext']= $message; 
         else 
          $data['emailtext']=$this->email->print_debugger(); 
    
    $this->API_model->insert_email('emaillogs',$data);
         } 
         }
         else
         {
            $from_email = $adminuser->email;
         $to_email = $adminuser->email; 

         $this->email->from($from_email, 'MINIGRIDEMS'); 
         $this->email->to($to_email);
         $this->email->subject('MINIGRID'.$plant); 
         $this->email->message($message); 
   
     $data = array(
   'emailaddress'=>$to_email,
   'slug'=>$slug,
   );
         //Send mail 
         if($this->email->send()) 
         $data['emailtext']= $message; 
         else 
          $data['emailtext']="Error in sending Email."; 
          
    $this->API_model->insert_email('emaillogs',$data);
         }
         
         return TRUE;
      } 
}