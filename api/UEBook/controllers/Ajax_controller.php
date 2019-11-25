<?php

/**
 * @package    CI
 * @subpackage Controller
 * @author     Jeevan<jeevan@seoessnece.com>
 * @description  Handle all type of ajax requerst with response.
 */
Class Ajax_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('trip_model');
        $this->load->model('user_model');
        $this->load->model('admin/vehicle_category_model');
        $this->load->model('admin/vehicle_model');
        $this->load->model('admin/event_category_model');
		$this->load->model('admin/inventory_model');
    }
    

    function updated_trip_status() {
        $responseArray = array();
        $status = $this->input->post('status');
        $trip_id = $this->input->post('trip_id');
        $trip_created_user_id = $this->input->post('trip_created_user_id');
        if ($trip_id != "") {
            try {
                $data = array('status' => $status);
                $condition = array('id' => $trip_id);
                $result = $this->trip_model->where('id', $trip_id)->update($data);
                
                //update trip current status
                switch ($status) {
                    case 'approved':
                        $current_staus = array('current_status' => 'waiting_to_reach_min_lot');
                        $result = $this->trip_model->where('id', $trip_id)->update($current_staus);
                        
                        //sent notification to trip created user
                        $tripData = $this->trip_model->where('id', $trip_id)->get();
                        
                        $trip_title = !empty($tripData->title) ? $tripData->title : '';
                        
                        $userData = $this->user_model->where('id', $trip_created_user_id)->get();
                        $to_id = !empty($userData->id) ? $userData->id : '';
                        
                        $device_id = !empty($userData->device_id) ? $userData->device_id : '';
                        $user_mobile_info = array('user_mobile_token' => $device_id);
                        
                        $message = $trip_title. ' has approved by admin.';
                        
                        $title = 'Trip Approved';
                        $payload = $this->Common_Model->create_payload_json($message,$title);
                        
                        $notification_type = 'trip_approved_by_admin';
                        $sent = $this->Common_Model->push_notification($user_mobile_info, $payload, $trip_id, 'admin', $to_id,$notification_type,$title);
                        if($sent){
                            $responseArray['response'] = 'true';
                            $responseArray['message'] = 'Trip is successfully Approved and sent notification to trip owener.';
                        }else{
                            $responseArray['response'] = 'true';
                            $responseArray['message'] = 'Trip is successfully Approved and notification not sent.';
                        }
                        
                        
                        break;
                    case 'pending':
                        $current_staus = array('current_status' => 'pending');
                        $result = $this->trip_model->where('id', $trip_id)->update($current_staus);
                        $responseArray['message'] = 'Trip status changed.';
                        break;
                    case 'reject':
                        $current_staus = array('current_status' => 'reject','status'=>'reject');
                        $result = $this->trip_model->where('id', $trip_id)->update($current_staus);
                        $responseArray['message'] = 'Trip is rejected.';
                        break;

                    default:
                        break;
                }
                
                
                if ($result) {
                    $responseArray['response'] = 'true';
                } else {
                    $responseArray['response'] = 'false';
                    $responseArray['message'] = 'Something Went Wrong! Please Try again';
                }
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);
        die;
    }
    
    function cancel_trip() {
        $responseArray = array();
        $status = $this->input->post('status');
        $trip_id = $this->input->post('trip_id');
        if ($trip_id != "") {
            try {
                if ($status) {
                    $current_staus = array('current_status' => 'cancelled','status'=>'pending');
                    $result = $this->trip_model->where('id', $trip_id)->update($current_staus);
                    $responseArray['response'] = 'true';
                    $responseArray['message'] = 'Trip cancelled.';
                }else{
                    $current_staus = array('current_status' => 'pending','status'=>'pending');
                    $result = $this->trip_model->where('id', $trip_id)->update($current_staus);
                    
                    $responseArray['response'] = 'true';
                    $responseArray['message'] = 'Trip status updated.';
                }

              
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);
        die;
    }
    
    function delete_trip() {
        $responseArray = array();
        $id = $this->input->post('id');

        if ($id != "") {
            try {
                $current_staus = array('is_deleted' => 1);
                $del = $this->trip_model->where('id', $id)->update($current_staus);
                if ($del) {
                    $responseArray['response'] = 'true';
                    $responseArray['message'] = 'Succesfully Deleted';
                } else {
                    $responseArray['response'] = 'false';
                    $responseArray['message'] = 'Something Went Wrong! Please Try again';
                }
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);
        die;
    }
    
     function driver_approved() {
        $responseArray = array();
        $id = $this->input->post('id');
        $driver_status = $this->input->post('driver_status');

        if ($id != "") {
            try {
                $current_staus = array('driver_status' => $driver_status);
                $res = $this->user_model->where('id', $id)->update($current_staus);
                if ($res) {
                    $responseArray['response'] = 'true';
                    $responseArray['message'] = 'Driver successfully approved';
                } else {
                    $responseArray['response'] = 'false';
                    $responseArray['message'] = 'Something Went Wrong! Please Try again';
                }
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);
        die;
    }
    
    function vehicle_approved(){
        $responseArray = array();
        $id = $this->input->post('id');
        $driver_status = $this->input->post('vehicle_status');

        if ($id != "") {
            try {
                $current_staus = array('approved' => $driver_status);
                $res = $this->vehicle_model->where('id', $id)->update($current_staus);
                if ($res) {
                    $responseArray['response'] = 'true';
                    $responseArray['message'] = 'Vehicle successfully approved';
                } else {
                    $responseArray['response'] = 'false';
                    $responseArray['message'] = 'Something Went Wrong! Please Try again';
                }
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);
        die; 
    }

    function deleteCommonAttribute() {
        $responseArray = array();
        $id = $this->input->post('id');
        $model = $this->input->post('deleteModel');
        $message = $this->input->post('successMsg');

        if ($id != "") {
            try {
                $del = $this->$model->delete($id);
                    if($del){
                        $responseArray['response'] = 'true';
                        $responseArray['message'] = 'Succesfully Deleted';
                    }else{
                        $responseArray['response'] = 'false';
                        $responseArray['message'] = 'Something Went Wrong! Please Try again';
                    }
            } catch (Exception $e) {
                $responseArray['response'] = 'false';
                $responseArray['message'] = 'Something Went Wrong! Please Try again';
            }
        }
        echo json_encode($responseArray);die;
    }

}
