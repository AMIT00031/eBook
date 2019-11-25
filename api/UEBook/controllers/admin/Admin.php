<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
/**
 * Admin Page for this controller.
 * Since this controller is set as the Admin controller's related stuff.
 * So any other public methods not prefixed with an underscore will
 */
    function __construct() {
        parent::__construct();
        $this->load->model('User');
    }
    public function index(){
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard', 'refresh');
        }
        $data = array(
            'title' => 'Login',
        );
        $this->template->load('admin/login', 'login', $data);
    }

    public function login(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if(!empty($_POST)){
            if ($this->form_validation->run() == FALSE) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if (!empty($username && !empty($password))) {
                    $username = removeExtraspace($username);
                    $password = removeExtraspace($password);
                    $result = $this->User->login($username, $password);
                    if ($result) {
                        $sess_array = array();
                        foreach ($result as $row) {
                            $sess_array = array(
                                'id' => $row->id,
                                'username' => $row->username
                            );
                            $this->session->set_userdata('logged_in', $sess_array);
                        }
                        redirect('dashboard', 'refresh');
                    } else {
                        $sdata['message'] = 'Invalid username or password!';
                        $flashdata = array(
                            'flashdata' => $sdata['message'],
                            'message_type' => 'error'
                        );
                        $this->session->set_userdata($flashdata);
                        redirect(base_url(), 'refresh');
                    }
                }
            }
        }
    }

}
