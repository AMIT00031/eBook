<?php

/* Notifications
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author : Jeevan<jeevan@seoessenc.com>
 * @date : 19-july-2018
 * @objective : Get all information about an user 
 */
class Notifications extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('trip_model');
        $this->load->model('user_favourite_trip_model');
        $this->load->model('user_participate_model');
        $this->load->model('notification_log_model');
    }

    public function list_get() {
        $notifications = array();
        $total_record = 0;
        $id = $this->get('id');
        $id = (int) $id;
        if ($id <= 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'missing parmeter'
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        }
        
        try {
            $notifications = $this->notification_log_model->fields('id,message,type,title,sending_date,request_from,status')->with_notifier('fields:id,email,username,user_type')->with_notifier_trip('fields:id,title')->where('to_id', $id)->get_all();

            if (!empty($notifications)) {
                $this->set_response([
                    'status' => 'success',
                    'total_records' => count($notifications),
                    'result' => $notifications,
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }else{
                $this->set_response([
                    'status' => 'success',
                    'total_records' => $total_record,
                    'message' => 'No notification found',
                    'result' => $notifications,
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } catch (Exception $exc) {
            $this->set_response([
                'status' => FALSE,
                'message' => $exc->getMessage(),
                    ], REST_Controller::HTTP_EXPECTATION_FAILED);
        }
    }

}
