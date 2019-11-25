<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Search_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->has_one['category'] = array('foreign_model' => 'job_category_model', 'foreign_table' => 'job_category', 'foreign_key' => 'id', 'local_key' => 'category_id');
    }

 
 function inventoryDetail($id,$jid,$loc) {
      
      $query='where a.status="1"';
      
        if (!empty($id)) {
             $query .=' and a.title like "%'.$id.'%"';
        }
         if (!empty($jid)) {
           $query .=' and a.price='.$jid.'';
        } 
         if (!empty($loc)) {
           $query .=' and b.name="'.$loc.'"';
        } 
            
   $query = 'select a.*
    from inventory as a join oilcities as b on a.city_id=b.id '.$query.' '; 
    $query = $this->db->query($query);
    $result = $query->result();
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        
    }
    
    
    function jobsearchDetail($lid,$tid,$pos) {
      
      $query='where a.status="1"';
      
        if (!empty($tid)) {
             $query .=' and a.job_title like "%'.$tid.'%"';
        }
         if (!empty($pos)) {
           $query .=' and a.role='.$pos.'';
        } 
         if (!empty($lid)) {
           $query .=' and a.location="'.$lid.'"';
        } 
            
   $query = 'select a.* from jobs as a  '.$query.' '; 
    $query = $this->db->query($query);
    $result = $query->result();
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        
    }
    
      function adsearchDetail($categories,$title,$location,$price) {
      
      $query='where b.active="1"';
      
        if (!empty($title)) {
             $query .=' and a.title like "%'.$title.'%"';
        }
         if (!empty($categories)) {
           $query .=' and a.category_id='.$categories.'';
        } 
          if (!empty($price)) {
           $query .=' and a.price='.$price.'';
        } 
         if (!empty($location)) {
           $query .=' and c.name like "%'.$location.'%"';
        } 
            
   $query = 'select a.*,b.name as catname,c.name as cityname from classifieds as a join oilcategories as b on a.category_id=b.id join oilcities as c on c.id=a.city_id '.$query.' '; 
    $query = $this->db->query($query);
    $result = $query->result();
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        
    }
    
    
}
