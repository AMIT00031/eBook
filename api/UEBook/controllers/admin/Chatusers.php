<?php

Class Chatusers extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/chatuser_model');
             $this->load->model('admin/user_model');
    }

    public function index(){
       $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

       // $list = $this->chatuser_model->get_all();
      $list =  $this->chatuser_model->getUserDetail();		//echo "<pre>";print_r($list);
        $data = array(
            'title' => ' Users',
            'list_heading' => ' Users',
            'users' => $list
        );
        $this->template->load('admin/base', 'admin/users/Chatusers', $data);
    }

}
