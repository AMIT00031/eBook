<?php

class Userchat_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "userschat";
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
 
}
