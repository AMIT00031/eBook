<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Dashboard extends CI_Controller{	function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
    }
   public function index(){
        $checklogin = $this->user_model->check_admin_login_status();
        if(!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }
    $new_customer = $this->user_model->new_customer();    $data = array(
            'title' => 'Dashboard',
            'new_customer' => $new_customer, 
        );
        $this->template->load('admin/base', 'admin/landing_page', $data);
    }
}
