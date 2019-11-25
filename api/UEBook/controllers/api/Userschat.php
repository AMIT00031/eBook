<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author : Userschat<Userschat@seoessenc.com>
 * @date : 31-oct-2018
 * @objective : Get all information regarding Userschat 
 */
class Userschat extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/userchat_model');
       $this->load->model('user_model');
        
       
    }
    
    public  function getNonExistingFilename($uploadFilesTo, $name)

  {
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
