<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Powerplants extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}
	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$this->load->model('API_model');
		$datas=$this->API_model->read();
		
		   $dtpoints = array();
		//validate form input
		$this->form_validation->set_rules('GridNameInput','Grid Name is Required', 'required');
		$this->form_validation->set_rules('GridSizeInput','Grid Size is Required', 'required');
		
		$gridname = $this->input->post('GridNameInput');
		$gridsize = $this->input->post('GridSizeInput');
		$gridslug = $this->trim_string($gridname);
		$datas = array(
		'slug'=>$gridslug,
		'sizegrid'=>$gridsize,
		'gridname'=>$gridname,
		'selectadmin'=>$user->username);
		if (!$this->form_validation->run() == FALSE)
		{
			$group = $this->ion_auth->create_group($gridslug,$gridname);
			$api = $this->put();
			$api_id=$this->getLastInserted();
			$datas['api_id']=$api_id;
           $message =$this->grid_model->create($datas);
           
				redirect($gridslug.'/settings');
		
	} 
	$gc=array();
	$gcd=array();
	$gnm=array();
       $ints = 1; 
	$posts =$this->grid_model->get_all();
	$datapoints= 0;
	If(!empty($posts))
	{
	foreach($posts as $post)
	{
	array_push($gc,$post->id);
	array_push($gnm,$post->gridname);
	array_push($gcd,$post->slug);
	}
	$vdata=array();
	
	foreach($gcd as $gdc)
	{
	$tmessage = 0;
	 $griddata = $this->grid_model->get_specific('slug',$gdc);
	 if( !empty($griddata->day_db))
					{
						
						$smdb = $griddata->day_db;
						if($griddata->intervalsdata != NULL)
						{
							$ints = $griddata->intervalsdata;
						}
						else
						{
							$ints = 1;
						}
						
						$plist = explode(',',$smdb);

		}
		else
		{
		$plist = '';
		}
	 
	 
	$cplist = 0;
	$inputtotal =array();
	 $inputdtotal =array();
	 $ttarray = array();
	 if(!empty($plist)){
        $cplist = count($plist);
        
	 $inter = array();
			foreach($plist as $list)
			{
			$inputv = array();
	$inputd = array();
				$snd = $list;
				
				
               $sort = array();
               
               
				$datas = $this->API_model->get_feeds($snd);
				foreach($datas as $data){
					if($data['datatype']== 0)
					{
					array_push($inputd,$data['inputvalue']);
					}
					else
					{
						array_push($inputv,$data['inputvalue']);
						$tt = $data['year']."-".$data['month']."-".$data['day'];
						array_push($ttarray,$tt);
						if($data['inputvalue']==0)
						{
						array_push($inter,$data['inputvalue']);
						
						}
					}
					
				}
				$tinput = array_sum($inputv);
				$dinput = array_sum($inputd);
				 array_push($inputtotal,$tinput);
				 array_push($inputdtotal,$dinput);
				
			}
			
	 }
	else
	{
	 $inputv = array();
	$inputd = array();
	$cplist = 0;
	array_push($ttarray,0);
	}
	
	if(!empty($inter))
	{
	$tmessage = count($inter);
	
	}
	else
	{
	$tmessage = 0;
	}
	$inter = array();
	$ntttime = strtotime($ttarray[0]);
	$cctime = time();
	$timedifft = $cctime - $ntttime;
	 $tTinputv = array(
	 'slug'=>$gdc,
	 'input'=>array_sum($inputtotal)/$ints,
	 'geninput'=>array_sum($inputdtotal)/$ints,
	 'connections'=>$cplist,
	 'inter'=>$tmessage
	 );
	 array_push($vdata,$tTinputv);
	  
	 $cplist = 0;
	 $inputtotal =array();
	 $inputdtotal =array();
	}

	$count = count($gc);

	foreach($posts as $post)
	{
	if($post->day_db != ""){
	$datapoints = '{        
				type: "spline",
				xValueType: "dateTime",
				lineThickness:1,
				showInLegend: true,           
				name: "'.$post->gridname.'", 
				dataPoints:'.$this->get_feeds($post->slug).',
			}';
	
	}
	else
	{
	$datapoints = '{        
				type: "spline",
				xValueType: "dateTime",
				lineThickness:1,
				showInLegend: true,           
				name: "'.$post->gridname.'", 
				dataPoints:[{x:date,y:0}],
			}';
	}
	array_push($dtpoints,$datapoints);
	}
	}
	$data =array(
		'title'=>'Start Page',
		'posts'=>$posts,
		'cumdata'=>$vdata,
		'js'=>'	<script type="text/javascript">
	window.onload = function () {
	var date = Math.floor(Date.now());
	
		var chart = new CanvasJS.Chart("chartContainer",
		{
			
                        animationEnabled: true,
			title:{
				text: "ENERGY PER GRID"
			},
						 axisX:{
  title:"Time",

		intervalType: "month",
 },
 axisY:{
  title:"POWER (kW)",
 
 },
			axisY2:{
				
				
				
								
			},
                        theme: "theme2",
                        toolTip:{
                                shared: true
                        },
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
				fontSize: 15,
				fontFamily: "Lucida Sans Unicode"

			},
			data: ['.$this->arraytostring ($dtpoints).'
			
			],
          legend: {
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
          }
        });

chart.render();
}
var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}

