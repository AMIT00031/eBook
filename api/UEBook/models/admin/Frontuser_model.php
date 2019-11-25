<?php

Class Frontuser_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "user_login_table";
    public $primary_key = "id";
    
    function updateRecord($tbl_name='', $params=array(),$id=''){ 		
		if($id){
			$this->db->where('id',$id);
			$this->db->update($tbl_name, $params);
			$this->db->last_query();
			return true;
		}else{
			return false;
		}
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
	function deleteRecord($tbl_name='',$id=''){
		if($tbl_name!='' && $id!='') {
			$this->db->delete($tbl_name, array('id' => $id));
			return true;
		}else{
			return false;
		}			
	}		function get_all(){		$this->db->select('id,register_id,user_name,url,status,publisher_type');        $query = $this->db->get('user_login_table');        return $query->result_array();	}
}
