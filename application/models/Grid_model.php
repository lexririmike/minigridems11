<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Grid_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
public function get_all()
{
  
  //$this->db->order_by('slug','ASC');
  $query = $this->db->get('grid');
  if($query->num_rows()>0)
  {
    return $query->result();
  }
  return FALSE;
}
	public function get_specific($where = NULL,$value = NULL)
  {
  if(isset($where))
  {
    $this->db->where($where,$value);
  }
  //$this->db->order_by('slug','ASC');
  $query = $this->db->get('grid');

    return $query->row();
  
  }
 
  public function create($data)
  {
  	
  	 
  return $this->db->insert('grid',$data);
  }
 
  public function update_data($slug,$data)
  {
  	$this->db->where('id', $slug);
  	 $this->db->update('grid',$data);
  }
 
  public function delete($id)
  {
  	$this->db->where('slug', $id);
return $this->db->delete('grid');
  } 
  // API DATABASE
  public function get_allapi()
{
  
  $query = $this->db->get('api_keys');
  if($query->num_rows()>0)
  {
    return $query->result();
  }
  return FALSE;
}
	public function get_specificapi($where = NULL,$value = NULL)
  {
  if(isset($where))
  {
    $this->db->where($where,$value);
  }
  //$this->db->order_by('slug','ASC');
  $query = $this->db->get('api_keys');

    return $query->row();
  
  }
  public function delete_api($id)
  {
  	$this->db->where('id', $id);
return $this->db->delete('api_keys');
  } 
  public function get_logs($db)
  {
	  $query = $this->db->get($db);
	      return $query->result();
  }
}
