<?php
/* State
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class City extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->lang->load('auth');
        $this->load->model('admin/country_model');
        $this->load->model('admin/state_model');
        $this->load->model('admin/city_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $list = $this->city_model->with_country()->with_state()->get_all();
//        dump($list);die;
        $data = array(
            'title' => 'City',
            'list_heading' => 'City',
            'cities' => $list,
        );

        $this->template->load('admin/base', 'admin/city/list', $data);
    }

    function add() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $data = $this->input->post();
        if (!empty($data)) {
            $categoryInfo = returnValidData('cities', $data);

            $name = !empty($data['name']) ? $data['name'] : '';
            $slug = url_title($name, 'dash', true);
            $categoryInfo['url'] = $slug;

            try {
                $this->city_model->insert($categoryInfo, FALSE);
                setMessage('City added Successfully', 'success');
                redirect('admin/city', 'refresh');
            } catch (Exception $ex) {
                $sdata['message'] = 'City not added! Please Try again';
                $flashdata = array(
                    'flashdata' => $sdata['message'],
                    'message_type' => 'error'
                );
                $this->session->set_userdata($flashdata);
                redirect('admin/city', 'refresh');
            }
        }

        $countries = $this->country_model->as_dropdown('country_name')->get_all();
        
        $data = array(
            'title' => 'City',
            'list_heading' => 'Add City',
            'countries' => $countries
        );
        $this->template->load('admin/base', 'admin/city/add', $data);
    }

    function edit($id = null) {

        if (!empty($id)) {
            $edit_data = $this->city_model->get($id);
//            dump($edit_data);die;
        }

        $data = $this->input->post();
        if (!empty($data)) {

            $category_data = returnValidData('cities', $data);

            $name = !empty($data['name']) ? $data['name'] : '';
            $slug = url_title($name, 'dash', true);
            $category_data['url'] = $slug;


            try {
                $ab = $this->city_model->update($category_data, $id);
                if ($ab) {
                    setMessage('City Updated Successfully', 'success');
                    redirect('admin/city', 'refresh');
                } else {
                    setMessage('City Not Updated Successfully ! Something went wrong', 'warning');
                    redirect('admin/city', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('City not updated! Please Try again', 'warning');
                redirect('admin/city', 'refresh');
            }
        }
        
        $countries = $this->country_model->as_dropdown('country_name')->get_all();
        $data = array(
            'title' => 'Update City',
            'list_heading' => 'Update City',
            'countries' => $countries,
            'edit_data' => $edit_data
        );

        $this->template->load('admin/base', 'admin/city/edit', $data);
    }

}





