<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Rest extends REST_Controller {

     public function __construct() {
           parent::__construct();
           $this->load->model('API_model');
           $this->load->helper('date');
    } 
     
     public function data_post(){ 
    $data = $this->input->input_stream('data');
     $date=  time();
	 $api = $this->ret_key();
	 $this->load->model('grid_model');
	 $tapi =$this->grid_model->get_specificapi('api_key',$api);
     $api_id = $tapi->id;
	 $sgrid = $this->grid_model->get_specific('api_id',$api_id);
	 $message = array();
	 if(!empty($data)){
	 
	 $datas =json_decode($data,true);
	 
	
	 foreach ($datas as $t=>$v)
{
   
   
   $ttv= count($v);
   $ttv= $ttv-2;
   $node = $v[1];
   
   for($i=0;$i<$ttv;$i++){
   $nv=$i+2;
       $message = array(
            'input_node' => $node,
			'key_num'=>$i,
            'inputvalue' =>$v[$nv],
			'slug'=>$sgrid->slug,
            'timestamp'  => date('Y-m-d H:i:s',$date)
           );
     $insd=$this->API_model->read();
	 $id = "";
	 $intime = array();
	 foreach($insd as $ins)
	 {
	 if($ins['input_node'] == $message['input_node'] && $ins['slug'] == $message['slug'] && $ins['key_num']==$message['key_num'])
	 {
			 $id=$ins['id'];
 
	 }
	 if(!empty($ins['feed_input']) && $ins['key_num']==$message['key_num'])
	 {
				 $vins = $message['inputvalue'];
				 $insvalue = $vins;
		 $plist = explode('| ',$ins['process_list']);
		 foreach($plist as $list)
		 {
			 
			 $rest = substr($list,1,1);
			 $snd = substr($list,2,1);
			 if($rest == '+')
			 {
				 if ($snd == '-')
				 {
					 $insvalue = $vins - substr($list,3);
				 }
				 else
				 {
					 $insvalue = $vins + substr($list,2);
				 }
			 }
			 elseif($rest == 'X' && $snd != '-')
			 {
				 $insvalue = $vins * substr($list,2);
			 }
			 
		 }
		 $indata = array
		 (
		   'inputvalue'=>$insvalue,
		   'datatype'=>$ins['datatype'],
		   'feed_name'=>$ins['name'],
		   'timestamp'=>date('Y-m-d H:i:s',$date),
		 );
		 $this->API_model->insert_feeds($ins['feed_input'],$indata);
            
     
	 }
	 array_push($intime,$ins['timestamp']);
	 }
	 if(!empty($id))
	 {
		  $this->API_model->update($message,$id);
		  $message = 200;
		  $id='0';
	 }
	 else{
    $this->API_model->insert($message);
    $message = 200;
    $id=0;
	 }
	}
	}
   
}
   
     $this->set_response($message, REST_Controller::HTTP_CREATED);
     $ssd =$this->API_model->read();
     $feedset = array();
     
     foreach ($ssd as $ss)
     {
     array_push($feedset,$ss['feed_input']);
     }
    
     $feds=$this->API_model->get_feeds($feedset[0]);
      $fedsid = array();
	  foreach($feds as $fed)
	  {
		  array_push($fedsid,$fed['id']);
	  }
	  
    $cdfeds=min($fedsid);
     $specfed = $this->API_model->get_specificfeeds($feedset[0],'id',$cdfeds);
     $time = strtotime($specfed->timestamp);
     $curtime = time();
     $diff = $curtime-$time;
     if($diff < 0)
{
	$diff = 0;
}
if($diff > 3600) {
	$this->data_management($sgrid->slug,$sgrid->gridname);
	 }
     }
     
     
     function data_management($grid_slug,$plant)
 {
	 $this->load->model('API_model');
	 
	 
	 $feeds = $this->relay_feeds($grid_slug);
	   
		$count = count($feeds);
		for($i=0;$i<$count;$i++)
		{
			$hour=date('m-d-Y H', strtotime('-1 hour'));
			$hourdata="";
		   $timelydata = array();
		     $idsf=array();

			$datas = $this->API_model->get_feeds($feeds[$i]);
		    
			foreach ($datas as $insdata)
			{ $dbtime = strtotime($insdata['timestamp']);
			
				$hourdata = $insdata['inputvalue'];
					$datatp = $insdata['datatype'];
					$feedname = $insdata['feed_name'];
				//get hourly data
				if($hour == date('m-d-Y H',$dbtime))
				{
					
					array_push($timelydata,$hourdata);
					array_push($idsf,$insdata['id']);
				
					
				}
			
			
					
				
				if(!empty($timelydata))
				{
					$timely= array_sum($timelydata);
					
				    $this->API_model->delete_feeds($feeds[$i],$idsf);
				  $this->import_feedsperhour($dbtime,$feedname,$datatp,$timely,$grid_slug);
				
				}

			}
			if(!empty($timelydata))
				{
				$timelytt= array_sum($timelydata);
			if($timelytt == 0)
			{
			    $message = 'The distribution line {'.$feeds[$i].' } is down at'.$hour.' for the mini-grid'.$plant;
			    $this->send_mail($grid_slug,$plant,$message);
			    $this->send_sms($grid_slug,$message);
			    
			}
				}
		}
		
 }
   function update_datamanagement($db,$data=array(),$check)
   {   
	   $this->load->model('API_model'); 
         
		  $this->API_model->update_datamanagement($db,$data,$check);
		 
	   
   }
   function insert_datamanagement($db,$data=array())
   {
	   $this->load->model('API_model');

		$this->API_model->insert_feeds($db,$data);
   }
    function relay_feeds($grid_slug)
   {
	   $this->load->model('API_model');
	   
	 $data=$this->API_model->read();
	 $griddata = $this->grid_model->get_specific('slug',$grid_slug);
	 $feeds = array();
	 foreach($data as $ds1)
		{
			if(!empty($ds1['feed_input']))
			{
				array_push($feeds,$ds1['feed_input']);
			}
		}
		return $feeds;
   }
   function import_feedsperhour($dbtime,$feedname,$datatp,$timely,$grid_slug)
   {
	   $this->load->model('API_model');
	   $griddata = $this->grid_model->get_specific('slug',$grid_slug);
	     
	   if(!empty($griddata->day_db))
	   {
	     	
						$smdb = $griddata->day_db;
						$plist = explode(',',$smdb);
						$lnd = 0;
						
					foreach($plist as $list)
						{
						$subst = substr($list,10);
							if ($subst == $feedname) {
								$snd = $list;
								$lnd = 1;
								
								
							}
							
							
						}	
                                                if ($lnd == 1){
						//for days
						$checkdy = array(
						'year'=>date('Y',$dbtime),
						'month'=>date('m',$dbtime),
						'day'=>date('d',$dbtime),
						'hours'=>date('H',$dbtime),
						'feed_name'=>$feedname,
						'datatype'=>$datatp,
						);
						
						$checkby = array(
						'year'=>date('Y',$dbtime),
						'month'=>date('m',$dbtime),
						'day'=>date('d',$dbtime),
						'hours'=>date('H',$dbtime),
						'feed_name'=>$feedname,
						'datatype'=>$datatp,
						);
						$gtwn = $this->API_model->getfspecificfeedsdata($snd,$checkby);
						if(!empty($gtwn))
						{
						$checkdy['inputvalue'] = $timely+$gtwn['inputvalue'];
						$this->update_datamanagement($snd,$checkdy,$checkby);
						}
						else
						{
						 $checkdy['inputvalue'] = $timely;
						 
						$this->insert_datamanagement($snd,$checkdy);
					}
					
					
					
						}
						else
					{
						
						$smdb = $grid_slug."_perday".$feedname;
						
						$this->API_model->create_daily_database($smdb);
						$id=$griddata->id;
						$datagrid= array(
						'day_db'=>$griddata->day_db.",".$smdb,
						);
						$this->API_model->update_grid($datagrid,$id);
						
						
						$checkdy = array(
						'year'=>date('Y',$dbtime),
						'month'=>date('m',$dbtime),
						'day'=>date('d',$dbtime),
						'hours'=>date('H',$dbtime),
						'feed_name'=>$feedname,
						'datatype'=>$datatp,
						'inputvalue'=>$timely
						);
						$this->insert_datamanagement($smdb,$checkdy);
						
					}
						
			}
					else
					{
						
						$smdb = $grid_slug."_perday".$feedname;
						
						$this->API_model->create_daily_database($smdb);
						$id=$griddata->id;
						$datagrid= array(
						'day_db'=>$griddata->day_db.",".$smdb,
						);
						$this->API_model->update_grid($datagrid,$id);
						
						
						$checkdy = array(
						'year'=>date('Y',$dbtime),
						'month'=>date('m',$dbtime),
						'day'=>date('d',$dbtime),
						'hours'=>date('H',$dbtime),
						'feed_name'=>$feedname,
						'datatype'=>$datatp,
						'inputvalue'=>$timely
						);
						$this->insert_datamanagement($smdb,$checkdy);
						
					}
					
					
   }
    
	 public function send_mail($slug,$plant,$message) { 
	 //Load email library 
         $this->load->library('email'); 
	 $this->load->model('API_model');
	 $adminuser = $this->ion_auth->user(1)->row();
	$grid=$this->API_model->get_specificfeeds('groups','name',$slug);
	
             $gusergroup =$this->API_model->getfspecificfeedsdata('users_groups',array('group_id'=>$grid->id));
             if(!empty($gusergroup))
             {
             
            foreach($gusergroup as $usergroup){
            $specuser = $this->ion_auth->user($usergroup['user_id'])->row();
         $from_email = $adminuser->email;
         $to_email = $specuser->email; 
   
         

   
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
      public function send_sms($slug,$message)
      {
      	$this->load->library('nexmo');
      	 $adminuser = $this->ion_auth->user(1)->row();
	$grid=$this->API_model->get_specificfeeds('groups','name',$slug);
	
             $gusergroup =$this->API_model->getfspecificfeedsdata('users_groups',array('group_id'=>$grid->id));
             if(!empty($gusergroup))
             {
             foreach($gusergroup as $usergroup){
               $specuser = $this->ion_auth->user($usergroup['user_id'])->row();
      	$from = $adminuser->phone;
      	$to = $specuser->phone;
      	$message = array(
      		'text'=>$message
      	);
      	$data = array(
   'smsnumber'=>$to_email,
   'slug'=>$slug,
   );
      	$response = $this->nexmo->send_message($from,$to,$message);
      	$data['smstext']= $response;
      	$this->API_model->insert_sms($data);
      }
      }
      return TRUE;
      }
	
    
}
?>