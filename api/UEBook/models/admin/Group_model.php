<?php
/* Company
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Group_model extends MY_Model {

    function __construct() {
        parent::__construct();
           }
   public $table = "groups_calling";
    public $primary_key = "id";
  
     public function selectname_select($name,$usid) {
        
         $query = 'select a.* from groups_calling as a where a.name="'.$name.'" and a.userid='.$usid.'  and a.status=1   ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return 1;
            } else {
                return 0;
            }
 
  }  
  
        public function selectuserlistgroup($usid) {
        
          $query = 'select a.* from groups_calling as a where (a.userid='.$usid.'  || FIND_IN_SET('.$usid.',a.groupuserid) )  and a.status=1 order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
          if ($result) {
               return $result;
          } else {
                return 0;
          }
 
        } 
  
       public function selectusergroup($usid) {
        
          $query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.status=1 order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
      }  
    
       public function selectgroupbyid($id) {
        
          $query = 'select a.* from groups_calling as a where a.id='.$id.' and a.status=1 order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
      } 

      public function selectusergroupdatatoall($usid,$grid) {
          $query = 'select a.* from groups_calling as a where (a.userid='.$usid.'  || FIND_IN_SET('.$usid.',a.groupuserid) )  and a.status=1  and a.id='.$grid.' order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
      }
      public function selectusergroupdata($usid,$grid) {
        
          $query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.status=1 and a.id='.$grid.'  order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
      }  
  
    public function selectgroupdata($usid,$grid) {
        
        $query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.status=1 and a.id='.$grid.' order by a.id desc';
        $query = $this->db->query($query);
        $result = $query->row_array();
        if ($result) {
           return $result;
        } else {
            return 0;
        }
 
    }
    public function updategroupdata($usid,$grid,$groupuserid) {
        
        $query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.status=1 and a.id='.$grid.' order by a.id desc';
        $query = $this->db->query($query);
        $result = $query->row_array();
        if ($result) {
           return $result;
        } else {
            return 0;
        }
 
    } 

    public function selectusermessagegroupdata($usid,$grid) {
        
   $query = 'select a.* from groups_calling as a where   (a.userid='.$usid.'  || FIND_IN_SET('.$usid.',a.groupuserid) )  and a.status=1 and a.id='.$grid.' order by a.id desc   ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
  }  
  
  
  
      public function selectusergroupid($usid,$gid) {
        
          $query = 'select a.* from groups_calling as a where a.userid='.$usid.' and a.id='.$gid.' and a.status=1 order by a.id desc   ';
          $query = $this->db->query($query);
          $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
  }  
  
  
  
        public function selectusersbygroup($usid) {
        
              $query = 'select a.id,a.username,a.profilephoto,a.device_uid,a.device_VOIPID from users as a where a.id IN ('.$usid.')'; 
              $query = $this->db->query($query);
              $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
        }
        public function selectusersbygroup_($usid,$usid_) {
              if (!empty($usid_)) {
                $query = 'select a.id,a.username,a.profilephoto,a.device_uid,a.device_VOIPID from users as a where a.id IN ('.$usid.') AND a.id NOT IN ('.$usid_.')  '; 
              }else{
                $query = 'select a.id,a.username,a.profilephoto,a.device_uid,a.device_VOIPID from users as a where a.id IN ('.$usid.') '; 
              }
              
              $query = $this->db->query($query);
              $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return 0;
            }
 
        }
  
  
    public function clasifiedcountry_select() {
        
         $query = 'select a.* from oilcountries as a where a.active=1  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  }  
  
    public function clasifiedcities_select($id) {
        
         $query = 'select a.* from oilcities as a where a.active=1 and a.country_code="'.$id.'"  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
   public function clasifiedcity_select($id) {
      $query = 'select a.* from oilcities as a where  a.id="'.$id.'"  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
  
  
    public function clasifiedcurrency_select($id) {
        
         $query = 'select a.* from oilcurrencies as a where a.code="'.$id.'"  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
     public function editclasfile_update($data) {
      
         $datan = array(
'filename' =>  $data['filename'],
'post_id' =>  $data['post_id'],
'active' =>  $data['active'],
'created_at' =>  $data['created_at'],
'updated_at' =>  $data['updated_at']
);


$this->db->insert('clasifiedimages',$datan);
  } 
public function clasifieddisplaywithuserid_select($id,$cid,$aid) {
        if($aid=='All') {
         $query = 'select a.* from classifieds as a where a.user_id="'.$id.'" and category_id="'.$cid.'" and a.deleted_at=0  '; }
         elseif($aid=='Private') {
         $query = 'select a.* from classifieds as a where a.user_id="'.$id.'" and category_id="'.$cid.'" and post_type_id="'.$aid.'" and a.deleted_at=0 '; }
         elseif($aid=='Professional') {
         $query = 'select a.* from classifieds as a where a.user_id="'.$id.'" and category_id="'.$cid.'"  and post_type_id="'.$aid.'" and a.deleted_at=0 '; }
         else{
              $query = 'select a.* from classifieds as a where a.user_id="'.$id.'"  and a.deleted_at=0  ';
         }
         
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
  public function clasifieddisplaywithcatid_select($id) {
        
         $query = 'select a.* from oilcategories as a where a.id="'.$id.'" and a.deleted_at=0  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  }
    public function clasifieddisplaywithcityid_select($id) {
        
         $query = 'select a.* from oilcities as a where a.id="'.$id.'"  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
      public function clasifieddisplaywithimagesid_select($id) {
        
         $query = 'select a.* from clasifiedimages as a where a.post_id="'.$id.'"  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
  public function clasifieddisplaywithaalluserid_select($id,$cid,$aid){
        
        
          if($aid=='All') {
         $query = 'select a.* from classifieds as a where a.user_id!="'.$id.'" and category_id="'.$cid.'"  and a.deleted_at=0 '; }
         elseif($aid=='Private') {
         $query = 'select a.* from classifieds as a where a.user_id!="'.$id.'" and category_id="'.$cid.'" and post_type_id="'.$aid.'" and a.deleted_at=0 '; }
         elseif($aid=='Professional') {
         $query = 'select a.* from classifieds as a where a.user_id!="'.$id.'" and category_id="'.$cid.'"  and post_type_id="'.$aid.'" and a.deleted_at=0 '; }
         else{
              $query = 'select a.* from classifieds as a where a.user_id!="'.$id.'"  and a.deleted_at=0   ';
         }
         
         
         
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
  public function clasifieddisplaywithaalljobid_select($id){
         $query = 'select a.* from classifieds as a where a.id="'.$id.'" and a.deleted_at=0 ';
       $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
   public function clasifieddelete_select($data){
             $datan = array(
'deleted_at' =>  1,
);

$this->db->where('id', $data['classifiedid']);

$this->db->update('classifieds', $datan);
         
  } 
  public function clasifiedmessage_add($data){

      
       $datan = array(
'useremail' =>  $data['useremail'],
'userid' =>  $data['userid'],
'jobidid' =>  $data['jobidid'],
'jobidtitle' =>  $data['jobidtitle'],
'contactuserid' =>  $data['contactuserid'],
'phoneno' =>  $data['phoneno'],
'message' =>  $data['message'],
'contactusername' =>  $data['contactusername'],
'contactuseremail' =>  $data['contactuseremail'],
'created_at' =>  $data['created_at'],
'updated_at' =>  $data['updated_at']
);


$this->db->insert('clasifiedmessage',$datan); 
$insert_id = $this->db->insert_id();

     
if ($insert_id) {
               return $insert_id;
            } else {
                return false;
            }

  }
    public function clasifiedimagejobid_select($id){
         $query = 'select a.* from clasifiedimages as a where a.post_id="'.$id.'"';
       $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
      public function deleteimagejobid_select($id){
       $this->db->where('id', $id);
     $this->db->delete('clasifiedimages'); 
   
  } 
      public function selectuserreadstatus($data){
            $datan = array(
'unreadmessage' => 1,

);  

$this->db->where('groupid', $data['groupid']);
$this->db->where('sendtoid', $data['userid']);

$this->db->update('groupsuserschat', $datan);


 
   
  } 

  
}
