<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends MY_Controller {


	public function index()
	{
		
		$this->errorlogs();
	}
	public function errorlogs()
	{
		$this->load->model('grid_model');
		$logs=$this->grid_model->get_logs('smslogs');
		$logs2=$this->grid_model->get_logs('emaillogs');
		$data =array(
		'title'=>'System Logs',
		'logs'=>$logs,
		'emlogs'=>$logs2,
		);
		$this->template->load('default','error_logs',$data);
	}
}