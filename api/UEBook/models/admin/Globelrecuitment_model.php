<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Globelrecuitment_model extends MY_Model {

    function __construct() {
        parent::__construct();
      
    }

    public $table = "clasifiedregion";
    public $primary_key = "clasifiedregion_id";
 
     public function getmessage($data) {
        
        
              $result = $this->db->query('select * from chat where (fromid='.$data['user_id'].' || toid='.$data['user_id'].') and (toid='.$data['admin_id'].'  || toid='.$data['user_id'].') and status="1" order by created_at asc')->result();
              
        
          if ($result) {
               return $result;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
  /***********************************************************************
	** Function name : updateRecord
	** Purpose  : This function used for delete Users data	
	************************************************************************/

       public function deletemessage($data) {
       
        $datan = array( 
    'status'      =>0, 
   
);

$this->db->update('chat', $datan, array('toid' =>  $data['user_id']));
 $this->db->update('chat', $datan, array('fromid' =>  $data['user_id']));   
  //  $this->db->insert('jobapply', $data);  
      
  }
  
 public	function update($tbl_name='', $params=array(),$id='')
	{ 		
		if($id){
			$this->db->where('id',$id);
			$this->db->update($tbl_name, $params);
			return true;
		}else{
			return false;
		}
	}
	
}