</script>',
 'datas'=>$datas
		);
	
		$this->template->load('default','powerplant',$data);
			

		
	}
	
	function arraytostring ($var=array())
	{
	$rest = "";
	foreach($var as $dtpont)
	{
	 $rest .= $dtpont.",";
	}
	return $rest;
	}
	public function deletegrid($slug)
	{
		$tid=$this->grid_model->get_specific('slug',$slug);
		$id=$tid->api_id;
		$this->grid_model->delete_api($id);
		$this->grid_model->delete($slug);
		$groups = $this->ion_auth->groups()->result();
		
		foreach($groups as $group)
		{
			if($slug == $group->name)
			{
				$this->ion_auth->delete_group($group->id);
			
			}
		
		}

		redirect('/');
	}
	function trim_string($str)
	{
		//get $str and trim it 
		$newstr = substr($str,0,3 );
		// now reduce the size of string to 3
		$finalstr = substr($newstr,0,3);
		 $chstr =$this->checkSlugsingrid($finalstr);
		
		//check value and ensure is not in db
		if($chstr == $finalstr)
		{
		  return $finalstr;
		
		}
		else 
		{
			$rdnstr = $this->randStrGen(3);;
			$nchst = $this->checkSlugsingrid($rdnstr);
			while($rdnstr != $nchst)
			{
				$rdnstr = $this->randStrGen(3);
			
			}
			return $rdnstr;
		}
		
		
	}
	
	function checkSlugsingrid($str)
	{
		$val ="";
		$slugs = array();
		//check db if value is in db..
		$dbinfo=$this->grid_model->get_all();
		if(!empty($dbinfo)){
		foreach ($dbinfo as $row)
		{
		$slugs[] =$row->slug;
		}
		}
		if(in_array($str,$slugs))
		{
			$val = 0;
		
		}
		else
		{
			$val = $str;
			
		}
		
	   return $val;
	}
	//generate string
	
	function randStrGen($len){
    $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz$?!-0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    return $result;
}
 public function get_feeds($gdc)
	{
	$plist=array();
	$gcd=array();
	$data_points = array();
	 $this->load->model('API_model');
	 
	
	 $griddata = $this->grid_model->get_specific('slug',$gdc);
	 if( !empty($griddata->day_db))
					{
						
						$smdb = $griddata->day_db;
						$ints = $griddata->intervalsdata;
						$plist = explode(',',$smdb);

		}
	 
	 if(!empty($plist)){
        $cplist = count($plist);
			foreach($plist as $list)
			{
				$snd = $list;
				
               $sort = array();
				$datas = $this->API_model->get_feeds($snd);
				foreach($datas as $data){
					$month=$data['month'];
					
			$year=$data['year'];
			$day=$data['day'];
			$hours=$data['hours'];
			$xtime = $year.'-'.$month.'-'.$day;
	$x = strtotime($xtime);
	$xt = $x*1000;
	$point = array( 'x'=>$xt,'y' => $data['inputvalue']/$ints);
        
        array_push($data_points, $point);    
	}
			}
			}
			else
			{
			$data_points=array();
			}
	 
	 $timestmp = array();
	 $powerstmp= array();
	 $data_set=array();
	foreach ($data_points as $key ) {
   array_push($timestmp,$key['x']);
   array_push($powerstmp,$key['y']);
}
array_multisort($timestmp, SORT_ASC, $powerstmp);
	 $sdttime =$this->get_keys_for_duplicate_values($timestmp,$clean = false);
	 $timestmp = array_unique($timestmp);
	 
	 foreach ($timestmp as $stmp)
	 {
	 
	 $pwr = array();
	
	 if(!empty($sdttime[$stmp]))
	 {
	 foreach($sdttime[$stmp] as $index)
	 {
	 array_push($pwr,$powerstmp[$index]);
	 
	 }
	 }
	 $pwrsum = array_sum($pwr);
	 $dataset = array('x'=>$stmp,'y'=>$pwrsum);
	 array_push($data_set,$dataset);
	 
	 
	 }
	 
	return json_encode($data_set, JSON_NUMERIC_CHECK);
	}
	public function get_coordinates()
	{
		
// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$posts =$this->grid_model->get_all();
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

		foreach($posts as $post)
	{
$node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$post->gridname);
  $newnode->setAttribute("lat", $post->latitude);
  $newnode->setAttribute("lng", $post->longitude);

		
	}
echo $dom->saveXML();
	}
	function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

 function put()
	{
		 $this->load->library('REST', array('server' => base_url(),
                        'api_key'         => '48sgoc0kog80wwco8wcsoc404scssks0oc44o0gk',
                        'api_name'        => 'emskey',
                        
                       ));   
					   
		$key=$this->rest->put('keys/index');
		return $this->rest->debug();
	}
	
	function getLastInserted() {
    $datas = $this->grid_model->get_allapi();
$sv =array();
$apv = array();
foreach($datas as $v)
{
	$id = $v->id;
	
	array_push($sv,$id);
}
$count = count($sv);
	 $count = $count-1;
return $sv[$count]; 
       }
       
       
       function get_keys_for_duplicate_values($my_arr, $clean = false) {
    if ($clean) {
        return array_unique($my_arr);
    }

    $dups = $new_arr = array();
    foreach ($my_arr as $key => $val) {
      if (!isset($new_arr[$val])) {
         $new_arr[$val] = $key;
      } else {
        if (isset($dups[$val])) {
           $dups[$val][] = $key;
        } else {
          // $dups[$val] = array($key);
           // Comment out the previous line, and uncomment the following line to
           // include the initial key in the dups array.
           $dups[$val] = array($new_arr[$val], $key);
        }
      }
    }
    return $dups;
}



}
