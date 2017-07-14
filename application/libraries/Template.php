<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template 
    {
        var $ci;
         
        function __construct() 
        {
            $this->ci =& get_instance();

        }
        
        function load($tpl_view, $body_view = null, $data = null)
        {
        	if ( ! is_null( $body_view ) )
        	{
        		if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) )
        		{
        			$body_view_path = $tpl_view.'/'.$body_view;
        		}
        		else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.php' ) )
        		{
        			$body_view_path = $tpl_view.'/'.$body_view.'.php';
        		}
        		else if ( file_exists( APPPATH.'views/'.$body_view ) )
        		{
        			$body_view_path = $body_view;
        		}
        		else if ( file_exists( APPPATH.'views/'.$body_view.'.php' ) )
        		{
        			$body_view_path = $body_view.'.php';
        		}
        		else
        		{
        			show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.php');
        		}
        		 
        		$body = $this->ci->load->view($body_view_path, $data, TRUE);
        		 
        		if ( is_null($data) )
        		{
        			$data = array('body' => $body,'user_profile'=>$this->site_data());
        		}
        		else if ( is_array($data) )
        		{
        			$data['body'] = $body;
					$data['user_profile'] = $this->site_data();
        		}
        		else if ( is_object($data) )
        		{
        			$data->body = $body;
					$data->user_profile = $this->site_data();
        		}
        	}
        	 
        	$this->ci->load->view('default/'.$tpl_view, $data);
        }
		    public function site_data()
    {
        // Common variables that are used site wide in views
		$this->ci->load->library('ion_auth');
		if ($this->ci->ion_auth->logged_in())
    {
		$id=$this->ci->ion_auth->get_user_id();
		$this->ci->load->model('User_model');
		$prof =$this->ci->User_model->get_user_profile($id);
		return $prof->url;
	}
	return false;
	}
    }
    