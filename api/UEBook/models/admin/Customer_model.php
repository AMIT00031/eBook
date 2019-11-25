<?php
Class Customer_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $before_create = array('timestamps');
    public $table = "user_login";
    public $primary_key = "id";

    function timestamps($customer) {
        $customer['created_at'] = $customer['updated_at'] = date('Y-m-d H:i:s');
        return $customer;
    }

}
