<?php
/* Company
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Company_model extends MY_Model {

    function __construct() {
        parent::__construct();
           }
 public function company_insert($data) {
      
    $this->db->insert('company', $data);  
      
  }
  
   public function company_update($data) {
        $datan = array(
'cid' =>  $data['cid'],
'user_id' =>  $data['user_id'],
'name' =>   $data['name'],
'website' =>   $data['website'],
'location' =>  $data['location'],
'mobile' =>   $data['mobile'],
'email' =>   $data['email'],

);

$this->db->where('c_id', $data['cid']);

$this->db->update('company', $datan);
   // $this->db->insert('company', $data);  
      
  }
  
     public function company_select($id) {
        
         $query = 'select a.* from company as a where a.user_id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }  
   
   
}
