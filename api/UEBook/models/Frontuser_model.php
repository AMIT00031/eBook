<?php 
    
Class Frontuser_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "users";
    public $primary_key = "id";

    public function getUserDetail($id) {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
               return $result;
            } else {
                return false;
            }
        }else{
			return false;
		}
    }
    function updateRecord($tbl_name='', $params=array(),$id='')
    {       
        if($id){
            $this->db->where('id',$id);
            $this->db->update($tbl_name, $params);
            $this->db->last_query();
            return true;
        }else{
            return false;
        }
    }
}