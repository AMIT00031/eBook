<?php

Class Customers extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->lang->load('auth');
        $this->load->model('admin/Customer_model');
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $list = $this->Customer_model->get_all();

        $data = array(
            'title' => 'Registered User',
            'list_heading' => 'Registered User',
            'registered_user' => $list,
        );

        $this->template->load('admin/base', 'admin/users/reg_user_list', $data);
    }

    function contact_user() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $list = $this->user_contact_model->get_all();
        $data = array(
            'title' => 'Contacted User',
            'list_heading' => 'Contacted User',
            'contact_users' => $list
        );

        $this->template->load('admin/base', 'admin/users/contacts_user_list', $data);
    }

}
