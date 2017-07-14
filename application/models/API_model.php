<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class API_model extends CI_Model{
    public function read($id=NULL){
        if($id===NULL){
           $replace = "" ;
        }
        else{
            $replace = "=$id";
        }
        $this->db->order_by('id','ASC');
        $this->db->where('id',$replace);
        $query = $this->db->get("input");
        return $query->result_array();
    }
	//read feeds

    public function insert($data){
        $this->db->insert('input', $data);
        return TRUE;
    }
    public function delete($id){
    	$this->db->where('id', $id);
        $this->db->delete('input');
        return TRUE;
        }
    public function update($data,$id){
       
       $this->db->where('id',$id);
       $this->db->update('input',$data);        
    }

	 public function update_grid($data=array(),$id){
       
       $this->db->where('id',$id);
       $this->db->update('grid',$data);        
    } 
    public function get_specific($where = NULL,$value = NULL)
  {
  if(isset($where))
  {
    $this->db->where($where,$value);
  }
  $this->db->order_by('id','ASC');
  $query = $this->db->get('input');

    return $query->row();
  
  }
  
  //Grid User Database Access
  function ins_griduser($data)
  {
	  $this->db->insert('grid_user', $data);
        return TRUE;
  }
  
  public function read_griduser($id=NULL){
        if($id===NULL){
           $replace = "" ;
        }
        else{
            $replace = "=$id";
        }
        $this->db->where('id',$replace);
        $query = $this->db->get("grid_user");
        return $query->result_array();
    }
	
	 public function delete_griduser($id){
	 	$this->db->where('id', $id);
        $this->db->delete('grid_user');
        return TRUE;
        }
		
	public function update_griduser($slug,$data)
  {
  	$this->db->where('id', $slug);
  	 $this->db->update('grid',$data);
  }
  
  public function get_api()
  {
	  $query = $this->db->get('api_keys');

    return $query->result();
  }
  //feeds database handling
  function create_feed($name,$id,$data)
	{
		$this->load->dbforge();
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
    'timestamp' => array('type' => 'timestamp'),
    'feed_name' => array('type' => 'varchar(200)'),
    'datatype' => array('type' => 'varchar(200)'),
    'inputvalue' => array('type' => 'Double','default'=>'0'),
        ));
		$this->dbforge->create_table($name, TRUE);
		$this->update($data,$id);
	}
	function insert_feeds($name,$data)
	{
		  $this->db->insert($name, $data);
        return TRUE;
	}
	
	function count_db($name)
	{
		$this->db->select('COUNT(*)');
		$query = $this->db->get($name);
		return $query->result();
	}
	   public function get_feeds($name)
    {
	$this->db->order_by('id','ASC');
$q = $this->db->get($name);

    return $q->result_array();
    
    }
    public function get_feedsins($name)
    {
	$this->db->where("timestamp >= DATE_SUB(NOW(),INTERVAL 1 HOUR)", NULL, FALSE);
$q = $this->db->get($name)->result_array();
    return $q;
    }
    
	 public function get_specificfeeds($name,$where = NULL,$value = NULL)
  {
  if(isset($where))
  {
    $this->db->where($where,$value);
  }
 $this->db->order_by('id','ASC');
  $query = $this->db->get($name);

    return $query->row();
  
  }
  // Data Management

	
	 function create_daily_database($name)
	{
		$this->load->dbforge();
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
    'datatype' => array('type' => 'tinyint(4)'),
    'feed_name' => array('type' => 'varchar(200)'),
    'year' => array('type' => 'smallint(6)'),
    'month' => array('type' => 'tinyint(4)'),
    'day' => array('type' => 'tinyint(4)'),
    'hours' => array('type' => 'tinyint(4)'),
    'inputvalue' => array('type' => 'float','DEFAULT'=>'0.00'),
        ));
		$this->dbforge->create_table($name, TRUE);
		
	}

	function update_datamanagement($db,$data,$feed)
	{
		$this->db->where($feed);
  	 $this->db->update($db,$data);
	}
	function delete_feeds($db,$id)
	{
	$this->db->where_in('id', $id);
        $this->db->delete($db); 
	}
	 function getfspecificfeedsdata($db,$wdq)
	{
	$this->db->where($wdq);
	$this->db->order_by('id','ASC');
	$query = $this->db->get($db);
	return $query->result_array();
	}
	   	 public function get_specificfeedsdata($name,$where = array())
  {
  
    $this->db->where($where);
  
  $this->db->order_by('id','ASC');
  $query = $this->db->get($name);

    return $query->result();
  
  }
  function insert_email($name,$data)
	{
		  $this->db->insert($name, $data);
        return TRUE;
	}
	 function insert_sms($name,$data)
	{
		  $this->db->insert($name, $data);
        return TRUE;
	}
  function getmaxid($name)
	{
		$this->db->select_max('id');
		$query = $this->db->get($name);
$row = $query->row();
if ($row) {
    $maxid = $row->id; 
}
else
{
	$maxid = 0;
}
return $maxid;
	}
}