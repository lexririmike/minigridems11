<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mroutes extends MY_Controller 
	{
public function __construct()
	{
		parent::__construct();
                $this->load->helper('date');

	}
	
	public function index($link=NULL)
	{
		if(isset($link))
		{
		if(!$this->session->userdata('set_grid')) {
                redirect('/');
            }
            else 
            {
            	$url = $_SESSION['set_grid'];
              	redirect($url.'/'.$link);
            }
       }
       else {
       	$this->session->unset_userdata('set_gridname');
       	$this->session->set_userdata('set_template','0');
       	redirect('/');
       }
	}
   public function export_pdf($report=array(),$slug,$date,$conns,$sdate,$numofconnections)
   {
   
   $time = now();
   $input = array();
   $dta = array();
   $datatpe = array();
   $dattpe = array();
    $gengraph="";
    $graph="";
   foreach ($report as $v) {
         foreach ($v as $k=>$vt) {
 
	   foreach ($vt as $data) {
	   if($data['datatype'] == 1){
	   $datatype = 1;
   array_push($datatpe,$datatype);
   }
   else{
   $datatype = 0;
  array_push($dattpe,$datatype);
   }
   } }}
   if(!empty($datatpe)){
   $datatype = $datatpe[0];
   $graph =$this->create_graph($report,$datatype);
   }
   elseif(!empty($dattpe))
   {
   $datatype = $dattpe[0];
    $gengraph =$this->create_graph($report,$datatype);
   }
   $input = $report;
$posts = $this->grid_model->get_specific('slug',$slug);
foreach($input as $v) 
{
						 foreach($v as $k=>$vt) 
			{
							foreach($vt as $vin) {
array_push($dta,$vin['value']);
							}							
							 
						 }
}
$dtasum = array_sum($dta);

   	// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
$pdfFilePath = FCPATH."downloads/reports/report".$time.".pdf";
$data =array( 
'title'=>'Report Data',
'posts'=>$posts,
'dates'=>$date,
'inp'=>$dtasum,
'duration'=>$sdate,
'inputdata'=>$input,
'connections'=>$conns,
'slug'=>$slug,
'graph'=>$graph,
'gengraph'=>$gengraph,
'numofconnections'=>$numofconnections,
); // pass data to the view
 
if (file_exists($pdfFilePath) == FALSE)
{
    ini_set('memory_limit','512M'); 
    ini_set('max_execution_time', 300);
    $html = $this->load->view('export',$data, true); // render the view into HTML
     
    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 
    $pdf->showImageErrors = true;
    $pdf->WriteHTML($html); // write the HTML into the PDF
    $pdf->Output($pdfFilePath, 'F'); // save to file because we can
}
 
redirect("/downloads/reports/report".$time.".pdf"); 
   }
   public function get_report($report=array())
	{
	$time = date('Ymd',now());
             header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"report".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
   	$this->load->helper('file');
		$handle = fopen('downloads/csv/csv_'.$time.'.csv', 'w');
		
    /*  Now use it to write file. write_file helper function will do it */
    foreach ($report as $data) {
		foreach($data as $key=>$values)
		{
			fputcsv($handle, array($key,'Power','Interruption Hours','Datatype(1 repesents Distribution, 0 represents Generation)'));
			foreach($values as $datass)
		{
               // output the column headings
              
			   fputcsv($handle, $datass);
            }
		}
	}
                fclose($handle);
    $this->load->helper('download');
    force_download('downloads/csv/csv_'.$time.'.csv', NULL);
    /*  Done    */
		
	}
	public function export()
	{
	$this->load->helper('form');
	$this->load->model('API_model');
	$select = $this->input->post('selector1');
	$type = $this->input->post('selector2');
     
	$conns = $this->input->post('connectionsnum');
	$sdate = $this->input->post('dtpmain');
	$url = $this->input->post('HiddenUrl');
	 $griddata = $this->grid_model->get_specific('slug',$url);
	
	$value = array();
	if(!empty($griddata->day_db))
			{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);
						$numofconnections = count($plist);
					foreach($plist as $list)
					{
						
	$dsta=$this->getdata($select,$list,$sdate,$ints);
	if($select == 1)
	{
		$periodduration = ' [Months]';
	}
	elseif ($select == 2)
	{
		$periodduration = ' [Days]';
	}
	else
	{
		$periodduration = ' [Hours]';
	}
	$feedname = substr($list,10).$periodduration;
	$feeds = array($feedname=>$dsta);
    array_push($value,$feeds);
					}
			}
			
	if($type == 'csv')
	{
	$this->get_report($value);
	
	}
	else
	{
	$this->export_pdf($value,$url,$select,$conns,$sdate,$numofconnections);
	}
	}
	function getdata($date,$db,$specdate,$ints)
	{
		
		$this->load->model('API_model');
		if($date == 1)
		{
			$months = array();
			$daths = array();
			$ydata=$this->API_model->get_specificfeedsdata($db,array('year'=>$specdate));
			
			foreach($ydata as $yrdata)
			{
				array_push($months,$yrdata->month);
				array_push($daths,$yrdata->datatype);
			}
			$month = array_unique($months);
			sort($month);
			$datstype = array_unique($daths);
			$endata = array();
			for($i=1;$i<$month[0];$i++){
			$monthName = date('F', mktime(0, 0, 0, $i, 10));
				$sndata = 0;
				$senddata = array(
				'time'=>$monthName,
				'value'=>$sndata,
				'loss'=>1,
				'datatype'=>$datstype[0]
				);
				array_push($endata,$senddata);
				
			}
			foreach($month as $mnth)
			{
			        $interupt=array();
				$mndata=array();
				$datatype = array();
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$specdate,'month'=>$mnth));
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
					$dtatype = $dt->datatype;
					array_push($mndata,$stdt);
					if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					array_push($datatype,$dtatype);
					}
				}
				$sndata = array_sum($mndata);
				$sndatatype = array_unique($datatype);
				
				$loss = count($interupt);
				$monthName = date('F', mktime(0, 0, 0, $mnth, 10));
				$senddata = array(
				'time'=>$monthName,
				'value'=>$sndata,
				'loss'=>$loss,
				'datatype'=>1
				);
				array_push($endata,$senddata);
				
			}
		}
		elseif($date == 2)
		{
			$dths = array();
			$daths = array();
			
			$plist = explode('-',$specdate);
			$mdata=$this->API_model->get_specificfeedsdata($db,array('month'=>$plist[0],'year'=>$plist[1]));
			
			foreach($mdata as $mrdata)
			{
				array_push($dths,$mrdata->day);
				array_push($daths,$mrdata->datatype);
			}
			$days = array_unique($dths);
			$datstype = array_unique($daths);
			
			$endata = array();
			for($i=1;$i<$days[0];$i++){
			$sndata = 0;
				$senddata = array(
				'time'=>$i,
				'value'=>$sndata,
				'loss'=>1,
				'datatype'=>$datstype[0]
				);
				array_push($endata,$senddata);
			
			}
			foreach($days as $dth)
			{
			$interupt=array();
				$mndata=array();
				$datatype = array();
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[1],'month'=>$plist[0],'day'=>$dth));
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
					$dtatype = $dt->datatype;
					array_push($mndata,$stdt);
					array_push($datatype,$dtatype);
					if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					
					}
				}
				$sndata = array_sum($mndata);
				$sndatatype = array_unique($datatype);
				$loss = count($interupt);
				$senddata = array(
				'time'=>$dth,
				'value'=>$sndata,
				'loss'=>$loss,
				'datatype'=>$sndatatype[0]
				);
				array_push($endata,$senddata);
				
			}
		}
		elseif($date == 3)
		{
			$dths = array();
			$daths = array();
			$plist = explode('-',$specdate);
			
			$mdata=$this->API_model->get_specificfeedsdata($db,array('day'=>$plist[0],'month'=>$plist[1],'year'=>$plist[2]));
			foreach($mdata as $mrdata)
			{
				array_push($dths,$mrdata->hours);
				array_push($daths,$mrdata->datatype);
			}
			$days = array_unique($dths);
			$datstype = array_unique($daths);
			$endata = array();
			if(!empty($days)){
			for($i=0;$i<$days[0];$i++){
			$sndata = 0;
				$senddata = array(
				'time'=>$i.":00",
				'value'=>$sndata,
				'loss'=>'1',
				'datatype'=>$datstype[0]
				);
				array_push($endata,$senddata);
			
			}}
			else
			{
			for($i=0;$i<24;$i++){
			$sndata = 0;
				$senddata = array(
				'time'=>$i.":00",
				'value'=>$sndata,
				'loss'=>'1',
				'datatype'=>$datstype[0]
				);
				array_push($endata,$senddata);
			
			}
			
			
			
			}
			foreach($days as $dth)
			{
				$mndata=array();
				$datatype = array();
				$interupt=array();
				$data=$this->API_model->get_specificfeedsdata($db,array('year'=>$plist[2],'month'=>$plist[1],'day'=>$plist[0],'hours'=>$dth));
				foreach ($data as $dt)
				{
					$stdt = $dt->inputvalue/$ints;
					$dtatype = $dt->datatype;
					array_push($mndata,$stdt);
					array_push($datatype,$dtatype);
						if($dt->inputvalue == 0)
					{
					array_push($interupt,$dt->inputvalue);
					
					}
				}
				$sndata = array_sum($mndata);
					$loss = count($interupt);
				$sndatatype = array_unique($datatype);
				$senddata = array(
				'time'=>$dth.":00",
				'value'=>$sndata,
				'loss'=>$loss,
				'datatype'=>$sndatatype[0]
				);
				
				array_push($endata,$senddata);
			}
		}
		
		return $endata;
	}
	
	function create_graph($gdata,$datatype)
	{
	 $this->load->library('JpGraph/Graph');
	 
	 require_once (APPPATH.'/libraries/JpGraph/jpgraph_line.php');
	
	  // Stores for graph data
        
        // Setup the graph
$graph = new Graph(750,520,'auto');
$graph->SetScale( 'textlin' );


$graph->img->SetAntiAliasing(false);
if($datatype == 1){
$graph->title->Set('Distributed Energy');
}
else
{
$graph->title->Set('Generated Energy');
}
$graph->SetBox(false);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->img->SetAntiAliasing();
$graph->xgrid->Show();
$graph->SetMargin(40,40,30,130);
 $xdata = array();
        $ydata = array();
foreach ($gdata as$v) {
         foreach ($v as$k=>$vt) {
         $xdata = array();
        $ydata = array();
       
	   foreach ($vt as $data) {
            // only plot when there is a kW value
              if(!empty($data['time'])){
              if($data['datatype'] == $datatype){
              
               array_push($xdata,$data['time']); // date
                array_push($ydata,$data['value']); // kw
                }
                else
        {
        
        array_push($xdata,0); // date
                array_push($ydata,0); // kw
        }
             }
        else
        {
        
        array_push($xdata,0); // date
                array_push($ydata,0); // kw
        }
        }
        $color = "#".dechex(rand(0x000000, 0xFFFFFF));
        
        // Create  line
$p1 = new LinePlot($ydata);

$graph->Add($p1);
$p1->SetColor($color);
$p1->SetLegend($k);
        }
        }
        
       
        $graph->xaxis->SetTickLabels($xdata);
        $graph->legend->SetFrameWeight(1);
   
$fileName = "uploads/graphs/".time().".png";
  $graph->Stroke($fileName);
// Output line
return $fileName;
	}
	function create_graphspecific($gdata,$datatype)
	{
	 $this->load->library('JpGraph/Graph');
	 
	 require_once (APPPATH.'/libraries/JpGraph/jpgraph_line.php');
	
	  // Stores for graph data
        
        // Setup the graph
$graph = new Graph(750,520,'auto');
$graph->SetScale( 'textlin' );


$graph->img->SetAntiAliasing(false);
if($datatype == 1){
$graph->title->Set('Distributed Energy');
}
else
{
$graph->title->Set('Generated Energy');
}
$graph->SetBox(false);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->img->SetAntiAliasing();
$graph->xgrid->Show();
$graph->SetMargin(40,40,30,130);
 $xdata = array();
        $ydata = array();
foreach ($gdata as$v) {
        
         $xdata = array();
        $ydata = array();
       
            // only plot when there is a kW value
              if(!empty($data['time'])){
              if($data['datatype'] == $datatype){
              
               array_push($xdata,$data['time']); // date
                array_push($ydata,$data['value']); // kw
                }
                else
        {
        
        array_push($xdata,0); // date
                array_push($ydata,0); // kw
        }
             }
        else
        {
        
        array_push($xdata,0); // date
                array_push($ydata,0); // kw
        }
        
        $color = "#".dechex(rand(0x000000, 0xFFFFFF));
        
        // Create  line
$p1 = new LinePlot($ydata);

$graph->Add($p1);
$p1->SetColor($color);
$p1->SetLegend($k);
        
        }
        
       
        $graph->xaxis->SetTickLabels($xdata);
        $graph->legend->SetFrameWeight(1);
   
$fileName = "uploads/graphs/min_".time().".png";
  $graph->Stroke($fileName);
// Output line
return $fileName;
	}
	
}