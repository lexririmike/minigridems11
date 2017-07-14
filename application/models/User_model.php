<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{
     public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_user_profile($id)
	{
		$this->db->where('user_id',$id);
		 $query = $this->db->get('user_profile');

    return $query->row();
	}
	public function create_pic($imgdata) 
 {   
 $this->db->insert('user_profile',$imgdata); 
 $info = 'Uploaded';
 return $info;
 }
 
 	public function update_pic($imgdata) 
 {   

 $this->db->where('user_id',$imgdata['user_id']);
$this->db->update('user_profile',$imgdata); 
 $info = 'Updated';

 return $info;
 }
}