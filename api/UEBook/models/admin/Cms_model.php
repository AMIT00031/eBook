<?php

Class Cms_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public $table = "cms";
    public $primary_key = "id";

}
