<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author : Usersstatus<Userschat@seoessenc.com>
 * @date : 11-march-2020
 * @objective : Get all information regarding Userschat 
 */
class Userstatus extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/userchat_model');
		$this->load->model('user_model');
		$this->load->model('common_model');  
    }
	
	
	//post method: http://dnddemo.com/ebooks/api/userstatus/userChatStatusSetting
	public function userChatStatusSetting_post() {
		$lang ="en";
		$_['en_success'] = "Successfully set";	
		$_['en_failed'] = "Something went wrong! please try again.";	
		$_['en_user_unavailable'] = "User account does not exists please try again.";	
	    $data = array();
		$postData 		= $this->input->post();
		$visibility 	= !empty($postData['visibility_flag']) ? $postData['visibility_flag'] : '';	
		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';	
		$user_ids 		= !empty($postData['user_ids']) ? $postData['user_ids'] : '';	
		$isUserExists = $this->user_model->checkUserExist('user_login_table',array('id'=>$user_id));
		
		if($isUserExists>0 && $isUserExists==1){
		    if($visibility=="visible_to"){	
			   $update_data = array('chat_status_setting'=>$visibility,'user_ids_visible_to'=>$user_ids);
		    }else if($visibility=="hide_from"){
			   $update_data = array('chat_status_setting'=>$visibility,'user_ids_hide_from'=>$user_ids); 
		    }else{
			    $update_data = array('chat_status_setting'=>$visibility);
		    }
			$is_update = $this->common_model->update_data('user_login_table',$update_data,array('id'=>$user_id));
			
			if($is_update){

				$response = array('status' => '1','error' => false,'user_id' => $user_id,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = array('status' => '1','error' => true,'message' => '','message' => $_['en_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'message' => '','message' => $_['en_user_unavailable']);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}			
	}
	
	
	//post method: http://dnddemo.com/ebooks/api/userstatus/selectedUsersListForStatus
	public function selectedUsersListForStatus_post() {
		$lang ="en";
		$_['en_success'] = "Successfully set";	
		$_['en_failed'] = "Something went wrong! please try again.";	
		$_['en_user_unavailable'] = "User account does not exists please try again.";	
	    $data = array();
		$postData 		= $this->input->post();
		$visibility 	= !empty($postData['visibility']) ? $postData['visibility'] : '';		
		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';	
		if($user_id!=''){
			//$user_ids 		= !empty($postData['user_ids']) ? $postData['user_ids'] : '';	
			$user_details = $this->user_model->getUserInfo('user_login_table',array('id'=>$user_id));
			
			$fields       = "ult.id,ult.user_name,ult.url,ult.email,ult.about_me, ult.publisher_type, ult.device_token,ult.device_type,ult.phone_no,ult.status";
			//$whrcond = " ult.id != $arr[id] "; 
			$whrcond 	= " ult.id != $user_id"; 
			$frndUserList   = $this->user_model->getDetailsOther('user_login_table',$fields,$whrcond,$user_id);
			$data = array(); 
			//print_r($frndUserList); 
			
			if(!empty($frndUserList)>0 && $user_id!=''){
		   
				if($user_details->chat_status_setting=="visible_to"){
					// && $user_details->user_ids!='' 
					if($user_details->user_ids_visible_to !=''){
						$user_lists = explode(",",$user_details->user_ids_visible_to);
					}else{
						$user_lists ="";
					}
				}else if($user_details->chat_status_setting=="hide_from"){
					if($user_details->user_ids_hide_from !=''){
						$user_lists = explode(",",$user_details->user_ids_hide_from); 
						
					}else{
						$user_lists ="";
					}
				}else if($user_details->chat_status_setting=="all"){
					$user_lists ="all";
				}
				
				foreach($frndUserList as $key=>$freind_id){  
				    
					$data[$key]['id'] = $freind_id->id;
					$data[$key]['user_name'] = $freind_id->user_name;
					$data[$key]['url'] = $freind_id->url;
					$data[$key]['email'] = $freind_id->email;
					$data[$key]['about_me'] = $freind_id->about_me;
					$data[$key]['publisher_type'] = $freind_id->publisher_type;
					$data[$key]['device_token'] = $freind_id->device_token;
					$data[$key]['device_type'] = $freind_id->device_type;
					$data[$key]['phone_no'] = $freind_id->phone_no;
					$data[$key]['status'] = $freind_id->status;
					if($user_lists=="all"){
						$data[$key]['is_in_list'] = "No";
					}else if($user_lists==""){
						$data[$key]['is_in_list'] = "No";
					}else {
						
						if(in_array($freind_id->id,$user_lists)){
							//$frnd_id_list[$key]['id'] = $freind_id->id;
							$data[$key]['is_in_list'] = "Yes";
						}else{
							//$frnd_id_list[$key]['id'] = $freind_id->$id;
							$data[$key]['is_in_list'] = "No";
						}
					}
				}

				/* if($visibility=="hide_from") { 
				   $frnd_id_list;
				}else if($visibility=="visible_to"){
					$frnd_id_list;
				}else{
					$frnd_id_list;
				
				} */ 
				$response = array('status' => '1','error' => false,'user_id' => $user_id,'visibility_flag' => $user_details->chat_status_setting,'data' => $data,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = array('status' => '1','error' => true,'message' => '','user_id' => $user_id,'visibility_flag' => $user_details->chat_status_setting,'data' => $data,'message' => $_['en_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'message' => '','message' => $_['en_user_unavailable']);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}			
	}
		
	//post method: http://dnddemo.com/ebooks/api/userstatus/addUserChatStatus
	public function addUserChatStatus_post() {
		
        $lang ="en";
		$_['en_success'] = "Successfully added";	
		$_['en_failed'] = "Something went wrong! please try again.";	
		$postData = $this->input->post();
		$param = array();		
		//$visibility 	= !empty($postData['visibility']) ? $postData['visibility'] : '';		
		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';			
		$message_type 	= !empty($postData['message_type']) ? $postData['message_type'] : '';
		
		$bg_color 		= !empty($postData['bg_color']) ? $postData['bg_color'] : NULL;
		$font_style 	= !empty($postData['font_style']) ? $postData['font_style'] : NULL;
					
		$message 		= !empty($postData['message']) ? $postData['message'] : '';	
		//$status_user_id = !empty($postData['status_user_id']) ? $postData['status_user_id'] : '';	
		$response = array();
		$user_details = $this->user_model->getUserInfo('user_login_table',array('id'=>$user_id));
		
		if(!empty($user_details) && $user_details!=''){
			
			if($message_type != "text")
			{	
				//Document file
				if(!empty($_FILES['pdf_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chatstatus/document/';
						$fileinfo = pathinfo($_FILES['pdf_file']['name']);
						$extension = $fileinfo['extension'];
						$message = $upload_path.'document_'.time().'.'.$extension;
						$file_path = $upload_path .'document_'.time().'.'.$extension;
						move_uploaded_file($_FILES['pdf_file']['tmp_name'], $file_path);
					}else{
						$response = array('status' => '1','error' => true,'message' => 'file size must not be more than 2 MB');
						$this->set_response($response, REST_Controller::HTTP_OK);
						exit();
					}
				}
				
				//image file
				 if(!empty($_FILES['image_file'])){ 
					 $errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chatsstatus/gallery/'; 
						$fileinfo = pathinfo($_FILES['image_file']['name']);
						$extension = $fileinfo['extension']; 
						$message = $upload_path.'gallery_'.time().'.'.$extension; 
						$file_path = $upload_path .'gallery_'.time().'.'.$extension;
						move_uploaded_file($_FILES['image_file']['tmp_name'], $file_path);
					}else{
						$response = array('status' => '1','error' => true,'message' => 'file size must not be more than 2 MB');
						$this->set_response($response, REST_Controller::HTTP_OK);
						exit();
					}
				}
				
				//audio file
				/* if(!empty($_FILES['audio_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chatstatus/audio/';
						$fileinfo  = pathinfo($_FILES['audio_file']['name']);
						$extension = $fileinfo['extension'];
						$message   =  $upload_path.'audio_'.time().'.'.$extension;
						$file_path = $upload_path .'audio_'.time().'.'.$extension;
						move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path);
					}else{
						$response["error"] = true;
						$response["message"] = "file size must not be more than 2 MB";
						echoResponse(201, $response);
						exit();
					}
				}
				 */
				//video file
				if(!empty($_FILES['video_file'])){
					$errors= array();
					if(empty($errors)==true){
						$upload_path = 'upload/chatstatus/video/';
						$fileinfo   = pathinfo($_FILES['video_file']['name']);
						$extension = $fileinfo['extension'];
						$message   = 	 $upload_path.'video_'.time().'.'.$extension;
						$file_path = $upload_path .'video_'.time().'.'.$extension;
						move_uploaded_file($_FILES['video_file']['tmp_name'], $file_path);
					}else{
						$response = array('status' => '1','error' => true,'message' => 'file size must not be more than 2 MB');
						$this->set_response($response, REST_Controller::HTTP_OK);
						exit();
					}
				}
			
			}else{ 
			  
				$message = utf8_encode(addslashes($message)); 
							
			}	
				
			if (!empty($message) && $message!="") {
				
				$param['userid'] = $user_id;
				$param['message_type'] 	= $message_type;
				$param['message'] 		= $message;
				$param['bg_color'] 		= ($bg_color)?$bg_color:'#4B0082';
				$param['font_style'] 	= ($font_style)?$font_style:'NORMAL'; 
				$param['created_at'] 	=  date("Y-m-d h:i:s");
				
				/* if($visibility=="hide_from") {    //all,hide_from,show_to
				   $param['user_ids_hide_from'] = $user_ids_hide_from;
				    $param['visibility_setting'] = $visibility;
				}else if($visibility=="show_to"){
					
					$param['user_ids_show_to'] = $user_ids_show_to;
					$param['visibility_setting'] = $visibility;
				}else{
					 $param['visibility_setting'] = $visibility;
				} */
				
				//$postData['password'] = $password;
				$user_status_id = $this->common_model->save_data('user_chat_status_timeline',$param);
				
				$response = array('status' => '1','error' => false,'user_status_id' => $user_status_id,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = array('status' => '1','error' => true,'user_status_id' => '','message' => $_['en_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'user_status_id' => '','message' => 'Account not avialable! please provide correct user');
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}
	

	//post method: http://dnddemo.com/ebooks/api/userstatus/userChatStatusList
	public function userChatStatusList_post() {
		
        $lang ="en";
		$_['en_success'] = "Successfully fetch";		
		$_['en_failed'] = "Something went wrong! please try again.";	
	    
		$postData = $this->input->post();
		
		//$visibility 	= !empty($postData['visibility']) ? $postData['visibility'] : '';		
		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';			
		//$message_type 	= !empty($postData['message_type']) ? $postData['message_type'] : '';		
		//$message 		= !empty($postData['message']) ? $postData['message'] : '';	
		$status_user_id = !empty($postData['status_user_id']) ? $postData['status_user_id'] : '';	
		
		$response = array();
		//$count_percent = count($percentage_array);
        if($user_id && $status_user_id) { 		
			
			$user_details = $this->user_model->getUserInfo('user_login_table',array('id'=>$user_id));
			
			$chatStatusDetails = $this->common_model->select_data('user_chat_status_timeline','',array('userid'=>$status_user_id));
			
			if(!empty($chatStatusDetails) && !empty($user_details!='')){
				
				foreach($chatStatusDetails as $key=>$chatStatusDet){
				   $chatStatusDetails[$key]->message=utf8_decode(stripslashes($chatStatusDet->message)); 
				}
				$chatUserDetails = $this->user_model->getUserInfo('user_login_table',array('id'=>$chatStatusDetails[0]->userid));
				
				if($chatUserDetails->chat_status_setting=="visible_to"){
					
					if($chatUserDetails->user_ids_visible_to !='' && in_array($user_id,explode(",",$chatUserDetails->user_ids_visible_to) ) ){
						$chat_status = "visible"; 
						//$user_lists = explode(",",$chatUserDetails->user_ids_visible_to);
					}else{
						$chat_status ="not available";
					}
				}else if($chatUserDetails->chat_status_setting=="hide_from"){
					if($chatUserDetails->user_ids_hide_from !='' && in_array($user_id,explode(",",$chatUserDetails->user_ids_hide_from)) ){
						$chat_status = "hide"; 
						//$user_lists = explode(",",$chatUserDetails->user_ids_hide_from); 
						
					}else{
						$chat_status ="not available";
					}
				}else if($chatUserDetails->chat_status_setting=="all"){
					$chat_status ="visible";
				}
				 
				$response = array('status' => '1','error' => false,'chat_status'=>$chat_status,'data' => $chatStatusDetails,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			}else{
				
				$response = array('status' => '1','error' => true,'message' => $_['en_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'message' => 'Please select which user you want to see status');
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}
	
	//post method: http://dnddemo.com/ebooks/api/userstatus/latestUserStatusList
	public function latestUserStatusList_post() {
		$lang ="en";
		$_['en_success'] = "Successfully fetch";	
		$_['en_failed'] = "Something went wrong! please try again.";	
		$_['en_user_unavailable'] = "User account does not exists please try again.";	
	    $data = array();
		$postData 		= $this->input->post();
		$visibility 	= !empty($postData['visibility']) ? $postData['visibility'] : '';		
		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';	
		if($user_id!=''){
			//$user_ids 		= !empty($postData['user_ids']) ? $postData['user_ids'] : '';	
			$user_details = $this->user_model->getUserInfo('user_login_table',array('id'=>$user_id));
			
			$latestUserStatusList   = $this->user_model->latestUserStatusList($user_id);
			$data = array(); 
			//print_r($frndUserList); 
			
			if(!empty($latestUserStatusList)>0 && $user_id!=''){
		   
				/* if($user_details->chat_status_setting=="visible_to"){
					// && $user_details->user_ids!='' 
					if($user_details->user_ids_visible_to !=''){
						$user_lists = explode(",",$user_details->user_ids_visible_to);
					}else{
						$user_lists ="";
					}
				}else if($user_details->chat_status_setting=="hide_from"){
					if($user_details->user_ids_hide_from !=''){
						$user_lists = explode(",",$user_details->user_ids_hide_from); 
						
					}else{
						$user_lists ="";
					}
				}else if($user_details->chat_status_setting=="all"){
					$user_lists ="all";
				} */
				
				foreach($latestUserStatusList as $key=>$freind_id){  
				    
					$data[$key]['status_id'] 		= $freind_id->status_id;
					$data[$key]['message'] 			= $freind_id->message;
					$data[$key]['message_type'] 	= $freind_id->message_type;
					$data[$key]['created_at'] 	= $freind_id->created_at;
					$data[$key]['user_id'] 			= $freind_id->user_id;
					$data[$key]['user_name'] 		= $freind_id->user_name;
					$data[$key]['url'] 				= $freind_id->url;
					$data[$key]['email'] 			= $freind_id->email;
					$data[$key]['about_me'] 		= $freind_id->about_me;
					$data[$key]['publisher_type'] 	= $freind_id->publisher_type;
					$data[$key]['device_token'] 	= $freind_id->device_token;
					$data[$key]['device_type'] 		= $freind_id->device_type;
					$data[$key]['phone_no'] 		= $freind_id->phone_no;
					$data[$key]['status']			= $freind_id->status;
					
					/* if($user_lists=="all"){
						$data[$key]['is_in_list'] = "No";
					}else if($user_lists==""){
						$data[$key]['is_in_list'] = "No";
					}else {
						
						if(in_array($freind_id->id,$user_lists)){
							//$frnd_id_list[$key]['id'] = $freind_id->id;
							$data[$key]['is_in_list'] = "Yes";
						}else{
							//$frnd_id_list[$key]['id'] = $freind_id->$id;
							$data[$key]['is_in_list'] = "No";
						}
					} */
				}

				/* if($visibility=="hide_from") { 
				   $frnd_id_list;
				}else if($visibility=="visible_to"){
					$frnd_id_list;
				}else{
					$frnd_id_list;
				
				} */ 
				$response = array('status' => '1','error' => false,'user_id' => $user_id,'visibility_flag' => $user_details->chat_status_setting,'data' => $data,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = array('status' => '1','error' => true,'message' => '','user_id' => $user_id,'visibility_flag' => $user_details->chat_status_setting,'data' => $data,'message' => $_['en_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'message' => '','message' => $_['en_user_unavailable']);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}			
	}
	
	//post method: http://dnddemo.com/ebooks/api/userstatus/userChatStatusList
	public function userOwnChatStatusList_post() {
		
        $lang ="en";
		$_['en_success'] 		= 	"Successfully fetch";		
		$_['en_failed'] 		= 	"Something went wrong! please try again.";
		$_['en_userid_failed'] 	= 	"User id missing";
			
	    
		$postData = $this->input->post();

		$user_id 		= !empty($postData['user_id']) ? $postData['user_id'] : '';			
		//$status_user_id = !empty($postData['status_user_id']) ? $postData['status_user_id'] : '';	
		$response = array();
		
        if($user_id) { 		
			
			$user_details = $this->user_model->getUserInfo('user_login_table',array('id'=>$user_id));
			
			$chatStatusDetails = $this->common_model->select_data('user_chat_status_timeline','',array('userid'=>$user_id),'id','desc','',10);
			
			if(!empty($chatStatusDetails) && !empty($user_details!='')){
				
				$response = array('status' => '1','error' => false,'chat_status'=>$chat_status,'data' => $chatStatusDetails,'message' => $_['en_success'] );
				$this->set_response($response, REST_Controller::HTTP_OK);
			}else{
				
				$response = array('status' => '1','error' => true,'message' => $_[$lang.'_failed']);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}else{
			$response = array('status' => '1','error' => true,'message' => $_[$lang.'_userid_failed']);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}
	
	
	//raw data 
    public  function getNonExistingFilename($uploadFilesTo, $name){
	
		if (!file_exists($uploadFilesTo . '/' . $name))
		return $name;
		return getNonExistingFilename($uploadFilesTo, rand(100, 200) . '_' . $name);

	}

	public function sendMessage_post() {
        $postData = $this->input->post();
         $postDatanew['userid'] = !empty($postData['userid']) ? $postData['userid'] : '';
          $postDatanew['sendtoid'] = !empty($postData['sendtoid']) ? $postData['sendtoid'] : '';
              $postDatanew['chanelid'] = !empty($postData['chanelid']) ? $postData['chanelid'] : rand(100000, 999999); 
     
     
        if($postData['messagetype']=='text'){ 
             $postDatanew['messagetype'] = !empty($postData['messagetype']) ? $postData['messagetype'] : '';
              $postDatanew['message'] = !empty($postData['message']) ? $postData['message'] : '';
               $postDatanew['video'] = !empty($postData['video']) ? $postData['video'] : '';
            
                   }
            
       if($postData['messagetype']=='image'){   $postDatanew['messagetype']=$postData['messagetype'];   
        $upload_path = 'uploads/userschat/';
        
        if(!empty($_FILES['image'])) {
            $userImages['image'] = $_FILES['image']['name'];
 $fileinfo = pathinfo($_FILES['image']['name']);
    $extension = $fileinfo['extension'];
    $file_name = 'class_' . rand() . '.' . $extension;
    $file_path = $upload_path . $file_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
    
        }
         $postDatanew['messagetype'] = !empty($postData['messagetype']) ? $postData['messagetype'] : '';
              $postDatanew['message'] = !empty($postData['message']) ? $postData['message'] : '';
               $postDatanew['video'] = !empty($postData['video']) ? $postData['video'] : '';
                 $postDatanew['voicemessage'] = !empty($postData['voicemessage']) ? $postData['voicemessage'] : '';
                $postDatanew['image']=$file_name;  
               
               
   
       }
       
        if($postData['messagetype']=='voice'){   
        $upload_path = 'uploads/userschat/';
        
        if(!empty($_FILES['voicemessage'])) {
            $userImages['voicemessage'] = $_FILES['voicemessage']['name'];
 $fileinfo = pathinfo($_FILES['voicemessage']['name']);
    $extension = $fileinfo['extension'];
    $file_name = 'class_' . rand() . '.' . $extension;
    $file_path = $upload_path . $file_name;
    move_uploaded_file($_FILES['voicemessage']['tmp_name'], $file_path);
    
        }
         $postDatanew['messagetype'] = !empty($postData['messagetype']) ? $postData['messagetype'] : '';
              $postDatanew['message'] = !empty($postData['message']) ? $postData['message'] : '';
               $postDatanew['video'] = !empty($postData['video']) ? $postData['video'] : '';
                  $postDatanew['image'] = !empty($postData['image']) ? $postData['image'] : '';
                $postDatanew['voicemessage']=$file_name;  
               
               
   
       }
        if($postData['messagetype']=='video'){ 
             $upload_path = 'uploads/userschat/';
             if($_FILES['image']['name']!='') {
                
              $userImages['image'] = $_FILES['image']['name'];
               $userImages['video'] = $_FILES['video']['name'];
               
               
 $fileinfo = pathinfo($_FILES['image']['name']);
  $fileinfovideo = pathinfo($_FILES['video']['name']);
    $extension = $fileinfo['extension'];
    $extensionvideo = $fileinfovideo['extension'];
    $file_name = 'class_' . rand() . '.' . $extension;
       $file_namevideo = 'class_' . rand() . '.' . $extensionvideo;
    $file_path = $upload_path . $file_name;
     $file_pathvideo = $upload_path . $file_namevideo;
    move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
     move_uploaded_file($_FILES['video']['tmp_name'], $file_pathvideo);
      $postDatanew['messagetype'] = !empty($postData['messagetype']) ? $postData['messagetype'] : '';
              $postDatanew['message'] = !empty($postData['message']) ? $postData['message'] : '';
              $postDatanew['voicemessage'] = !empty($postData['voicemessage']) ? $postData['voicemessage'] : ''; 
            
               $postDatanew['video'] = $file_namevideo;  
            
        $postDatanew['image']=$file_name;  

           
           
             }
             else { 
                $postDatanew['messagetype'] = !empty($postData['messagetype']) ? $postData['messagetype'] : '';
              $postDatanew['message'] = !empty($postData['message']) ? $postData['message'] : '';
               $postDatanew['video'] = !empty($postData['video']) ? $postData['video'] : '';
             $postDatanew['voicemessage'] = !empty($postData['voicemessage']) ? $postData['voicemessage'] : '';
          $postDatanew['image']="";  
   
              
                 
                 
                 
             }
        }
    
    
          //$postDatanew['messagetype']=$postData['messagetype']; 
         //   $postDatanew['message']=$postData['message']; 
         //     $postDatanew['video']=$postData['video']; 
         $postDatanew['unreadmessage'] = 0;
         //print_r($postDatanew); exit;
         $res = $this->userchat_model->insert($postDatanew); 
          if ($res) {
     
               $senduser = $this->user_model->get($postData['sendtoid']);
                $userdata = $this->user_model->get($postData['userid']);
             
              if($senduser->device_type=='ios') {
if ( $senduser->device_id!="") {				
		$apnsHost = 'gateway.sandbox.push.apple.com';	
		
		$apnsCert = 'pushcert.pem';					
		$apnsPort = 2195;					
		$apnsPass = '1234';					
		$token = $senduser->device_id;	
		 if($postData['messagetype']=='text'){ 	$mst = $userdata->username." :\r\n ".$postData['message']; }
		  if($postData['messagetype']=='video'){ 	$mst = $userdata->username." Has Send The Video "; }
		   if($postData['messagetype']=='image'){ 	$mst = $userdata->username." Has Send The Image ";  }
		  if($postData['messagetype']=='voice'){ 	$mst = $userdata->username." Has Send The Audio ";  }
	
		
		$payload['aps'] = array('alert' => $mst, 'badge' => 1, 'sound' => 'default');			
		$payload['api_type'] = 'one2oneuser_chat';					
		$output = json_encode($payload);						
		$token = pack('H*', str_replace(' ', '', $token));			
		$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;	
		$streamContext = stream_context_create();						
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);	
		stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);			
		$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);		
		fwrite($apns, $apnsMessage);						
		fclose($apns);			
	///////////////////////////////////////////////////////////					
	}}
	
	else
	{
	    
	    	$token = $senduser->device_VOIPID;	
		 if($postData['messagetype']=='text'){ 	
		     $username=$userdata->username;
		     $messag=$postData['message'];
		     $mst = $postData['message']; }
		  if($postData['messagetype']=='video'){ 
		       $username=$userdata->username;
		        $messag=$postData['message'];
		      $mst = " Has Send The Video "; }
		   if($postData['messagetype']=='image'){ 
		        $username=$userdata->username;
		         $messag=$postData['message'];
		       $mst =" Has Send The Image ";  }
		   	   if($postData['messagetype']=='voice'){ 
		        $username=$userdata->username;
		         $messag=$postData['message'];
		       $mst =" Has Send The voice ";  }
		   
		   $tId= $postDatanew['chanelid'];
	     $user_mobile_info = array('user_mobile_token' =>$token);
                $message = $mst;
                $title = $username;
$userId=$postData['sendtoid'];

                $payload = $this->create_payload_json($message, $title);
                $notification_type = $postData['messagetype'];
//echo $payload."--".$tId."--".$userId."--".$notification_type."--".$title;
                $this->Common_Model->push_notification($user_mobile_info, $payload, $tId, 'admin', $userId, $notification_type, $title);   
	    
	}
	
	
	

	
            $response = array(
                'status' => '1',
                'message' => 'Added successfully.'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $response = array(
                'status' => '0',
                'message' => 'Something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
}
   
    function create_payload_json($message, $title) {
        $badge = "0";
        $sound = 'default';
        $payload = array();
        $payload['aps'] = array('message' => $message, 'title' => $title, 'badge' => intval($badge), 'sound' => $sound);
        return json_encode($payload);
    }

    public function getusermessage_post() {
        $postData = $this->input->post();
     
      $postDatanew['userid']=$postData['userid']; 
       
      
      $res =$this->userchat_model->getmessagelist($postDatanew);
   
           if (!empty($res)) {
            $this->set_response([
                'status' => '1',
                'total_records' => count($res),
                'result' => $res,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'No Message found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
}
   
    public function getuserallmessage_post() {
        $postData = $this->input->post();
     
      $postDatanew['userid']=$postData['userid']; 
       $postDatanew['sendtoid']=$postData['sendtoid']; 
        $postDatanew['messagetype']=$postData['messagetype']; 
       
          $resupdate = $this->userchat_model->Userallmessage_update($postDatanew ); 
      $res =$this->userchat_model->getmessagealllist($postDatanew);
      
           if (!empty($res)) {
            $this->set_response([
                'status' => '1',
                'total_records' => count($res),
                'result' => $res,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'No Message found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
}
   
	public function create_ticket_post() {
		
        $postData = $this->input->post();

        $res = $this->support_model->insert($postData);
        if ($res) {
            
            
            
            
            $response = array(
                'status' => '1',
                'message' => 'Message Sent successfully.'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $response = array(
                'status' => '0',
                'message' => 'Something went wrong'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }
    
    public function delete_message_post() {
        $postData = $this->input->post();

       $res =$this->support_model->deletemessage($postData);
     
      if ($res) {
            $response = array(
                'status' => '0',
                'message' => 'Something went wrong.'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $response = array(
                'status' => '1',
                'message' => 'Message Deleted successfully.'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }
    
    public function get_message_post() {
        $postData = $this->input->post();

       $res =$this->support_model->getmessage($postData);
      
        if (!empty($res)) {
            $this->set_response([
                'status' => '1',
                'total_records' => count($res),
                'result' => $res,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->set_response([
                'status' => '0',
                'message' => 'No Message found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function VOIPCall_post() {
     $postData = $this->input->post();     
   // print_r( $postData);  exit;
if ( $postData['device_VOIPID'][0] !="") {	
    $expol=explode(",",$postData['device_VOIPID'][0]);
    
      for ($x = 0; $x < (  count($expol) ); $x++) {
          
        
         
  
       
		$apnsHost = 'gateway.sandbox.push.apple.com';	
		
		$apnsCert = 'VOIP.pem';					
		$apnsPort = 2195;					
		$apnsPass = '1234';					
		$token = $expol[$x];					
	//	$mst = "Has Audio : ".$postData['hasAudio']." Has Video: ".$postData['hasVideo']." Caller Image URL: ".$postData['CallerImageURL']." Caller Name: ".$postData['CallerName']." live Url: ".$postData['liveUrl'];		
if($postData['isCallingORDecline']=='calling'){
//	$mst ='{"hasAudio" : "'.$postData['hasAudio'].'","hasVideo" :"'.$postData['hasVideo'].'","CallerImageURL" :"'.$postData['CallerImageURL'].'","liveUrl" : "'.$postData['liveUrl'].'","CallerName" : "'.$postData['CallerName'].'"}';
$mst ='Calling'; 
$mstjit ='{"hasAudio" : "'.$postData['hasAudio'].'","hasVideo" :"'.$postData['hasVideo'].'","CallerImageURL" :"'.$postData['CallerImageURL'].'","liveUrl" : "'.$postData['liveUrl'].'","CallerName" : "'.$postData['CallerName'].'"}';

	$payload['hasAudio'] = $postData['hasAudio'];	
	$payload['hasVideo'] = $postData['hasVideo'];	
	$payload['CallerImageURL'] = $postData['CallerImageURL'];	
	$payload['liveUrl'] = $postData['liveUrl'];	
	$payload['CallerName'] =$postData['CallerName'];	
					
    
    
}
else{
 $mst ='declined';  
 $mstjit ='{}';
}

		$payload['aps'] = array('alert' =>  $mst, 'badge' => 1, 'sound' => 'default');	
		
		$payload['api_type'] = 'olibizz_VOIPCall';					
		$output = json_encode($payload);
		
	
		$token = pack('H*', str_replace(' ', '', $token));			
		$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;	
		$streamContext = stream_context_create();						
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);	
		stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);			
		$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);		
		fwrite($apns, $apnsMessage);						
		fclose($apns);			
	///////////////////////////////////////////////////////////					
	} 
	
    
    
}

if ( $postData['device_VOIPID'][0] !="") {
     $this->set_response([
                'status' => '1',
                'message' => 'VOIP Notification Send'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}
else
{
      $this->set_response([
                'status' => '0',
                'message' => 'VOIP Notification Not Send'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
}
      
         
     }
    
    public function deleteUserChat_post() {
            
        $postData = $this->input->post();
   
           $postDatanew['chatid'] = !empty($postData['chatid']) ? $postData['chatid'] : '';
             $postDatanew['userid'] = !empty($postData['userid']) ? $postData['userid'] : '';
               $postDatanew['sendid'] = !empty($postData['sendid']) ? $postData['sendid'] : '';
                 $postDatanew['status'] = !empty($postData['status']) ? $postData['status'] : '';
                 
                 
                 if($postDatanew['chatid']==''){
                    
                $res = $this->userchat_model->deleteUserall_update($postDatanew ); 

}
else
{ 
   $res = $this->userchat_model->deleteUser_update($postDatanew );
   
    
}
 if ($res) {
            $response = array(
                'status' => '0',
                'message' => 'Something went wrong.'
            );
            $this->set_response($response, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $response = array(
                'status' => '1',
                'message' => 'Message Deleted successfully.'
            );
            $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }

       
        }

}
