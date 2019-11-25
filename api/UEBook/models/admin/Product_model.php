<?php
Class Product_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    public $table = "tbl_books";
    public $primary_key = "id";
    public function check_admin_login_status() {
        $_id = $this->session->userdata('admin_id');
        if (!empty($_id)) {
            return true;
        } else {
            return false;
        }
    }
	
	public function getAllCategory($id=''){      
		//$query = "select a.*from inventory as a where a.id='".$id."' ";
		$query = "select * from category ";
		$query = $this->db->query($query);
		$result = $query->result();
		 if ($result) {
				return $result;
		} else {
			$result;
		}
	}
	
	public function getAllUserList(){      
		$query = "select id,user_name,status from user_login_table ";
		$query = $this->db->query($query);
		$result = $query->result();
		 if ($result) {
				return $result;
		}else{
			$result;
		}
	}
	
	public function getCategory($whrCond='',$whrCond2='',$whrCond3='',$whrCond4='',$whrCond4='',$whrCond5='')
	{   
	    /* if($whrCond){
			$query = "select a.*from inventory as a where a.id='".$id."' ";
		}else{
			$query = 'select * from inventory ';
		} */
		$this->db->select('*');
		$this->db->from('category');
		if($whrCond)$this->db->where($whrCond);
		
		if($whrCond2!=''){
			$stringCond2 	 = explode(" ",$whrCond2);
			$countStringCond2 = count($stringCond2);
			if($countStringCond2==1){				
				 $this->db->like('description', $stringCond2[0]);		  
			}else{
				for($i=0; $i<$countStringCond2; $i++){	 
					 if($i==0){ 
						 $this->db->where('description LIKE', "%$stringCond2[$i]%");									
					 } else{	
						 $this->db->or_where('description LIKE', "%$stringCond2[$i]%");					 
					 } 
				 }					
			}
		}
		if($whrCond3!=''){
			$stringCond3 	 	= explode(" ",$whrCond3);
			$countStringCond3   = count($stringCond3);
			if($countStringCond3==1){				
				 $this->db->like('model_no', $stringCond3[0]);		  
			}else{
				for($j=0; $i<$countStringCond3; $j++){	 
					 if($j==0){ 
						 $this->db->where('model_no LIKE', "%$stringCond3[$j]%");									
					 } else{	
						 $this->db->or_where('model_no LIKE', "%$stringCond3[$j]%");					 
					 } 
				 }					
			}
		}
		if($whrCond4!=''){
			$stringCond4 	  = explode(" ",$whrCond4);
			$countStringCond4 = count($stringCond4);
			if($countStringCond4==1){				
				 $this->db->like('part_no', $stringCond4[0]);		  
			}else{
				for($k=0; $i<$countStringCond4; $k++){	 
					 if($k==0){ 
						 $this->db->where('part_no LIKE', "%$stringCond4[$k]%");									
					 } else{	
						 $this->db->or_where('part_no LIKE', "%$stringCond4[$k]%");					 
					 } 
				 }					
			}
		}
		if($whrCond5!=''){
			$stringCond5 	 = explode(" ",$whrCond5);
			$countStringCond5 = count($stringCond5);
			if($countStringCond5==1){				
				 $this->db->like('seller_name', $stringCond5[0]);		  
			}else{
				for($i=0; $i<$countStringCond5; $i++){	 
					 if($i==0){ 
						 $this->db->where('seller_name LIKE', "%$stringCond5[$i]%");									
					 } else{	
						 $this->db->or_where('seller_name LIKE', "%$stringCond5[$i]%");					 
					 } 
				 }					
			}
		}
		
		
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
