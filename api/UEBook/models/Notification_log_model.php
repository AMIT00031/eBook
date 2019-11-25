<?php

/* Notification_log_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Notification_log_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->has_one['notifier'] = array('foreign_model' => 'user_model', 'foreign_table' => 'users', 'foreign_key' => 'id', 'local_key' => 'to_id');
        $this->has_one['notifier_trip'] = array('foreign_model' => 'trip_model', 'foreign_table' => 'trips', 'foreign_key' => 'id', 'local_key' => 'trip_id');
    }

    public $table = "notification_log";
    public $primary_key = "id";

}
