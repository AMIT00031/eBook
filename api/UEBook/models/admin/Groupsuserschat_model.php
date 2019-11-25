<?php

class Groupsuserschat_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "groupsuserschat";
    public $primary_key = "uschid";

    
     public function edituser_update($data) {
                     $datan = array(
'username' =>  $data['username'],
'email' =>  $data['email'],
'phone' =>  $data['phone'],
'user_type' =>  $data['user_type'],
'profilephoto' =>  $data['profilephoto'],
'resume' =>  $data['resume'],
);


$this->db->where('id', $data['user_id']);

$this->db->update('users', $datan);
}

 public function getmessagelist($data) {

        $result = $this->db->query('
        select a.chanelid,a.userid, a.sendtoid,u.profilephoto ,(select count(*) from userschat where chanelid=a.chanelid and sendtoid='.$data['userid'].' and unreadmessage=0 ) as unreadmess
        ,(select username from users where  id=a.sendtoid  ) as sendtoidname,(select username from users where  id=a.userid  ) as username
          ,(select profilephoto from users where  id=a.sendtoid  ) as sendtoidprofilephoto,(select profilephoto from users where  id=a.userid  ) as userprofilephoto
        
        from userschat a left JOIN users u on u.id = a.sendtoid where (a.userid = '.$data['userid'].' || a.sendtoid = '.$data['userid'].' )  group by  a.chanelid order by uschid desc
        
       ')->result();
              
        
          if ($result) {
               return $result;
            } else {
                return false;
            }
 } 
 
 
 public function getmessagealllist($data) {
      //  print_r($data); exit;
      $wheredata= 'where ((userid='.$data['userid'].' and sendtoid='.$data['sendtoid'].') || (sendtoid='.$data['userid'].'  and userid='.$data['sendtoid'].')) and status="1"';
           if($data['messagetype']=='text') {  $wheredata .=' and messagetype="text"'; }
           elseif($data['messagetype']=='video') {  $wheredata .=' and messagetype="video"'; }
           elseif($data['messagetype']=='image') {  $wheredata .=' and messagetype="image"'; }
            elseif($data['messagetype']=='voice') {  $wheredata .=' and messagetype="voice"'; }
            else {$wheredata .=' '; }
              $result = $this->db->query('select *,(select profilephoto from users where id=userschat.userid) as profilephoto from userschat '.$wheredata.' order by created_at asc')->result();
         
          if ($result) {
               return $result;
            } else {
                return false;
            }
 }  
     
     public function deleteUser_update($data) {
                     $datan = array(
'userdelete' =>  1,

);
$this->db->where('uschid',  $data['chatid']);
$this->db->update('userschat', $datan);
}


  public function deleteUserall_update($data) {
   
$datan = array(
'userdelete' =>  1,

);

$this->db->where('sendtoid',$data['sendid'],'userid',$data['userid'] );
$this->db->update('userschat', $datan);
}    


  public function Userallmessage_update($data) {
   
$datan = array(
'unreadmessage' =>  1,

);

$this->db->where('sendtoid',$data['userid'],'userid',$data['sendtoid'] );
$this->db->update('userschat', $datan);
}  



}
