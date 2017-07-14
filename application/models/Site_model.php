<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Site_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_records() {
		//$this->db->from($this->data);
		$this->db->order_by("timestamp", "desc");
		$q = $this->db->get('message'); // 5 is per page
		return $q->result();		
	}
     
	 function get_reply() {
		//$this->db->from($this->data);
		$this->db->order_by("timestamp", "desc");
		$q = $this->db->get('reply'); 
		return $q->result();		
	}
	function add_record($data) {
		$this->db->insert('message', $data);
		return;
	}

	function add_reply($data) {
		$this->db->insert('reply', $data);
		return;
	}

	function delete_row($id) {
		$this->db->where('id',$id);
		$this->db->delete('message');
	}
	    public function get_specific($where = NULL,$value = NULL)
  {
  if(isset($where))
  {
    $this->db->where($where,$value);
  }
  
  $query = $this->db->get('message');

    return $query->row();
  
  }

}