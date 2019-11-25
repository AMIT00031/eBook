<?phpClass Userchat extends CI_Controller { function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/user_model');
          $this->load->model('admin/support_model');
    }

    public function index() {
         $checklogin = $this->user_model->check_admin_login_status();
        if (!$checklogin) {
            redirect(base_url('admin/auth/login'));
        }
 $user_id = $this->input->get('id');
 $list =  $this->user_model->getUserclientDetail($user_id);
 $listuser =  $this->user_model->getUserDetail($user_id);

if(isset($_POST['submit']))
{
      $postData = $this->input->post();
       $listuser =  $this->user_model->getUserDetail($postData['toid']);


if ( $listuser[0]->device_id!="") {				
		$apnsHost = 'gateway.sandbox.push.apple.com';	
		
		$apnsCert = 'pushcert.pem';					
		$apnsPort = 2195;					
		$apnsPass = '1234';					
		$token = $listuser[0]->device_id;					
		$mst = "OilBizz Support Team : ".$postData['message'];		
		$payload['aps'] = array('alert' => $mst, 'badge' => 1, 'sound' => 'default');			
		$payload['api_type'] = 'olibizz_chat';					
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

	
        $res = $this->support_model->insert($postData);
      
  $message = $this->session->flashdata('Added Sucessfully');
    redirect('/admin/userchat?id='.$user_id, 'refresh');
}

        $data = array(
            'title' => 'Chat Users',
            'list_heading' => 'Chat Users',
             'username' => $listuser[0]->username,
            'users' => $list
        );
        $this->template->load('admin/base', 'admin/users/chatuserslist', $data);
    }

}
