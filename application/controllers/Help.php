<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {


	public function index()
	{
$data =array(
		'title'=>'Help'
		);
		$this->template->load('default','help',$data);
	}
	public function contactus()
	{
			//validate form input
		$this->form_validation->set_rules('EmailInput','Email is Required', 'required');
		$this->form_validation->set_rules('SubjectInput','Subject is Required', 'required');
		$this->form_validation->set_rules('MessageInput','Message is Required', 'required');
		if($this->form_validation->run() == TRUE)
		{
		  $from_email = $this->input->post('EmailInput');
         $to_email = 'amari@strathmore.edu'; 
   
         //Load email library 
         $this->load->library('email'); 

   
         $this->email->from($from_email, 'SERC EMS HELP'); 
         $this->email->to($to_email);
         $this->email->subject($this->input->post('SubjectInput')); 
         $this->email->message($this->input->post('MessageInput')); 
   
         //Send mail 
         if($this->email->send()) 
         $data['emailsent']= 'Email Sent successfully!!'; 
         else 
          $data['emailsent']="Error in sending Email."; 
		redirect('help');
		}
		else
		{
$data =array(
		'title'=>'Contact Us'
		);
		$this->template->load('default','contactus',$data);
	}
	}
	public function aboutus()
	{
$data =array(
		'title'=>'ABOUT US'
		);
		$this->template->load('default','aboutus',$data);
	}
}
