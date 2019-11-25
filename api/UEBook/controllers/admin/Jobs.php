<?php
/* Jobs
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/job_model');
        $this->load->model('admin/job_category_model');
    }

    public function index() {
         $list = $this->job_model->with_category()->get_all();
        $data = array(
            'title' => 'Jobs',
            'jobs' => $list,
        );
        $this->template->load('admin/base', 'admin/job/job_list', $data);
    }

    public function category() {
        $list = $this->job_category_model->get_all();

        $data = array(
            'title' => 'Job Category',
            'list_heading' => 'Job Category',
            'categories' => $list,
        );

        $this->template->load('admin/base', 'admin/job/cat_list', $data);
    }

    public function add_category() {
        $postData = $this->input->post();
        if (!empty($postData)) {
            try {
                $this->job_category_model->insert($postData);
                setMessage('category added successfully', 'success');
                redirect('admin/jobs/category');
            } catch (Exception $exc) {
                setMessage($exc->getTraceAsString(), 'danger');
                redirect('admin/jobs/category');
            }
        }
        
        $category = $this->job_category_model->as_dropdown('name')->get_all();

        $data = array(
            'title' => 'Add Job Category',
            'category' => $category,
            'list_heading' => 'Add Job Category'
        );
        $this->template->load('admin/base', 'admin/job/add_category', $data);
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
            'title' => 'Jobs',
            'vehicles' => $list,
        );
        $this->template->load('admin/base', 'admin/vehicle/vehicle_list', $data);
    }

    function detail($id = null) {
        $result = $this->vehicle_model->with_category()->with_gallery()->get($id);
        $assigned_vehicles = $this->trip_assign_vehicles_model->with_assigned_trip()->with_assigned_by()->where('vehicle_id',$id)->get_all();
        $data = array(
            'title' => 'Jobs Details',
            'detail' => $result,
            'assigned_trips' => $assigned_vehicles,
        );
        $this->template->load('admin/base', 'admin/vehicle/detail', $data);
    }

}
