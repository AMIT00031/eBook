<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lists extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/vehicle_category_model');
        $this->load->model('admin/vehicle_model');
    }

    function build() {

        $formType = $this->input->post('type');
        $section = $this->input->post('section');
        $data = array();

        $data = $this->getData($formType);

        $html = $this->loadView($formType, $data, $section);

        $array = array(
            'html' => $html,
            'total_vote' => 100
        );

        echo json_encode($array);
    }

    function loadView($formType, $data, $section = NULL) {
        $html = '';
        if (!empty($section)) {
            $html = $this->load->view('admin/vehicle/includes/' . $formType, $data, true);
        } else {
            $html = $this->load->view('admin/vehicle/includes/' . $formType, $data, true);
        }

        return $html;
    }

    function getData($formType) {
        $data = array();

        switch ($formType) {

            case "vehicle":
                $vehicle_list = array();
                $vehicle_list = $this->vehicle_model->with_category()->get_all();
                $data = array('VEHICLE' => $vehicle_list);
                break;
        }

        return $data;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */