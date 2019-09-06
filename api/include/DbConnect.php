<?php
  class DbConnect
  {
	const DB_SERVER = "localhost";
	const DB_USER = "dnddemo_ebooks";
	const DB_PASSWORD ="ebooks@321!";
	const DB = "dnddemo_ebooks";
	private $db = NULL;
	public function __construct(){
		//parent::__construct();				// Init parent contructor
		$this->dbConnect();					// Initiate Database connection
	}
	/*
	 *  Database connection 
	*/
	private function dbConnect(){
		$this->db = @mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
		if($this->db){
			mysql_select_db(self::DB,$this->db);
		}
	 }
  }
?>


