<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Globelrecuitmentjobs_model extends MY_Model {

    function __construct() {
        parent::__construct();
      
    }

    public $table = " clasifiedjobs";
    public $primary_key = "clasifiedjobs_id";
 
 public function companycat_select($pid) {
   
  $result = $this->db->query('select a.* from clasifiedjobs as a where
   FIND_IN_SET('.$pid.', clasifiedjobs_subcat) ')->result();  
     if ($result) {
            return $result;
        } else {
            $result;
        }
}
  
  
  
}
