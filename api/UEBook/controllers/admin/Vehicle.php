<?php

/* Vehicle
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Vehicle extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/vehicle_category_model');
        $this->load->model('admin/vehicle_model');
        $this->load->model('trip_assign_vehicles_model');
        $this->load->model('admin/vehicle_gallery_model');
        $this->load->helper('html');
    }

    public function index() {
        
    }

    public function category() {
        $list = $this->vehicle_category_model->get_all();

        $data = array(
            'title' => 'Vehicle Category',
            'list_heading' => 'Vehicle Category',
            'categories' => $list,
        );

        $this->template->load('admin/base', 'admin/vehicle/list', $data);
    }

    public function add_category() {
        $postData = $this->input->post();
        if (!empty($postData)) {
            try {
                $this->vehicle_category_model->insert($postData);
                setMessage('vehicle added successfully', 'success');
                redirect('admin/vehicle/category');
            } catch (Exception $exc) {
                setMessage($exc->getTraceAsString(), 'danger');
                redirect('admin/vehicle/category');
            }
        }

        $data = array(
            'title' => 'Add Vehicle Category',
            'list_heading' => 'Add Vehicle Category'
        );
        $this->template->load('admin/base', 'admin/vehicle/add_category', $data);
    }

    function edit_category($id = null) {
        if (!empty($id)) {
            $edit_data = $this->vehicle_category_model->get($id);
        }
        $post = $this->input->post();
        if (!empty($post)) {
            try {
                $ab = $this->vehicle_category_model->update($post, $id);
                if ($ab) {
                    setMessage('vehicle category updated successfully', 'success');
                    redirect('admin/vehicle/category', 'refresh');
                } else {
                    setMessage('Country Not Updated Successfully ! Something went wrong', 'warning');
                    redirect('admin/vehicle/category', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('Country not updated! Please Try again', 'warning');
                redirect('admin/vehicle/category', 'refresh');
            }
        }
        $data = array(
            'title' => 'Update Country',
            'list_heading' => 'Update Country',
            'edit_data' => $edit_data
        );

        $this->template->load('admin/base', 'admin/vehicle/edit_category', $data);
    }

    function vehicle_list() {
        $list = $this->vehicle_model->with_category()->with_gallery()->get_all();
        $data = array(
            'title' => 'Vehicles',
            'vehicles' => $list,
        );
        $this->template->load('admin/base', 'admin/vehicle/vehicle_list', $data);
    }

    function detail($id = null) {
        $result = $this->vehicle_model->with_category()->with_gallery()->get($id);
        $assigned_vehicles = $this->trip_assign_vehicles_model->with_assigned_trip()->with_assigned_by()->where('vehicle_id',$id)->get_all();
        $data = array(
            'title' => 'Vehicles Details',
            'detail' => $result,
            'assigned_trips' => $assigned_vehicles,
        );
        $this->template->load('admin/base', 'admin/vehicle/detail', $data);
    }

}
