<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Support_model extends MY_Model {

    function __construct() {
        parent::__construct();
      
    }

    public $table = "chat";
    public $primary_key = "ch_id";
 
 
     public function getmessage($data) {
        
        
              $result = $this->db->query('select * from chat where (fromid='.$data['user_id'].' || toid='.$data['user_id'].') and (toid='.$data['admin_id'].'  || toid='.$data['user_id'].') and status="1" order by created_at asc')->result();
              
        
          if ($result) {
               return $result;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
       public function deletemessage($data) {
       
        $datan = array( 
    'status'      =>0, 
   
);

$this->db->update('chat', $datan, array('toid' =>  $data['user_id']));
 $this->db->update('chat', $datan, array('fromid' =>  $data['user_id']));   
  //  $this->db->insert('jobapply', $data);  
      
  }
  
  
}
