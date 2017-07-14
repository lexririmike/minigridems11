<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {
    
	 function __construct()
	{
		parent::__construct();
		$this->load->model('grid_model');
		$this->load->library('form_validation');
        $this->load->helper('form');
		$this->load->library('csvimport');
	}

	public function index()
	{
		$slug = $this->input->post('HiddenUrl');
		$id = $this->input->post('HiddenId');
		$this->form_validation->set_rules('selector1', 'Select Administrator', 'required');
		$this->form_validation->set_rules('selectinterval', 'Select Interval', 'required');
		$this->form_validation->set_rules('GridNameInput', 'Grid Name', 'required');
		$this->form_validation->set_rules('GridSizeInput', 'Grid SIze', 'required');
		
		if($this->form_validation->run() == TRUE)
		{
			$data=array(
			'selectadmin'=> $this->input->post('selector1'),
			'gridname'=>$this->input->post('GridNameInput'),
			'sizegrid'=>$this->input->post('GridSizeInput'),
			'commissioningdate'=>$this->input->post('GridDateComInput'),
			'manufacturer'=>$this->input->post('GridManufactureInput'),
			'modeltype'=>$this->input->post('GridModelTypeInput'),
			'latitude'=>$this->input->post('displayLat'),
			'longitude'=>$this->input->post('displayLong'),
			'intervalsdata'=>$this->input->post('selectinterval')
			);
		$this->grid_model->update_data($id,$data);
		redirect($slug.'/settings');
		
		
		}
		else 
		{
		 $this->load->model('API_model');
              $input = $this->API_model->read();
  	$post= $this->grid_model->get_specific('slug',$_SESSION['set_grid']);
    $api = $this->grid_model->get_specificapi('id',$post->api_id);
	$apiread = $this->API_model->read_griduser();
	$url=$_SESSION['set_grid'].'/settings/get_input';
	$js = '	';
$data =array(
		'title'=>'Settings',
		'posts'=>$post,
		'api'=>$api,
		'apiread'=>$apiread,
		'users'=>$this->ion_auth->users()->result(),
		'inputs'=>$input,
		'js'=>$js
		);
		$this->template->load('default','settings',$data);
	}
	}

	public function add_user()
	{
		$slug = $this->input->post('HiddenUrl');
		$this->load->model('API_model');
		
		$this->form_validation->set_rules('GridpowerInput', 'Enter Power Allocated', 'required');
		$this->form_validation->set_rules('GriddateInput', 'Enter Date Selected', 'required');
		$this->form_validation->set_rules('GridconsumInput', 'Enter Power Consumption', 'required');
		
		if($this->form_validation->run() == TRUE)
		{
			$date = $this->input->post('GriddateInput').'-01'; 
			$data = array(
			  'ref_num'=>$this->input->post('GridrefInput'),
			  'power'=>$this->input->post('GridpowerInput'),
			  'date_connected'=>$date,
			  'consumption'=>$this->input->post('GridconsumInput'),
			  'slug'=>$this->input->post('HiddenUrl')
			);
			$this->API_model->ins_griduser($data);
			redirect($slug.'/settings');
		}
		
	}
	function importcsv($name,$data) 
	{ 
	$this->load->model('API_model');
	    $csvdata=array();
		$error = ''; 
		$config['upload_path'] = 'uploads/csv';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '204800';
		$this->load->library('upload');
		$this->upload->initialize($config);
		 if (!$this->upload->do_upload("GridfileInput")) 
		 {
            $error = $this->upload->display_errors();
			return $error;
		 }
		 else 
		 {
             $file_data = $this->upload->data();
              $file_path =  'uploads/csv/'.$file_data['file_name'];
 
            if ($this->csvimport->get_array($file_path)) 
			{
               $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
					$date = $row['Timestamp'];
					$date = str_replace("/", "-",$date);
                    $insert_data = array(
                        'timestamp'=>date('Y-m-d H:i:s',strtotime($date)),
                        'inputvalue'=>$row['Values'],
						'feed_name'=>$data['feed_name'],
						'datatype'=>$data['datatype']
                    );
					
							$this->API_model->insert_feeds($name,$insert_data);
				}
				
			}
			else
			{
				$error="Error occured";
				return $error;
			}
		 }
		 
		
	}
	function get_input()
	{
		$this->load->helper('date');
		$time = now();
		$ttal= array();
		$this->load->model('API_model');
		$datas=$this->API_model->read();
		foreach ($datas as $acdata)
		{
			if($acdata['slug'] == $_SESSION['set_grid'] )
			{
				$tdiff = $time-strtotime($acdata['timestamp']);
				array_push($ttal,array(
				     'id'=>$acdata['id'],
				    'nodeid'=>$acdata['input_node'],
					'name'=>$acdata['name'],
					'key'=>$acdata['key_num'],
					'description'=>$acdata['description'],
					'value'=>$acdata['inputvalue'],
					'stime'=>$tdiff
				));
			}
		}
		echo json_encode($ttal);
	}
	function del_input($id,$slug)
	{
		$this->load->model('API_model');
		$this->API_model->delete($id);
		redirect($slug.'/settings');
	}
	function feeds()
	{
		//validate form input
	
		$this->form_validation->set_rules('dataType','Data Type is Required', 'required');
		$this->form_validation->set_rules('feedtypeName',' Feed Name is Required', 'required');
		if($this->form_validation->run() == TRUE)
		{
			$id = $this->input->post('inputid');
			$node= $this->input->post('nodeid');
			$slug=$this->input->post('slug');
			$tid = $node + $id;
			$name= $slug.'_feed_'.$tid;
			
			$datas = array
			(
			'feed_input'=>$name,
			'name'=>$this->input->post('feedtypeName'),
			'datatype'=>$this->input->post('dataType'),
			'process_list'=>$this->input->post('hiddenfeed'),
			);
			$this->create_feed($name,$id,$datas);

				

							$csvdat= array
							(
							  'feed_name'=>$this->input->post('feedtypeName'),
							  'datatype'=>$this->input->post('dataType'),
							);
							$csv = $this->importcsv($name,$csvdat);

			
		}
		redirect($slug.'/settings');
		
	}
	function create_feed($name,$id,$process)
	{
		$this->load->model('API_model');
		$this->API_model->create_feed($name,$id,$process);
		
	}
}
