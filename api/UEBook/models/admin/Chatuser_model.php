<?php
Class Chatuser_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    public $table = "user_login_table";
    public $primary_key = "id";
public function getUserDetail() {
  $result = $this->db->query('select a.*,(select count(*) from user_chats where (sender=a.id || receiver=a.id) and is_active=1 ) as chatmessage from user_login_table as a')->result(); 
     if ($result){
            return $result;
        }else{
            $result;
        }
}
  
             


    function new_customer() {
        $current_date = date('Y-m-d');
        $this->db->select('count(*) as numrows');
        $this->db->from('users');
        $this->db->where('DATE(created_at)', $current_date);

        $query = $this->db->get();
        $result = $query->row();
        
        if ($result) {
            return $result;
        } else {
            $result;
        }
    }

}
