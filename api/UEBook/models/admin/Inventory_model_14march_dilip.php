<?php

Class Inventory_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "inventory";
    public $primary_key = "id";

    public function check_admin_login_status() {
        $_id = $this->session->userdata('admin_id');
        if (!empty($_id)) {
            return true;
        } else {
            return false;
        }
    }
	
	public function getAllInventroy($id='')
	{      
		//$query = "select a.*from inventory as a where a.id='".$id."' ";
		$query = "select * from inventory ";
		$query = $this->db->query($query);
		$result = $query->result();
		 if ($result) {
				return $result;
		} else {
			$result;
		}
	}
	
	public function getInventroy($whrCond='')
	{   
	    /* if($whrCond){
			$query = "select a.*from inventory as a where a.id='".$id."' ";
		}else{
			$query = 'select * from inventory ';
		} */
		$this->db->select('*');
		$this->db->from('inventory');
		if($whrCond)$this->db->where($whrCond);
		$query = $this->db->get();
		$result = $query->result();
		 if ($result) {
				return $result;
			} else {
				$result;
			}
	}
	
	
	
	/***********************************************************************
	** Function name : updateRecord
	** Purpose  : This function used for delete Users data	
	************************************************************************/
	function updateRecord($tbl_name='', $params=array(),$id='')
	{ 		
		if($id){
			$this->db->where('id',$id);
			$this->db->update($tbl_name, $params);
			return true;
		}else{
			return false;
		}
	}	
	/***********************************************************************
	** Function name : deleteRecord
	** Purpose  : This function used for delete Users data	
	************************************************************************/
	function deleteRecord($tbl_name='',$id='')
	{
		if($tbl_name!='' && $id!='') {
			$this->db->delete($tbl_name, array('id' => $id));
			return true;
		}else{
			return false;
		}			
	}
	function ajaxDeleteRecord($tbl_name='',$id='')
	{
		if($tbl_name!='' && $id!='') {
			$this->db->delete($tbl_name, array('id' => $id));
			$this->db->delete('inventory_images', array('inv_id' => $id));
			return true;
		}else{
			return false;
		}			
	}
	
	function getAllRecord($tblname,$selectF='',$whrCond='') { 
	    
		$selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($whrCond)$this->db->where($whrCond);	
		//$this->db->where('status',1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return false;
		endif;
		
	}
	function getRecord($tblname,$id,$selectF='',$whrCond='') { 
	    
		$selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($id)$this->db->where('id',$id);
		if($whrCond)$this->db->where($whrCond);
		//$this->db->where('status',1);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row();
		else:
			return false;
		endif;
		
	 }
	 
	
/* 
public function getUserDetail($id)
{
      $query = 'select a.*
    from users as a where a.id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
     if ($result) {
            return $result;
        } else {
            $result;
        }
} */
    
}
