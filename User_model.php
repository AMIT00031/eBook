<?php

class User_model extends MY_Model {

    function __construct() {
        parent::__construct();
		define('API_ACCESS_KEY','AAAA2RSvweQ:APA91bEnwlkf53HXU4559AUAIgsoEgnPLwDT3tw1cpju0WIPPdguWgmYEHHWGONZ4aNaxn8jAw0s5lbNbbJqFd1w-aEnHJ-5G-36bw3m5lj3u53e15RoERzNBoUX8O8cam40Qmy77d8G'); 
		
    }

    public $table = "user_login_table";
    public $primary_key = "id";
	
	/* $query = $this->db->query($mysql);
	if($query->num_rows()>0){
		$row = $query->row();
	} */
	
	
    public function createUser($full_name, $pass, $email, $phone_no, $file_url, $device_token, $device_type, $random_number, $country="",$gender,$publisher_type,$user_name,$about_me,$face_cordX='',$face_cordY='',$face_width='',$login_type='' ){
        //if (!$this->isUserExists($email,$user_name)){
        if (!$this->isUserExists($email)){
            //$password = base64_encode($pass);
            $password = md5($pass);
            date_default_timezone_set('America/Los_Angeles');
            //echo "<pre>";print_r($_POST);exit();
           $mysql = "INSERT INTO user_login_table set full_name       ='".$full_name."',
                                                        email          ='".$email."',
                                                        phone_no       ='".$phone_no."',
                                                        url            ='".$file_url."',
                                                        device_token   ='".$device_token."',
                                                        device_type    ='".$device_type."',
                                                        register_id    ='".$random_number."',
                                                        country        ='".$country."',
                                                        date_edited    ='".time()."',
                                                        password       ='".$password."',
                                                        login_type      ='".$login_type."',
                                                        gender         ='".$gender."',
                                                        publisher_type ='".$publisher_type."',
                                                        user_name      ='".$user_name."',
                                                        face_cordX       ='".$face_cordX."',
                                                        face_cordY       ='".$face_cordY."',
                                                        face_width       ='".$face_width."'";
                        //$result = mysql_query($mysql);
						$result = $this->db->query($mysql);
						//print_r($result);  
                       
						//$user_login_id = mysql_insert_id();
						$user_login_id = $this->db->insert_id();
                        $return_data = $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name;
                        if(is_numeric($user_login_id) && $user_login_id!=''){
                            $data = 'Now you can login with this email and password';
                            $to = $email;
                            $subject = 'Your registration is completed';
                            /* Let's Prepare The Message For The E-mail */
                            $message = 'Hello '.$username.'
                            Your email and password is following:
                            Username : '.$email.'
                            password: '.$pass.'';
                            /* Send The Message Using mail() Function */
                            if(mail($to, $subject, $message)){
                                return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'0';
                            }
                        }else{
                            return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'1';
                        }
                    }else{
                        return $user_login_id.'&'.$email.'&'.$phone_no.'&'.$full_name.'&'.'2';
                    }
    }
	
	public function getUserInfoByEmail($email){
        $mysql = "SELECT * FROM user_login_table WHERE email ='".$email."'";
        //$result = mysql_query($mysql);
        //$num_rows = mysql_num_rows($result);
		$query = $this->db->query($mysql);
		
        if ($query->$num_rows() > 0) {
            /* while ($res = mysql_fetch_object($result)) {
                $rows = $res;
            } */
			$rows = $query->row();
            return $rows;
        } else {
            return 1;
        }
    }

	function updateUser($device_type,$device_token,$login_type,$email,$userid='') {
        //$password = base64_encode($password);
		if($email!=''){
			$mysql = "update user_login_table set device_type ='".$device_type."', device_token ='".$device_token."', login_type  ='".$login_type ."' where email ='".$email."'";
			//$run = mysql_query($mysql);
			$run = $this->db->query($mysql);
            return 1;
        }else{
            return 0;
        }
    }
	
	public function getUser($email, $user_name, $pass) {
        $password = md5($pass);
       //$mysql = "SELECT * FROM user_login_table WHERE (user_name = '".$user_name."') and password='".$password."'"; die;
        $mysql = "SELECT * FROM user_login_table WHERE (email = '".$email."') and password='".$password."' limit 1"; 
		$query = $this->db->query($mysql);
		if($query->num_rows()>0){
			$row = $query->row();
			 return $row;
		}else{
			return false
		}	 
        //$run = mysql_query($mysql);
        //$user = mysql_fetch_object($run);
    }
	
