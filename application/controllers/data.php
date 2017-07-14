<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index($slug=Null)
	{
		if($slug=Null)
		{
			return ="error";
		}
		
	}
}



?>