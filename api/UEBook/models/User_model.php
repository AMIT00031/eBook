<?php

class User_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "users";
    public $primary_key = "id";

    function checkAccountExist($email) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
		//$this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
   
    function checkAccountExistById($id) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$id);
		//$this->db->limit(1);
        $query = $this->db->get();
		echo $query->num_rows(); 
        $result = $query->row();
		//echo $this->db->last_query();
        print_r($result); die("yes");
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
   function isValidCode($code = '', $id = null) {

        if (!empty($code)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $this->db->where('activation_code', $code);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
	
    function isUserAlreadyActivated($id) {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                $active = $result->active;
                if ($active == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


   function getUserDetail($id) {
        if (!empty($id)) {
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
               return true;
            } else {
                return false;
            }
        }
    }
	function getRecord($tblname,$id,$selectF='',$whrCond='') { 
	    $selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($id)$this->db->where('id',$id);
		if($whrCond)$this->db->where($whrCond);
		//$this->db->where('status',1);
		//$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row();
		else:
			return false;
		endif;
	 }
    
    function getAllNotifications($user_id) {
        $data = array();
        $finalArray = array();
        $message = "";
        if (!empty($user_id)) {
            $this->db->select('n.notification_object_id,nb.entity_type,nb.entity_id,type.entity_type,type.entity_table,u.username,u.id as user_id,u.email');
            $this->db->from('notification n');
            $this->db->join('notification_object nb', 'nb.id=n.notification_object_id');
            $this->db->join('users u', 'n.notifier_id=u.id');
            $this->db->join('notification_entity_type type', 'type.id=nb.entity_type');
            $this->db->where('n.notifier_id', $user_id);
            $query = $this->db->get();
            $data = $query->result();
            if ($query->num_rows() > 0) {
                foreach ($data as $v) {
                    $entity = $v->entity_table;
                    $entity_id = $v->entity_id;
                    switch ($entity) {
                        case 'trips':
                            $query = $this->db->query("select id,title from trips where id = $entity_id");
                            $tripData = $query->row();
                            if (!empty($tripData)) {
                                $message = "You have received a new trip invitation named " . $tripData->title . "";
                            }
                            break;

                        default:
                            break;
                    }

                    $finalArray[] = array(
                        'notification_object_id' => !empty($v->notification_object_id) ? $v->notification_object_id : '',
                        'username' => !empty($v->username) ? $v->username : '',
                        'user_id' => !empty($v->user_id) ? $v->user_id : '',
                        'email' => !empty($v->email) ? $v->email : '',
                        'entity_type' => !empty($v->entity_type) ? $v->entity_type : '',
                        'trip_id' => !empty($tripData->id) ? $tripData->id : '',
                        'message' => $message,
                    );
                }
                return $finalArray;
            } else {
                return $finalArray;
            }
        }
    }
function getuserdetails_select($id) {
    
        $this->db->select('*');
        $this->db->from('users');
        
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    
    function getusercontactusdetails_select($id) {
        $this->db->select('*');
        $this->db->from('users');
         $this->db->where('id != ', $id);
        $query = $this->db->get();
        $result = $query->result();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    
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
echo $this->db->last_query();
}
 
}