	public function userlogin($email, $user_name, $pass, $device_token, $device_type){
        //$password = base64_encode($pass);
        $password = md5($pass);
        //$mysql = "SELECT * FROM user_login_table WHERE (user_name='".$user_name."') and password='".$password."'"; 
       $mysql ="SELECT * FROM user_login_table WHERE (email='".$email."') and password='".$password."'"; 
        $run = $this->db->query($mysql);
        $num_rows = $run->num_rows(); 
        //$mysql = mysql_query("update user_login_table set device_token='".$device_token."' ,device_type='".$device_type."' where user_name='".$user_name."' and password='".$password."'");
		if($num_rows>0){
			$mysql = "update user_login_table set device_token='".$device_token."' ,device_type='".$device_type."' where email='".$email."' and password='".$password."'";
			$query = $this->db->query($mysql);
			if($this->db->affected_rows() > 0){
				return 1 ;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
    }
	
	public function DictionaryData($wordData) {
        if(!empty($wordData)){
           $mysql = 'select Definition from DEFINITIONS where wordID = (select wordID from WORDS where Word = "'.$wordData.'")';
           //echo $mysql;exit();
		   $query = $this->db->query($mysql);
		   if($query->num_rows()>0){
            //$result = mysql_query($mysql);
           // $num_rows = mysql_num_rows($result);
				$rows = $query->result();
				/* while ($res = mysql_fetch_object($result)) {
					$rows[] = $res;
				} */
                return $rows;
            } else {
                return 1;
            }
         }
    }
	
	public function sendFrndReq($user_id, $frnd_id){
	    
		if (!$this->isReqValidation($user_id,$frnd_id)){ 
			
			$mysql = "INSERT INTO tbl_frnds set user_id ='".$user_id."', frnd_id ='".$frnd_id."' ";
			$query  = $this->db->query($mysql);
			$ins_id = $this->db->insert_id();
			if($ins_id>0){
           
				return TRUE;
			}
		}else{
			return FALSE;
        }
    }
	
	function userEdit($address, $user_id, $file_url, $country="",$password,$publisher_type,$email,$about_me) {
		
		if($password!=''){ 
            $pass = md5($password);		
			$mysql = "update user_login_table set address ='".$address."',
                                               country ='".$country."',
                                               password ='".$pass."',
                                               publisher_type ='".$publisher_type."',
                                               email ='".$email."',
                                               about_me ='".$about_me."' where id='".$user_id."'";
		}else{ 
         $mysql = "update user_login_table set address ='".$address."',
                                               country ='".$country."',
                                               publisher_type ='".$publisher_type."',
                                               email ='".$email."',
                                               about_me ='".$about_me."' where id='".$user_id."'";
		}
        
        $run = $this->db->query($mysql);
        if($run > 0){
            return 1;
        }else{
            return 0;
        }
    }
	
	public function getUserInfo($user_id) {
		
		$fields = 'id, register_id, full_name,user_name,url, email,gender, phone_no,country, date_edited,status, message_status, publisher_type, about_me, about_me, device_token, device_type, address';
        
        $mysql = "SELECT $fields FROM user_login_table WHERE   id ='" . $user_id . "'"; 
        $query = $this->db->query($mysql);
        if ($query->num_rows() > 0) { 
               
            $res = $query->row();
		
            /* while ($res = mysql_fetch_object($result)) {
                $rows[] = $res;
            }
            $rows = array(
                'id' => $rows[0]->id,
            );
            return $rows; */
            return $res;
        } else {
            return 0;
        }
    }
	
	function userEditProfilePic($user_id, $file_url) {
        if($file_url){
            $mysql = "update user_login_table set url ='".$file_url."' where id='".$user_id."'";
        }
        $run = $this->db->query($mysql);
        if($this->db->affected_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }
	
	function updatePassword($user_id, $opass, $npass){
		
		$mysql = "select id,email from user_login_table where id='".$user_id."' and password='" . md5($opass) . "' ";
		$query = $this->db->query($mysql);
		if($query->num_rows()>0){ 
			$password = md5($npass);
			$mysql = "update user_login_table set password='" . $password . "' where id='" . $user_id . "' and password='" . md5($opass) . "'";
			$run = $this->db->query($mysql);
			if($this->db->affected_rows() > 0){
				return 1;
			}else{
				return 0;
			}
		}else{
			return "notexist";
		}
    }
	
	function forgetPassword($email){
        $chars = "0123456789";
        $pass = substr(str_shuffle($chars), 0, 6);
        $password = md5($pass);
		
		$mysql = "select id,email from user_login_table where email='".$email."'";
		$query = $this->db->query($mysql);
		if($query->num_rows()>0){ 
			
			$mysql = "update user_login_table set password='".$password."' where email='".$email."'";

			$run = $this->db->query($mysql);
			
			if ($this->db->affected_rows() > 0){ 
				$tos = $email;
				$subject = 'Ebooks App - Forgot password';
				$from = 'info@dnddemo.com';
				$message = '<b>Hello  '.$email.'<br/><br/></b>
						Your email and password is following:<br/><br/>
						<b>E-mail: '.$email.'<br/>
						Your  password : '.$pass.'</b><br/><br/>
						Now you can login with this email and password.<br/><br/>
						Thanks<br/>
						Team eBooks';
				
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: Ebooks <dnddemo.com@noreply>' . "\r\n";
				$headers .= 'Reply-To: ' . $admin_email . "\r\n";
				$headers .= 'X-Mailer: PHP/' . phpversion();
				$sent = mail(trim($tos), $subject, $message, $headers);		
				if ($sent) {
					return 1;
				} else {
					$err = 'Message could not be sent.';
					$err .= 'Mailer Error: ' . $mail->ErrorInfo;
					return 0;
				}
				
			}else{
				return 0;
			}
		}else{ 
			return "notexist";
		}
    }
	
	private function isReqValidation($user_id,$frnd_id) {
        $mysql = "SELECT id from tbl_frnds WHERE user_id ='".$user_id."' AND frnd_id='".$frnd_id."'";
		$query = $this->db->query($mysql);
		if($query->num_rows()>0){ 
			return $query->num_rows();
		}else{
			 return false;
		}
    }
	
	public function getAuthorDetails2($userid) {
        if($userid !==''){
            $mysql = "SELECT id,user_name,url,email,about_me, publisher_type,device_token, device_type FROM user_login_table WHERE id ='".$userid."'";
            //$run = mysql_query($mysql);
            //$row = mysql_fetch_object($run);
			$query = $this->db->query($mysql);
			if($query->num_rows()>0){
				 $row = $query->row();
				return $row;
			}
        }else{
            return NULL;
        }
    }
	
	private function isUserExists($email,$user_name='') {
        //$mysql = "SELECT id from user_login_table WHERE email ='".$email."' AND user_name='".$user_name."'";
        $mysql = "SELECT id from user_login_table WHERE email ='".$email."'";
        //$mysql = "SELECT id from user_login_table WHERE email ='".$email."'";
		$query = $this->db->query($mysql);
		if($query->num_rows()>0){
			 //$row = $query->row();
			return $query->num_rows();
		}else{
			return 0;
		}
        /* $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        return $num_rows > 0; */
    }
	
	
	//raw data
	public function getUserInfo_old($tbl_name, $where=array()) {
		
		if($tbl_name!='' && !empty($where)){
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->where($where);
			$query = $this->db->get();
			$rows  = array();
			
			if ($query->num_rows() > 0) {
				
				$result = $query->row();
				//$rowss  = (array) $result;
				//return $rowss;   
				return $result; 
			} else {
				return false;
			}
		}else{
			return false;
		}
    }
	
	function checkUserExist($tbl,$where='') { 
        if($tbl!='' && !empty($where)){
			$this->db->select('*');
			$this->db->from($tbl);
			$this->db->where($where);
			$query = $this->db->get();
			$rows  = array();
			if ($query->num_rows() > 0) { 
				return $query->num_rows(); 
			} else {
				return false;
			}
		}else{
			return false;
		}
    }
	
    function checkAccountExist($email) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
		//$this->db->limit(1);
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
			$result = $query->row();
            return $result;
        } else {
            return false;
        }
    }
   
	public function getDetailsOther($tbl,$fields='', $whrcond='',$user_id='') {
        
		$fields  = ($fields)?$fields:"*"; 
		
		if($tbl!=''){
			//$query = "select $fields from $tbl where 1"; 
			//( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )
			$querysel = "select $fields from $tbl as ult left join tbl_frnds ON ( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )  WHERE 1 and ( tbl_frnds.user_id = $user_id OR tbl_frnds.frnd_id = $user_id ) and tbl_frnds.status=1 and ult.id != $user_id  group by ult.id"; 
			
			$query = $this->db->query($querysel);
	    
            if ($query->num_rows() > 0) { 
               
                $res = $query->result();
                //$rows[] = $res;	
                return $res;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
	public function latestUserStatusList($user_id) {
        
		if($user_id!=''){
			//$query = "select $fields from $tbl where 1"; 
			//( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )
			//$querysel = "select $fields from $tbl as ult left join tbl_frnds ON ( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )  WHERE 1 and ( tbl_frnds.user_id = $user_id OR tbl_frnds.frnd_id = $user_id ) and tbl_frnds.status=1 and ult.id != $user_id  group by ult.id";
			$querysel = "select ucst.id as status_id,ucst.message,ucst.message_type,ucst.created_at, ult.id as user_id,ult.user_name,ult.url,ult.email,ult.about_me, ult.publisher_type,ult.device_token, ult.device_type,ult.phone_no,ult.status from user_chat_status_timeline as ucst left join user_login_table as ult ON ( ult.id = ucst.userid OR ult.id = ucst.userid ) left join tbl_frnds on( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )  WHERE 1 and ( tbl_frnds.user_id = $user_id OR tbl_frnds.frnd_id = $user_id ) and tbl_frnds.status=1 and ult.id != $user_id group by ult.id  order by ucst.id desc limit 25";			
			
			$query = $this->db->query($querysel);
	    
            if ($query->num_rows() > 0) { 
               
                $res = $query->result();
                //$rows[] = $res;	
                return $res;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
   
    function checkAccountExistById($id) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$id);
		//$this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
	
    function isValidCode($code = '', $id = null) {

        if (!empty($code)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $this->db->where('activation_code', $code);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
	
    function isUserAlreadyActivated($id) {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                $active = $result->active;
                if ($active == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


   function getUserDetail($id) {
        if (!empty($id)) {
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
               return true;
            } else {
                return false;
            }
        }
    }
	function getRecord($tblname,$id,$selectF='',$whrCond='') { 
	    $selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($id)$this->db->where('id',$id);
		if($whrCond)$this->db->where($whrCond);
		//$this->db->where('status',1);
		//$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row();
		else:
			return false;
		endif;
	 }
    
    function getAllNotifications($user_id) {
        $data = array();
        $finalArray = array();
        $message = "";
        if (!empty($user_id)) {
            $this->db->select('n.notification_object_id,nb.entity_type,nb.entity_id,type.entity_type,type.entity_table,u.username,u.id as user_id,u.email');
            $this->db->from('notification n');
            $this->db->join('notification_object nb', 'nb.id=n.notification_object_id');
            $this->db->join('users u', 'n.notifier_id=u.id');
            $this->db->join('notification_entity_type type', 'type.id=nb.entity_type');
            $this->db->where('n.notifier_id', $user_id);
            $query = $this->db->get();
            $data = $query->result();
            if ($query->num_rows() > 0) {
                foreach ($data as $v) {
                    $entity = $v->entity_table;
                    $entity_id = $v->entity_id;
                    switch ($entity) {
                        case 'trips':
                            $query = $this->db->query("select id,title from trips where id = $entity_id");
                            $tripData = $query->row();
                            if (!empty($tripData)) {
                                $message = "You have received a new trip invitation named " . $tripData->title . "";
                            }
                            break;

                        default:
                            break;
                    }

                    $finalArray[] = array(
                        'notification_object_id' => !empty($v->notification_object_id) ? $v->notification_object_id : '',
                        'username' => !empty($v->username) ? $v->username : '',
                        'user_id' => !empty($v->user_id) ? $v->user_id : '',
                        'email' => !empty($v->email) ? $v->email : '',
                        'entity_type' => !empty($v->entity_type) ? $v->entity_type : '',
                        'trip_id' => !empty($tripData->id) ? $tripData->id : '',
                        'message' => $message,
                    );
                }
                return $finalArray;
            } else {
                return $finalArray;
            }
        }
    }
	function getuserdetails_select($id) {
    
        $this->db->select('*');
        $this->db->from('users');
        
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    
    function getusercontactusdetails_select($id) {
        $this->db->select('*');
        $this->db->from('users');
         $this->db->where('id != ', $id);
        $query = $this->db->get();
        $result = $query->result();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
     
	public function edituser_update($data) {
		$datan = array(
		'username' =>  $data['username'],
		'email' =>  $data['email'],
		'phone' =>  $data['phone'],
		'user_type' =>  $data['user_type'],
		'profilephoto' =>  $data['profilephoto'],
		'resume' =>  $data['resume'],
		);


		$this->db->where('id', $data['user_id']);

		$this->db->update('users', $datan);
		echo $this->db->last_query();
	}

}
