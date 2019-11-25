<?php

Class Settings extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/setting_model');
        $this->load->model('admin/user_model');
    }

    public function index() {
        $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }

        $list = $this->setting_model->get_all();
//        dump($list);die;
        $data = array(
            'title' => 'Setting',
            'settings' => $list
        );
        $this->template->load('admin/base', 'admin/setting/list', $data);
    }

    function update($id = null) {
        if (!empty($id)) {
            $edit_data = $this->setting_model->get($id);
        }
        $post = $this->input->post();
        if (!empty($post)) {
            try {
                $ab = $this->setting_model->update($post, $id);
                if ($ab) {
                    setMessage('vehicle category updated successfully', 'success');
                    redirect('admin/settings', 'refresh');
                } else {
                    setMessage('Country Not Updated Successfully ! Something went wrong', 'warning');
                    redirect('admin/settings', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('Country not updated! Please Try again', 'warning');
                redirect('admin/settings', 'refresh');
            }
        }

        $data = array(
            'title' => 'Update Setting',
            'list_heading' => 'Update Setting',
            'edit_data' => $edit_data
        );

        $this->template->load('admin/base', 'admin/setting/update_settings', $data);
    }

}
