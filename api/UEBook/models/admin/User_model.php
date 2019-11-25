<?php
Class User_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public $table = "admin_login_table";
    public $primary_key = "id";
    public function check_admin_login_status() { 
       $_id = $this->session->userdata('admin_id'); 
        if (!empty($_id)){
            return true;
        }else{
            return false;
        }
    }
public function getUserclientDetail($id){          
$datan = array('messupdate'=>1, );

$this->db->update('user_chats', $datan, array('toid' =>  $id));
$this->db->update('user_chats', $datan, array('fromid' =>  $id)); 
 $query = 'select a.*
    from chat as a where (a.fromid='.$id.' || a.toid='.$id.') and status="1"  ';
    $query = $this->db->query($query);
    $result = $query->result();
     if ($result) {
            return $result;
        } else {
            $result;
        }
}

public function getUserDetail($id){
      $query = 'select a.*
    from user_login_table as a where a.id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
     if ($result) {
            return $result;
        } else {
            $result;
        }
} 
  function new_customer() {
       
        $this->db->select('count(*) as numrows');
        $this->db->from('user_login_table');
  

        $query = $this->db->get();
        $result = $query->row();
        if ($result) {
            return $result;
        } else {
            $result;
        }
    }

}
