<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/**
 * @author : jeevan<jeevan@seoessenc.com>
 * @date : 31-oct-2018
 * @objective : Get all information regarding jobs 
 */
class Support extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/support_model');
         $this->load->model('user_model');
        
       
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
    public function receiveoffmessage_post() {
    $postData = $this->input->post(); 
   $user = $this->user_model->get(array("id"=>$postData['callerUserId']));
       if(($user->device_type)=='ios')
       {
       }
       else
       {
         
       $id=$user->device_VOIPID;
       $mess="dialToneOff";
       
     
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array (
        'to' => $id,
        'data' => array (
                "body" => $mess,
                "title" => "dialToneOff",
                "icon" => "myicon"
        )
);
$fields = json_encode ( $fields );
$headers = array (
        'Authorization: key=' . "AAAAO_GwUeQ:APA91bGOmp4b8eiKZtytk6n-Jhd7aOkQ_xiGUwl57ZZuH99DzCdw9fMKvmLnwRG0AElnS5Og36jNKjuORKpof0_xGtVSPwaBJ5XYD68qTCSqXMS1eoNJL5XXNeAGjKjCu1WgO23QQRzN",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
curl_close ( $ch );
//print_r($fields);
	if (!$result){
    $this->set_response([
                'status' => '0',
                'message' => 'dial Tone not Off'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}else{
     $this->set_response([
                'status' => '1',
                'message' => 'dial Tone Off'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code 
}
  
       }
}


     public function VOIPCall_post() {
     $postData = $this->input->post();     
   // print_r( $postData);  exit;
      $isCallingORDecline = !empty($postData['isCallingORDecline']) ? $postData['isCallingORDecline'] : '';
if (  $isCallingORDecline !="") {
   // print_r($postData['device_VOIPID'][0]); exit;
    $expol=explode(",",$postData['device_VOIPID'][0]);
  // print_r($expol);
      for ($x = 0; $x < (  count($expol) ); $x++) {
        $user = $this->user_model->get(array("device_VOIPID"=>$expol[$x]));
     
    
     if(($user->device_type)=='ios')
       {
           
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
	$payload['callerUserId'] =$postData['callerUserId'];			
    
    
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
	$result =	fwrite($apns, $apnsMessage);
		fclose($apns);	
	      
	if (!$result){
    $this->set_response([
                'status' => '1',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Send'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}else{
     $this->set_response([
                'status' => '0',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Not Send'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
}
	
		
       }
       
       else
       {
           
           if($postData['isCallingORDecline']=='calling'){
//	$mst ='{"hasAudio" : "'.$postData['hasAudio'].'","hasVideo" :"'.$postData['hasVideo'].'","CallerImageURL" :"'.$postData['CallerImageURL'].'","liveUrl" : "'.$postData['liveUrl'].'","CallerName" : "'.$postData['CallerName'].'"}';
$mst ='Calling'; 
$mstjit ='{"hasAudio" : "'.$postData['hasAudio'].'","hasVideo" :"'.$postData['hasVideo'].'","CallerImageURL" :"'.$postData['CallerImageURL'].'","liveUrl" : "'.$postData['liveUrl'].'","callerUserId" : "'.$postData['callerUserId'].'","CallerName" : "'.$postData['CallerName'].'"}';

	$payload['hasAudio'] = $postData['hasAudio'];	
	$payload['hasVideo'] = $postData['hasVideo'];	
	$payload['CallerImageURL'] = $postData['CallerImageURL'];	
	$payload['liveUrl'] = $postData['liveUrl'];	
	$payload['CallerName'] =$postData['CallerName'];
	$payload['callerUserId'] =$postData['callerUserId'];

					
    
    
}
else{
 $mst ='declined';  
 $mstjit ='{}';
}

       $id=$user->device_VOIPID;
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array (
        'to' => $id,
        "priority"=>"high",
       'data' => array (
                "body" => $mstjit,
                
                "title" =>$mst,
                "icon" => ""
        )
        
        
);

$fields = json_encode ( $fields );
$headers = array (
        'Authorization: key=' . "AAAAO_GwUeQ:APA91bGOmp4b8eiKZtytk6n-Jhd7aOkQ_xiGUwl57ZZuH99DzCdw9fMKvmLnwRG0AElnS5Og36jNKjuORKpof0_xGtVSPwaBJ5XYD68qTCSqXMS1eoNJL5XXNeAGjKjCu1WgO23QQRzN",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
curl_close ( $ch );
      
	if (!$result){
    $this->set_response([
                'status' => '1',
                'message' => 'VOIP Notification Send',
                 'callerUserId' => $_POST['callerUserId'],
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}else{
     $this->set_response([
                'status' => '0',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Not Send'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
}

       }
      
	if (!$result){
    $this->set_response([
                'status' => '1',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Send'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}else{
     $this->set_response([
                'status' => '0',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Not Send'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
}

	//	fclose($apns);			
	///////////////////////////////////////////////////////////					
	} 

    
}

if (  $isCallingORDecline !="") {
     $this->set_response([
                'status' => '1',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Send'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code  
}
else
{
      $this->set_response([
                'status' => '0',
                 'callerUserId' => $_POST['callerUserId'],
                'message' => 'VOIP Notification Not Send'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
}
      
         
     }
    
    

}
