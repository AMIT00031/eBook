<?php
Class Users extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/user_model');
    }

 public function index(){
 $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin){
            redirect(base_url('admin/auth/login'));
        }     $list = $this->user_model->get_all();	 
        $data = array(
            'title' => 'Admin Users',
            'list_heading' => 'Admin Users',
            'users' => $list
        );		//echo "<pre>";print_r($data);
        $this->template->load('admin/base', 'admin/users/users', $data);
    }
}
