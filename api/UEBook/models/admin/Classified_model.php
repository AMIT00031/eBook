<?php
/* Company
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Classified_model extends MY_Model {

    function __construct() {
        parent::__construct();
           }
 
  
     public function clisifiedcat_select() {
        
         $query = 'select a.* from oilcategories as a where a.active=1  ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
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
   public function clasified_all_buy_catid_select($id){
        $query = 'select a.* from classifieds as a where a.category_id="'.$id.'" and a.deleted_at=0 ';
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
  
  
    public function clasifieddisplaywithaallenquiry_select($id){
         $query = 'select a.*,(select profilephoto from  users where id=a.contactuserid ) as senderprofilepick from clasifiedmessage as a  where a.userid="'.$id.'" ';
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
      public function editclasfied_update($data){
         
       $datan = array(
'country_code' => $data['country_code'],
'user_id' =>  $data['user_id'],
'category_id' =>  $data['category_id'],
'post_type_id' =>  $data['post_type_id'],
'title' =>  $data['title'],
'description' =>  $data['description'],
'tags' =>  $data['tags'],
'price' =>  $data['price'],
'negotiable' =>  $data['negotiable'],
'priceicon' =>  $data['priceicon'],
'city_id' =>  $data['city_id'],
'lon' =>  $data['lon'],
'lat' =>  $data['lat'],
'verified_email' =>  $data['verified_email'],
'verified_phone' =>  $data['verified_phone'],
'reviewed' =>  $data['reviewed'],
'featured' =>  $data['featured'],
'archived' =>  $data['archived'],
'partner' =>  $data['partner'],
'deleted_at' =>  $data['deleted_at'],

);  


$this->db->where('id', $data['adsid']);

$this->db->update('classifieds', $datan);


 
   
  } 

  
}
