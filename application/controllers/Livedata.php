<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Livedata extends MY_Controller {


	public function index()
	{
	$this->load->model('API_model');
	$datapoints = $this->get_feeds();
	 $datas=$this->API_model->read();
	 $url = $_SESSION['set_grid'].'/livedata/get_valuefeeds';
	 $url3 = $_SESSION['set_grid'].'/livedata/getLastInsert';
	 $url2 = $this->get_initialfeeds();
	 $co2=$this->get_currentvalues();
	 $tdata = $this->getp_data();
	$v =array();
	
	foreach($co2 as $data){
	array_push($v,$data['inputvalue']);}
	$sumv= array_sum($v);
	//number of feeds
	$cpoints = array();
	foreach($datas as $vdata)
	{
	if(!empty($vdata['feed_input']) && $vdata['slug']==$_SESSION['set_grid']){
	array_push($cpoints,$vdata['id']);
	
	}
	
	}
	$cpoint= count($cpoints);
	
	 if(empty($sumv))
	 {
	 $co='0';
	 
	 }
	 else
	 {
	 $co =$sumv;
	 
	 $co = $co/100000;
	 $co = $co * 0.332297783;
	 }
	 
		$data =array(
		'title'=>'Live Data',
		'data_points'=>$datapoints,
		'datas'=> $tdata,
		'co2'=>$co,
		'js'=>'	<script type="text/javascript">
	window.onload = function () {
	
                var dps = [];
		var markers = [];//datapoints
for (var i = 0; i <'.$cpoint.'; ++i) {
    markers[i] = [];
}


		var chart = new CanvasJS.Chart("chartContainer",{
		    zoomEnabled: true,
			animationEnabled: true,
			title :{
				text: "Live  Data"
			},	
           toolTip:{
		shared: true
	},			
			 axisX:{
  title:"Time",
   
  //valueFormatString: "hh:mm:ss",
 },
 axisY:{
  title:"Power(W)",
		interlacedColor: "#F5F5F5",
		gridColor: "#D7D7D7",
		tickColor: "#D7D7D7"
 },
			legend:{
		verticalAlign: "bottom",
		horizontalAlign: "center",
		fontSize: 15,
		fontFamily: "Lucida Sans Unicode",
		cursor:"pointer",
		itemclick : function(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else {
			e.dataSeries.visible = true;
		}
		chart.render();
		}
	},
	data: []
		});

		
		var yVal = 0;	
		var updateInterval = 30000;
		var dataLength = 100; // number of dataPoints visible at any point
                var time = new Date();
		time.getHours();
		time.getMinutes();
		time.getSeconds();
		time.getMilliseconds();
		// starting at now
	function initialchartdisplay()
	{
	
	
    var sdata = '.$url2.';
    sdata.sort(function(x, y){
    return x.dataPoints.x - y.dataPoints.x;
})
        for (var i = 0; i < sdata.length ; i++) {
        
		for (var j = 0; j < sdata[i].dataPoints.length ; j++) {
		
			Array.prototype.push.call(markers[i],{ x:sdata[i].dataPoints[j].x, y: sdata[i].dataPoints[j].y });
			console.log(sdata[i].dataPoints[j].x);
		}
		
		sdata[i].dataPoints = markers[i];
		console.log(sdata[i]);
		chart.options.data[i] = sdata[i];
	if (markers[i].length >  dataLength )
    {
    	markers[i].shift();				
    }
console.log(markers[i]);
	}
	

	
   }

	
	
	
		initialchartdisplay();	
function displayChart(data) {


	for (var i = 0; i <= data.length - 1; i++) {
		
		var dataPointss = [];
		// add interval duration to time				
				time.setTime(time.getTime()+ updateInterval);
		for (var j = 0; j <= data[i].dataPoints.length - 1; j++) {
			Array.prototype.push.call(markers[i],{ x:data[i].dataPoints[j].x, y: data[i].dataPoints[j].y });
			
		}
		
		data[i].dataPoints = markers[i];
		
		chart.options.data[i] = data[i];
		chart.options.data[i].dataPoints.sort(compareDataPointYAscend);
	if (markers[i].length >  dataLength )
    {
    	markers[i].shift();				
    }
console.log(markers[i]);
	}
	

	chart.render();
}
function compareDataPointYAscend(dataPoint1, dataPoint2) {
		return dataPoint1.x - dataPoint2.x;
}		
		var updateChart = function () {
			
			
			
			var cdo = [];
			
		
		 $.ajax({
        type: "GET",
		url: "'.base_url($url).'",
		dataType: "json",
		success: function (json) { displayChart(json);}
		
		
		});
		var container = function(){ 
		var tmp = "";
		$.ajax({
        type: "GET",
		url: "'.base_url($url3).'",
		dataType: "json",
		success: function (json) { 
		tmp = json;
		contai = tmp/1000;
        var co = contai * 0.332297783;
		  
		var co1 = parseFloat((co).toFixed(3));
		document.getElementById("cpower").innerHTML ="<label>"+contai+" (kW)</label>";
			document.getElementById("cc02").innerHTML ="<label>"+co1+" (kg)</label>";
		}
		
		});
		return tmp;
		}();
		
		
        var refreshId = setInterval(function()
        {
           var container = function(){ 
		var tmp = "";
		$.ajax({
        type: "GET",
		url: "'.base_url($url3).'",
		dataType: "json",
		success: function (json) { 
		tmp = json;
		var contai = tmp/1000;
            var co = contai * 0.332297783;
		  co = co/1000;
		var co1 = parseFloat((co).toFixed(3));
		document.getElementById("cpower").innerHTML ="<label>"+contai+" (kW)</label>";
			document.getElementById("cc02").innerHTML ="<label>"+co1+" (kg)</label>";
		}
		
		});
		return tmp;
		}();
            
			console.log(container);
        }, 9000);
	
		
	

		};

		// generates first set of dataPoints
		updateChart(); 

		// update chart after specified time. 
		setInterval(function(){updateChart()}, updateInterval); 
}
function $_GET(param) {
        var vars = {};
        window.location.href.replace( location.hash, "" ).replace( 
                /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
                function( m, key, value ) { // callback
                        vars[key] = value !== undefined ? value : "";
                }
        );

        if ( param ) {
                return vars[param] ? vars[param] : 0;        
        }
        return vars;
}



	
	</script>'
		);
		$this->template->load('default','livedata',$data);
	}
	public function get_feeds()
	{
	
	$data_points = array();
	 $this->load->model('API_model');
	 $datas=$this->API_model->read();
	 
	 foreach($datas as $data){
	$tt=date('i',strtotime($data['timestamp']));
	$point = array('x'=>$tt, 'y' => $data['inputvalue']);
        
        array_push($data_points, $point);    
	}
	return json_encode($data_points, JSON_NUMERIC_CHECK);
	}

public function get_ajaxfeeds()
	{
	
	$data_points = array();
	 $this->load->model('API_model');
	 $datas=$this->API_model->read();
	 foreach($datas as $data){
	$tt=strtotime($data['timestamp']) * 1000;
	$point = array('x'=>$tt, 'y' => $data['inputvalue']);
        
        array_push($data_points, $point);    
	}
	echo json_encode($data_points, JSON_NUMERIC_CHECK);
	}
	public function get_timefeeds()
	{
		$this->load->model('API_model');
		//$datas=$this->API_model->read();
		//get current time
		
		//get last id
		$lid=$this->getLastInserted('input');
		$datas=$this->API_model->read($lid);
		$ctime =$data['timestamp'];
		return json_encode($ctime, JSON_NUMERIC_CHECK) ;
	}
	public function get_valuefeeds()
	{
		$this->load->model('API_model');
		$this->load->helper('date');
		$datas=$this->API_model->read();
		$feeds = array();
		$dt=array();
		foreach($datas as $ffd)
		{
			if(!empty($ffd['feed_input']))
			{
				array_push($feeds, $ffd['feed_input']);
			}
		}
		
		
		foreach($feeds as $feed)
		{
			$dat=$this->API_model->get_feeds($feed);
		
      $sv=array();
	 $sn = array();
	 $tn=array();
	 foreach($dat as $v)
	 {
         $p=$v['id'];
          $d = $v['inputvalue'];
          $t = $v['timestamp'];
          	
          array_push($sn,$d);
          array_push($sv,$p);
          array_push($tn,$t);
	 }
	
	 
	 $count = max($sv);
	 
	 
	 $idinput = $this->API_model->get_specificfeeds($feed,'id',$count);
	 
	 $jdata  = $idinput->inputvalue;
	 $xdata = time()*1000;
	 $time = strtotime($idinput->timestamp);
	 
	 $datestring = 'Y-m-d H:i';
          $ctime = time();

        
        $ntime= date($datestring, $time);
        
	$cntime= date($datestring, $ctime);
	if($ntime == $cntime){
	$cdata = array('x'=>$xdata,'y'=>$jdata);
		$datastring = array(
		'type' => 'spline',
		'name'=>$idinput->feed_name,
		'xValueType' => 'dateTime',
		
		);
		$datastring['dataPoints']=array();
	array_push($datastring['dataPoints'],$cdata);
		array_push($dt,$datastring);
	}
	else{
	$tno = 0;
	$xdata = time()*1000;
	$cdata =array('x'=>$xdata,'y'=>$tno);
	$datastring1 = array(
	'type' => 'spline',
	'name'=>$idinput->feed_name,
	'xValueType' => 'dateTime',
	
	);
	$datastring1['dataPoints']=array();
	array_push($datastring1['dataPoints'],$cdata);
	
		array_push($dt,$datastring1);
		}
		 $sv=array();
	 $sn = array();
	 $tn=array();
		}
	 
		$res= json_encode($dt, JSON_NUMERIC_CHECK);
	echo $res;
	

		
	}
	
	public function get_initialfeeds()
	{
		$this->load->model('API_model');
		$this->load->helper('date');
		$datas=$this->API_model->read();
		$feeds = array();
		$dt=array();
		
		foreach($datas as $ffd)
		{
			if(!empty($ffd['feed_input']))
			{
				array_push($feeds, $ffd['feed_input']);
			}
		}
		
		foreach($feeds as $feed)
		{
	$datastring = array(
		'type' => 'spline',
		'xValueType' => 'dateTime',
		);
		$datastring['dataPoints']=array();
	 $idinput = $this->API_model->get_specificfeedsdata($feed,array('timestamp >'=>'(now() - interval 1 minute)'));
	 
	foreach($idinput as $ids){
	
	$datastring ['name']=$ids->feed_name;
	$jdata  = $ids->inputvalue;
	$xdata = strtotime($ids->timestamp)*1000;
	$cdata = array('x'=>$xdata,'y'=>$jdata);
		
		array_push($datastring['dataPoints'],$cdata);
		
		
		 }
		
$fruit = array_pop($datastring);
		array_push($dt,$datastring);
		
		}
		
	 
		$res= json_encode($dt, JSON_NUMERIC_CHECK);
	return $res;
	

		
	}
	 function getLastInserted($db) {
$query =$this->db->query('SELECT MAX(id) AS `maxid` FROM `'.$db.'`');

 return $query->row_array(); 
       }
       public function get_currentvalues()
       {
         $query=$this->db->query("SELECT inputvalue FROM input WHERE DATE('timestamp') = CURDATE()");
         return $query->result_array();
       }
       
       function getp_data()
	{
	$this->load->model('API_model');
		$url= $_SESSION['set_grid'];
		$value = array();
		$today = date("Y-m-d");
		$year = date("Y");
		
		$month = date("m");
		$day = date("d");
		$griddata = $this->grid_model->get_specific('slug',$url);
		if(!empty($griddata->day_db))
			{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);
						
					foreach($plist as $list)
					{
						$data=$this->API_model->get_specificfeedsdata($list,array('year'=>$year,'month'=>$month,'day'=>$day,'datatype'=>1));
	                                   
	                                   
	                                   foreach ($data as $dts)
	                                   {
	                                   $stdt = $dts->inputvalue/$ints;
					array_push($value,$stdt);
	                                   }
					}
					
			}
			$value = array_sum($value);
			return $value;
	}
	function getLastInsert() {
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
		$lastmin = date("Y/m/d h:i:s", strtotime("-1 minutes"));
		for($i=0;$i<$cidcount;$i++){
             $query =$this->API_model->get_specificfeeds($v[$i],'id',$idst[$i]);
             if(!empty($query))
             {
			 $dbtime = strtotime($query->timestamp);
              if($curdate == date('Y-m-d H:i',$dbtime) && $query->datatype == 1  )
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
		
		}
		else
		{
			$qst= 0;
		}
		$rsqt =json_encode($qst);
		echo $rsqt ;
       }
}
