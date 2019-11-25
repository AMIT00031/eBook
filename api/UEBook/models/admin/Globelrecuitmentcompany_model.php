<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Globelrecuitmentcompany_model extends MY_Model {

    function __construct() {
        parent::__construct();
      
    }

    public $table = "clasifiedcompany";
    public $primary_key = "clasifiedcompany_id";
 
 
  
  /***********************************************************************
	** Function name : updateRecord
	** Purpose  : This function used for delete Users data	
	************************************************************************/
	function updateRecord($tbl_name='', $params=array(),$id='')
	{ 		
		if($id){
			$this->db->where('clasifiedcompany_id',$id);
			$this->db->update($tbl_name, $params);
			return true;
		}else{
			return false;
		}
	}
	
	
	public	function getRecord($tblname,$id,$selectF='',$whrCond='') { 
	    
		$selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($id)$this->db->where('clasifiedcompany_id',$id);
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
	function deleteRecord($tbl_name='',$id='')
	{
		if($tbl_name!='' && $id!='') {
			$this->db->delete($tbl_name, array('clasifiedcompany_id' => $id));
			return true;
		}else{
			return false;
		}			
	}

}
