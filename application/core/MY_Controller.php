<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
   protected $slgrid = array();
   
	
	
	public function __construct()
  		{
    parent::__construct();
	   $this->load->driver('session');
	   $this->load->database();
	   $this->load->library('session');
$this->lang->load('auth');
$grid_model = $this->load->model('grid_model');
		
    if (!$this->ion_auth->logged_in())
    {
      //redirect them to the login page

     redirect('auth/login');
    }
	
   $grids = $this->grid_model->get_all();
   if($grids !== FALSE)
   {
   	foreach($grids as $grid)
   	{
   	  $this->slgrid[$grid->slug] = $grid->id;
   	  
   	 //if($grid->status == '1') $defaultgrid = $grid->slug;
   	}
   	
   }
    $grid_slug = $this->uri->segment(1);
   	
   	if(isset($grid_slug)&& array_key_exists($grid_slug, $this->slgrid)) 
   	{
		$set_grid = $grid_slug;


		}
		else
    {
     //load only frontpage
    }
 $gridname = $this->grid_model->get_specific('slug',$grid_slug);
    if(isset($set_grid))
    {
      
      $_SESSION['set_grid'] = $set_grid;
      $_SESSION['set_gridname']=$gridname->gridname;
      $_SESSION['set_template'] = '1';
      
    }
    else {
    	 $_SESSION['set_template'] = '0';
    	
    	}
		
  }
  
 
   
  
	
}
