<?php
/* Job_category_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class Job_category_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->has_many['jobs'] = array('foreign_model' => 'job_model', 'foreign_table' => 'jobs', 'foreign_key' => 'category_id', 'local_key' => 'id');
    }

    public $table = "job_category";
    public $primary_key = "id";
}




