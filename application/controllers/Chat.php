<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {

       public function __construct()
	{
		
		parent::__construct();
        $site_model=$this->load->model('site_model');
	}
	
	public function index()
	{
		$data = array();
	    $usprof ='';
		$this->load->library('ion_auth');
		if ($this->ion_auth->logged_in())
    {
		$id=$this->ion_auth->get_user_id();
		$this->load->model('User_model');
		$prof =$this->User_model->get_user_profile($id);
		$usprof=$prof->url;
	}
	$data['user_profile']=$usprof;
		if($query = $this->site_model->get_records()) 
		{
			$data['records'] = $query;
		}
		if($q = $this->site_model->get_reply()) 
		{
			$data['replys'] = $q;
		}
		$data['title'] = 'MESSAGE BOARD';
		$this->template->load('default','chat',$data);
	}
	
	
	public function create() {
		$userinfo =$this->ion_auth->user()->row();
		$user_id=$userinfo->id;
		$url=$this->input->post('HiddenUrl');
		$data = array(
			'title' => $this->input->post('title'),
			'message' => $this->input->post('content'),
			'user_id'=>$user_id,
			'user_group'=>$url
		);

		$this->site_model->add_record($data);
		redirect($url.'/chat');
	}
	public function delete($id)
	{
		$dat = $this->site_model->get_specific('id',$id);
		$this->site_model->delete_row($id);
		redirect($dat->user_group.'/chat');
	}
	
	public function reply() {
		$url=$this->input->post('HiddenUrl');
		$id=$this->input->post('HiddenId');
		$data = array(
			'reply' => $this->input->post('content'),
			'message_id'=>$id
		);

		$this->site_model->add_reply($data);
		redirect($url.'/chat');
	}
	
}