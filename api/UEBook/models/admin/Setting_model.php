<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Setting_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "setting";
    public $primary_key = "id";

}
