<?php

/* Partner
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Adminpartner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/adminpartner_model');

        /* $this->load->model('trip_model');
          $this->load->model('user_favourite_trip_model');
          $this->load->model('user_favourite_trip_model');
          $this->load->model('user_complaint_model');
          $this->load->model('user_suggestion_model'); */
    }

    public function index() {

        $list = $this->adminpartner_model->getAllPartners();
        $data = array(
            'title' => 'Partner users',
            'users' => $list,
        );
        $this->template->load('admin/base', 'admin/trip_users/partner_list', $data);
    }
    
    
    function drivers() {
        $list = $this->user_model->with_profile()->where('user_type', 'driver')->get_all();
//        dump($list);die;
        $data = array(
            'title' => 'Drivers',
            'users' => $list,
        );
        $this->template->load('admin/base', 'admin/trip_users/driver_list', $data);
    }
    
      function managers() {
        $list = $this->user_model->with_profile()->where('user_type', 'manager')->get_all();
        $data = array(
            'title' => 'Manager',
            'users' => $list,
        );
        $this->template->load('admin/base', 'admin/trip_users/manager_list', $data);
    }
    
    function partner_details($id = null,$slug = null){
      if(!empty($id)){
          $con1 = array('user_id'=> $id,'user_type'=>$slug);
          
          $count1 = array('user_id'=> $id,'user_type'=>'driver');
          $count2 = array('user_id'=> $id,'user_type'=>'manager');
          
          $driver_count = $this->user_model->where($count1)->count_rows();
          $manager_count = $this->user_model->where($count2)->count_rows();
          
           $vechiles = $this->user_model->adminpartner_model->vehicleList($id);
          
          if($slug == 'vehicle'){
              $results = $this->user_model->adminpartner_model->vehicleList($id);
          }else{
              $results = $this->user_model->with_profile()->where($con1)->get_all();
          }
          
          
          $data = array(
            'title' => 'Partners Details',
            'partner_id' => $id,
            'slug' => $slug,
            'total_driver' => $driver_count,
            'total_manager' => $manager_count,
            'total_vehicles' => count($vechiles),
            'results' => $results
        );
        $this->template->load('admin/base', 'admin/trip_users/partner_details', $data);
          
      }
    }

    function changePartStatus($id = '', $type = '') {
        $tbl_name = 'users';
        if ($type == 1):
            $params = array('partner_status' => 'approved');
            $this->adminpartner_model->updateRecord($tbl_name, $params, $id);
            echo $partner_status = 1;
            die;
        elseif ($type == 0):
            $params = array('partner_status' => 'pending');
            $this->adminpartner_model->updateRecord($tbl_name, $params, $id);
            echo $partner_status = 0;
            die;
        endif;
        //redirect(base_url().'helpcenter/managehelpcenter/');
    }

}
